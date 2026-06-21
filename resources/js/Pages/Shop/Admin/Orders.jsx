import AdminLayout from '@/components/Shop/AdminLayout'

const orders = [
  { id: '#HL-25060007', customer: 'Pn Sofuha', email: 'sofuha@email.com', items: 3, total: 'RM 128', status: 'Delivered', date: '20 Jun 2026', courier: 'Skynet', tracking: 'SK-12345678' },
  { id: '#HL-25060006', customer: 'MiJuen Restaurant', email: 'mijuen@email.com', items: 5, total: 'RM 456', status: 'Shipped', date: '19 Jun 2026', courier: 'J&T Express', tracking: 'JT-87654321' },
  { id: '#HL-25060005', customer: 'Ahmad Bakar', email: 'ahmad@email.com', items: 8, total: 'RM 890', status: 'Processing', date: '18 Jun 2026', courier: 'Ninja Van', tracking: 'NV-24680135' },
  { id: '#HL-25060004', customer: 'Siti Nur', email: 'siti@email.com', items: 2, total: 'RM 234', status: 'Paid', date: '17 Jun 2026', courier: null, tracking: null },
  { id: '#HL-25060003', customer: 'Ali Hassan', email: 'ali@email.com', items: 4, total: 'RM 567', status: 'Pending', date: '16 Jun 2026', courier: null, tracking: null },
]

const statusColors = { Delivered: 'bg-emerald-50 text-emerald-600', Shipped: 'bg-cyan-50 text-cyan-600', Processing: 'bg-indigo-50 text-indigo-600', Paid: 'bg-amber-50 text-amber-600', Pending: 'bg-gray-100 text-gray-600' }

export default function AdminOrders() {
  return (
    <AdminLayout>
      <div className="space-y-4">
        <div><h1 className="text-xl font-bold text-slate-800">Orders</h1><p className="text-sm text-slate-500 mt-1">All customer orders</p></div>
        <div className="bg-white border border-gray-100 rounded-xl overflow-hidden">
          <table className="w-full text-sm">
            <thead><tr className="border-b border-gray-100 text-slate-400 text-xs"><th className="text-left p-4">Order</th><th className="text-left p-4">Customer</th><th className="text-right p-4">Items</th><th className="text-right p-4">Total</th><th className="text-center p-4">Status</th><th className="text-left p-4">Courier</th><th className="text-left p-4">Date</th></tr></thead>
            <tbody>
              {orders.map(o => (
                <tr key={o.id} className="border-b border-gray-50 hover:bg-slate-50">
                  <td className="p-4 font-mono text-slate-600 text-xs">{o.id}</td>
                  <td className="p-4"><div className="font-medium text-slate-700">{o.customer}</div><div className="text-xs text-slate-400">{o.email}</div></td>
                  <td className="p-4 text-right text-slate-600">{o.items}</td>
                  <td className="p-4 text-right font-medium text-slate-700">{o.total}</td>
                  <td className="p-4 text-center"><span className={`px-2.5 py-0.5 rounded-full text-xs font-medium ${statusColors[o.status]}`}>{o.status}</span></td>
                  <td className="p-4 text-slate-500 text-xs">{o.courier || '—'}<br />{o.tracking && <span className="text-cyan-600 font-mono">{o.tracking}</span>}</td>
                  <td className="p-4 text-slate-400 text-xs">{o.date}</td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>
    </AdminLayout>
  )
}
