import { usePage } from '@inertiajs/react'
import { useEffect, useState } from 'react'
import { motion, AnimatePresence } from 'framer-motion'
import { CheckCircle, X } from 'lucide-react'
import ShopHeader from '@/components/Shop/ShopHeader'
import ShopFooter from '@/components/Shop/ShopFooter'

function FlashMessage() {
  const { flash } = usePage().props
  const [visible, setVisible] = useState(false)

  useEffect(() => {
    if (flash?.success) {
      setVisible(true)
      const timer = setTimeout(() => setVisible(false), 4000)
      return () => clearTimeout(timer)
    }
  }, [flash?.success])

  return (
    <AnimatePresence>
      {visible && (
        <motion.div initial={{ opacity: 0, y: -20 }} animate={{ opacity: 1, y: 0 }} exit={{ opacity: 0, y: -20 }}
          className="fixed top-20 left-1/2 -translate-x-1/2 z-50">
          <div className="flex items-center gap-2 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-2.5 rounded-xl shadow-lg">
            <CheckCircle className="w-4 h-4" />
            <span className="text-sm">{flash.success}</span>
            <button onClick={() => setVisible(false)}><X className="w-3.5 h-3.5" /></button>
          </div>
        </motion.div>
      )}
    </AnimatePresence>
  )
}

export default function ShopLayout({ children }) {
  return (
    <div className="min-h-screen flex flex-col bg-white">
      <ShopHeader />
      <FlashMessage />
      <main className="flex-1">{children}</main>
      <ShopFooter />
    </div>
  )
}
