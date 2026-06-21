import { useState, useEffect } from 'react'
import { motion, AnimatePresence } from 'framer-motion'
import { ShieldCheck, ChevronDown } from 'lucide-react'

export default function CookieBanner({ consent, hasConsent, acceptAll, acceptEssential, updatePreference, showBanner, showSettings, openSettings, closeBanner }) {
  const [localSettings, setLocalSettings] = useState(false)
  const [analytics, setAnalytics] = useState(consent?.analytics ?? false)

  useEffect(() => {
    if (showSettings) {
      setLocalSettings(true)
    }
  }, [showSettings])

  useEffect(() => {
    if (!showBanner) {
      setLocalSettings(false)
    }
  }, [showBanner])

  function handleAcceptAll() {
    const result = acceptAll()
    if (result.analytics) {
      window.dispatchEvent(new CustomEvent('cookie-consent-analytics-accepted'))
    }
  }

  function handleAcceptEssential() {
    acceptEssential()
  }

  function handleSave() {
    const result = updatePreference({ analytics })
    if (result.analytics) {
      window.dispatchEvent(new CustomEvent('cookie-consent-analytics-accepted'))
    }
  }

  if (!showBanner && !consent) return null

  const alreadyConsented = consent !== null && !showSettings

  return (
    <AnimatePresence>
      {showBanner && (
        <motion.div
          initial={{ y: 120, opacity: 0 }}
          animate={{ y: 0, opacity: 1 }}
          exit={{ y: 120, opacity: 0 }}
          transition={{ type: 'spring', damping: 25, stiffness: 300 }}
          className="fixed bottom-0 left-0 right-0 z-[90] p-4 sm:p-6"
        >
          <div className="max-w-4xl mx-auto bg-slate-900 border border-slate-700/60 rounded-2xl shadow-2xl shadow-black/40 p-5 sm:p-6">
            {!localSettings ? (
              <div className="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                <div className="flex items-start gap-3 flex-1">
                  <div className="w-9 h-9 rounded-lg bg-indigo-500/20 flex items-center justify-center flex-shrink-0 mt-0.5">
                    <ShieldCheck className="w-5 h-5 text-indigo-400" />
                  </div>
                  <div>
                    <p className="text-sm text-white font-medium mb-1">We use cookies</p>
                    <p className="text-xs text-gray-400 leading-relaxed">
                      We use essential cookies for site functionality and analytics cookies to understand how you use our site.
                      You can choose which cookies to accept.
                    </p>
                  </div>
                </div>
                <div className="flex items-center gap-2 flex-shrink-0 w-full sm:w-auto">
                  {!alreadyConsented && (
                    <>
                      <button
                        onClick={() => setLocalSettings(true)}
                        className="px-4 py-2 text-xs font-medium text-gray-300 bg-white/5 border border-white/10 rounded-lg hover:bg-white/10 transition-colors whitespace-nowrap"
                      >
                        Customize
                      </button>
                      <button
                        onClick={handleAcceptAll}
                        className="px-5 py-2 text-xs font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition-colors whitespace-nowrap"
                      >
                        Accept All
                      </button>
                    </>
                  )}
                  {alreadyConsented && (
                    <button
                      onClick={closeBanner}
                      className="px-5 py-2 text-xs font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition-colors"
                    >
                      Close
                    </button>
                  )}
                </div>
              </div>
            ) : (
              <div>
                <div className="flex items-center gap-3 mb-4">
                  <div className="w-9 h-9 rounded-lg bg-indigo-500/20 flex items-center justify-center">
                    <ShieldCheck className="w-5 h-5 text-indigo-400" />
                  </div>
                  <div>
                    <p className="text-sm text-white font-medium">Cookie Preferences</p>
                    <p className="text-xs text-gray-400">Choose which cookies you allow.</p>
                  </div>
                </div>

                <div className="space-y-3 mb-5">
                  <div className="flex items-center justify-between bg-slate-800 rounded-lg px-4 py-3">
                    <div>
                      <p className="text-sm text-white font-medium">Essential Cookies</p>
                      <p className="text-xs text-gray-400 mt-0.5">Required for site functionality, CSRF & session security.</p>
                    </div>
                    <div className="w-10 h-6 bg-indigo-600/40 rounded-full flex items-center justify-center flex-shrink-0">
                      <div className="w-3.5 h-3.5 bg-indigo-400 rounded-full" />
                    </div>
                  </div>

                  <div className={`flex items-center justify-between rounded-lg px-4 py-3 border transition-colors ${analytics ? 'bg-slate-800 border-indigo-500/30' : 'bg-slate-800/50 border-slate-700/30'}`}>
                    <div>
                      <p className="text-sm text-white font-medium">Analytics Cookies</p>
                      <p className="text-xs text-gray-400 mt-0.5">Help us improve by understanding visitor behavior.</p>
                    </div>
                    <button
                      onClick={() => setAnalytics(!analytics)}
                      className={`relative w-10 h-6 rounded-full transition-colors flex-shrink-0 ${analytics ? 'bg-indigo-600' : 'bg-slate-600'}`}
                    >
                      <div className={`absolute top-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform ${analytics ? 'translate-x-[18px]' : 'translate-x-0.5'}`} />
                    </button>
                  </div>
                </div>

                <div className="flex items-center gap-2">
                  <button
                    onClick={handleAcceptAll}
                    className="px-5 py-2 text-xs font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition-colors"
                  >
                    Accept All
                  </button>
                  <button
                    onClick={handleSave}
                    className="px-5 py-2 text-xs font-medium text-gray-300 bg-white/5 border border-white/10 rounded-lg hover:bg-white/10 transition-colors"
                  >
                    Save Preferences
                  </button>
                  <button
                    onClick={handleAcceptEssential}
                    className="px-4 py-2 text-xs font-medium text-gray-400 hover:text-gray-300 transition-colors ml-auto"
                  >
                    Essential Only
                  </button>
                </div>
              </div>
            )}
          </div>
        </motion.div>
      )}
    </AnimatePresence>
  )
}
