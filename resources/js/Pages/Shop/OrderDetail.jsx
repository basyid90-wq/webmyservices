import { route } from '@/lib/ziggy'
import ShopLayout from '@/components/Shop/ShopLayout'
import { Package, Clock, Truck, CheckCircle, MapPin } from 'lucide-react'

const statusSteps = ['pending', 'paid', 'processing', 'shipped', 'delivered']
const statusLabels = { pending: 'Menunggu', paid: 'Dibayar', processing: 'Diproses', shipped: 'Dihantar', delivered: 'Diterima' }
const statusIcons = { pending: Clock, paid: Package, processing: Package, shipped: Truck, delivered: CheckCircle }

export default function OrderDetail({ order }) {
  const currentStep = statusSteps.indexOf(order.status)

  return (
    <ShopLayout>
      <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
        <a href={route('shop.dashboard')} className="text-sm text-slate-400 hover:text-slate-600 mb-6 inline-block">&larr; Kembali ke Dashboard</a>
        <div className="flex items-center justify-between mb-6">
          <div>
            <h1 className="text-xl font-bold text-slate-800">Pesanan {order.order_number}</h1>
            <p className="text-sm text-slate-500">{new Date(order.created_at).toLocaleDateString('ms-MY', { day: 'numeric', month: 'long', year: 'numeric' })}</p>
          </div>
          <span className="text-lg font-bold text-slate-800">RM {order.total}</span>
        </div>

        <div className="bg-white border border-gray-100 rounded-xl p-5 mb-6">
          <h3 className="text-sm font-semibold text-slate-800 mb-4">Status Pesanan</h3>
          <div className="flex items-center gap-0">
            {statusSteps.map((step, i) => {
              const Icon = statusIcons[step]
              const active = i <= currentStep
              return (
                <div key={step} className="flex-1 flex items-center">
                  <div className="flex flex-col items-center">
                    <div className={`w-8 h-8 rounded-full flex items-center justify-center text-xs ${active ? 'bg-cyan-500 text-white' : 'bg-gray-200 text-gray-400'}`}>
                      <Icon className="w-4 h-4" />
                    </div>
                    <span className={`text-[9px] mt-1 ${active ? 'text-slate-700 font-medium' : 'text-gray-400'}`}>{statusLabels[step]}</span>
                  </div>
                  {i < statusSteps.length - 1 && (
                    <div className={`flex-1 h-0.5 mx-1 ${i < currentStep ? 'bg-cyan-500' : 'bg-gray-200'}`} />
                  )}
                </div>
              )
            })}
          </div>
        </div>

        {order.shipment && (
          <div className="bg-white border border-gray-100 rounded-xl p-5 mb-6">
            <h3 className="text-sm font-semibold text-slate-800 mb-3 flex items-center gap-2">
              <Truck className="w-4 h-4 text-cyan-500" />
              Penghantaran — {order.shipment.provider?.name}
            </h3>
            <p className="text-xs text-slate-500 mb-3">Tracking: <span className="font-mono text-cyan-600">{order.shipment.tracking_number}</span></p>
            {order.shipment.tracking_history && order.shipment.tracking_history.length > 0 && (
              <div className="space-y-2">
                {order.shipment.tracking_history.map((t, i) => (
                  <div key={i} className="flex gap-3 text-xs">
                    <div className="flex flex-col items-center">
                      <div className={`w-2 h-2 rounded-full ${i === 0 ? 'bg-cyan-500' : 'bg-gray-300'}`} />
                      {i < order.shipment.tracking_history.length - 1 && <div className="w-px flex-1 bg-gray-200" />}
                    </div>
                    <div className="pb-2">
                      <p className="text-slate-700">{t.description}</p>
                      <p className="text-slate-400">{t.location} · {new Date(t.timestamp).toLocaleString('ms-MY')}</p>
                    </div>
                  </div>
                ))}
              </div>
            )}
          </div>
        )}

        <div className="bg-white border border-gray-100 rounded-xl p-5 mb-6">
          <h3 className="text-sm font-semibold text-slate-800 mb-3">Item Pesanan</h3>
          {order.items?.map(item => (
            <div key={item.id} className="flex items-center gap-3 py-3 border-b border-gray-50 last:border-0">
              <div className="w-10 h-10 rounded-lg bg-slate-50 flex items-center justify-center text-lg">🐟</div>
              <div className="flex-1">
                <span className="text-sm text-slate-700">{item.product_name}</span>
                <span className="text-xs text-slate-400 ml-2">×{item.quantity}</span>
              </div>
              <span className="text-sm font-medium text-slate-700">RM {item.subtotal}</span>
            </div>
          ))}
        </div>

        <div className="bg-white border border-gray-100 rounded-xl p-5">
          <h3 className="text-sm font-semibold text-slate-800 mb-3 flex items-center gap-2"><MapPin className="w-4 h-4 text-cyan-500" />Alamat Penghantaran</h3>
          <p className="text-sm text-slate-600">{order.customer_name}</p>
          <p className="text-xs text-slate-500">{order.customer_phone}</p>
          <p className="text-xs text-slate-500 mt-1">{order.shipping_address}, {order.shipping_postcode} {order.shipping_city}, {order.shipping_state}</p>
        </div>
      </div>
    </ShopLayout>
  )
}