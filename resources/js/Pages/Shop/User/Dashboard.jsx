import UserLayout from '@/components/Shop/UserLayout'
import { ShoppingBag, Truck, DollarSign, Clock } from 'lucide-react'
import { route } from '@/lib/ziggy'

const stats = [
  { icon: ShoppingBag, label: 'Total Orders', value: '12', color: 'bg-cyan-500' },
  { icon: Truck, label: 'Active Shipments', value: '2', color: 'bg-indigo-500' },
  { icon: DollarSign, label: 'Total Spent', value: 'RM 2,450', color: 'bg-emerald-500' },
  { icon: Clock, label: 'Last Order', value: '2 days ago', color: 'bg-amber-500' },
]

const recentOrders = [
  { id: '#HL-25060007', total: 'RM 128', status: 'Delivered', date: '20 Jun 2026', courier: 'Skynet', tracking: 'SK-12345678' },
  { id: '#HL-25060006', total: 'RM 456', status: 'Shipped', date: '19 Jun 2026', courier: 'J&T Express', tracking: 'JT-87654321' },
  { id: '#HL-25060005', total: 'RM 890', status: 'Processing', date: '18 Jun 2026', courier: 'Ninja Van', tracking: 'NV-24680135' },
]

export default function UserDashboard() {
  return (
    <UserLayout>
      <div className="space-y-6">
        <div><h1 className="text-xl font-bold text-slate-800">Welcome, Demo User</h1><p className="text-sm text-slate-500 mt-1">Your account overview</p></div>

        <div className="grid grid-cols-2 lg:grid-cols-4 gap-4">
          {stats.map(s => (
            <div key={s.label} className="bg-white border border-gray-100 rounded-xl p-4">
              <div className={`w-8 h-8 rounded-lg ${s.color} bg-opacity-10 flex items-center justify-center mb-2`}>
                <s.icon className={`w-4 h-4 ${s.color.replace('bg-', 'text-')}`} />
              </div>
              <div className="text-lg font-bold text-slate-800">{s.value}</div>
              <div className="text-xs text-slate-400">{s.label}</div>
            </div>
          ))}
        </div>

        <div className="bg-white border border-gray-100 rounded-xl p-5">
          <h3 className="text-sm font-semibold text-slate-800 mb-4">Recent Orders</h3>
          <div className="space-y-3">
            {recentOrders.map(o => (
              <a key={o.id} href={route('shop.order.detail', o.id)} className="flex items-center justify-between p-3 bg-slate-50 rounded-lg hover:bg-slate-100 transition-colors">
                <div>
                  <span className="text-sm font-medium text-slate-700">{o.id}</span>
                  <span className="text-xs text-slate-400 ml-2">{o.date}</span>
                </div>
                <div className="flex items-center gap-4">
                  <span className="text-xs text-slate-500">{o.courier}</span>
                  <span className={`px-2 py-0.5 rounded-full text-xs font-medium ${o.status === 'Delivered' ? 'bg-emerald-50 text-emerald-600' : o.status === 'Shipped' ? 'bg-cyan-50 text-cyan-600' : 'bg-indigo-50 text-indigo-600'}`}>{o.status}</span>
                  <span className="text-sm font-medium text-slate-700">{o.total}</span>
                </div>
              </a>
            ))}
          </div>
        </div>
      </div>
    </UserLayout>
  )
}
