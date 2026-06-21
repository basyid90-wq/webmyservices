import AdminLayout from '@/components/Shop/AdminLayout'
import { Truck, CheckCircle } from 'lucide-react'

const shipments = [
  { id: 1, order: '#HL-25060007', customer: 'Pn Sofuha', courier: 'Skynet', tracking: 'SK-12345678', status: 'Delivered', date: '20 Jun 2026' },
  { id: 2, order: '#HL-25060006', customer: 'MiJuen Restaurant', courier: 'J&T Express', tracking: 'JT-87654321', status: 'Shipped', date: '19 Jun 2026' },
  { id: 3, order: '#HL-25060005', customer: 'Ahmad Bakar', courier: 'Ninja Van', tracking: 'NV-24680135', status: 'Processing', date: '18 Jun 2026' },
]

export default function AdminShipping() {
  return (
    <AdminLayout>
      <div className="space-y-4">
        <div><h1 className="text-xl font-bold text-slate-800">Shipping Management</h1><p className="text-sm text-slate-500 mt-1">Manage shipments and assign couriers</p></div>

        <div className="grid grid-cols-1 md:grid-cols-4 gap-4">
          {[
            { icon: Truck, label: 'Skynet', count: 12, color: 'bg-orange-500' },
            { icon: Truck, label: 'J&T Express', count: 8, color: 'bg-red-500' },
            { icon: Truck, label: 'Ninja Van', count: 5, color: 'bg-purple-500' },
            { icon: Truck, label: 'Pos Laju', count: 3, color: 'bg-blue-500' },
          ].map(c => (
            <div key={c.label} className="bg-white border border-gray-100 rounded-xl p-4 text-center hover:shadow-md transition-shadow">
              <div className={`w-10 h-10 rounded-lg ${c.color} bg-opacity-10 flex items-center justify-center mx-auto mb-2`}>
                <c.icon className={`w-5 h-5 ${c.color.replace('bg-', 'text-')}`} />
              </div>
              <div className="text-lg font-bold text-slate-800">{c.count}</div>
              <div className="text-xs text-slate-500">{c.label}</div>
            </div>
          ))}
        </div>

        <div className="bg-white border border-gray-100 rounded-xl p-5">
          <h3 className="text-sm font-semibold text-slate-800 mb-4">Active Shipments</h3>
          <div className="space-y-3">
            {shipments.map(s => (
              <div key={s.id} className="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                <div className="flex items-center gap-3">
                  <Truck className="w-5 h-5 text-slate-400" />
                  <div><span className="text-sm font-medium text-slate-700">{s.order}</span><span className="text-xs text-slate-400 ml-2">{s.customer}</span></div>
                </div>
                <div className="text-xs text-slate-500">{s.courier}<br /><span className="font-mono text-cyan-600">{s.tracking}</span></div>
                <span className={`px-2 py-0.5 rounded-full text-xs font-medium ${s.status === 'Delivered' ? 'bg-emerald-50 text-emerald-600' : s.status === 'Shipped' ? 'bg-cyan-50 text-cyan-600' : 'bg-indigo-50 text-indigo-600'}`}>{s.status}</span>
              </div>
            ))}
          </div>
        </div>
      </div>
    </AdminLayout>
  )
}
