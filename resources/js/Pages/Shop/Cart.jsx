import { route } from '@/lib/ziggy'
import ShopLayout from '@/components/Shop/ShopLayout'
import useShopCart from '@/hooks/useShopCart'
import { Minus, Plus, X, ShoppingBag, ArrowRight } from 'lucide-react'

export default function Cart() {
  const { cart, updateQty, removeItem, subtotal } = useShopCart()
  const shipping = subtotal > 100 ? 0 : 10
  const total = subtotal + shipping

  return (
    <ShopLayout>
      <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
        <h1 className="text-2xl font-bold text-slate-800 mb-8 flex items-center gap-3">
          <ShoppingBag className="w-6 h-6 text-cyan-500" />
          Your Cart
        </h1>

        {(!cart.items || cart.items.length === 0) ? (
          <div className="text-center py-20">
            <span className="text-6xl mb-4 block">🛒</span>
            <p className="text-slate-500 mb-6">Your cart is empty.</p>
            <a href={route('shop.catalog')} className="inline-flex items-center gap-2 bg-cyan-500 text-white px-6 py-2.5 rounded-xl text-sm font-medium hover:bg-cyan-600">
              Start Shopping <ArrowRight className="w-4 h-4" />
            </a>
          </div>
        ) : (
          <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div className="lg:col-span-2 space-y-3">
              {cart.items.map((item) => (
                <div key={item.product_id} className="flex items-center gap-4 bg-white border border-gray-100 rounded-xl p-4">
                  <div className="w-16 h-16 rounded-lg bg-slate-50 flex items-center justify-center text-2xl flex-shrink-0">🐟</div>
                  <div className="flex-1 min-w-0">
                    <h4 className="text-sm font-semibold text-slate-800 truncate">{item.name}</h4>
                    <span className="text-sm font-bold text-slate-700">RM {item.price}</span>
                  </div>
                  <div className="flex items-center border border-gray-200 rounded-lg">
                    <button onClick={() => updateQty(item.product_id, Math.max(0, item.quantity - 1))} className="p-1.5 text-slate-400 hover:text-slate-600">
                      <Minus className="w-3.5 h-3.5" />
                    </button>
                    <span className="w-8 text-center text-sm font-medium text-slate-700">{item.quantity}</span>
                    <button onClick={() => updateQty(item.product_id, item.quantity + 1)} className="p-1.5 text-slate-400 hover:text-slate-600">
                      <Plus className="w-3.5 h-3.5" />
                    </button>
                  </div>
                  <span className="text-sm font-bold text-slate-800 w-20 text-right">RM {(item.price * item.quantity).toFixed(2)}</span>
                  <button onClick={() => removeItem(item.product_id)} className="p-1.5 text-slate-300 hover:text-red-500">
                    <X className="w-4 h-4" />
                  </button>
                </div>
              ))}
            </div>

            <div className="bg-slate-50 border border-gray-100 rounded-xl p-5 h-fit">
              <h3 className="text-sm font-semibold text-slate-800 mb-4">Order Summary</h3>
              <div className="space-y-2 text-sm mb-4">
                <div className="flex justify-between text-slate-600"><span>Subtotal</span><span>RM {subtotal.toFixed(2)}</span></div>
                <div className="flex justify-between text-slate-600">
                  <span>Shipping</span>
                  <span>{shipping === 0 ? <span className="text-emerald-600">FREE</span> : `RM ${shipping.toFixed(2)}`}</span>
                </div>
                <div className="flex justify-between font-bold text-slate-800 pt-3 border-t border-gray-200">
                  <span>Total</span><span>RM {total.toFixed(2)}</span>
                </div>
              </div>
              {subtotal < 100 && (
                <p className="text-[10px] text-slate-400 mb-4">Add RM {(100 - subtotal).toFixed(2)} more for free shipping!</p>
              )}
              <a href={route('shop.checkout')} className="block text-center bg-cyan-500 hover:bg-cyan-600 text-white px-6 py-3 rounded-xl text-sm font-medium transition-colors">
                Proceed to Checkout
              </a>
            </div>
          </div>
        )}
      </div>
    </ShopLayout>
  )
}
