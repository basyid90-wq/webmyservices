import { useState } from 'react'
import { motion, AnimatePresence } from 'framer-motion'
import { ArrowRight, Image } from 'lucide-react'
import { route } from '@/lib/ziggy'

export default function Portfolio({ projects, categories }) {
  const [activeFilter, setActiveFilter] = useState('all')

  const filtered = activeFilter === 'all'
    ? projects
    : projects.filter((p) => (p.category || '').trim().toLowerCase() === activeFilter.trim().toLowerCase())

  return (
    <section id="portfolio" className="py-24 lg:py-32 bg-slate-900/30">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center mb-16">
          <p className="text-indigo-400 text-sm font-semibold tracking-widest uppercase mb-3">Our Work</p>
          <h2 className="text-3xl md:text-4xl font-bold text-white mb-4">Our Portfolio</h2>
          <p className="text-gray-400 max-w-2xl mx-auto">
            Some of the projects we have delivered for our clients.
          </p>
        </div>

        <div className="flex flex-wrap items-center justify-center gap-2 mb-10">
          <button
            onClick={() => setActiveFilter('all')}
            className={`px-4 py-2 rounded-lg text-sm font-medium transition-colors ${
              activeFilter === 'all' ? 'bg-indigo-600 text-white' : 'bg-gray-800 text-gray-300 hover:bg-gray-700'
            }`}
          >
All
          </button>
          {categories.map((cat) => (
            <button
              key={cat.id}
              onClick={() => setActiveFilter(cat.name)}
              className={`px-4 py-2 rounded-lg text-sm font-medium transition-colors ${
                activeFilter === cat.name ? 'bg-indigo-600 text-white' : 'bg-gray-800 text-gray-300 hover:bg-gray-700'
              }`}
            >
              {cat.name}
            </button>
          ))}
        </div>

        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <AnimatePresence mode="popLayout">
            {filtered.map((project) => (
              <motion.a
                key={project.id}
                layout
                initial={{ opacity: 0, scale: 0.9 }}
                animate={{ opacity: 1, scale: 1 }}
                exit={{ opacity: 0, scale: 0.9 }}
                href={route('project.detail', { project: project.slug })}
                className="group bg-gray-900 border border-gray-800 rounded-xl overflow-hidden hover:border-indigo-500/50 transition-all duration-300 hover:shadow-lg hover:shadow-indigo-500/5"
              >
                <div className="relative overflow-hidden aspect-video bg-gray-800">
                  {project.thumbnail ? (
                    <img
                      src={`/storage/${project.thumbnail}`}
                      alt={project.title}
                      className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                    />
                  ) : (
                    <div className="w-full h-full flex items-center justify-center text-gray-600">
                      <Image className="w-16 h-16" />
                    </div>
                  )}
                  <span className="absolute top-3 left-3 bg-indigo-600/90 text-white text-xs font-medium px-2.5 py-1 rounded-full">
                    {project.category}
                  </span>
                </div>
                <div className="p-5">
                  <h3 className="text-lg font-semibold text-white mb-1 group-hover:text-indigo-400 transition-colors">
                    {project.title}
                  </h3>
                  {project.client && (
                    <p className="text-sm text-gray-500">{project.client.name}</p>
                  )}
                </div>
              </motion.a>
            ))}
          </AnimatePresence>
        </div>

        {projects.length >= 6 && (
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
