export default function ShopFooter() {
  return (
    <footer className="bg-slate-50 border-t border-gray-100">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
        <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div>
            <div className="flex items-center gap-2 mb-3">
              <div className="w-7 h-7 rounded-lg bg-gradient-to-br from-cyan-500 to-blue-600 flex items-center justify-center">
                <span className="text-white font-bold text-[10px]">HL</span>
              </div>
              <span className="text-sm font-bold text-slate-800">HasilLaut Pangkor</span>
            </div>
            <p className="text-xs text-slate-500 leading-relaxed">
              Hasil laut segar dari Pulau Pangkor. Ikan kering, udang kering, sotong, belacan & sambal homemade — dihantar terus ke rumah anda.
            </p>
          </div>
          <div>
            <h4 className="text-xs font-semibold text-slate-800 mb-3">Pautan</h4>
            <ul className="space-y-1.5">
              <li><a href="#" className="text-xs text-slate-500 hover:text-slate-700">Semua Produk</a></li>
              <li><a href="#" className="text-xs text-slate-500 hover:text-slate-700">Cara Pesan</a></li>
              <li><a href="#" className="text-xs text-slate-500 hover:text-slate-700">Polisi Penghantaran</a></li>
            </ul>
          </div>
          <div>
            <h4 className="text-xs font-semibold text-slate-800 mb-3">Hubungi</h4>
            <ul className="space-y-1.5 text-xs text-slate-500">
              <li>019-4920559 (WhatsApp)</li>
              <li>basyid90@gmail.com</li>
              <li>No 2-2A Taman Desa Pangkor, 32300 Pulau Pangkor, Perak</li>
            </ul>
          </div>
        </div>
        <div className="mt-8 pt-6 border-t border-gray-200 text-center text-[11px] text-slate-400">
          &copy; {new Date().getFullYear()} HasilLaut Pangkor. Demo E-Commerce oleh WebMy Services.
        </div>
      </div>
    </footer>
  )
}
