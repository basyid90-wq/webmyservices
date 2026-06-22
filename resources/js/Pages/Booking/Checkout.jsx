import { route } from '@/lib/ziggy'
import BookingLayout from '@/components/Booking/BookingLayout'
import { CreditCard, Shield } from 'lucide-react'

export default function Checkout({ errors }) {
  const query = new URLSearchParams(typeof window !== 'undefined' ? window.location.search : '')
  const roomId = query.get('room_id') || ''
  const checkIn = query.get('check_in') || ''
  const checkOut = query.get('check_out') || ''
  const adults = query.get('guests_adults') || '2'
  const kids = query.get('guests_kids') || '0'
  const roomName = query.get('room_name') || 'Room'
  const nights = parseInt(query.get('nights') || '1')
  const subtotal = parseFloat(query.get('subtotal') || '0')

  return (
    <BookingLayout>
      <div className="max-w-lg mx-auto px-4 py-12">
        <h1 className="text-2xl font-bold text-stone-800 mb-8">Checkout</h1>

        {errors?.dates && <div className="mb-6 bg-red-50 border border-red-200 text-red-600 text-sm px-4 py-3 rounded-xl">{errors.dates}</div>}

        <form method="POST" action={route('booking.checkout.submit')} acceptCharset="UTF-8">
          <input type="hidden" name="_token" value={typeof document !== 'undefined' ? document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '' : ''} />
          <input type="hidden" name="room_id" value={roomId} />
          <input type="hidden" name="check_in" value={checkIn} />
          <input type="hidden" name="check_out" value={checkOut} />
          <input type="hidden" name="guests_adults" value={adults} />
          <input type="hidden" name="guests_kids" value={kids} />
          <input type="hidden" name="nights" value={nights} />
          <input type="hidden" name="subtotal" value={subtotal} />

          <div className="bg-white border border-stone-200 rounded-xl p-5 mb-4">
            <h3 className="text-sm font-semibold text-stone-800 mb-4">Customer Information</h3>
            <div className="space-y-3">
              <div>
                <label className="block text-xs text-stone-500 mb-1">Full Name *</label>
                <input name="customer_name" type="text" required className="w-full border border-stone-200 rounded-lg px-3 py-2.5 text-sm text-stone-800 bg-white focus:border-amber-500 outline-none" />
              </div>
              <div>
                <label className="block text-xs text-stone-500 mb-1">Email *</label>
                <input name="customer_email" type="email" required className="w-full border border-stone-200 rounded-lg px-3 py-2.5 text-sm text-stone-800 bg-white focus:border-amber-500 outline-none" />
              </div>
              <div>
                <label className="block text-xs text-stone-500 mb-1">Phone *</label>
                <input name="customer_phone" type="text" required className="w-full border border-stone-200 rounded-lg px-3 py-2.5 text-sm text-stone-800 bg-white focus:border-amber-500 outline-none" />
              </div>
            </div>
          </div>

          <div className="bg-white border border-stone-200 rounded-xl p-5 mb-4">
            <h3 className="text-sm font-semibold text-stone-800 mb-3">Booking Summary</h3>
            <div className="text-sm space-y-1.5">
              <div className="flex justify-between text-stone-600"><span>Room</span><span className="font-medium text-stone-800">{roomName}</span></div>
              <div className="flex justify-between text-stone-600"><span>Nights</span><span className="font-medium text-stone-800">{nights}</span></div>
              <div className="flex justify-between font-bold text-stone-800 pt-2 border-t border-stone-100"><span>Total</span><span>RM {subtotal.toFixed(2)}</span></div>
            </div>
          </div>

          <div className="bg-white border border-stone-200 rounded-xl p-5 mb-4">
            <h3 className="text-sm font-semibold text-stone-800 mb-3">Payment</h3>
            <label className="flex items-center gap-3 p-3 rounded-lg border border-amber-500 bg-amber-50 cursor-pointer">
              <input type="radio" name="payment_channel" value="2" defaultChecked className="hidden" />
              <CreditCard className="w-5 h-5 text-amber-500" />
              <div className="text-sm"><span className="font-medium text-stone-700">FPX Online Banking</span><span className="block text-xs text-stone-400">All Malaysian banks</span></div>
            </label>
            <div className="flex items-center gap-2 mt-3 text-[10px] text-stone-400">
              <Shield className="w-3 h-3" /> Secure payment by Bayarcash
            </div>
          </div>

          <button type="submit"
            className="w-full bg-amber-500 hover:bg-amber-600 text-white py-3.5 rounded-xl font-medium text-sm transition-colors">
            Pay RM {subtotal.toFixed(2)}
          </button>
        </form>
      </div>
    </BookingLayout>
  )
}
