import { useState } from 'react'
import { motion, AnimatePresence } from 'framer-motion'
import { X, CheckCircle, Send, Loader2 } from 'lucide-react'
import axios from 'axios'
import Button from '@/components/ui/Button'

const industries = [
  'F&B / Restaurant',
  'Contractor Services',
  'Agency / Creative',
  'E-Commerce / Retail',
  'Healthcare / Medical',
  'Education',
  'Real Estate',
  'Automotive',
  'Travel / Tourism',
  'Technology / IT',
  'Finance / Insurance',
  'Others',
]

const goals = [
  'Collect Leads (Form / Inquiry)',
  'Company Profile / Branding',
  'Booking System',
  'Product Sales (E-Commerce)',
  'Membership System',
  'Blog / Content Marketing',
  'Others',
]

const contentStatuses = [
  'Ready (logo, images, text)',
  'Partially available',
  'None at all',
]

function formatPhone(raw) {
  const digits = raw.replace(/\D/g, '')
  if (digits.length >= 10 && digits.startsWith('0')) {
    return '+60' + digits.slice(1)
  }
  if (digits.length >= 10 && !digits.startsWith('60')) {
    return '+60' + digits
  }
  if (digits.length >= 8 && digits.startsWith('60')) {
    return '+' + digits
  }
  return raw
}

const upperFields = ['name', 'company_name']

