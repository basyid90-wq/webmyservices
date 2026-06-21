import UserLayout from '@/components/Shop/UserLayout'
import { route } from '@/lib/ziggy'
import { Truck, Package, CheckCircle, Clock } from 'lucide-react'

const shipments = [
  { id: 7, order: '#HL-25060007', courier: 'Skynet', tracking: 'SK-12345678', status: 'Delivered',
    timeline: [
      { status: 'Delivered', desc: 'Bungkusan telah selamat diterima', location: 'Pangkor, Perak', time: '20 Jun, 2:30 PM' },
      { status: 'Out for Delivery', desc: 'Kurier sedang dalam perjalanan', location: 'Lumut, Perak', time: '20 Jun, 9:00 AM' },
      { status: 'Shipped', desc: 'Bungkusan telah diambil oleh kurier', location: 'Ipoh, Perak', time: '19 Jun, 4:00 PM' },
      { status: 'Processing', desc: 'Pesanan sedang diproses di gudang', location: 'Kuala Lumpur', time: '18 Jun, 10:00 AM' },
    ]},
  { id: 6, order: '#HL-25060006', courier: 'J&T Express', tracking: 'JT-87654321', status: 'Shipped',
    timeline: [
      { status: 'Shipped', desc: 'Bungkusan telah diambil oleh kurier', location: 'Ipoh, Perak', time: '19 Jun, 3:00 PM' },
      { status: 'Processing', desc: 'Pesanan sedang diproses di gudang', location: 'Kuala Lumpur', time: '18 Jun, 8:00 AM' },
    ]},
]

const stepIcons = { Delivered: CheckCircle, 'Out for Delivery': Truck, Shipped: Truck, Processing: Package }
const stepColors = { Delivered: 'text-emerald-500 bg-emerald-500', 'Out for Delivery': 'text-cyan-500 bg-cyan-500', Shipped: 'text-cyan-500 bg-cyan-500', Processing: 'text-indigo-500 bg-indigo-500' }

export default function UserTracking() {
  return (
    <UserLayout>
      <div className="space-y-6">
        <div><h1 className="text-xl font-bold text-slate-800">Shipment Tracking</h1><p className="text-sm text-slate-500 mt-1">Track your deliveries</p></div>

        {shipments.map(s => (
          <div key={s.id} className="bg-white border border-gray-100 rounded-xl p-5">
            <div className="flex items-center justify-between mb-4 pb-4 border-b border-gray-100">
              <div>
                <a href={route('shop.order.detail', s.id)} className="text-sm font-semibold text-cyan-600 hover:underline">{s.order}</a>
                <p className="text-xs text-slate-500 mt-0.5">{s.courier} · Tracking: <span className="font-mono text-cyan-600">{s.tracking}</span></p>
              </div>
              <span className="text-xs font-medium text-slate-500">{s.status}</span>
            </div>
            <div className="relative">
              {s.timeline.map((t, i) => {
                const Icon = stepIcons[t.status] || Clock
                return (
                  <div key={i} className="flex gap-3">
                    <div className="flex flex-col items-center">
                      <div className={`w-6 h-6 rounded-full flex items-center justify-center text-white text-[10px] ${stepColors[t.status]}`}>
                        <Icon className="w-3 h-3" />
                      </div>
                      {i < s.timeline.length - 1 && <div className="w-0.5 flex-1 bg-gray-200 my-1" />}
                    </div>
                    <div className="pb-5">
                      <p className="text-sm font-medium text-slate-700">{t.desc}</p>
                      <p className="text-xs text-slate-400">{t.location}</p>
                      <p className="text-xs text-slate-300">{t.time}</p>
                    </div>
                  </div>
                )
              })}
            </div>
          </div>
        ))}
      </div>
    </UserLayout>
  )
}
