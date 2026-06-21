import { useState } from 'react'
import { motion, AnimatePresence } from 'framer-motion'
import { Plus } from 'lucide-react'

const faqs = [
  {
    q: 'How long does it take to complete a website?',
    a: 'Depending on project complexity. Small projects (landing pages) can be done in 3-5 days. We will provide a clear timeline before the project starts.',
  },
  {
    q: 'What do I need to provide as a client?',
    a: 'You need to provide content (text & images), business logo, and design references if any. We will guide you throughout the process.',
  },
  {
    q: 'Are the websites built mobile-friendly?',
    a: 'Yes, all our websites are built with responsive design. Your website will look great on desktop, tablet, and smartphones.',
  },
  {
    q: 'Can I update the website myself after it is done?',
    a: 'Yes, we will install a CMS (Content Management System) that makes it easy for you to update content, images, and business info without technical knowledge.',
  },
  {
    q: 'Is SEO included?',
    a: 'Yes, every website we build includes basic SEO (meta tags, sitemap, structured data). For Professional plans and above, we do more comprehensive SEO.',
  },
  {
    q: 'What about domain and hosting?',
    a: 'We handle everything — domain registration, hosting setup, business email. All included in the plan you choose.',
  },
]

export default function FAQ() {
  const [openIndex, setOpenIndex] = useState(null)

  return (
    <section id="faq" className="py-24 lg:py-32">
      <div className="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center mb-16">
          <p className="text-indigo-400 text-sm font-semibold tracking-widest uppercase mb-3">FAQ</p>
          <h2 className="text-3xl md:text-4xl font-bold text-white mb-4">
            Got Questions? We Have Answers.
          </h2>
          <p className="text-gray-400">
            Can't find the answer you're looking for? Contact us directly.
          </p>
        </div>

        <div className="space-y-3">
          {faqs.map((faq, i) => (
            <div
              key={i}
              className="bg-white/5 backdrop-blur border border-white/10 rounded-xl overflow-hidden"
            >
              <button
                onClick={() => setOpenIndex(openIndex === i ? null : i)}
                className="w-full flex items-center justify-between px-6 py-4 text-left"
              >
                <span className="text-sm font-medium text-white pr-4">{faq.q}</span>
                <motion.div
                  animate={{ rotate: openIndex === i ? 45 : 0 }}
                  transition={{ duration: 0.2 }}
                  className="text-gray-500 flex-shrink-0"
                >
                  <Plus className="w-5 h-5" />
                </motion.div>
              </button>
              <AnimatePresence>
                {openIndex === i && (
                  <motion.div
                    initial={{ height: 0, opacity: 0 }}
                    animate={{ height: 'auto', opacity: 1 }}
                    exit={{ height: 0, opacity: 0 }}
                    transition={{ duration: 0.2 }}
                    className="overflow-hidden"
                  >
                    <p className="px-6 pb-4 text-sm text-gray-400 leading-relaxed">{faq.a}</p>
                  </motion.div>
                )}
              </AnimatePresence>
            </div>
          ))}
        </div>
      </div>
    </section>
  )
}
