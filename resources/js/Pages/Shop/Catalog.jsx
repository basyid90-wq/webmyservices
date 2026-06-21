import { useState } from 'react'
import { motion } from 'framer-motion'
import { route } from '@/lib/ziggy'
import ShopLayout from '@/components/Shop/ShopLayout'
import { Search, Star, ShoppingBag, ChevronLeft, ChevronRight } from 'lucide-react'

function ProductCard({ product }) {
  return (
    <motion.a
      href={route('shop.product', { product: product.slug })}
      initial={{ opacity: 0, y: 10 }}
      animate={{ opacity: 1, y: 0 }}
      className="group bg-white border border-gray-100 rounded-2xl overflow-hidden hover:border-cyan-200 hover:shadow-lg hover:shadow-cyan-500/5 transition-all duration-300"
    >
      <div className="relative overflow-hidden aspect-square bg-gradient-to-br from-slate-50 to-white">
        {product.image ? (
          <img src={`/storage/${product.image}`} alt={product.name} className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
        ) : (
          <div className="w-full h-full flex items-center justify-center">
            <span className="text-4xl">🐟</span>
          </div>
        )}
        {product.compare_price && (
          <span className="absolute top-3 left-3 bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">
            SALE
          </span>
        )}
      </div>
      <div className="p-4">
        {product.category && (
          <span className="text-[10px] text-cyan-600 font-medium">{product.category.name}</span>
        )}
        <h3 className="text-sm font-semibold text-slate-800 mt-0.5 mb-1.5 group-hover:text-cyan-600 transition-colors line-clamp-2">{product.name}</h3>
        <div className="flex items-baseline gap-1.5">
          <span className="text-base font-bold text-slate-800">RM {product.price}</span>
          {product.compare_price && (
            <span className="text-xs text-slate-400 line-through">RM {product.compare_price}</span>
          )}
        </div>
        {product.unit && <span className="text-[10px] text-slate-400">/ {product.unit}</span>}
      </div>
    </motion.a>
  )
}

export default function Catalog({ products, categories, filters }) {
  return (
    <ShopLayout>
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
        <div className="text-center mb-8 lg:mb-12">
          <span className="inline-block text-xs font-medium text-cyan-600 bg-cyan-50 px-3 py-1 rounded-full mb-3">
            🐟 Hasil Laut Pangkor
          </span>
          <h1 className="text-3xl lg:text-4xl font-bold text-slate-800 mb-3">
            Segar Dari Laut,<br className="sm:hidden" /> Terus Ke Dapur Anda
          </h1>
          <p className="text-slate-500 max-w-lg mx-auto">
            Ikan kering, udang, sotong, belacan & sambal homemade — diproses secara tradisional, dihantar ke seluruh Malaysia.
          </p>
        </div>

        <div className="flex flex-wrap items-center justify-center gap-2 mb-8">
          <a
            href={route('shop.catalog')}
            className={`px-3 py-1.5 rounded-full text-xs font-medium transition-colors ${
              !filters.category ? 'bg-cyan-500 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'
            }`}
          >
            Semua
          </a>
          {categories.map((cat) => (
            <a
              key={cat.id}
              href={route('shop.catalog', { category: cat.slug })}
              className={`px-3 py-1.5 rounded-full text-xs font-medium transition-colors ${
                filters.category === cat.slug ? 'bg-cyan-500 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'
              }`}
            >
              {cat.name}
            </a>
          ))}
        </div>

        <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-6">
          {products.data.map((product) => (
            <ProductCard key={product.id} product={product} />
          ))}
        </div>

        {products.data.length === 0 && (
          <div className="text-center py-20">
            <span className="text-5xl mb-4 block">🐟</span>
            <p className="text-slate-400">Tiada produk dalam kategori ini.</p>
          </div>
        )}

        {products.last_page > 1 && (
          <div className="flex items-center justify-center gap-2 mt-10">
            {products.links.map((link, i) => (
              <a
                key={i}
                href={link.url || '#'}
                dangerouslySetInnerHTML={{ __html: link.label }}
                className={`px-3 py-1.5 rounded-lg text-xs font-medium ${
                  link.active ? 'bg-cyan-500 text-white' : !link.url ? 'text-slate-300' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'
                }`}
              />
            ))}
          </div>
        )}
      </div>
    </ShopLayout>
  )
}