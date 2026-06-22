<?php

namespace App\Http\Controllers;

use App\Models\Shop\Cart;
use App\Models\Shop\Order;
use App\Models\User;
use App\Notifications\NewOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Webimpian\BayarcashSdk\Bayarcash;

class CheckoutController extends Controller
{
    public function show()
    {
        return Inertia::render('Shop/Checkout');
    }

    public function process(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string|max:500',
            'shipping_city' => 'required|string|max:100',
            'shipping_state' => 'required|string|max:100',
            'shipping_postcode' => 'required|string|max:10',
            'payment_channel' => 'required|in:2,3',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|integer',
            'items.*.name' => 'required|string',
            'items.*.price' => 'required|numeric',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $subtotal = collect($request->items)->sum(fn ($i) => $i['price'] * $i['quantity']);
        $shipping = $request->input('cart_shipping', $subtotal > 100 ? 0 : 10);
        $total = $request->input('cart_total', $subtotal + $shipping);

        $order = Order::create([
            'user_id' => Auth::id(),
            'order_number' => Order::generateOrderNumber(),
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'shipping_address' => $request->shipping_address,
            'shipping_city' => $request->shipping_city,
            'shipping_state' => $request->shipping_state,
            'shipping_postcode' => $request->shipping_postcode,
            'subtotal' => $subtotal,
            'shipping_fee' => $shipping,
            'total' => $total,
            'status' => 'pending',
            'payment_channel' => $request->payment_channel === '2' ? Bayarcash::FPX : Bayarcash::FPX,
        ]);

        foreach ($request->items as $item) {
            $order->items()->create([
                'shop_product_id' => $item['product_id'],
                'product_name' => $item['name'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'subtotal' => $item['price'] * $item['quantity'],
            ]);
        }

        User::first()?->notify(new NewOrder('new', $order->order_number, number_format($total, 2), $request->customer_name));

        // Also clear any server-side cart if exists
        $cart = \App\Models\Shop\Cart::where('session_id', session()->getId())->first();
        if ($cart) {
            $cart->items()->delete();
        }

        $token = config('bayarcash.api_token');

        if (empty($token)) {
            $cart->items()->delete();
            $order->update(['status' => 'paid', 'transaction_id' => 'DEMO-' . strtoupper(uniqid()), 'paid_at' => now()]);
            User::first()?->notify(new NewOrder('paid', $order->order_number, number_format($total, 2), $request->customer_name));
            return redirect()->route('shop.order.success', $order->order_number);
        }

        $callbackBase = rtrim(config('app.url'), '/');

        $data = [
            'order_number' => $order->order_number,
            'amount' => $total,
            'payer_name' => $request->customer_name,
            'payer_email' => $request->customer_email,
            'payer_telephone_number' => $request->customer_phone,
            'payment_channel' => $request->payment_channel === '2' ? Bayarcash::FPX : Bayarcash::FPX,
            'return_url' => $callbackBase . '/shop/orders/' . $order->order_number . '/success',
            'success_url' => $callbackBase . '/bayarcash/callback/transaction',
            'failed_url' => $callbackBase . '/bayarcash/callback/transaction',
            'cancel_url' => $callbackBase . '/shop/checkout',
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
            Log::error('Bayarcash error: ' . $e->getMessage());
            $order->update(['status' => 'failed']);
            return redirect()->route('shop.order.success', $order->order_number)
                ->with('error', 'Payment failed. Please contact support.');
        }
    }

    public function success(Order $order)
    {
        return Inertia::render('Shop/Success', ['order' => $order->load('items')]);
    }

    public function callback(Request $request)
    {
        $bayarcash = app(Bayarcash::class);
        if (config('bayarcash.sandbox', true)) {
            $bayarcash->useSandbox();
        }

        try {
            $valid = $bayarcash->verifyTransactionCallbackData(
                $request->all(),
                config('bayarcash.api_secret_key')
            );

            if ($valid && $request->input('status') === '3') {
                $order = Order::where('order_number', $request->input('order_number'))->first();
                if ($order) {
                    $order->update([
                        'status' => 'paid',
                        'transaction_id' => $request->input('transaction_id'),
                        'paid_at' => now(),
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::error('Bayarcash callback error: ' . $e->getMessage());
        }

        return response('OK');
    }

    private function getCart(): Cart
    {
        return Cart::firstOrCreate(['session_id' => session()->getId()]);
    }
}
