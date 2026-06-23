import { useState, useCallback } from 'react'
import { Swiper, SwiperSlide, useSwiperSlide } from 'swiper/react'
import { Navigation, Pagination, EffectCoverflow } from 'swiper/modules'
import { motion, AnimatePresence } from 'framer-motion'
import { ArrowLeft, ArrowRight, Image, FolderOpen } from 'lucide-react'
import { route } from '@/lib/ziggy'
import 'swiper/css'
import 'swiper/css/navigation'
import 'swiper/css/pagination'
import 'swiper/css/effect-coverflow'

function PortfolioSlide({ project }) {
  const { isActive } = useSwiperSlide()

  return (
    <div
      className={`relative overflow-hidden rounded-2xl bg-gray-900 border transition-all duration-500 ${
        isActive
          ? 'border-indigo-500/40 shadow-xl shadow-indigo-500/10 scale-100 opacity-100'
          : 'border-gray-800 scale-[0.92] opacity-50 hover:opacity-80'
      }`}
    >
      <a href={route('project.detail', { project: project.slug })} className="block group">
        <div className="relative overflow-hidden aspect-[16/10] bg-gray-800">
          {project.thumbnail ? (
            <img
              src={`/storage/${project.thumbnail}`}
              alt={project.title}
              className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out"
            />
          ) : (
            <div className="w-full h-full flex items-center justify-center text-gray-600">
              <Image className="w-16 h-16" />
            </div>
          )}
          <span className="absolute top-3 left-3 bg-indigo-600/90 backdrop-blur text-white text-xs font-semibold px-3 py-1 rounded-full tracking-wide">
            {project.category}
          </span>
          {isActive && (
            <div className="absolute inset-0 bg-gradient-to-t from-gray-900/80 via-transparent to-transparent" />
          )}
        </div>
        <div className="p-5">
          <h3 className="text-lg font-semibold text-white mb-1 group-hover:text-indigo-400 transition-colors">
            {project.title}
          </h3>
          {project.client && (
            <p className="text-sm text-gray-500">{project.client.name}</p>
          )}
        </div>
      </a>
    </div>
  )
}

export default function Portfolio({ projects, categories }) {
  const [activeFilter, setActiveFilter] = useState('all')
  const [swiper, setSwiper] = useState(null)

  const filtered = activeFilter === 'all'
    ? projects
    : projects.filter((p) => p.category_slug === activeFilter)

  const goNext = useCallback(() => swiper?.slideNext(), [swiper])
  const goPrev = useCallback(() => swiper?.slidePrev(), [swiper])

  const handleFilterChange = (slug) => {
    setActiveFilter(slug)
    setTimeout(() => {
      swiper?.update()
      swiper?.slideTo(0, 300)
    }, 50)
  }

  return (
    <section id="portfolio" className="py-24 lg:py-32 bg-slate-900/30 overflow-hidden">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <motion.div
          initial={{ opacity: 0, y: 30 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          className="text-center mb-12"
        >
          <p className="text-indigo-400 text-sm font-semibold tracking-widest uppercase mb-3">Our Work</p>
          <h2 className="text-3xl md:text-4xl font-bold text-white mb-4">Our Portfolio</h2>
          <p className="text-gray-400 max-w-2xl mx-auto">
            Some of the projects we have delivered for our clients.
          </p>
        </motion.div>

        <div className="flex flex-wrap items-center justify-center gap-2 mb-12">
          <button
            onClick={() => handleFilterChange('all')}
            className={`px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 ${
              activeFilter === 'all'
                ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/25'
                : 'bg-gray-800 text-gray-300 hover:bg-gray-700 hover:text-white'
            }`}
          >
            All
          </button>
          {categories.map((cat) => (
            <button
              key={cat.id}
              onClick={() => handleFilterChange(cat.slug)}
              className={`px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 ${
                activeFilter === cat.slug
                  ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/25'
                  : 'bg-gray-800 text-gray-300 hover:bg-gray-700 hover:text-white'
              }`}
            >
              {cat.name}
            </button>
          ))}
        </div>

        {filtered.length > 0 ? (
          <div className="relative">
            <AnimatePresence mode="wait">
              <motion.div
                key={activeFilter}
                initial={{ opacity: 0 }}
                animate={{ opacity: 1 }}
                exit={{ opacity: 0 }}
                transition={{ duration: 0.3 }}
              >
                <Swiper
                  onSwiper={setSwiper}
                  modules={[Navigation, Pagination, EffectCoverflow]}
                  effect="coverflow"
                  centeredSlides
                  slidesPerView="auto"
                  spaceBetween={20}
                  loop={filtered.length >= 3}
                  speed={600}
                  grabCursor
                  coverflowEffect={{
                    rotate: 0,
                    stretch: -10,
                    depth: 200,
                    modifier: 1,
                    slideShadows: false,
                  }}
                  navigation={{
                    prevEl: '.portfolio-prev',
                    nextEl: '.portfolio-next',
                  }}
                  pagination={{
                    el: '.portfolio-pagination',
                    clickable: true,
                    bulletClass: 'inline-block w-2 h-2 rounded-full bg-gray-600 mx-1 cursor-pointer transition-all duration-300',
                    bulletActiveClass: '!bg-indigo-500 !w-6',
                  }}
                  breakpoints={{
                    320: { slidesPerView: 1.15 },
                    768: { slidesPerView: 2 },
                    1024: { slidesPerView: 2.5 },
                    1280: { slidesPerView: 3 },
                  }}
                  className="!pb-14"
                >
                  {filtered.map((project) => (
                    <SwiperSlide key={project.id} className="!h-auto">
                      <PortfolioSlide project={project} />
                    </SwiperSlide>
                  ))}
                </Swiper>
              </motion.div>
            </AnimatePresence>

            {filtered.length > 2 && (
              <>
                <button
                  onClick={goPrev}
                  className="portfolio-prev absolute top-1/2 -left-2 lg:-left-6 -translate-y-1/2 z-10 w-10 h-10 rounded-full bg-white/10 backdrop-blur border border-white/10 flex items-center justify-center text-white hover:bg-white/20 hover:border-indigo-500/30 transition-all duration-300 shadow-lg"
                >
                  <ArrowLeft className="w-4 h-4" />
                </button>
                <button
                  onClick={goNext}
                  className="portfolio-next absolute top-1/2 -right-2 lg:-right-6 -translate-y-1/2 z-10 w-10 h-10 rounded-full bg-white/10 backdrop-blur border border-white/10 flex items-center justify-center text-white hover:bg-white/20 hover:border-indigo-500/30 transition-all duration-300 shadow-lg"
                >
                  <ArrowRight className="w-4 h-4" />
                </button>
              </>
            )}
            <div className="portfolio-pagination flex justify-center gap-1 mt-4" />
          </div>
        ) : (
          <motion.div
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            className="flex flex-col items-center justify-center py-20 text-gray-500"
          >
            <FolderOpen className="w-12 h-12 mb-3" />
            <p className="text-sm">No projects in this category yet.</p>
          </motion.div>
        )}

        {projects.length >= 50 && (
          <div className="text-center mt-12">
            <a
              href={route('portfolio')}
              className="inline-flex items-center gap-2 text-indigo-400 hover:text-indigo-300 font-medium transition-colors"
            >
              View All
              <ArrowRight className="w-4 h-4" />
            </a>
          </div>
        )}
      </div>
    </section>
  )
}
