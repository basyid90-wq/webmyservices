import { motion } from 'framer-motion'
import { route } from '@/lib/ziggy'
import BookingLayout from '@/components/Booking/BookingLayout'
import { Users } from 'lucide-react'

export default function Catalog({ rooms }) {
  return (
    <BookingLayout>
      <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div className="text-center mb-12">
          <span className="inline-block text-xs font-medium text-amber-600 bg-amber-50 px-3 py-1 rounded-full mb-3">🏡 Pangkor Island</span>
          <h1 className="text-3xl lg:text-4xl font-bold text-stone-800 mb-3">Desa Pangkor Homestay</h1>
          <p className="text-stone-500 max-w-lg mx-auto">Penginapan selesa & tenang di tepi pantai Pulau Pangkor. Sesuai untuk percutian keluarga, honeymoon, atau team retreat.</p>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          {rooms.map((room, i) => (
            <motion.a
              key={room.id}
              href={route('booking.room', { room: room.slug })}
              initial={{ opacity: 0, y: 10 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ delay: i * 0.05 }}
              className="group bg-white border border-stone-200 rounded-2xl overflow-hidden hover:border-amber-300 hover:shadow-lg transition-all duration-300"
            >
              <div className="aspect-[4/3] bg-gradient-to-br from-stone-100 to-amber-50 flex items-center justify-center text-5xl">
                {room.image ? <img src={`/storage/${room.image}`} alt={room.name} className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" /> : '🏡'}
              </div>
              <div className="p-5">
                {room.amenities && room.amenities.length > 0 && (
                  <div className="flex flex-wrap gap-1.5 mb-3">
                    {room.amenities.slice(0, 3).map((a) => (
                      <span key={a} className="text-[10px] text-stone-500 bg-stone-100 px-2 py-0.5 rounded-full">{a}</span>
                    ))}
                  </div>
                )}
                <h3 className="text-base font-semibold text-stone-800 mb-1 group-hover:text-amber-600 transition-colors">{room.name}</h3>
                <div className="flex items-center gap-1.5 text-xs text-stone-400 mb-3">
                  <Users className="w-3 h-3" />
                  <span>Up to {room.max_guests} guests</span>
                </div>
                <div className="flex items-baseline gap-1">
                  <span className="text-xl font-bold text-stone-800">RM {room.price_per_night}</span>
                  <span className="text-xs text-stone-400">/ night</span>
                </div>
              </div>
            </motion.a>
          ))}
        </div>

        {rooms.length === 0 && (
          <div className="text-center py-20 text-stone-400">No rooms available at the moment.</div>
        )}
      </div>
    </BookingLayout>
  )
}
