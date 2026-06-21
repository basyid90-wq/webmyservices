import { useState, useEffect, useCallback } from 'react'

const STORAGE_KEY = 'cookie_consent'

function loadConsent() {
  try {
    const raw = localStorage.getItem(STORAGE_KEY)
    if (raw) {
      const parsed = JSON.parse(raw)
      if (typeof parsed.essential === 'boolean' && typeof parsed.analytics === 'boolean') {
        return parsed
      }
    }
  } catch {}
  return null
}

function saveConsent(consent) {
  try {
    localStorage.setItem(STORAGE_KEY, JSON.stringify({ ...consent, timestamp: Date.now() }))
  } catch {}
}

export default function useCookieConsent() {
  const [consent, setConsentState] = useState(() => loadConsent())
  const [showBanner, setShowBanner] = useState(false)
  const [showSettings, setShowSettings] = useState(false)

  useEffect(() => {
    if (consent === null) {
      setShowBanner(true)
    }
  }, [consent])

  const hasConsent = useCallback((type) => {
    if (!consent) return false
    return consent[type] === true
  }, [consent])

  const acceptAll = useCallback(() => {
    const next = { essential: true, analytics: true }
    saveConsent(next)
    setConsentState(next)
    setShowBanner(false)
    setShowSettings(false)
    return next
  }, [])

  const acceptEssential = useCallback(() => {
    const next = { essential: true, analytics: false }
    saveConsent(next)
    setConsentState(next)
    setShowBanner(false)
    setShowSettings(false)
    return next
  }, [])

  const updatePreference = useCallback((prefs) => {
    const next = { essential: true, analytics: prefs.analytics ?? consent?.analytics ?? false }
    saveConsent(next)
    setConsentState(next)
    setShowBanner(false)
    setShowSettings(false)
    return next
  }, [consent])

  const openSettings = useCallback(() => {
    setShowSettings(true)
    setShowBanner(true)
  }, [])

  return {
    consent,
    hasConsent,
    acceptAll,
    acceptEssential,
    updatePreference,
    showBanner,
    showSettings,
    openSettings,
    closeBanner: () => setShowBanner(false),
  }
}
