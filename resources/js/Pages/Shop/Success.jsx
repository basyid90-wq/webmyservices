import { useEffect } from 'react'
import { route } from '@/lib/ziggy'
import ShopLayout from '@/components/Shop/ShopLayout'
import useShopCart from '@/hooks/useShopCart'
import { CheckCircle, ArrowRight, Package } from 'lucide-react'

export default function Success({ order }) {
  const { clearCart } = useShopCart()

  useEffect(() => {
    clearCart()
  }, [])
  return (
    <ShopLayout>
      <div className="max-w-lg mx-auto px-4 py-16 lg:py-24 text-center">
        <div className="w-16 h-16 rounded-full bg-emerald-100 flex items-center justify-center mx-auto mb-6">
          <CheckCircle className="w-8 h-8 text-emerald-600" />
        </div>
        <h1 className="text-2xl font-bold text-slate-800 mb-2">Pesanan Diterima!</h1>
        <p className="text-slate-500 mb-6">Terima kasih. Pesanan anda sedang diproses.</p>

        <div className="bg-slate-50 border border-gray-100 rounded-xl p-5 mb-6 text-left">
          <div className="space-y-2 text-sm">
            <div className="flex justify-between"><span className="text-slate-500">No Pesanan</span><span className="font-semibold text-slate-800">{order.order_number}</span></div>
            <div className="flex justify-between"><span className="text-slate-500">Status</span><span className="font-semibold text-emerald-600">{order.status === 'paid' ? 'Dibayar' : 'Menunggu Bayaran'}</span></div>
            <div className="flex justify-between"><span className="text-slate-500">Jumlah</span><span className="font-semibold text-slate-800">RM {order.total}</span></div>
          </div>
        </div>

        <div className="flex flex-col gap-3">
          <a href={route('shop.order.detail', order.id)} className="inline-flex items-center justify-center gap-2 bg-cyan-500 hover:bg-cyan-600 text-white px-6 py-2.5 rounded-xl text-sm font-medium transition-colors">
            <Package className="w-4 h-4" />
            Track Pesanan Anda
          </a>
          <a href={route('shop.catalog')} className="inline-flex items-center justify-center gap-2 text-cyan-600 hover:text-cyan-700 text-sm font-medium transition-colors">
            Sambung Beli-Belah <ArrowRight className="w-4 h-4" />
          </a>
        </div>
      </div>
    </ShopLayout>
  )
}
