import { useState, useMemo } from 'react'
import { motion } from 'framer-motion'
import { route } from '@/lib/ziggy'
import axios from 'axios'
import BookingLayout from '@/components/Booking/BookingLayout'
import { Users, Wifi, Wind, Car, UtensilsCrossed, Tv } from 'lucide-react'

const amenityIcons = { 'WiFi': Wifi, 'Air Cond': Wind, 'Parking': Car, 'TV': Tv, 'Kitchen': UtensilsCrossed }

export default function Room({ room, blockedDates, bookedDates }) {
  const [checkIn, setCheckIn] = useState('')
  const [checkOut, setCheckOut] = useState('')
  const [adults, setAdults] = useState(2)
  const [kids, setKids] = useState(0)
  const [availability, setAvailability] = useState(null)
  const [loading, setLoading] = useState(false)

  const disabledDates = useMemo(() => [...blockedDates, ...bookedDates], [blockedDates, bookedDates])

  const today = new Date().toISOString().split('T')[0]

  async function check() {
    if (!checkIn || !checkOut) return
    setLoading(true)
    try {
      const res = await axios.post(route('booking.availability', room.id), { check_in: checkIn, check_out: checkOut })
      setAvailability(res.data)
    } catch {
      setAvailability({ available: false })
    } finally {
      setLoading(false)
    }
  }

  function book() {
    const params = new URLSearchParams({
      room_id: room.id,
      check_in: checkIn,
      check_out: checkOut,
      guests_adults: adults,
      guests_kids: kids,
      nights: availability?.nights || 1,
      subtotal: availability?.subtotal || room.price_per_night,
      room_name: room.name,
    })
    window.location.href = route('booking.checkout') + '?' + params.toString()
  }

  return (
    <BookingLayout>
      <div className="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
        <a href={route('booking.catalog')} className="text-sm text-stone-400 hover:text-stone-600 mb-6 inline-block">&larr; Back to rooms</a>

        <div className="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
          <div className="aspect-[4/3] rounded-2xl bg-gradient-to-br from-stone-100 to-amber-50 flex items-center justify-center text-7xl border border-stone-200">
            {room.image ? <img src={`/storage/${room.image}`} alt={room.name} className="w-full h-full object-cover rounded-2xl" /> : '🏡'}
          </div>

          <div>
            <h1 className="text-2xl lg:text-3xl font-bold text-stone-800 mb-2">{room.name}</h1>
            <div className="flex items-center gap-1.5 text-sm text-stone-400 mb-2">
              <Users className="w-4 h-4" /> Up to {room.max_guests} guests
            </div>
            <div className="text-3xl font-bold text-amber-600 mb-6">RM {room.price_per_night}<span className="text-sm font-normal text-stone-400">/night</span></div>

            {room.amenities && room.amenities.length > 0 && (
              <div className="flex flex-wrap gap-2 mb-6">
                {room.amenities.map((a) => {
                  const Icon = amenityIcons[a] || null
                  return (
                    <span key={a} className="flex items-center gap-1.5 text-xs text-stone-600 bg-stone-100 px-2.5 py-1.5 rounded-lg">
                      {Icon && <Icon className="w-3.5 h-3.5" />}{a}
                    </span>
                  )
                })}
              </div>
            )}

            {room.description && (
              <div className="text-sm text-stone-600 leading-relaxed mb-6" dangerouslySetInnerHTML={{ __html: room.description }} />
            )}

            <div className="bg-stone-50 border border-stone-200 rounded-xl p-5 space-y-4">
              <h3 className="text-sm font-semibold text-stone-800">Book This Room</h3>

              <div className="grid grid-cols-2 gap-3">
                <div>
                  <label className="block text-xs text-stone-500 mb-1">Check-in</label>
                  <input type="date" min={today} value={checkIn} onChange={(e) => { setCheckIn(e.target.value); setAvailability(null) }}
                    className="w-full border border-stone-200 rounded-lg px-3 py-2 text-sm text-stone-800 bg-white focus:border-amber-500 outline-none" />
                </div>
                <div>
                  <label className="block text-xs text-stone-500 mb-1">Check-out</label>
                  <input type="date" min={checkIn || today} value={checkOut} onChange={(e) => { setCheckOut(e.target.value); setAvailability(null) }}
                    className="w-full border border-stone-200 rounded-lg px-3 py-2 text-sm text-stone-800 bg-white focus:border-amber-500 outline-none" />
                </div>
              </div>

              <div className="grid grid-cols-2 gap-3">
                <div>
                  <label className="block text-xs text-stone-500 mb-1">Adults</label>
                  <select value={adults} onChange={(e) => setAdults(parseInt(e.target.value))}
                    className="w-full border border-stone-200 rounded-lg px-3 py-2 text-sm text-stone-800 bg-white focus:border-amber-500 outline-none">
                    {[...Array(room.max_guests)].map((_, i) => <option key={i} value={i + 1}>{i + 1} Adult{i > 0 ? 's' : ''}</option>)}
                  </select>
                </div>
                <div>
                  <label className="block text-xs text-stone-500 mb-1">Kids</label>
                  <select value={kids} onChange={(e) => setKids(parseInt(e.target.value))}
                    className="w-full border border-stone-200 rounded-lg px-3 py-2 text-sm text-stone-800 bg-white focus:border-amber-500 outline-none">
                    {[...Array(4)].map((_, i) => <option key={i} value={i}>{i === 0 ? 'None' : i}</option>)}
                  </select>
                </div>
              </div>

              {checkIn && checkOut && (
                <button onClick={check} disabled={loading}
                  className="w-full bg-stone-200 hover:bg-stone-300 text-stone-700 py-2 rounded-lg text-sm font-medium transition-colors disabled:opacity-50">
                  {loading ? 'Checking...' : 'Check Availability'}
                </button>
              )}

              {availability && availability.available && (
                <motion.div initial={{ opacity: 0, y: 5 }} animate={{ opacity: 1, y: 0 }}
                  className="bg-emerald-50 border border-emerald-200 rounded-lg p-3 text-center">
                  <p className="text-emerald-700 text-sm font-medium">Available! {availability.nights} night{availability.nights > 1 ? 's' : ''}</p>
                  <p className="text-xl font-bold text-emerald-800 mt-1">RM {availability.subtotal}</p>
                  <button onClick={book}
                    className="mt-3 w-full bg-amber-500 hover:bg-amber-600 text-white py-2.5 rounded-lg text-sm font-medium transition-colors">
                    Book Now — RM {availability.subtotal}
                  </button>
                </motion.div>
              )}

              {availability && !availability.available && (
                <div className="bg-red-50 border border-red-200 rounded-lg p-3 text-center text-sm text-red-600">
                  Sorry, these dates are not available.
                </div>
              )}
            </div>
          </div>
        </div>
      </div>
    </BookingLayout>
  )
}
