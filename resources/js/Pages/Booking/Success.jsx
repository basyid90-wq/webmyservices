import { route } from '@/lib/ziggy'
import BookingLayout from '@/components/Booking/BookingLayout'
import { CheckCircle, ArrowRight } from 'lucide-react'

export default function Success({ booking }) {
  return (
    <BookingLayout>
      <div className="max-w-lg mx-auto px-4 py-16 lg:py-24 text-center">
        <div className="w-16 h-16 rounded-full bg-emerald-100 flex items-center justify-center mx-auto mb-6">
          <CheckCircle className="w-8 h-8 text-emerald-600" />
        </div>
        <h1 className="text-2xl font-bold text-stone-800 mb-2">Booking Confirmed!</h1>
        <p className="text-stone-500 mb-6">Thank you. Your reservation has been received.</p>

        <div className="bg-white border border-stone-200 rounded-xl p-5 mb-6 text-left">
          <div className="space-y-2 text-sm">
            <div className="flex justify-between"><span className="text-stone-500">Booking No</span><span className="font-semibold text-stone-800">{booking.booking_number}</span></div>
            <div className="flex justify-between"><span className="text-stone-500">Room</span><span className="font-semibold text-stone-800">{booking.room_name}</span></div>
            <div className="flex justify-between"><span className="text-stone-500">Check-in</span><span className="font-semibold text-stone-800">{booking.check_in}</span></div>
            <div className="flex justify-between"><span className="text-stone-500">Check-out</span><span className="font-semibold text-stone-800">{booking.check_out}</span></div>
            <div className="flex justify-between"><span className="text-stone-500">Guests</span><span className="font-semibold text-stone-800">{booking.guests_adults} Adult{booking.guests_adults > 1 ? 's' : ''}{booking.guests_kids > 0 ? ` + ${booking.guests_kids} Kid${booking.guests_kids > 1 ? 's' : ''}` : ''}</span></div>
            <div className="flex justify-between"><span className="text-stone-500">Nights</span><span className="font-semibold text-stone-800">{booking.total_nights}</span></div>
            <div className="flex justify-between"><span className="text-stone-500">Status</span><span className="font-semibold text-emerald-600">{booking.status === 'paid' ? 'Paid' : 'Pending'}</span></div>
            <div className="flex justify-between font-bold text-stone-800 pt-2 border-t border-stone-100"><span>Total</span><span>RM {booking.total}</span></div>
          </div>
        </div>

        <a href={route('booking.catalog')} className="inline-flex items-center gap-2 text-amber-600 hover:text-amber-700 text-sm font-medium transition-colors">
          Browse More Rooms <ArrowRight className="w-4 h-4" />
        </a>
      </div>
    </BookingLayout>
  )
}
