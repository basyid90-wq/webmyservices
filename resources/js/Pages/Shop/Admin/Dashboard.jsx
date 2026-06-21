import AdminLayout from '@/components/Shop/AdminLayout'
import { BarChart3, Package, ShoppingBag, Users, Truck, Ticket, TrendingUp, DollarSign } from 'lucide-react'

const stats = [
  { icon: DollarSign, label: 'Revenue', value: 'RM 24,850', change: '+12.5%', color: 'bg-emerald-500' },
  { icon: ShoppingBag, label: 'Total Orders', value: '156', change: '+8.2%', color: 'bg-cyan-500' },
  { icon: Users, label: 'Customers', value: '42', change: '+18.7%', color: 'bg-indigo-500' },
  { icon: Package, label: 'Products', value: '18', change: '5 low stock', color: 'bg-amber-500' },
  { icon: Truck, label: 'Shipments', value: '28', change: '3 pending', color: 'bg-violet-500' },
  { icon: Ticket, label: 'Coupons Used', value: '34', change: '2 active', color: 'bg-rose-500' },
]

export default function AdminDashboard() {
  return (
    <AdminLayout>
      <div className="space-y-6">
        <div>
          <h1 className="text-xl font-bold text-slate-800">Admin Dashboard</h1>
          <p className="text-sm text-slate-500 mt-1">Overview of your store performance</p>
        </div>

        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
          {stats.map(s => (
            <div key={s.label} className="bg-white border border-gray-100 rounded-xl p-5 hover:shadow-md transition-shadow">
              <div className="flex items-center justify-between mb-3">
                <div className={`w-10 h-10 rounded-lg ${s.color} bg-opacity-10 flex items-center justify-center`}>
                  <s.icon className={`w-5 h-5 ${s.color.replace('bg-', 'text-')}`} />
                </div>
                <span className="text-xs font-medium text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">{s.change}</span>
              </div>
              <div className="text-2xl font-bold text-slate-800">{s.value}</div>
              <div className="text-xs text-slate-500 mt-1">{s.label}</div>
            </div>
          ))}
        </div>

        <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
          <div className="bg-white border border-gray-100 rounded-xl p-5">
            <div className="flex items-center justify-between mb-4">
              <h3 className="text-sm font-semibold text-slate-800">Recent Orders</h3>
              <span className="text-xs text-cyan-600">View All</span>
            </div>
            <table className="w-full text-xs">
              <thead><tr className="text-slate-400"><th className="text-left pb-2">Order</th><th className="text-left pb-2">Customer</th><th className="text-right pb-2">Total</th><th className="text-right pb-2">Status</th></tr></thead>
              <tbody>
                {[
                  ['HL-25060007', 'Pn Sofuha', 'RM 128', 'Delivered'], ['HL-25060006', 'MiJuen Restaurant', 'RM 456', 'Shipped'],
                  ['HL-25060005', 'Ahmad Bakar', 'RM 890', 'Processing'], ['HL-25060004', 'Siti Nur', 'RM 234', 'Paid'],
                ].map(([order, name, total, status]) => (
                  <tr key={order} className="border-t border-gray-50">
                    <td className="py-2 text-slate-500 font-mono">{order}</td><td className="py-2 text-slate-700">{name}</td>
                    <td className="py-2 text-right font-medium text-slate-700">{total}</td>
                    <td className="py-2 text-right"><span className={`px-2 py-0.5 rounded-full text-[10px] font-medium ${
                      status === 'Delivered' ? 'bg-emerald-50 text-emerald-600' : status === 'Shipped' ? 'bg-cyan-50 text-cyan-600' : status === 'Processing' ? 'bg-indigo-50 text-indigo-600' : 'bg-amber-50 text-amber-600'
                    }`}>{status}</span></td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>

          <div className="bg-white border border-gray-100 rounded-xl p-5">
            <div className="flex items-center justify-between mb-4">
              <h3 className="text-sm font-semibold text-slate-800">Revenue Chart</h3>
              <span className="text-xs text-slate-400">Last 6 months</span>
            </div>
            <div className="flex items-end gap-2 h-32 mb-2">
              {[35, 42, 28, 55, 48, 72].map((h, i) => (
                <div key={i} className="flex-1 flex flex-col items-center gap-1">
                  <div className="w-full rounded-t-md bg-gradient-to-t from-cyan-500 to-cyan-400" style={{height: `${h}%`}} />
                  <span className="text-[9px] text-slate-400">{['Jan','Feb','Mar','Apr','May','Jun'][i]}</span>
                </div>
              ))}
            </div>
            <div className="text-xs text-center text-slate-400 mt-2">RM{'\u00A0'}24,850 total revenue this year</div>
          </div>
        </div>
      </div>
    </AdminLayout>
  )
}
