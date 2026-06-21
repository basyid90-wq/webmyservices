import { motion } from 'framer-motion'
import Button from '@/components/ui/Button'
import { route } from '@/lib/ziggy'

export default function CTA() {
  return (
    <section className="py-24 lg:py-32">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          className="relative overflow-hidden rounded-2xl bg-gradient-to-br from-indigo-600/20 to-purple-600/20 border border-indigo-500/20 p-8 md:p-12 text-center"
        >
          <div className="absolute inset-0 bg-[radial-gradient(ellipse_at_top,rgba(99,102,241,0.15),transparent_50%)]" />
          <div className="relative">
            <h2 className="text-3xl md:text-4xl font-bold text-white mb-4">
              Let's Build Your Website
            </h2>
            <p className="text-gray-400 max-w-xl mx-auto mb-8">
              Have a project in mind? Contact us for a free consultation. We'll help you from A-Z.
            </p>
            <a href={route('contact')}>
              <Button size="lg">
                Get In Touch Now
              </Button>
            </a>
          </div>
        </motion.div>
      </div>
    </section>
  )
}
