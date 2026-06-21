import { motion } from 'framer-motion'
import { Code2, Globe, Server, Search, PenTool, Headphones } from 'lucide-react'

const iconMap = {
  'heroicon-o-code-bracket': Code2,
  'heroicon-o-globe-alt': Globe,
  'heroicon-o-server': Server,
  'heroicon-o-magnifying-glass': Search,
  'heroicon-o-paint-brush': PenTool,
  'heroicon-o-headphones': Headphones,
}

export default function Services({ services }) {
  return (
    <section id="services" className="py-24 lg:py-32">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center mb-16">
          <p className="text-indigo-400 text-sm font-semibold tracking-widest uppercase mb-3">
            Our Services
          </p>
          <h2 className="text-3xl md:text-4xl font-bold text-white mb-4">
            What We Offer
          </h2>
          <p className="text-gray-400 max-w-2xl mx-auto">
            Complete services from start to finish — domain, hosting, web, everything.
          </p>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          {services.map((service, i) => {
            const Icon = iconMap[service.icon] || Code2
            return (
              <motion.div
                key={service.id}
                initial={{ opacity: 0, y: 20 }}
                whileInView={{ opacity: 1, y: 0 }}
                viewport={{ once: true }}
                transition={{ delay: i * 0.1 }}
                className="group bg-white/5 backdrop-blur border border-white/10 rounded-xl p-6 hover:border-indigo-500/50 transition-all duration-300 hover:shadow-lg hover:shadow-indigo-500/5"
              >
                <div className="w-12 h-12 flex items-center justify-center rounded-lg bg-indigo-500/10 text-indigo-400 mb-5 group-hover:bg-indigo-500/20 transition-colors">
                  <Icon className="w-6 h-6" />
                </div>
                <h3 className="text-lg font-semibold text-white mb-3">{service.title}</h3>
                <p className="text-gray-400 text-sm leading-relaxed">{service.description}</p>
              </motion.div>
            )
          })}
        </div>
      </div>
    </section>
  )
}
