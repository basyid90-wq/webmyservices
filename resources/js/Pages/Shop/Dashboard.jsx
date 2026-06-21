import { route } from '@/lib/ziggy'
import ShopLayout from '@/components/Shop/ShopLayout'
import { Package, Clock, Truck, CheckCircle, ArrowRight } from 'lucide-react'

const statusIcons = {
  pending: Clock,
  paid: Package,
  processing: Package,
  shipped: Truck,
  delivered: CheckCircle,
}
const statusColors = {
  pending: 'text-amber-600 bg-amber-50',
  paid: 'text-blue-600 bg-blue-50',
  processing: 'text-indigo-600 bg-indigo-50',
  shipped: 'text-cyan-600 bg-cyan-50',
  delivered: 'text-emerald-600 bg-emerald-50',
}
const statusLabels = {
  pending: 'Menunggu Bayaran',
  paid: 'Dibayar',
  processing: 'Diproses',
  shipped: 'Dihantar',
  delivered: 'Diterima',
}

export default function Dashboard({ orders }) {
  return (
    <ShopLayout>
      <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
        <div className="flex items-center justify-between mb-8">
          <div>
            <h1 className="text-2xl font-bold text-slate-800">Dashboard</h1>
            <p className="text-sm text-slate-500">Pesanan dan tracking anda</p>
          </div>
          <a href={route('shop.catalog')} className="text-sm text-cyan-600 hover:underline">Beli-Belah</a>
        </div>

        {orders.length === 0 ? (
          <div className="text-center py-16 bg-white border border-gray-100 rounded-xl">
            <Package className="w-12 h-12 text-slate-300 mx-auto mb-3" />
            <p className="text-slate-500 mb-4">Tiada pesanan lagi.</p>
            <a href={route('shop.catalog')} className="text-sm text-cyan-600 hover:underline font-medium">
              Mula Beli-Belah <ArrowRight className="w-3.5 h-3.5 inline" />
            </a>
          </div>
        ) : (
          <div className="space-y-4">
            {orders.map(order => {
              const Icon = statusIcons[order.status] || Clock
              return (
                <a key={order.id} href={route('shop.order.detail', order.id)}
                  className="block bg-white border border-gray-100 rounded-xl p-5 hover:border-cyan-200 transition-colors">
                  <div className="flex items-center justify-between mb-3">
                    <span className="text-xs font-mono text-slate-500">{order.order_number}</span>
                    <span className={`inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium ${statusColors[order.status]}`}>
                      <Icon className="w-3 h-3" />
                      {statusLabels[order.status]}
                    </span>
                  </div>
                  <div className="flex items-center justify-between">
                    <div>
                      <span className="text-sm font-semibold text-slate-800">RM {order.total}</span>
                      <span className="text-xs text-slate-400 ml-2">{order.items?.length || 0} item</span>
                    </div>
                    <span className="text-xs text-slate-400">{new Date(order.created_at).toLocaleDateString('ms-MY')}</span>
                  </div>
                  {order.shipment && (
                    <div className="mt-3 pt-3 border-t border-gray-100 flex items-center gap-2 text-xs text-slate-500">
                      <Truck className="w-3.5 h-3.5" />
                      {order.shipment.provider?.name} · {order.shipment.tracking_number}
                    </div>
                  )}
                </a>
              )
            })}
          </div>
        )}
      </div>
    </ShopLayout>
  )
}