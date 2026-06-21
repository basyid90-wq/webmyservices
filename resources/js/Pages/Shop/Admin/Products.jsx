import AdminLayout from '@/components/Shop/AdminLayout'
import { Pencil, Trash2 } from 'lucide-react'

const products = [
  { id: 1, name: 'Ikan Bilis Mata Biru', category: 'Ikan Kering', price: 'RM 18.00', stock: 50, image: '🐟' },
  { id: 2, name: 'Udang Kering Gred A', category: 'Udang Kering', price: 'RM 35.00', stock: 3, image: '🦐' },
  { id: 3, name: 'Sotong Kering Besar', category: 'Sotong Kering', price: 'RM 30.00', stock: 0, image: '🦑' },
  { id: 4, name: 'Belacan Homemade', category: 'Belacan & Sambal', price: 'RM 12.00', stock: 100, image: '🌶️' },
  { id: 5, name: 'Sambal Hitam Pahang', category: 'Belacan & Sambal', price: 'RM 16.00', stock: 45, image: '🍯' },
  { id: 6, name: 'Ikan Masin Talang', category: 'Ikan Masin', price: 'RM 20.00', stock: 8, image: '🧂' },
  { id: 7, name: 'Ikan Gelama Kering', category: 'Ikan Kering', price: 'RM 22.00', stock: 25, image: '🐟' },
]

export default function AdminProducts() {
  return (
    <AdminLayout>
      <div className="space-y-4">
        <div className="flex items-center justify-between">
          <div><h1 className="text-xl font-bold text-slate-800">Products</h1><p className="text-sm text-slate-500 mt-1">Manage your product catalog</p></div>
          <button className="bg-cyan-500 hover:bg-cyan-600 text-white px-4 py-2 rounded-lg text-sm font-medium">+ Add Product</button>
        </div>
        <div className="bg-white border border-gray-100 rounded-xl overflow-hidden">
          <table className="w-full text-sm">
            <thead><tr className="border-b border-gray-100 text-slate-400 text-xs"><th className="text-left p-4">Product</th><th className="text-left p-4">Category</th><th className="text-right p-4">Price</th><th className="text-right p-4">Stock</th><th className="text-right p-4">Actions</th></tr></thead>
            <tbody>
              {products.map(p => (
                <tr key={p.id} className="border-b border-gray-50 hover:bg-slate-50">
                  <td className="p-4"><span className="flex items-center gap-3"><span className="text-xl">{p.image}</span><span className="font-medium text-slate-700">{p.name}</span></span></td>
                  <td className="p-4 text-slate-500">{p.category}</td>
                  <td className="p-4 text-right font-medium text-slate-700">{p.price}</td>
                  <td className="p-4 text-right"><span className={`px-2 py-0.5 rounded-full text-xs font-medium ${p.stock <= 0 ? 'bg-red-50 text-red-600' : p.stock <= 5 ? 'bg-amber-50 text-amber-600' : 'bg-emerald-50 text-emerald-600'}`}>{p.stock} units</span></td>
                  <td className="p-4 text-right"><div className="flex items-center justify-end gap-2"><button className="p-1.5 text-slate-400 hover:text-cyan-600"><Pencil className="w-4 h-4" /></button><button className="p-1.5 text-slate-400 hover:text-red-500"><Trash2 className="w-4 h-4" /></button></div></td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>
    </AdminLayout>
  )
}
