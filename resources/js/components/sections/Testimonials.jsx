import { useState, useCallback } from 'react'
import { Swiper, SwiperSlide, useSwiperSlide } from 'swiper/react'
import { Autoplay, Pagination, EffectCoverflow } from 'swiper/modules'
import { motion } from 'framer-motion'
import { Star, Quote } from 'lucide-react'
import 'swiper/css'
import 'swiper/css/pagination'
import 'swiper/css/effect-coverflow'

function TestimonialSlide({ testimonial }) {
  const { isActive } = useSwiperSlide()

  return (
    <div
      className={`relative rounded-2xl p-6 md:p-8 transition-all duration-700 ease-out ${
        isActive
          ? 'bg-gradient-to-br from-gray-900 to-gray-800 border border-indigo-500/30 shadow-2xl shadow-indigo-500/10 scale-100 opacity-100'
          : 'bg-gray-900/60 border border-gray-800 scale-[0.85] opacity-40 blur-[1px]'
      }`}
    >
      {isActive && (
        <Quote className="absolute top-4 right-4 w-20 h-20 text-indigo-500/5 -rotate-12" />
      )}

      <div className="flex items-center gap-4 mb-6 relative z-10">
        <div
          className={`flex-shrink-0 rounded-full overflow-hidden transition-all duration-500 ${
            isActive ? 'w-14 h-14 ring-2 ring-indigo-500/30 ring-offset-2 ring-offset-gray-900' : 'w-12 h-12'
          }`}
        >
          {testimonial.avatar ? (
            <img
              src={`/storage/${testimonial.avatar}`}
              alt={testimonial.client_name}
              className="w-full h-full object-cover"
            />
          ) : (
            <div className="w-full h-full bg-indigo-600/30 flex items-center justify-center text-white text-xl font-bold">
              {testimonial.client_name.charAt(0).toUpperCase()}
            </div>
          )}
        </div>
        <div>
          <h4 className={`font-semibold text-white transition-all duration-500 ${isActive ? 'text-base' : 'text-sm'}`}>
            {testimonial.client_name}
          </h4>
          {testimonial.role && (
            <p className="text-xs text-gray-500 mt-0.5">{testimonial.role}</p>
          )}
        </div>
      </div>

      <div className="flex gap-0.5 mb-4 relative z-10">
        {[...Array(5)].map((_, i) => (
          <motion.div
            key={i}
            initial={isActive ? { scale: 0, opacity: 0 } : false}
            animate={isActive ? { scale: 1, opacity: 1 } : false}
            transition={{ delay: isActive ? 0.2 + i * 0.08 : 0, type: 'spring', stiffness: 300 }}
          >
            <Star className="w-4 h-4 text-yellow-500 fill-yellow-500" />
          </motion.div>
        ))}
      </div>

      <blockquote
        className={`text-gray-400 leading-relaxed italic relative z-10 transition-all duration-500 ${
          isActive ? 'text-sm md:text-base' : 'text-xs'
        }`}
      >
        &ldquo;{testimonial.quote}&rdquo;
      </blockquote>
    </div>
  )
}

export default function Testimonials({ testimonials }) {
  const [swiper, setSwiper] = useState(null)

  const pause = useCallback(() => swiper?.autoplay?.stop(), [swiper])
  const resume = useCallback(() => swiper?.autoplay?.start(), [swiper])

  if (!testimonials || testimonials.length === 0) return null

  const duplicated = testimonials.length < 4
    ? [...testimonials, ...testimonials, ...testimonials]
    : testimonials

  return (
    <section id="testimonials" className="py-24 lg:py-32 overflow-hidden">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <motion.div
          initial={{ opacity: 0, y: 30 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          className="text-center mb-14"
        >
          <p className="text-indigo-400 text-sm font-semibold tracking-widest uppercase mb-3">Testimonials</p>
          <h2 className="text-3xl md:text-4xl font-bold text-white mb-4">What Our Clients Say</h2>
          <p className="text-gray-400 max-w-2xl mx-auto">
            Feedback from clients who have used our services.
          </p>
        </motion.div>

        <div
          className="relative"
          onMouseEnter={pause}
          onMouseLeave={resume}
        >
          <Swiper
            onSwiper={setSwiper}
            modules={[Autoplay, Pagination, EffectCoverflow]}
            effect="coverflow"
            centeredSlides
            slidesPerView="auto"
            spaceBetween={0}
            loop={duplicated.length >= 3}
            speed={800}
            grabCursor
            autoplay={{
              delay: 4000,
              disableOnInteraction: false,
              pauseOnMouseEnter: false,
            }}
            coverflowEffect={{
              rotate: 0,
              stretch: -40,
              depth: 300,
              modifier: 1,
              slideShadows: false,
            }}
            pagination={{
              el: '.testimonial-pagination',
              clickable: true,
              renderBullet: (index, className) => {
                return `<span class="${className} testimonial-bullet"></span>`
              },
            }}
            breakpoints={{
              320: { slidesPerView: 1.1 },
              768: { slidesPerView: 1.8 },
              1024: { slidesPerView: 2.5 },
              1280: { slidesPerView: 3 },
            }}
            className="!pb-16"
          >
            {(duplicated.length < 4 ? duplicated : testimonials).map((testimonial, idx) => (
              <SwiperSlide key={`${testimonial.id}-${idx}`} className="!h-auto py-8">
                <TestimonialSlide testimonial={testimonial} />
              </SwiperSlide>
            ))}
          </Swiper>

          <div className="testimonial-pagination flex justify-center gap-1.5 mt-2" />
        </div>
      </div>

      <style>{`
        .testimonial-bullet {
          display: inline-block;
          width: 36px;
          height: 3px;
          border-radius: 2px;
          background: rgba(99, 102, 241, 0.2);
          cursor: pointer;
          transition: all 0.4s ease;
          position: relative;
          overflow: hidden;
        }
        .testimonial-bullet::after {
          content: '';
          position: absolute;
          inset: 0;
          background: rgb(99, 102, 241);
          transform: scaleX(0);
          transform-origin: left;
          transition: transform 4s linear;
        }
        .testimonial-bullet.swiper-pagination-bullet-active::after {
          transform: scaleX(1);
          transform-origin: left;
        }
        .testimonial-bullet.swiper-pagination-bullet-active {
          background: rgba(99, 102, 241, 0.3);
          width: 48px;
        }
      `}</style>
    </section>
  )
}
