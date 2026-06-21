import AdminLayout from '@/components/Shop/AdminLayout'
import { Ticket, Copy } from 'lucide-react'

const coupons = [
  { code: 'RAYA2026', type: '20% Off', min: 'RM 50', used: '12/100', expiry: 'Dec 2026', active: true },
  { code: 'WELCOME10', type: 'RM 10 Off', min: 'RM 30', used: '8/50', expiry: 'Sep 2026', active: true },
  { code: 'HASILLAUT', type: '15% Off', min: 'RM 20', used: '5/-', expiry: 'Jun 2027', active: true },
  { code: 'FREESHIP', type: 'Free Ship', min: 'RM 0', used: '0/-', expiry: '—', active: false },
]

export default function AdminCoupons() {
  return (
    <AdminLayout>
      <div className="space-y-4">
        <div className="flex items-center justify-between">
          <div><h1 className="text-xl font-bold text-slate-800">Coupons</h1><p className="text-sm text-slate-500 mt-1">Manage discount codes</p></div>
          <button className="bg-cyan-500 hover:bg-cyan-600 text-white px-4 py-2 rounded-lg text-sm font-medium">+ New Coupon</button>
        </div>
        <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
          {coupons.map(c => (
            <div key={c.code} className="bg-white border border-gray-100 rounded-xl p-5 hover:shadow-md transition-shadow">
              <div className="flex items-center justify-between mb-3">
                <div className="flex items-center gap-2">
                  <Ticket className="w-5 h-5 text-cyan-500" />
                  <span className="font-bold text-slate-800 text-lg">{c.code}</span>
                </div>
                <span className={`w-2 h-2 rounded-full ${c.active ? 'bg-emerald-500' : 'bg-gray-300'}`} />
              </div>
              <div className="grid grid-cols-2 gap-2 text-xs">
                <div><span className="text-slate-400">Type:</span> <span className="text-slate-700 font-medium">{c.type}</span></div>
                <div><span className="text-slate-400">Min Order:</span> <span className="text-slate-700 font-medium">{c.min}</span></div>
                <div><span className="text-slate-400">Used:</span> <span className="text-slate-700 font-medium">{c.used}</span></div>
                <div><span className="text-slate-400">Expiry:</span> <span className="text-slate-700 font-medium">{c.expiry}</span></div>
              </div>
            </div>
          ))}
        </div>
      </div>
    </AdminLayout>
  )
}
