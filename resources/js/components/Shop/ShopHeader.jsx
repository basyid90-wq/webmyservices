import { useState } from 'react'
import { usePage, router } from '@inertiajs/react'
import { Menu, X, ShoppingBag, Search, User, LogOut } from 'lucide-react'
import { route } from '@/lib/ziggy'

export default function ShopHeader() {
  const [mobileOpen, setMobileOpen] = useState(false)
  const { props } = usePage()
  const user = props.auth?.user

  function logout() {
    router.post(route('shop.logout'))
  }

  return (
    <header className="sticky top-0 z-50 bg-white/95 backdrop-blur border-b border-gray-100">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex items-center justify-between h-16 lg:h-18">
          <div className="flex items-center gap-8">
            <a href={route('shop.catalog')} className="flex items-center gap-2.5">
              <div className="w-8 h-8 rounded-lg bg-gradient-to-br from-cyan-500 to-blue-600 flex items-center justify-center">
                <span className="text-white font-bold text-xs">HL</span>
              </div>
              <div>
                <span className="text-sm font-bold text-slate-800 leading-tight">
                  Hasil<span className="text-cyan-500">Laut</span>
                </span>
                <span className="block text-[9px] text-slate-400 -mt-0.5">Pangkor</span>
              </div>
            </a>
            <nav className="hidden lg:flex items-center gap-1">
              {[
                { label: 'Semua Produk', href: route('shop.catalog') },
                { label: 'Ikan Kering', href: route('shop.catalog', { category: 'ikan-kering' }) },
                { label: 'Udang & Sotong', href: route('shop.catalog', { category: 'udang-sotong' }) },
                { label: 'Sambal & Sos', href: route('shop.catalog', { category: 'sambal-sos' }) },
              ].map((link) => (
                <a key={link.label} href={link.href} className="px-3 py-2 text-sm text-slate-500 hover:text-slate-800 rounded-lg hover:bg-slate-50 transition-colors">
                  {link.label}
                </a>
              ))}
            </nav>
          </div>

          <div className="flex items-center gap-3">
            <a href={route('shop.cart')} className="relative p-2 text-slate-500 hover:text-slate-700 transition-colors">
              <ShoppingBag className="w-5 h-5" />
            </a>
            {user ? (
              <>
                <a href={user.email?.includes('admin') ? route('shop.admin.dashboard') : route('shop.dashboard')}
                  className="p-2 text-slate-500 hover:text-slate-700 transition-colors" title="Dashboard">
                  <User className="w-5 h-5" />
                </a>
                <button onClick={logout} className="hidden lg:block text-xs text-slate-400 hover:text-slate-600">
                  ({user.name})
                </button>
              </>
            ) : (
              <a href={route('shop.login')} className="p-2 text-slate-500 hover:text-slate-700 transition-colors" title="Login">
                <User className="w-5 h-5" />
              </a>
            )}
            <button onClick={() => setMobileOpen(!mobileOpen)} className="lg:hidden p-2 text-slate-500">
              {mobileOpen ? <X className="w-5 h-5" /> : <Menu className="w-5 h-5" />}
            </button>
          </div>
        </div>
      </div>

      {mobileOpen && (
        <div className="lg:hidden border-t border-gray-100 bg-white">
          <div className="px-4 py-3 space-y-1">
            {[
              { label: 'Semua Produk', href: route('shop.catalog') },
              { label: 'Ikan Kering', href: route('shop.catalog', { category: 'ikan-kering' }) },
              { label: 'Udang & Sotong', href: route('shop.catalog', { category: 'udang-sotong' }) },
              { label: 'Sambal & Sos', href: route('shop.catalog', { category: 'sambal-sos' }) },
            ].map((link) => (
              <a key={link.label} href={link.href} onClick={() => setMobileOpen(false)} className="block px-3 py-2.5 text-sm text-slate-500 hover:text-slate-800 rounded-lg hover:bg-slate-50">
                {link.label}
              </a>
            ))}
            <a href={route('shop.cart')} onClick={() => setMobileOpen(false)} className="flex items-center gap-2 px-3 py-2.5 text-sm font-medium text-white bg-cyan-500 rounded-lg hover:bg-cyan-600">
              <ShoppingBag className="w-4 h-4" /> Troli
            </a>
          </div>
        </div>
      )}
    </header>
  )
}
