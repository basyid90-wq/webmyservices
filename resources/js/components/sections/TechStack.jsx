import { motion } from 'framer-motion'

export default function TechStack({ techStacks }) {
  if (!techStacks || techStacks.length === 0) return null

  return (
    <section className="py-20 bg-slate-900/20 overflow-hidden">
      <div className="text-center mb-10">
          <p className="text-indigo-400 text-sm font-semibold tracking-widest uppercase mb-3">
            Technologies We Use
          </p>
          <h2 className="text-3xl md:text-4xl font-bold text-white mb-4">Tech Stack</h2>
      </div>

      <div className="max-w-4xl mx-auto px-8">
        <div className="flex items-center justify-center gap-10 md:gap-14 flex-wrap">
          {techStacks.map((tech, i) => (
            <motion.div
              key={tech.id}
              initial={{ opacity: 0, scale: 0.8 }}
              whileInView={{ opacity: 1, scale: 1 }}
              viewport={{ once: true }}
              transition={{ delay: i * 0.08 }}
              whileHover={{ scale: 1.1 }}
              className="flex flex-col items-center gap-1.5"
            >
              {tech.logo && (
                <img
                  src={`/storage/${tech.logo}`}
                  alt={tech.name}
                  className="h-12 md:h-16 w-auto object-contain grayscale hover:grayscale-0 transition-all duration-300"
                />
              )}
              <span className="text-[11px] text-white font-semibold bg-indigo-600 px-2.5 py-0.5 rounded-full">
                {tech.name}
              </span>
            </motion.div>
          ))}
        </div>
      </div>
    </section>
  )
}
