import { useState } from 'react'
import { motion } from 'framer-motion'
import { route } from '@/lib/ziggy'
import Layout from '@/components/Layout'
import { CheckCircle, Shield, Server, Settings, BarChart3, Cloud, MessageCircle, ArrowRight, Zap } from 'lucide-react'

const features = [
  { icon: Shield, title: 'Free SSL Certificate', desc: 'Auto-renewing SSL to keep your site secure and trusted by browsers.' },
  { icon: Server, title: '24/7 Server Uptime Monitoring', desc: 'We monitor your server around the clock, responding to issues before they affect your business.' },
  { icon: Settings, title: 'Routine Security Updates & Patches', desc: 'Core, plugin, and dependency updates applied monthly to prevent vulnerabilities.' },
  { icon: BarChart3, title: 'Monthly Analytics & Performance Reports', desc: 'Clear reports on traffic, speed, and SEO health, delivered to your inbox.' },
  { icon: Cloud, title: 'Cloudflare CDN & Cache Management', desc: 'Global CDN and smart caching to deliver your site fast, anywhere in the world.' },
  { icon: MessageCircle, title: 'Priority WhatsApp Technical Support', desc: 'Direct access to our support team via WhatsApp for urgent issues and quick fixes.' },
]

export default function Maintenance() {
  const [hours, setHours] = useState(10)

  const traditionalCost = hours * 150
  const ourPlanCost = 150
  const savings = traditionalCost - ourPlanCost
  const savingsPercent = Math.round((savings / traditionalCost) * 100)

  return (
    <Layout>
      <section className="pt-32 pb-24">
        <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-16">
            <p className="text-indigo-400 text-sm font-semibold tracking-widest uppercase mb-3">Maintenance</p>
            <h1 className="text-3xl md:text-4xl font-bold text-white mb-4">Website Maintenance Plans</h1>
            <p className="text-gray-400 max-w-xl mx-auto">
              Keep your website secure, fast, and always online without breaking the bank.
            </p>
          </div>

          {/* === SECTION A: PRICING CALCULATOR === */}
          <div className="bg-white/5 backdrop-blur border border-white/10 rounded-2xl p-6 sm:p-8 mb-12">
            <h2 className="text-lg font-semibold text-white mb-6 flex items-center gap-2">
              <Zap className="w-5 h-5 text-indigo-400" />
              Interactive Savings Calculator
            </h2>

            <div className="mb-8">
              <div className="flex items-center justify-between mb-2">
                <span className="text-sm text-gray-400">Maintenance Hours per Month</span>
                <span className="text-sm font-bold text-white bg-indigo-500/20 px-3 py-0.5 rounded-full">{hours} hours</span>
              </div>
              <input
                type="range"
                min="10"
                max="50"
                step="5"
                value={hours}
                onChange={(e) => setHours(parseInt(e.target.value))}
                className="w-full h-2 bg-slate-700 rounded-lg appearance-none cursor-pointer accent-indigo-500 [&::-webkit-slider-thumb]:w-5 [&::-webkit-slider-thumb]:h-5 [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:shadow-lg"
              />
              <div className="flex justify-between mt-1">
                <span className="text-xs text-gray-600">10h</span>
                <span className="text-xs text-gray-600">20h</span>
                <span className="text-xs text-gray-600">30h</span>
                <span className="text-xs text-gray-600">40h</span>
                <span className="text-xs text-gray-600">50h</span>
              </div>
            </div>

            <div className="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
              <motion.div
                key={hours}
                initial={{ opacity: 0, x: -10 }}
                animate={{ opacity: 1, x: 0 }}
                className="bg-white/5 border border-white/10 rounded-xl p-5 text-center"
              >
                <p className="text-xs text-gray-500 uppercase tracking-wider mb-2">Freelancer / In-House IT</p>
                <p className="text-3xl font-bold text-gray-400 line-through">RM {traditionalCost.toLocaleString()}</p>
                <p className="text-xs text-gray-600 mt-1">{hours}h × RM 150/h</p>
                <p className="text-[10px] text-gray-600 mt-3">Typical cost for hiring a freelance developer or maintaining an in-house IT team.</p>
              </motion.div>

              <motion.div
                key={hours}
                initial={{ opacity: 0, x: 10 }}
                animate={{ opacity: 1, x: 0 }}
                className="bg-white/5 border border-indigo-500/50 rounded-xl p-5 text-center shadow-xl shadow-indigo-500/10 relative overflow-hidden"
              >
                <div className="absolute top-0 right-0 bg-indigo-600 text-white text-[9px] font-bold px-3 py-0.5 rounded-bl-lg">
                  BEST VALUE
                </div>
                <p className="text-xs text-indigo-400 uppercase tracking-wider mb-2">WebMy Services Plan</p>
                <p className="text-3xl font-bold text-white">RM {ourPlanCost.toLocaleString()}</p>
                <p className="text-xs text-gray-400 mt-1">flat rate / month</p>
                <p className="text-[10px] text-gray-500 mt-3">Unlimited maintenance hours. All features included. No hidden costs.</p>
              </motion.div>
            </div>

            <motion.div
              key={savings}
              initial={{ scale: 0.95, opacity: 0 }}
              animate={{ scale: 1, opacity: 1 }}
              className="bg-indigo-500/10 border border-indigo-500/20 rounded-xl p-5 text-center"
            >
              <p className="text-indigo-300 text-sm mb-1">Your Monthly Savings</p>
              <p className="text-2xl sm:text-3xl font-extrabold text-white">
                Anda Jimat{' '}
                <span className="text-indigo-400">RM {savings.toLocaleString()}</span>
              </p>
              <p className="text-indigo-300/70 text-xs mt-1">That's {savingsPercent}% less than traditional maintenance costs!</p>
            </motion.div>
          </div>

          {/* === SECTION B: WHAT YOU GET === */}
          <div className="mb-12">
            <h2 className="text-lg font-semibold text-white mb-6 text-center">Everything Included in Your Plan</h2>
            <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
              {features.map((feature, i) => (
                <motion.div
                  key={feature.title}
                  initial={{ opacity: 0, y: 10 }}
                  whileInView={{ opacity: 1, y: 0 }}
                  viewport={{ once: true }}
                  transition={{ delay: i * 0.05 }}
                  className="bg-white/5 border border-white/10 rounded-xl p-5 flex items-start gap-3.5 hover:border-indigo-500/30 transition-colors"
                >
                  <div className="w-9 h-9 rounded-lg bg-indigo-500/15 flex items-center justify-center flex-shrink-0">
                    <feature.icon className="w-4.5 h-4.5 text-indigo-400" />
                  </div>
                  <div>
                    <h3 className="text-sm font-semibold text-white mb-1">{feature.title}</h3>
                    <p className="text-xs text-gray-400 leading-relaxed">{feature.desc}</p>
                  </div>
                </motion.div>
              ))}
            </div>
          </div>

          {/* === CTA === */}
          <div className="text-center">
            <a
              href={route('contact')}
              className="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3.5 rounded-xl text-sm font-medium transition-colors shadow-lg shadow-indigo-500/20"
            >
              Contact Us Now
              <ArrowRight className="w-4 h-4" />
            </a>
            <p className="text-xs text-gray-600 mt-3">No commitment. Free consultation included.</p>
          </div>
        </div>
      </section>
    </Layout>
  )
}
