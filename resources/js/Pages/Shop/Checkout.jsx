import { route } from '@/lib/ziggy'
import ShopLayout from '@/components/Shop/ShopLayout'
import useShopCart from '@/hooks/useShopCart'
import { CreditCard, Shield, Truck, ShoppingBag } from 'lucide-react'

export default function Checkout({ errors, csrf_token }) {
  const { cart, subtotal } = useShopCart()
  const shipping = subtotal > 100 ? 0 : 10
  const total = subtotal + shipping

  return (
    <ShopLayout>
      <div className="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
        <h1 className="text-2xl font-bold text-slate-800 mb-8">Checkout</h1>

        {errors.payment && (
          <div className="mb-6 bg-red-50 border border-red-200 text-red-600 text-sm px-4 py-3 rounded-xl">{errors.payment}</div>
        )}

        {cart.items.length === 0 ? (
          <div className="text-center py-20">
            <p className="text-slate-500">Your cart is empty.</p>
            <a href={route('shop.catalog')} className="text-cyan-500 text-sm mt-2 inline-block">Back to Shop</a>
          </div>
        ) : (
        <form method="POST" action={route('shop.checkout.process')} acceptCharset="UTF-8">
          <input type="hidden" name="_token" value={document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''} />
          <input type="hidden" name="cart_subtotal" value={subtotal} />
          <input type="hidden" name="cart_shipping" value={shipping} />
          <input type="hidden" name="cart_total" value={total} />
          {cart.items.map((item, i) => (
            <span key={i}>
              <input type="hidden" name={`items[${i}][product_id]`} value={item.product_id} />
              <input type="hidden" name={`items[${i}][name]`} value={item.name} />
              <input type="hidden" name={`items[${i}][price]`} value={item.price} />
              <input type="hidden" name={`items[${i}][quantity]`} value={item.quantity} />
            </span>
          ))}

          <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div className="lg:col-span-2 space-y-6">
              <div className="bg-white border border-gray-100 rounded-xl p-5">
                <h3 className="text-sm font-semibold text-slate-800 mb-4">Maklumat Pelanggan</h3>
                <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                  <div>
                    <label className="block text-xs text-slate-500 mb-1">Nama Penuh *</label>
                    <input name="customer_name" type="text" required className="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-slate-800 bg-white placeholder:text-gray-400 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 outline-none" />
                  </div>
                  <div>
                    <label className="block text-xs text-slate-500 mb-1">Emel *</label>
                    <input name="customer_email" type="email" required className="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-slate-800 bg-white placeholder:text-gray-400 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 outline-none" />
                  </div>
                  <div className="sm:col-span-2">
                    <label className="block text-xs text-slate-500 mb-1">Telefon *</label>
                    <input name="customer_phone" type="text" required className="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-slate-800 bg-white placeholder:text-gray-400 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 outline-none" />
                  </div>
                </div>
              </div>

              <div className="bg-white border border-gray-100 rounded-xl p-5">
                <h3 className="text-sm font-semibold text-slate-800 mb-4">Alamat Penghantaran</h3>
                <div className="space-y-4">
                  <div>
                    <label className="block text-xs text-slate-500 mb-1">Alamat *</label>
                    <textarea name="shipping_address" rows={2} required className="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-slate-800 bg-white placeholder:text-gray-400 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 outline-none resize-none" />
                  </div>
                  <div className="grid grid-cols-3 gap-4">
                    <div>
                      <label className="block text-xs text-slate-500 mb-1">Bandar *</label>
                      <input name="shipping_city" type="text" required className="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-slate-800 bg-white placeholder:text-gray-400 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 outline-none" />
                    </div>
                    <div>
                      <label className="block text-xs text-slate-500 mb-1">Negeri *</label>
                      <input name="shipping_state" type="text" required className="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-slate-800 bg-white placeholder:text-gray-400 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 outline-none" />
                    </div>
                    <div>
                      <label className="block text-xs text-slate-500 mb-1">Poskod *</label>
                      <input name="shipping_postcode" type="text" required className="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-slate-800 bg-white placeholder:text-gray-400 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 outline-none" />
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div className="space-y-4">
              <div className="bg-slate-50 border border-gray-100 rounded-xl p-5">
                <h3 className="text-sm font-semibold text-slate-800 mb-4 flex items-center gap-2">
                  <ShoppingBag className="w-4 h-4 text-cyan-500" />
                  Pesanan Anda
                </h3>
                <div className="space-y-2 mb-4">
                  {cart.items?.map((item) => (
                    <div key={item.id} className="flex justify-between text-xs text-slate-600">
                      <span>{item.name} × {item.quantity}</span>
                      <span>RM {(item.price * item.quantity).toFixed(2)}</span>
                    </div>
                  ))}
                </div>
                <div className="space-y-2 text-sm pt-3 border-t border-gray-200">
                  <div className="flex justify-between text-slate-500"><span>Subtotal</span><span>RM {subtotal.toFixed(2)}</span></div>
                  <div className="flex justify-between text-slate-500"><span>Penghantaran</span><span>{shipping === 0 ? <span className="text-emerald-600">PERCUMA</span> : `RM ${shipping}`}</span></div>
                  <div className="flex justify-between font-bold text-slate-800 pt-2 border-t border-gray-200"><span>Jumlah</span><span>RM {total.toFixed(2)}</span></div>
                </div>
              </div>

              <div className="bg-white border border-gray-100 rounded-xl p-5">
                <h3 className="text-sm font-semibold text-slate-800 mb-3">Pembayaran</h3>
                <label className="flex items-center gap-3 p-3 rounded-lg border border-cyan-500 bg-cyan-50 cursor-pointer">
                  <input type="radio" name="payment_channel" value="2" defaultChecked className="hidden" />
                  <CreditCard className="w-5 h-5 text-cyan-500" />
                  <div className="text-sm"><span className="font-medium text-slate-700">FPX Online Banking</span><span className="block text-xs text-slate-400">Semua bank di Malaysia</span></div>
                </label>
                <div className="flex items-center gap-2 mt-3 text-[10px] text-slate-400">
                  <Shield className="w-3 h-3" /> Pembayaran selamat oleh Bayarcash
                </div>
              </div>

              <button type="submit"
                className="w-full flex items-center justify-center gap-2 bg-cyan-500 hover:bg-cyan-600 text-white px-6 py-3.5 rounded-xl font-medium text-sm transition-colors">
                <CreditCard className="w-4 h-4" />
                Bayar Sekarang
              </button>

              <div className="flex items-center gap-2 text-[10px] text-slate-400 justify-center">
                <Truck className="w-3 h-3" /> Penghantaran 3-5 hari bekerja
              </div>
            </div>
          </div>
        </form>
        )}
      </div>
    </ShopLayout>
  )
}
