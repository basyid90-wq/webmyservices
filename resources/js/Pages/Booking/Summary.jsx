import { route } from '@/lib/ziggy'
import BookingLayout from '@/components/Booking/BookingLayout'
import { Calendar, Users, Moon } from 'lucide-react'

export default function Summary({ room, checkIn, checkOut, guestsAdults, guestsKids, nights, subtotal }) {
  function proceed() {
    const params = new URLSearchParams({
      room_id: room.id,
      check_in: checkIn,
      check_out: checkOut,
      guests_adults: guestsAdults,
      guests_kids: guestsKids,
      nights,
      subtotal,
      room_name: room.name,
    })
    window.location.href = route('booking.checkout') + '?' + params.toString()
  }

  return (
    <BookingLayout>
      <div className="max-w-lg mx-auto px-4 py-12">
        <h1 className="text-2xl font-bold text-stone-800 mb-8 text-center">Booking Summary</h1>

        <div className="bg-white border border-stone-200 rounded-2xl p-6 space-y-4">
          <div className="flex items-start gap-3 pb-4 border-b border-stone-100">
            <div className="w-12 h-12 rounded-lg bg-amber-100 flex items-center justify-center text-2xl flex-shrink-0">🏡</div>
            <div>
              <h3 className="font-semibold text-stone-800">{room.name}</h3>
              <p className="text-sm text-stone-500">RM {room.price_per_night} / night</p>
            </div>
          </div>

          <div className="space-y-3 text-sm">
            <div className="flex items-center gap-2 text-stone-600"><Calendar className="w-4 h-4 text-amber-500" /> <span>Check-in: <strong>{checkIn}</strong></span></div>
            <div className="flex items-center gap-2 text-stone-600"><Calendar className="w-4 h-4 text-amber-500" /> <span>Check-out: <strong>{checkOut}</strong></span></div>
            <div className="flex items-center gap-2 text-stone-600"><Moon className="w-4 h-4 text-amber-500" /> <span>{nights} night{nights > 1 ? 's' : ''}</span></div>
            <div className="flex items-center gap-2 text-stone-600"><Users className="w-4 h-4 text-amber-500" /> <span>{guestsAdults} Adult{guestsAdults > 1 ? 's' : ''}{guestsKids > 0 ? ` + ${guestsKids} Kid${guestsKids > 1 ? 's' : ''}` : ''}</span></div>
          </div>

          <div className="pt-4 border-t border-stone-100">
            <div className="flex justify-between text-lg font-bold text-stone-800">
              <span>Total</span>
              <span>RM {subtotal.toFixed(2)}</span>
            </div>
          </div>
        </div>

        <button onClick={proceed}
          className="w-full mt-6 bg-amber-500 hover:bg-amber-600 text-white py-3 rounded-xl font-medium text-sm transition-colors">
          Proceed to Payment
        </button>
      </div>
    </BookingLayout>
  )
}
