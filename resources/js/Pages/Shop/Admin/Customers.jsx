import AdminLayout from '@/components/Shop/AdminLayout'
import { Users, Mail, Phone } from 'lucide-react'

const customers = [
  { id: 1, name: 'Pn Sofuha', email: 'sofuha@email.com', phone: '012-345 6789', orders: 5, spent: 'RM 1,250', joined: 'Jan 2026' },
  { id: 2, name: 'MiJuen Restaurant', email: 'mijuen@email.com', phone: '019-876 5432', orders: 12, spent: 'RM 4,560', joined: 'Dec 2025' },
  { id: 3, name: 'Ahmad Bakar', email: 'ahmad@email.com', phone: '013-456 7890', orders: 3, spent: 'RM 890', joined: 'Mar 2026' },
  { id: 4, name: 'Siti Nur', email: 'siti@email.com', phone: '017-234 5678', orders: 8, spent: 'RM 2,340', joined: 'Feb 2026' },
  { id: 5, name: 'Ali Hassan', email: 'ali@email.com', phone: '011-987 6543', orders: 1, spent: 'RM 567', joined: 'Jun 2026' },
]

export default function AdminCustomers() {
  return (
    <AdminLayout>
      <div className="space-y-4">
        <div><h1 className="text-xl font-bold text-slate-800">Customers</h1><p className="text-sm text-slate-500 mt-1">Registered customer accounts</p></div>
        <div className="bg-white border border-gray-100 rounded-xl overflow-hidden">
          <table className="w-full text-sm">
            <thead><tr className="border-b border-gray-100 text-slate-400 text-xs"><th className="text-left p-4">Customer</th><th className="text-left p-4">Contact</th><th className="text-right p-4">Orders</th><th className="text-right p-4">Total Spent</th><th className="text-left p-4">Joined</th></tr></thead>
            <tbody>
              {customers.map(c => (
                <tr key={c.id} className="border-b border-gray-50 hover:bg-slate-50">
                  <td className="p-4"><div className="flex items-center gap-2"><div className="w-8 h-8 rounded-full bg-cyan-500 text-white flex items-center justify-center text-xs font-bold">{c.name[0]}</div><span className="font-medium text-slate-700">{c.name}</span></div></td>
                  <td className="p-4"><div className="text-xs text-slate-500 flex items-center gap-1"><Mail className="w-3 h-3" />{c.email}</div><div className="text-xs text-slate-400 mt-0.5">{c.phone}</div></td>
                  <td className="p-4 text-right font-medium text-slate-700">{c.orders}</td>
                  <td className="p-4 text-right font-medium text-slate-700">{c.spent}</td>
                  <td className="p-4 text-xs text-slate-400">{c.joined}</td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>
    </AdminLayout>
  )
}
