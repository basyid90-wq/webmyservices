<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Webimpian\BayarcashSdk\Bayarcash;

class BookingController extends Controller
{
    public function catalog()
    {
        $rooms = Room::where('is_active', true)->orderBy('sort_order')->get();

        return Inertia::render('Booking/Catalog', [
            'rooms' => $rooms->map(fn ($room) => [
                'id' => $room->id,
                'name' => $room->name,
                'slug' => $room->slug,
                'price_per_night' => $room->price_per_night,
                'max_guests' => $room->max_guests,
                'image' => $room->image,
                'amenities' => $room->amenities,
            ]),
        ]);
    }

    public function room(Request $request, Room $room)
    {
        return Inertia::render('Booking/Room', [
            'room' => [
                'id' => $room->id,
                'name' => $room->name,
                'slug' => $room->slug,
                'description' => $room->description,
                'price_per_night' => $room->price_per_night,
                'max_guests' => $room->max_guests,
                'image' => $room->image,
                'images' => $room->images,
                'amenities' => $room->amenities,
            ],
            'blockedDates' => $room->blockedDateStrings(),
            'bookedDates' => $room->bookedDateStrings(),
        ]);
    }

    public function checkAvailability(Request $request, Room $room)
    {
        $validated = $request->validate([
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
        ]);

        $available = $room->isAvailable($validated['check_in'], $validated['check_out']);

        $nights = (int) (new \DateTime($validated['check_out']))->diff(new \DateTime($validated['check_in']))->days;

        return response()->json([
            'available' => $available,
            'nights' => $nights,
            'subtotal' => $nights * $room->price_per_night,
        ]);
    }

    public function summary(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'guests_adults' => 'required|integer|min:1',
            'guests_kids' => 'nullable|integer|min:0',
        ]);

        $room = Room::findOrFail($validated['room_id']);

        if (!$room->isAvailable($validated['check_in'], $validated['check_out'])) {
            return redirect()->route('booking.room', $room->slug)->withErrors(['dates' => 'Tarikh ini tidak tersedia.']);
        }

        $nights = (int) (new \DateTime($validated['check_out']))->diff(new \DateTime($validated['check_in']))->days;

        return Inertia::render('Booking/Summary', [
            'room' => [
                'id' => $room->id,
                'name' => $room->name,
                'price_per_night' => $room->price_per_night,
            ],
            'checkIn' => $validated['check_in'],
            'checkOut' => $validated['check_out'],
            'guestsAdults' => (int) $validated['guests_adults'],
            'guestsKids' => (int) ($validated['guests_kids'] ?? 0),
            'nights' => $nights,
            'subtotal' => $nights * $room->price_per_night,
        ]);
    }

    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'guests_adults' => 'required|integer|min:1',
            'guests_kids' => 'nullable|integer|min:0',
            'nights' => 'required|integer|min:1',
            'subtotal' => 'required|numeric|min:0',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
        ]);

        $room = Room::findOrFail($validated['room_id']);

        if (!$room->isAvailable($validated['check_in'], $validated['check_out'])) {
            return back()->withErrors(['dates' => 'Tarikh ini tidak tersedia lagi.']);
        }

        $total = $validated['subtotal'];
        $bookingNumber = Booking::generateBookingNumber();

        $booking = Booking::create([
            'booking_number' => $bookingNumber,
            'room_id' => $room->id,
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'],
            'check_in' => $validated['check_in'],
            'check_out' => $validated['check_out'],
            'guests_adults' => $validated['guests_adults'],
            'guests_kids' => $validated['guests_kids'] ?? 0,
            'total_nights' => $validated['nights'],
            'subtotal' => $validated['subtotal'],
            'total' => $total,
            'status' => 'pending',
            'payment_channel' => Bayarcash::FPX,
        ]);

        $token = config('bayarcash.api_token');

        if (empty($token)) {
            $booking->update(['status' => 'paid', 'transaction_id' => 'DEMO-' . strtoupper(uniqid()), 'paid_at' => now()]);
            return redirect()->route('booking.success', $booking->booking_number);
        }

        $callbackBase = rtrim(config('app.url'), '/');

        $data = [
            'order_number' => $booking->booking_number,
            'amount' => $total,
            'payer_name' => $validated['customer_name'],
            'payer_email' => $validated['customer_email'],
            'payer_telephone_number' => $validated['customer_phone'],
            'payment_channel' => Bayarcash::FPX,
            'return_url' => $callbackBase . '/booking/orders/' . $booking->booking_number . '/success',
            'success_url' => $callbackBase . '/bayarcash/callback/transaction',
            'failed_url' => $callbackBase . '/bayarcash/callback/transaction',
            'cancel_url' => $callbackBase . '/booking/checkout',
        ];

        try {
            $bayarcash = app(Bayarcash::class);
            if (config('bayarcash.sandbox', true)) {
                $bayarcash->useSandbox();
            }
            $secretKey = config('bayarcash.api_secret_key');
            if ($secretKey) {
                $data['checksum'] = $bayarcash->createPaymentIntenChecksumValue($secretKey, $data);
            }
            $response = $bayarcash->createPaymentIntent($data);
            return redirect()->away($response->url);
        } catch (\Exception $e) {
            Log::error('Bayarcash booking error: ' . $e->getMessage());
            $booking->update(['status' => 'failed']);
            return redirect()->route('booking.success', $booking->booking_number)
                ->with('error', 'Payment failed. Please contact support.');
        }
    }

    public function success(Booking $booking)
    {
        return Inertia::render('Booking/Success', [
            'booking' => [
                'booking_number' => $booking->booking_number,
                'room_name' => $booking->room->name,
                'check_in' => $booking->check_in->format('d/m/Y'),
                'check_out' => $booking->check_out->format('d/m/Y'),
                'guests_adults' => $booking->guests_adults,
                'guests_kids' => $booking->guests_kids,
                'total_nights' => $booking->total_nights,
                'total' => $booking->total,
                'status' => $booking->status,
            ],
        ]);
    }
}
