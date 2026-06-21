import { motion } from 'framer-motion'
import { ArrowDown, ArrowRight } from 'lucide-react'
import { route } from '@/lib/ziggy'
import Button from '@/components/ui/Button'

function FakeDashboard() {
  return (
    <div className="w-full h-full bg-gray-100/90 flex">
      {/* Sidebar */}
      <div className="w-40 lg:w-48 flex-shrink-0 bg-slate-900 border-r border-slate-800 p-3 lg:p-4 flex flex-col">
        <div className="flex items-center gap-2 mb-6 lg:mb-8">
          <div className="w-5 h-5 lg:w-6 lg:h-6 rounded-lg bg-gradient-to-br from-cyan-400 to-blue-600 flex items-center justify-center">
            <span className="text-white text-[7px] lg:text-[9px] font-bold">HL</span>
          </div>
          <span className="text-[10px] lg:text-xs font-semibold text-white leading-tight">
            Hasil<span className="text-cyan-400">Laut</span>
          </span>
        </div>

        <div className="space-y-0.5 flex-1">
          {[
            { label: 'Dashboard', icon: '□', active: true },
            { label: 'Orders', icon: '○', active: false },
            { label: 'Products', icon: '◇', active: false },
            { label: 'Customers', icon: '◎', active: false },
            { label: 'Analytics', icon: '▽', active: false },
            { label: 'Settings', icon: '⚙', active: false },
          ].map((item) => (
            <div
              key={item.label}
              className={`flex items-center gap-2.5 px-2.5 py-2 rounded-lg text-[10px] lg:text-xs cursor-pointer transition-colors ${
                item.active
                  ? 'bg-cyan-500/15 text-cyan-400 font-medium'
                  : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800'
              }`}
            >
              <span className="text-[10px] w-3 text-center">{item.icon}</span>
              {item.label}
            </div>
          ))}
        </div>

        <div className="pt-4 border-t border-slate-800">
          <div className="flex items-center gap-2 px-2.5">
            <div className="w-5 h-5 lg:w-6 lg:h-6 rounded-full bg-cyan-500/20 text-cyan-400 flex items-center justify-center text-[8px] font-bold">AB</div>
            <div className="text-[9px] lg:text-[10px] text-slate-400 truncate">Admin</div>
          </div>
        </div>
      </div>

      {/* Main content */}
      <div className="flex-1 overflow-hidden bg-gray-50">
        {/* Top bar */}
        <div className="bg-white border-b border-gray-200 px-4 lg:px-5 py-2.5 lg:py-3 flex items-center justify-between">
          <div className="flex items-center gap-3">
            <span className="text-[10px] lg:text-xs font-semibold text-slate-800">Dashboard</span>
            <span className="text-[9px] lg:text-[10px] text-slate-400 hidden sm:inline">Welcome back, Admin</span>
          </div>
          <div className="flex items-center gap-3">
            <div className="relative">
              <div className="w-5 h-5 lg:w-6 lg:h-6 rounded-full bg-slate-100 flex items-center justify-center text-[10px] text-slate-400">🔔</div>
              <div className="absolute -top-0.5 -right-0.5 w-2 h-2 bg-red-500 rounded-full" />
            </div>
          </div>
        </div>

        <div className="p-3 lg:p-4 overflow-y-auto max-h-[calc(100%-36px)]">
          {/* Stats row */}
          <div className="grid grid-cols-4 gap-2 lg:gap-3 mb-3 lg:mb-4">
            {[
              { label: 'Total Orders', value: '1,247', change: '+12.5%', up: true, gradient: 'from-cyan-500 to-blue-500', icon: '📦' },
              { label: 'Revenue', value: 'RM 84.2K', change: '+23.1%', up: true, gradient: 'from-emerald-500 to-teal-500', icon: '💰' },
              { label: 'Products Sold', value: '3,842', change: '+8.2%', up: true, gradient: 'from-amber-500 to-orange-500', icon: '🐟' },
              { label: 'Customers', value: '586', change: '+18.7%', up: true, gradient: 'from-violet-500 to-purple-500', icon: '👥' },
            ].map((stat) => (
              <div key={stat.label} className="bg-white rounded-xl border border-gray-100 shadow-sm p-2.5 lg:p-3">
                <div className="flex items-center justify-between mb-1.5">
                  <span className="text-sm lg:text-base">{stat.icon}</span>
                  <div className={`h-4 w-8 lg:h-5 lg:w-10 rounded-md bg-gradient-to-r ${stat.gradient} opacity-20`} />
                </div>
                <div className="text-sm lg:text-lg font-bold text-slate-800 leading-tight">{stat.value}</div>
                <div className="flex items-center gap-1 mt-0.5">
                  <span className={`text-[9px] lg:text-[10px] ${stat.up ? 'text-emerald-600' : 'text-red-500'}`}>{stat.change}</span>
                  <span className="text-[8px] lg:text-[9px] text-slate-400 truncate">{stat.label}</span>
                </div>
              </div>
            ))}
          </div>

          <div className="grid grid-cols-3 gap-3 lg:gap-4">
            {/* Chart section */}
            <div className="col-span-2 bg-white rounded-xl border border-gray-100 shadow-sm p-3 lg:p-4">
              <div className="flex items-center justify-between mb-3">
                <div>
                  <div className="text-[10px] lg:text-xs font-semibold text-slate-800">Revenue Overview</div>
                  <div className="text-[9px] lg:text-[10px] text-slate-400">Monthly sales performance</div>
                </div>
                <div className="flex gap-1.5">
                  {['1W', '1M', '1Y', 'All'].map((period, i) => (
                    <span
                      key={period}
                      className={`text-[8px] lg:text-[9px] px-2 py-0.5 rounded-md ${
                        i === 1 ? 'bg-cyan-500 text-white' : 'text-slate-400 bg-slate-100'
                      }`}
                    >
                      {period}
                    </span>
                  ))}
                </div>
              </div>
              {/* Bar chart */}
              <div className="flex items-end gap-1.5 lg:gap-2 h-16 lg:h-20 mt-3">
                {[28, 35, 42, 38, 52, 48, 65, 58, 72, 68, 85, 78].map((h, i) => (
                  <motion.div
                    key={i}
                    initial={{ height: 0 }}
                    animate={{ height: `${(h / 85) * 100}%` }}
                    transition={{ duration: 0.5, delay: 0.6 + i * 0.04 }}
                    className="flex-1 rounded-t-md bg-gradient-to-t from-cyan-500 to-cyan-400 relative group"
                  >
                    <div className="absolute -top-4 left-1/2 -translate-x-1/2 text-[7px] lg:text-[8px] text-slate-500 opacity-0 group-hover:opacity-100 transition-opacity">
                      RM{(h * 1.2).toFixed(1)}K
                    </div>
                  </motion.div>
                ))}
              </div>
              <div className="flex justify-between mt-1.5">
                {['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'].map((m) => (
                  <span key={m} className="text-[7px] lg:text-[8px] text-slate-400">{m}</span>
                ))}
              </div>
            </div>

            {/* Top Products */}
            <div className="bg-white rounded-xl border border-gray-100 shadow-sm p-3 lg:p-4">
              <div className="text-[10px] lg:text-xs font-semibold text-slate-800 mb-3">Top Products</div>
              <div className="space-y-2.5">
                {[
                  { name: 'Ikan Bilis Mata Biru', sold: 482, revenue: 'RM 5,784', color: 'bg-cyan-500' },
                  { name: 'Ikan Masin (Talang)', sold: 356, revenue: 'RM 3,204', color: 'bg-amber-500' },
                  { name: 'Udang Kering', sold: 289, revenue: 'RM 2,601', color: 'bg-emerald-500' },
                  { name: 'Sotong Kering', sold: 245, revenue: 'RM 2,205', color: 'bg-orange-500' },
                ].map((product, i) => (
                  <div key={product.name} className="flex items-center gap-2">
                    <div className={`w-5 h-5 lg:w-6 lg:h-6 rounded-lg ${product.color} flex items-center justify-center text-white text-[8px] flex-shrink-0`}>
                      🛒
                    </div>
                    <div className="flex-1 min-w-0">
                      <div className="text-[9px] lg:text-[10px] font-medium text-slate-700 truncate">{product.name}</div>
                      <div className="text-[8px] lg:text-[9px] text-slate-400">{product.sold} sold</div>
                    </div>
                    <div className="text-[9px] lg:text-[10px] font-semibold text-slate-700">{product.revenue}</div>
                  </div>
                ))}
              </div>

              {/* Recent orders mini */}
              <div className="mt-3 pt-3 border-t border-gray-100">
                <div className="text-[10px] lg:text-xs font-semibold text-slate-800 mb-2">Recent Orders</div>
                <div className="space-y-1.5">
                  {[
                    { id: '#HL-1042', customer: 'Pn Sofuha', amount: 'RM 128', status: 'Delivered', color: 'text-emerald-600 bg-emerald-50' },
                    { id: '#HL-1041', customer: 'MiJuen Restaurant', amount: 'RM 456', status: 'Processing', color: 'text-amber-600 bg-amber-50' },
                    { id: '#HL-1040', customer: 'Kedai Ikan Bakar', amount: 'RM 890', status: 'Shipped', color: 'text-cyan-600 bg-cyan-50' },
                  ].map((order) => (
                    <div key={order.id} className="flex items-center justify-between text-[8px] lg:text-[9px]">
                      <div className="flex items-center gap-1.5">
                        <span className="text-slate-400 font-mono">{order.id}</span>
                        <span className="text-slate-500 truncate">{order.customer}</span>
                      </div>
                      <div className="flex items-center gap-1.5">
                        <span className="font-medium text-slate-700">{order.amount}</span>
                        <span className={`px-1 py-0.5 rounded text-[7px] text-balance ${order.color}`}>{order.status}</span>
                      </div>
                    </div>
                  ))}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  )
}

