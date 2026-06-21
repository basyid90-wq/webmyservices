import { useState } from 'react'
import { motion } from 'framer-motion'
import { Check } from 'lucide-react'
import Button from '@/components/ui/Button'
import PricingModal from '@/components/sections/PricingModal'

const defaultPlans = [
  {
    id: 1,
    name: 'Starter',
    price: '499',
    period: 'one-time',
    popular: false,
    features: [
      'Free .com.my domain (1 year)',
      '1GB Hosting (1 year)',
      '3-5 page website',
      'Mobile responsive',
      'Basic SEO',
      '1 month support',
    ],
  },
  {
    id: 2,
    name: 'Professional',
    price: '1499',
    period: 'one-time',
    popular: true,
    features: [
      'All Starter features',
      'Free .com.my domain (2 years)',
      '5GB Hosting (2 years)',
      '5-10 page website',
      'Basic e-commerce system',
      'Advanced SEO',
      'Google Analytics + Search Console',
      '3 months support',
    ],
  },
  {
    id: 3,
    name: 'Enterprise',
    price: '3999',
    period: 'one-time',
    popular: false,
    features: [
      'All Professional features',
      'Choice of domain (3 years)',
      'Unlimited hosting (3 years)',
      'Unlimited custom website',
      'Custom system (CRM, invoicing, etc.)',
      'Full SEO + Social Media setup',
      '12 months support',
      'Monthly website maintenance',
      'Priority support 24/7',
    ],
  },
]

const featureList = (features) =>
  Array.isArray(features)
    ? features.map((f) => (typeof f === 'string' ? f : f.feature))
    : []

export default function Pricing({ pricingPlans }) {
  const [modalPlan, setModalPlan] = useState(null)

  const plans = pricingPlans && pricingPlans.length > 0
    ? pricingPlans.map((p) => ({
        ...p,
        features: featureList(p.features),
        price: parseFloat(p.price).toString(),
      }))
    : defaultPlans

  return (
    <section id="pricing" className="py-24 lg:py-32 bg-slate-900/30">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center mb-16">
          <p className="text-indigo-400 text-sm font-semibold tracking-widest uppercase mb-3">Pricing</p>
          <h2 className="text-3xl md:text-4xl font-bold text-white mb-4">Pricing Plans</h2>
          <p className="text-gray-400 max-w-2xl mx-auto">
            Choose a plan that fits your business needs. No hidden fees.
          </p>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-5xl mx-auto">
          {plans.map((plan, i) => (
            <motion.div
              key={plan.id || plan.name}
              initial={{ opacity: 0, y: 20 }}
              whileInView={{ opacity: 1, y: 0 }}
              viewport={{ once: true }}
              transition={{ delay: i * 0.1 }}
              className={`relative bg-white/5 backdrop-blur border rounded-xl p-8 flex flex-col ${
                plan.popular
                  ? 'border-indigo-500/50 shadow-xl shadow-indigo-500/10'
                  : 'border-white/10 hover:border-indigo-500/30'
              }`}
            >
              {plan.popular && (
                <div className="absolute -top-3 left-1/2 -translate-x-1/2 bg-indigo-600 text-white text-xs font-semibold px-4 py-1 rounded-full">
                  Most Popular
                </div>
              )}
              <div className="mb-6">
                <h3 className="text-lg font-semibold text-white mb-2">{plan.name}</h3>
                <div className="flex items-baseline gap-1">
                  <span className="text-4xl font-bold text-white">RM{plan.price}</span>
                  <span className="text-sm text-gray-500">/{plan.period}</span>
                </div>
              </div>
              <ul className="space-y-3 mb-8 flex-1">
                {plan.features.map((feature) => (
                  <li key={feature} className="flex items-start gap-2.5 text-sm text-gray-400">
                    <Check className="w-4 h-4 text-indigo-400 mt-0.5 flex-shrink-0" />
                    {feature}
                  </li>
                ))}
              </ul>
              <Button
                variant={plan.popular ? 'primary' : 'outline'}
                className="w-full"
                onClick={() => setModalPlan(plan)}
              >
                Choose {plan.name}
              </Button>
            </motion.div>
          ))}
        </div>
      </div>

      <PricingModal
        plan={modalPlan}
        isOpen={modalPlan !== null}
        onClose={() => setModalPlan(null)}
      />
    </section>
  )
}
