import { useState } from 'react'
import AdminLayout from '@/components/Shop/AdminLayout'
import { CreditCard, Check } from 'lucide-react'

const gateways = [
  { id: 'toyyibpay', name: 'ToyyibPay', desc: 'Islamic payment gateway for Malaysian businesses', active: true, color: 'bg-emerald-500' },
  { id: 'billplz', name: 'Billplz', desc: 'FPX & credit card payment collection', active: true, color: 'bg-blue-500' },
  { id: 'bayarcash', name: 'Bayarcash', desc: 'Real-time settlement payment gateway', active: true, color: 'bg-orange-500' },
  { id: 'chipin', name: 'Chip-in', desc: 'Simple online payment & invoicing', active: false, color: 'bg-purple-500' },
]

export default function AdminPayments() {
  const [selected, setSelected] = useState('bayarcash')

  return (
    <AdminLayout>
      <div className="space-y-4">
        <div><h1 className="text-xl font-bold text-slate-800">Payment Settings</h1><p className="text-sm text-slate-500 mt-1">Configure payment gateways (demo)</p></div>

        <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
          {gateways.map(g => (
            <div key={g.id} onClick={() => setSelected(g.id)}
              className={`bg-white border rounded-xl p-5 cursor-pointer transition-all ${
                selected === g.id ? 'border-cyan-500 shadow-md shadow-cyan-500/10' : 'border-gray-100 hover:border-gray-200'
              }`}>
              <div className="flex items-center justify-between mb-3">
                <div className="flex items-center gap-3">
                  <div className={`w-10 h-10 rounded-lg ${g.color} bg-opacity-10 flex items-center justify-center`}>
                    <CreditCard className={`w-5 h-5 ${g.color.replace('bg-', 'text-')}`} />
                  </div>
                  <div>
                    <h3 className="text-sm font-semibold text-slate-800">{g.name}</h3>
                    <p className="text-xs text-slate-400">{g.desc}</p>
                  </div>
                </div>
                {selected === g.id && <Check className="w-5 h-5 text-cyan-500" />}
              </div>
              <div className="flex items-center gap-2">
                <span className={`w-2 h-2 rounded-full ${g.active ? 'bg-emerald-500' : 'bg-gray-300'}`} />
                <span className="text-xs text-slate-500">{g.active ? 'Active' : 'Inactive'}</span>
              </div>
            </div>
          ))}
        </div>

        <div className="bg-white border border-gray-100 rounded-xl p-5">
          <h3 className="text-sm font-semibold text-slate-800 mb-3">Transaction History (Demo)</h3>
          <div className="space-y-2 text-xs">
            {[
              { id: 'TXN-001', order: '#HL-25060007', amount: 'RM 128', method: 'FPX Online Banking', status: 'Success', date: '20 Jun 2026' },
              { id: 'TXN-002', order: '#HL-25060006', amount: 'RM 456', method: 'DuitNow QR', status: 'Success', date: '19 Jun 2026' },
              { id: 'TXN-003', order: '#HL-25060005', amount: 'RM 890', method: 'FPX Online Banking', status: 'Success', date: '18 Jun 2026' },
            ].map(t => (
              <div key={t.id} className="flex items-center justify-between py-2 border-b border-gray-50 last:border-0">
                <div>
                  <span className="text-slate-700 font-medium">{t.order}</span>
                  <span className="text-slate-400 ml-2">{t.method}</span>
                </div>
                <div className="flex items-center gap-3">
                  <span className="font-medium text-slate-700">{t.amount}</span>
                  <span className="text-emerald-600">{t.status}</span>
                  <span className="text-slate-400">{t.date}</span>
                </div>
              </div>
            ))}
          </div>
        </div>
      </div>
    </AdminLayout>
  )
}
