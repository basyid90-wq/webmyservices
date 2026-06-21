import { useForm } from '@inertiajs/react'
import { motion } from 'framer-motion'
import { Mail, Phone, MapPin } from 'lucide-react'
import Button from '@/components/ui/Button'

export default function ContactSection() {
  const { data, setData, post, processing, errors } = useForm({
    name: '',
    email: '',
    subject: '',
    message: '',
  })

  function handleSubmit(e) {
    e.preventDefault()
    post('/contact')
  }

  return (
    <section id="contact" className="py-24 lg:py-32 bg-slate-900/30">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center mb-16">
          <p className="text-indigo-400 text-sm font-semibold tracking-widest uppercase mb-3">Contact Us</p>
          <h2 className="text-3xl md:text-4xl font-bold text-white mb-4">Let's Discuss Your Project</h2>
          <p className="text-gray-400 max-w-2xl mx-auto">
            Have a project in mind? Get in touch and let's talk.
          </p>
        </div>

        <div className="grid grid-cols-1 lg:grid-cols-2 gap-12 max-w-5xl mx-auto">
          <motion.form
            onSubmit={handleSubmit}
            initial={{ opacity: 0, x: -20 }}
            whileInView={{ opacity: 1, x: 0 }}
            viewport={{ once: true }}
            className="space-y-5"
          >
            <div>
              <input
                type="text"
                placeholder="Name"
                value={data.name}
                onChange={(e) => setData('name', e.target.value)}
                className="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-colors"
              />
              {errors.name && <p className="text-red-400 text-xs mt-1">{errors.name}</p>}
            </div>
            <div>
              <input
                type="email"
                placeholder="Email"
                value={data.email}
                onChange={(e) => setData('email', e.target.value)}
                className="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-colors"
              />
              {errors.email && <p className="text-red-400 text-xs mt-1">{errors.email}</p>}
            </div>
            <div>
              <input
                type="text"
                placeholder="Subject"
                value={data.subject}
                onChange={(e) => setData('subject', e.target.value)}
                className="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-colors"
              />
              {errors.subject && <p className="text-red-400 text-xs mt-1">{errors.subject}</p>}
            </div>
            <div>
              <textarea
                rows={5}
                placeholder="Message"
                value={data.message}
                onChange={(e) => setData('message', e.target.value)}
                className="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-colors resize-none"
              />
              {errors.message && <p className="text-red-400 text-xs mt-1">{errors.message}</p>}
            </div>
            <Button type="submit" disabled={processing} className="w-full">
              {processing ? 'Sending...' : 'Send'}
            </Button>
          </motion.form>

          <motion.div
            initial={{ opacity: 0, x: 20 }}
            whileInView={{ opacity: 1, x: 0 }}
            viewport={{ once: true }}
            className="flex flex-col justify-center space-y-8"
          >
            {[
              { icon: Mail, label: 'Email', value: 'basyid90@gmail.com' },
              { icon: Phone, label: 'Phone', value: '019-4920559' },
              { icon: MapPin, label: 'Address', value: 'No 2-2A Taman Desa Pangkor, 32300 Pulau Pangkor, Perak' },
            ].map((item) => (
              <div key={item.label} className="flex items-start gap-4">
                <div className="w-10 h-10 flex items-center justify-center rounded-lg bg-indigo-500/10 text-indigo-400 flex-shrink-0">
                  <item.icon className="w-5 h-5" />
                </div>
                <div>
                  <h4 className="text-sm font-semibold text-white mb-1">{item.label}</h4>
                  <p className="text-sm text-gray-400">{item.value}</p>
                </div>
              </div>
            ))}
          </motion.div>
        </div>
      </div>
    </section>
  )
}
