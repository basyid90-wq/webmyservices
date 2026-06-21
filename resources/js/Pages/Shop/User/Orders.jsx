import UserLayout from '@/components/Shop/UserLayout'
import { route } from '@/lib/ziggy'
import { Truck } from 'lucide-react'

const orders = [
  { id: 7, order: '#HL-25060007', total: 'RM 128', items: 3, status: 'Delivered', date: '20 Jun 2026', courier: 'Skynet', tracking: 'SK-12345678' },
  { id: 6, order: '#HL-25060006', total: 'RM 456', items: 5, status: 'Shipped', date: '19 Jun 2026', courier: 'J&T Express', tracking: 'JT-87654321' },
  { id: 5, order: '#HL-25060005', total: 'RM 890', items: 8, status: 'Processing', date: '18 Jun 2026', courier: 'Ninja Van', tracking: 'NV-24680135' },
  { id: 4, order: '#HL-25060004', total: 'RM 234', items: 2, status: 'Paid', date: '17 Jun 2026', courier: null, tracking: null },
  { id: 3, order: '#HL-25060003', total: 'RM 567', items: 4, status: 'Pending', date: '16 Jun 2026', courier: null, tracking: null },
]
const statusColors = { Delivered: 'bg-emerald-50 text-emerald-600', Shipped: 'bg-cyan-50 text-cyan-600', Processing: 'bg-indigo-50 text-indigo-600', Paid: 'bg-amber-50 text-amber-600', Pending: 'bg-gray-100 text-gray-600' }

export default function UserOrders() {
  return (
    <UserLayout>
      <div className="space-y-4">
        <div><h1 className="text-xl font-bold text-slate-800">My Orders</h1><p className="text-sm text-slate-500 mt-1">All your purchase history</p></div>
        <div className="bg-white border border-gray-100 rounded-xl overflow-hidden">
          <table className="w-full text-sm">
            <thead><tr className="border-b border-gray-100 text-slate-400 text-xs"><th className="text-left p-4">Order</th><th className="text-right p-4">Items</th><th className="text-right p-4">Total</th><th className="text-center p-4">Status</th><th className="text-left p-4">Courier</th><th className="text-left p-4">Date</th></tr></thead>
            <tbody>
              {orders.map(o => (
                <tr key={o.id} className="border-b border-gray-50 hover:bg-slate-50">
                  <td className="p-4"><a href={route('shop.order.detail', o.id)} className="font-mono text-xs text-cyan-600 hover:underline">{o.order}</a></td>
                  <td className="p-4 text-right text-slate-600">{o.items}</td>
                  <td className="p-4 text-right font-medium text-slate-700">{o.total}</td>
                  <td className="p-4 text-center"><span className={`px-2.5 py-0.5 rounded-full text-xs font-medium ${statusColors[o.status]}`}>{o.status}</span></td>
                  <td className="p-4 text-xs text-slate-500">{o.courier || '—'}</td>
                  <td className="p-4 text-xs text-slate-400">{o.date}</td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>
    </UserLayout>
  )
}