export default function PricingModal({ plan, isOpen, onClose }) {
  const [submitted, setSubmitted] = useState(false)
  const [sending, setSending] = useState(false)
  const [errors, setErrors] = useState({})

  const [formData, setFormData] = useState({
    plan_name: plan?.name || '',
    name: '',
    company_name: '',
    whatsapp: '',
    email: '',
    industry: '',
    custom_industry: '',
    website_goal: '',
    reference_urls: '',
    content_status: '',
    additional_budget: '',
    message: '',
  })

  function update(field, value) {
    if (upperFields.includes(field)) {
      value = value.toUpperCase()
    }
    if (field === 'whatsapp') {
      value = value.replace(/[^0-9+\-\s]/g, '')
    }
    setFormData((prev) => ({ ...prev, [field]: value }))
    if (errors[field]) {
      setErrors((prev) => {
        const next = { ...prev }
        delete next[field]
        return next
      })
    }
  }

  async function handleSubmit(e) {
    if (e && e.preventDefault) e.preventDefault()
    setSending(true)
    setErrors({})

    const payload = { ...formData, plan_name: plan?.name || formData.plan_name }
    if (payload.industry === 'Others' && payload.custom_industry) {
      payload.industry = payload.custom_industry
    }
    delete payload.custom_industry

    if (payload.whatsapp) {
      payload.whatsapp = formatPhone(payload.whatsapp)
    }

    if (payload.additional_budget === '') {
      delete payload.additional_budget
    }

    try {
      await axios.post('/pricing-inquiry', payload)
      setSubmitted(true)
    } catch (err) {
      if (err.response?.status === 422) {
        const serverErrors = err.response.data.errors || {}
        Object.keys(serverErrors).forEach((key) => {
          if (Array.isArray(serverErrors[key])) {
            serverErrors[key] = serverErrors[key][0]
          }
        })
        setErrors(serverErrors)
      }
    } finally {
      setSending(false)
    }
  }

  function handleClose() {
    if (submitted) {
      setFormData({
        plan_name: plan?.name || '',
        name: '',
        company_name: '',
        whatsapp: '',
        email: '',
        industry: '',
        custom_industry: '',
        website_goal: '',
        reference_urls: '',
        content_status: '',
        additional_budget: '',
        message: '',
      })
      setSubmitted(false)
    }
    onClose()
  }

  if (!isOpen) return null

  return (
    <AnimatePresence>
      <div className="fixed inset-0 z-[100] flex items-center justify-center p-4">
        <motion.div
          initial={{ opacity: 0 }}
          animate={{ opacity: 1 }}
          exit={{ opacity: 0 }}
          className="absolute inset-0 bg-black/70 backdrop-blur-sm"
          onClick={handleClose}
        />

        <motion.div
          initial={{ opacity: 0, scale: 0.95, y: 20 }}
          animate={{ opacity: 1, scale: 1, y: 0 }}
          exit={{ opacity: 0, scale: 0.95, y: 20 }}
          className="relative w-full max-w-2xl max-h-[90vh] overflow-y-auto bg-slate-900 border border-slate-700/50 rounded-2xl shadow-2xl shadow-indigo-500/10"
        >
          <button
            onClick={handleClose}
            className="absolute top-4 right-4 p-2 text-gray-400 hover:text-white hover:bg-white/10 rounded-lg transition-colors z-10"
          >
            <X className="w-5 h-5" />
          </button>

          {submitted ? (
            <div className="p-8 md:p-12 text-center">
              <motion.div
                initial={{ scale: 0 }}
                animate={{ scale: 1 }}
                transition={{ type: 'spring', delay: 0.1 }}
                className="w-16 h-16 mx-auto mb-6 rounded-full bg-indigo-500/20 flex items-center justify-center"
              >
                <CheckCircle className="w-8 h-8 text-indigo-400" />
              </motion.div>
              <h3 className="text-2xl font-bold text-white mb-3">Thank You!</h3>
              <p className="text-gray-400 mb-2">
                Your application for the <span className="text-indigo-400 font-semibold">{plan?.name}</span> plan has been received.
              </p>
              <p className="text-gray-500 text-sm">
                We will contact you shortly via the WhatsApp / Email provided.
              </p>
              <button
                onClick={handleClose}
                className="mt-8 px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors"
              >
                Close
              </button>
            </div>
          ) : (
            <>
              <div className="px-6 md:px-8 pt-6 md:pt-8 pb-4 border-b border-slate-700/50">
                <span className="text-xs font-semibold text-indigo-400 uppercase tracking-widest">
                  {plan?.name} Plan
                </span>
                <h3 className="text-xl font-bold text-white mt-1">Application Form</h3>
                <p className="text-sm text-gray-400 mt-1">
                  Fill in the details below. We'll follow up as soon as possible.
                </p>
              </div>

              <div className="p-6 md:p-8 space-y-6">
                <div className="bg-indigo-500/10 border border-indigo-500/20 rounded-lg px-4 py-3">
                  <p className="text-sm text-indigo-300">
                    Selected Plan: <span className="font-semibold text-white">{plan?.name}</span> — RM{plan?.price}
                  </p>
                </div>

                <div>
                  <p className="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Basic Information</p>
                  <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                      <label className="block text-sm text-gray-300 mb-1.5">Full Name <span className="text-red-400">*</span></label>
                      <input
                        type="text"
                        value={formData.name}
                        onChange={(e) => update('name', e.target.value)}
                        className="w-full bg-slate-800 border border-slate-600 rounded-lg px-3.5 py-2.5 text-white text-sm placeholder-gray-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-colors"
                        placeholder="Your full name"
                      />
                      {errors.name && <p className="text-red-400 text-xs mt-1">{errors.name}</p>}
                    </div>
                    <div>
                      <label className="block text-sm text-gray-300 mb-1.5">Company / Brand Name</label>
                      <input
                        type="text"
                        value={formData.company_name}
                        onChange={(e) => update('company_name', e.target.value)}
                        className="w-full bg-slate-800 border border-slate-600 rounded-lg px-3.5 py-2.5 text-white text-sm placeholder-gray-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-colors"
                        placeholder="Your company (if any)"
                      />
                      {errors.company_name && <p className="text-red-400 text-xs mt-1">{errors.company_name}</p>}
                    </div>
                    <div>
                      <label className="block text-sm text-gray-300 mb-1.5">WhatsApp Number <span className="text-red-400">*</span></label>
                      <input
                        type="tel"
                        value={formData.whatsapp}
                        onChange={(e) => update('whatsapp', e.target.value)}
                        className="w-full bg-slate-800 border border-slate-600 rounded-lg px-3.5 py-2.5 text-white text-sm placeholder-gray-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-colors"
                        placeholder="e.g. 0123456789"
                      />
                      {errors.whatsapp && <p className="text-red-400 text-xs mt-1">{errors.whatsapp}</p>}
                    </div>
                    <div>
                      <label className="block text-sm text-gray-300 mb-1.5">Email Address <span className="text-red-400">*</span></label>
                      <input
                        type="email"
                        value={formData.email}
                        onChange={(e) => update('email', e.target.value)}
                        className="w-full bg-slate-800 border border-slate-600 rounded-lg px-3.5 py-2.5 text-white text-sm placeholder-gray-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-colors"
                        placeholder="email@example.com"
                      />
                      {errors.email && <p className="text-red-400 text-xs mt-1">{errors.email}</p>}
                    </div>
                  </div>
                </div>

                <div>
                  <p className="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Project Details</p>
                  <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                      <label className="block text-sm text-gray-300 mb-1.5">Industry / Business Niche</label>
                      <select
                        value={formData.industry}
                        onChange={(e) => update('industry', e.target.value)}
                        className="w-full bg-slate-800 border border-slate-600 rounded-lg px-3.5 py-2.5 text-white text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-colors"
                      >
                        <option value="">Select industry</option>
                        {industries.map((ind) => (
                          <option key={ind} value={ind}>{ind}</option>
                        ))}
                      </select>
                      {errors.industry && <p className="text-red-400 text-xs mt-1">{errors.industry}</p>}
                      {formData.industry === 'Others' && (
                        <div className="mt-3">
                          <input
                            type="text"
                            value={formData.custom_industry}
                            onChange={(e) => update('custom_industry', e.target.value)}
                            className="w-full bg-slate-800 border border-slate-600 rounded-lg px-3.5 py-2.5 text-white text-sm placeholder-gray-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-colors"
                            placeholder="Please specify your industry..."
                          />
                        </div>
                      )}
                    </div>
                    <div>
                      <label className="block text-sm text-gray-300 mb-1.5">Main Website Purpose</label>
                      <select
                        value={formData.website_goal}
                        onChange={(e) => update('website_goal', e.target.value)}
                        className="w-full bg-slate-800 border border-slate-600 rounded-lg px-3.5 py-2.5 text-white text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-colors"
                      >
                        <option value="">Select purpose</option>
                        {goals.map((g) => (
                          <option key={g} value={g}>{g}</option>
                        ))}
                      </select>
                      {errors.website_goal && <p className="text-red-400 text-xs mt-1">{errors.website_goal}</p>}
                    </div>
                    <div className="sm:col-span-2">
                      <label className="block text-sm text-gray-300 mb-1.5">
                        Reference / Inspiration Website URL
                      </label>
                      <textarea
                        rows={2}
                        value={formData.reference_urls}
                        onChange={(e) => update('reference_urls', e.target.value)}
                        className="w-full bg-slate-800 border border-slate-600 rounded-lg px-3.5 py-2.5 text-white text-sm placeholder-gray-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-colors resize-none"
                        placeholder="Paste 1-2 links to websites whose design you like..."
                      />
                      {errors.reference_urls && <p className="text-red-400 text-xs mt-1">{errors.reference_urls}</p>}
                    </div>
                    <div className="sm:col-span-2">
                      <label className="block text-sm text-gray-300 mb-1.5">Content Status</label>
                      <div className="flex flex-wrap gap-2">
                        {contentStatuses.map((status) => (
                          <button
                            type="button"
                            key={status}
                            onClick={() => update('content_status', status)}
                            className={`px-4 py-2 rounded-lg text-sm font-medium transition-all ${
                              formData.content_status === status
                                ? 'bg-indigo-600 text-white border border-indigo-500'
                                : 'bg-slate-800 text-gray-400 border border-slate-600 hover:border-slate-500'
                            }`}
                          >
                            {status}
                          </button>
                        ))}
                      </div>
                      {errors.content_status && <p className="text-red-400 text-xs mt-1">{errors.content_status}</p>}
                    </div>
                  </div>
                </div>

                <div>
                  <p className="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Additional</p>
                  <div className="grid grid-cols-1 gap-4">
                    <div>
                      <label className="block text-sm text-gray-300 mb-1.5">Additional Budget (RM) — if custom request</label>
                      <input
                        type="number"
                        value={formData.additional_budget}
                        onChange={(e) => update('additional_budget', e.target.value)}
                        className="w-full sm:w-48 bg-slate-800 border border-slate-600 rounded-lg px-3.5 py-2.5 text-white text-sm placeholder-gray-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-colors"
                        placeholder="0.00"
                      />
                      {errors.additional_budget && <p className="text-red-400 text-xs mt-1">{errors.additional_budget}</p>}
                    </div>
                    <div>
                      <label className="block text-sm text-gray-300 mb-1.5">Message / Additional Notes</label>
                      <textarea
                        rows={3}
                        value={formData.message}
                        onChange={(e) => update('message', e.target.value)}
                        className="w-full bg-slate-800 border border-slate-600 rounded-lg px-3.5 py-2.5 text-white text-sm placeholder-gray-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-colors resize-none"
                        placeholder="Anything else you'd like us to know..."
                      />
                      {errors.message && <p className="text-red-400 text-xs mt-1">{errors.message}</p>}
                    </div>
                  </div>
                </div>

                <div className="pt-2">
                  <Button type="button" disabled={sending} className="w-full" onClick={handleSubmit}>
                    {sending ? (
                      <>
                        <Loader2 className="w-4 h-4 animate-spin" />
                        Submitting...
                      </>
                    ) : (
                      <>
                        <Send className="w-4 h-4" />
                        Submit Application
                      </>
                    )}
                  </Button>
                </div>
              </div>
            </>
          )}
        </motion.div>
      </div>
    </AnimatePresence>
  )
}
