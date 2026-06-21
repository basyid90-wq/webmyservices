import { usePage } from '@inertiajs/react'
import { useEffect, useState, useRef } from 'react'
import { motion, AnimatePresence } from 'framer-motion'
import { CheckCircle, X } from 'lucide-react'
import Header from '@/components/Header'
import Footer from '@/components/Footer'
import CookieBanner from '@/components/CookieBanner'
import useCookieConsent from '@/hooks/useCookieConsent'
import { initAnalytics } from '@/lib/analytics'

function FlashMessage() {
  const { flash } = usePage().props
  const [visible, setVisible] = useState(false)

  useEffect(() => {
    if (flash?.success) {
      setVisible(true)
      const timer = setTimeout(() => setVisible(false), 5000)
      return () => clearTimeout(timer)
    }
  }, [flash?.success])

  return (
    <AnimatePresence>
      {visible && (
        <motion.div
          initial={{ opacity: 0, y: -20 }}
          animate={{ opacity: 1, y: 0 }}
          exit={{ opacity: 0, y: -20 }}
          className="fixed top-24 left-1/2 -translate-x-1/2 z-50"
        >
          <div className="flex items-center gap-3 bg-green-500/10 border border-green-500/30 text-green-400 px-5 py-3 rounded-xl backdrop-blur">
            <CheckCircle className="w-5 h-5" />
            <span className="text-sm">{flash.success}</span>
            <button onClick={() => setVisible(false)} className="ml-2 hover:text-green-300">
              <X className="w-4 h-4" />
            </button>
          </div>
        </motion.div>
      )}
    </AnimatePresence>
  )
}

export default function Layout({ children }) {
  const cookieConsent = useCookieConsent()
  const analyticsLoaded = useRef(false)

  useEffect(() => {
    if (cookieConsent.hasConsent('analytics') && !analyticsLoaded.current) {
      analyticsLoaded.current = true
      initAnalytics({ gtmId: 'GTM-XXXXXXX', pixelId: 'PIXEL-XXXXXXX' })
    }
  }, [cookieConsent.hasConsent('analytics')])

  useEffect(() => {
    function onAnalyticsAccept() {
      if (!analyticsLoaded.current) {
        analyticsLoaded.current = true
        initAnalytics({ gtmId: 'GTM-XXXXXXX', pixelId: 'PIXEL-XXXXXXX' })
      }
    }
    window.addEventListener('cookie-consent-analytics-accepted', onAnalyticsAccept)
    return () => window.removeEventListener('cookie-consent-analytics-accepted', onAnalyticsAccept)
  }, [])

  return (
    <div className="min-h-screen flex flex-col">
      <Header />
      <FlashMessage />
      <main className="flex-1">{children}</main>
      <Footer onCookieSettings={cookieConsent.openSettings} />
      <CookieBanner {...cookieConsent} />
    </div>
  )
}
