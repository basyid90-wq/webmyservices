import { motion } from 'framer-motion'
import { route } from '@/lib/ziggy'
import ShopLayout from '@/components/Shop/ShopLayout'
import useShopCart from '@/hooks/useShopCart'
import { ShoppingBag, Minus, Plus } from 'lucide-react'

export default function Product({ product, related }) {
  const { addItem } = useShopCart()

  function addToCart() {
    addItem(product)
  }

  return (
    <ShopLayout>
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
        <div className="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
          <motion.div initial={{ opacity: 0, x: -20 }} animate={{ opacity: 1, x: 0 }}
            className="relative aspect-square rounded-2xl bg-gradient-to-br from-slate-50 to-white overflow-hidden border border-gray-100">
            {product.image ? (
              <img src={`/storage/${product.image}`} alt={product.name} className="w-full h-full object-cover" />
            ) : (
              <div className="w-full h-full flex items-center justify-center text-8xl">🐟</div>
            )}
          </motion.div>

          <motion.div initial={{ opacity: 0, x: 20 }} animate={{ opacity: 1, x: 0 }} className="flex flex-col">
            {product.category && (
              <span className="text-xs font-medium text-cyan-600 bg-cyan-50 px-2.5 py-1 rounded-full w-fit mb-3">
                {product.category.name}
              </span>
            )}
            <h1 className="text-2xl lg:text-3xl font-bold text-slate-800 mb-3">{product.name}</h1>

            <div className="flex items-baseline gap-2 mb-4">
              <span className="text-3xl font-bold text-slate-800">RM {product.price}</span>
              {product.compare_price && (
                <span className="text-base text-slate-400 line-through">RM {product.compare_price}</span>
              )}
              {product.unit && <span className="text-sm text-slate-400">/ {product.unit}</span>}
            </div>

            {product.stock > 0 ? (
              <span className="text-xs text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full w-fit mb-4">✓ In Stock ({product.stock} available)</span>
            ) : (
              <span className="text-xs text-red-500 bg-red-50 px-2.5 py-1 rounded-full w-fit mb-4">Out of Stock</span>
            )}

            {product.description && (
              <div className="text-sm text-slate-600 leading-relaxed mb-6">
                <h3 className="font-semibold text-slate-800 mb-2">Huraian Produk</h3>
                <div dangerouslySetInnerHTML={{ __html: product.description }} />
              </div>
            )}

            <div className="flex gap-3 mt-auto pt-6 border-t border-gray-100">
              <button
                onClick={addToCart}
                disabled={product.stock < 1}
                className="flex-1 flex items-center justify-center gap-2 bg-cyan-500 hover:bg-cyan-600 disabled:bg-slate-200 disabled:text-slate-400 text-white px-6 py-3 rounded-xl font-medium text-sm transition-colors"
              >
                <ShoppingBag className="w-4 h-4" />
                Tambah ke Troli
              </button>
            </div>
          </motion.div>
        </div>

        {related.length > 0 && (
          <div className="mt-16">
            <h2 className="text-lg font-bold text-slate-800 mb-6">Anda Mungkin Juga Suka</h2>
            <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
              {related.map((p) => (
                <a key={p.id} href={route('shop.product', { product: p.slug })}
                  className="group bg-white border border-gray-100 rounded-xl overflow-hidden hover:border-cyan-200 transition-colors p-3">
                  <div className="aspect-square bg-slate-50 rounded-lg mb-3 flex items-center justify-center text-4xl">🐟</div>
                  <h4 className="text-xs font-semibold text-slate-800 group-hover:text-cyan-600 line-clamp-2">{p.name}</h4>
                  <span className="text-sm font-bold text-slate-800 mt-1">RM {p.price}</span>
                </a>
              ))}
            </div>
          </div>
        )}
      </div>
    </ShopLayout>
  )
}