export default function Hero() {
  return (
    <section className="relative min-h-screen flex items-center justify-center overflow-hidden">
      <div className="absolute inset-0 bg-[radial-gradient(ellipse_at_top,rgba(99,102,241,0.15),transparent_60%)]" />
      <div className="absolute inset-0 bg-[radial-gradient(ellipse_at_bottom_right,rgba(99,102,241,0.08),transparent_50%)]" />
      <div
        className="absolute inset-0 opacity-20"
        style={{ backgroundImage: 'radial-gradient(rgba(255,255,255,0.05) 1px, transparent 1px)', backgroundSize: '50px 50px' }}
      />

      <div className="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32 text-center">
        <motion.div initial={{ opacity: 0, y: 30 }} animate={{ opacity: 1, y: 0 }} transition={{ duration: 0.6 }}>
          <p className="text-indigo-400 text-sm lg:text-base font-medium tracking-widest uppercase mb-6">
            Web Development &bull; Hosting &bull; Domain &bull; Digital Services
          </p>
          <h1 className="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold text-white leading-tight mb-6 max-w-5xl mx-auto">
            We Help Bring <span className="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400">Your Business</span> Online
          </h1>
          <p className="text-gray-400 text-base lg:text-lg max-w-2xl mx-auto mb-10 leading-relaxed">
            From domain registration, hosting, to professional website development — we handle everything for you.
          </p>
          <div className="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="#portfolio">
              <Button>
                View Our Work
                <ArrowDown className="w-4 h-4" />
              </Button>
            </a>
            <a href={route('contact')}>
              <Button variant="outline">
                Contact Us
                <ArrowRight className="w-4 h-4" />
              </Button>
            </a>
          </div>
        </motion.div>

        <motion.div
          initial={{ opacity: 0, y: 50 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8, delay: 0.4 }}
          className="mt-20 max-w-5xl mx-auto"
        >
          <div className="bg-gradient-to-b from-gray-900/50 to-transparent border border-white/10 rounded-2xl overflow-hidden shadow-2xl shadow-indigo-500/10">
            <div className="bg-gray-900/80 border-b border-white/5 px-4 py-2 flex items-center gap-2">
              <div className="flex gap-1.5">
                <div className="w-2.5 h-2.5 rounded-full bg-red-500/70" />
                <div className="w-2.5 h-2.5 rounded-full bg-yellow-500/70" />
                <div className="w-2.5 h-2.5 rounded-full bg-green-500/70" />
              </div>
              <span className="text-[10px] lg:text-xs text-gray-500 ml-2">app.hasil-lautpangkor.com — Dashboard</span>
            </div>
            <div className="aspect-[16/10] lg:aspect-[16/9] overflow-hidden">
              <FakeDashboard />
            </div>
          </div>
        </motion.div>
      </div>

      <div className="absolute bottom-10 left-1/2 -translate-x-1/2 animate-bounce">
        <a href="#services" className="text-gray-500 hover:text-gray-300 transition-colors">
          <ArrowDown className="w-6 h-6" />
        </a>
      </div>
    </section>
  )
}
