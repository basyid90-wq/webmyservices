import { useState } from 'react'
import { useForm } from '@inertiajs/react'
import { route } from '@/lib/ziggy'
import ShopLayout from '@/components/Shop/ShopLayout'
import { User, Shield } from 'lucide-react'

const accounts = [
  { label: 'Admin', role: 'admin', email: 'admin@hasillaut.com', pass: 'demo123', icon: Shield, color: 'bg-slate-800', subtitle: 'Manage store' },
  { label: 'User', role: 'user', email: 'demo@hasillaut.com', pass: 'demo123', icon: User, color: 'bg-cyan-500', subtitle: 'Customer account' },
]

export default function Login() {
  const [tab, setTab] = useState(0)
  const { data, setData, post, processing, errors } = useForm({
    email: accounts[0].email,
    password: accounts[0].pass,
    remember: false,
    role: accounts[0].role,
  })

  function switchTab(i) {
    setTab(i)
    setData({ email: accounts[i].email, password: accounts[i].pass, remember: false, role: accounts[i].role })
  }

  return (
    <ShopLayout>
      <div className="max-w-md mx-auto px-4 py-16 lg:py-24">
        <div className="text-center mb-6">
          <div className="inline-flex bg-slate-100 rounded-xl p-1.5 gap-1">
            {accounts.map((a, i) => {
              const Icon = a.icon
              return (
                <button key={a.role} onClick={() => switchTab(i)}
                  className={`flex items-center gap-2 px-5 py-2.5 rounded-lg text-sm font-medium transition-all ${
                    tab === i ? 'bg-white text-slate-800 shadow-sm' : 'text-slate-400 hover:text-slate-600'
                  }`}>
                  <div className={`w-6 h-6 rounded-md flex items-center justify-center ${tab === i ? a.color : 'bg-slate-200'} text-white`}>
                    <Icon className="w-3.5 h-3.5" />
                  </div>
                  <div className="text-left">
                    <div className="text-xs leading-tight">{a.label}</div>
                    <div className="text-[10px] text-slate-400 leading-tight">{a.subtitle}</div>
                  </div>
                </button>
              )
            })}
          </div>
          <p className="text-xs text-slate-500 mt-4">Demo: Click <strong>Log Masuk</strong> to access the dashboard</p>
        </div>

        <form onSubmit={e => { e.preventDefault(); post(route('shop.login.submit')) }} className="space-y-4">
          <div>
            <label className="block text-xs text-slate-600 mb-1">Emel</label>
            <input type="email" value={data.email} onChange={e => setData('email', e.target.value)}
              className="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-slate-800 bg-white focus:border-cyan-500 outline-none" />
            {errors.email && <p className="text-red-500 text-xs mt-1">{errors.email}</p>}
          </div>
          <div>
            <label className="block text-xs text-slate-600 mb-1">Kata Laluan</label>
            <input type="password" value={data.password} onChange={e => setData('password', e.target.value)}
              className="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-slate-800 bg-white focus:border-cyan-500 outline-none" />
          </div>
          <button type="submit" disabled={processing}
            className="w-full bg-cyan-500 hover:bg-cyan-600 text-white py-2.5 rounded-xl text-sm font-medium transition-colors disabled:opacity-50">
            {processing ? 'Log Masuk...' : 'Log Masuk'}
          </button>
        </form>
      </div>
    </ShopLayout>
  )
}