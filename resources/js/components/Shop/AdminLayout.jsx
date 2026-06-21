import { useState } from 'react'
import { usePage, router } from '@inertiajs/react'
import { route } from '@/lib/ziggy'
import {
  LayoutDashboard, Package, ShoppingBag, Truck, CreditCard,
  Ticket, Users, ChevronLeft, LogOut, Menu, X, Store,
} from 'lucide-react'

const menu = [
  { icon: LayoutDashboard, label: 'Dashboard', route: 'shop.admin.dashboard' },
  { icon: Package, label: 'Products', route: 'shop.admin.products' },
  { icon: ShoppingBag, label: 'Orders', route: 'shop.admin.orders' },
  { icon: Truck, label: 'Shipping', route: 'shop.admin.shipping' },
  { icon: CreditCard, label: 'Payments', route: 'shop.admin.payments' },
  { icon: Ticket, label: 'Coupons', route: 'shop.admin.coupons' },
  { icon: Users, label: 'Customers', route: 'shop.admin.customers' },
]

export default function AdminLayout({ children }) {
  const { props } = usePage()
  const user = props.auth?.user
  const [collapsed, setCollapsed] = useState(false)
  const [mobileOpen, setMobileOpen] = useState(false)
  const active = props.ziggy?.location || ''

  function logout() { router.post(route('shop.logout')) }

  const sidebar = (
    <div className={`${collapsed ? 'w-16' : 'w-56'} bg-slate-800 h-screen flex flex-col transition-all duration-200 flex-shrink-0`}>
      <div className="p-4 flex items-center gap-2.5 border-b border-slate-700">
        <div className="w-7 h-7 rounded-lg bg-gradient-to-br from-cyan-400 to-blue-600 flex items-center justify-center flex-shrink-0">
          <span className="text-white font-bold text-[10px]">HL</span>
        </div>
        {!collapsed && <span className="text-sm font-bold text-white">HasilLaut <span className="text-cyan-400">Admin</span></span>}
      </div>
      <nav className="flex-1 p-2 space-y-0.5 overflow-y-auto">
        {menu.map(item => {
          const isActive = active.includes(route(item.route))
          return (
            <a key={item.label} href={route(item.route)}
              className={`flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-colors ${
                isActive ? 'bg-cyan-500/15 text-cyan-400' : 'text-slate-400 hover:text-white hover:bg-slate-700'
              }`}
              title={collapsed ? item.label : ''}>
              <item.icon className="w-4 h-4 flex-shrink-0" />
              {!collapsed && item.label}
            </a>
          )
        })}
      </nav>
      <div className="p-2 border-t border-slate-700 space-y-1">
        <a href={route('shop.catalog')} className="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-slate-400 hover:text-white hover:bg-slate-700 transition-colors">
          <Store className="w-4 h-4" /> {!collapsed && 'Back to Store'}
        </a>
        <button onClick={logout} className="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-slate-400 hover:text-red-400 hover:bg-slate-700 transition-colors">
          <LogOut className="w-4 h-4" /> {!collapsed && 'Logout'}
        </button>
      </div>
    </div>
  )

  return (
    <div className="flex h-screen bg-gray-100">
      <div className="hidden lg:block">{sidebar}</div>
      {mobileOpen && <div className="fixed inset-0 z-50 lg:hidden"><div className="absolute inset-0 bg-black/50" onClick={() => setMobileOpen(false)} />{sidebar}</div>}
      <div className="flex-1 flex flex-col overflow-hidden">
        <header className="bg-white border-b border-gray-200 h-14 flex items-center justify-between px-4 lg:px-6 flex-shrink-0">
          <button onClick={() => setMobileOpen(true)} className="lg:hidden p-1 text-slate-500"><Menu className="w-5 h-5" /></button>
          <button onClick={() => setCollapsed(!collapsed)} className="hidden lg:block p-1 text-slate-400 hover:text-slate-600"><ChevronLeft className={`w-4 h-4 transition-transform ${collapsed ? 'rotate-180' : ''}`} /></button>
          <div className="flex items-center gap-3 text-sm text-slate-500">
            <span>{user?.name}</span>
            <div className="w-7 h-7 rounded-full bg-cyan-500 text-white flex items-center justify-center text-xs font-bold">{user?.name?.[0]}</div>
          </div>
        </header>
        <main className="flex-1 overflow-y-auto p-4 lg:p-6">{children}</main>
      </div>
    </div>
  )
}
