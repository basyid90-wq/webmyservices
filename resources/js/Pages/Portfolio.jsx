import { motion } from 'framer-motion'
import { ArrowRight, Image } from 'lucide-react'
import { route } from '@/lib/ziggy'
import Layout from '@/components/Layout'

export default function Portfolio({ projects }) {
  return (
    <Layout>
      <section className="pt-32 pb-24">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-16">
            <p className="text-indigo-400 text-sm font-semibold tracking-widest uppercase mb-3">Hasil Kerja</p>
            <h1 className="text-3xl md:text-4xl font-bold text-white mb-4">Portfolio Kami</h1>
            <p className="text-gray-400 max-w-2xl mx-auto">
              Semua projek yang pernah kami siapkan.
            </p>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {projects.map((project) => (
              <motion.a
                key={project.id}
                initial={{ opacity: 0, y: 20 }}
                whileInView={{ opacity: 1, y: 0 }}
                viewport={{ once: true }}
                href={route('project.detail', { project: project.slug })}
                className="group bg-gray-900 border border-gray-800 rounded-xl overflow-hidden hover:border-indigo-500/50 transition-all duration-300"
              >
                <div className="relative overflow-hidden aspect-video bg-gray-800">
                  {project.thumbnail ? (
                    <img src={`/storage/${project.thumbnail}`} alt={project.title} className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                  ) : (
                    <div className="w-full h-full flex items-center justify-center text-gray-600">
                      <Image className="w-16 h-16" />
                    </div>
                  )}
                  <span className="absolute top-3 left-3 bg-indigo-600/90 text-white text-xs font-medium px-2.5 py-1 rounded-full">{project.category}</span>
                </div>
                <div className="p-5">
                  <h3 className="text-lg font-semibold text-white group-hover:text-indigo-400 transition-colors">{project.title}</h3>
                  {project.client && <p className="text-sm text-gray-500 mt-1">{project.client.name}</p>}
                </div>
              </motion.a>
            ))}
          </div>
        </div>
      </section>
    </Layout>
  )
}
