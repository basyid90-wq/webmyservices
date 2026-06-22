export default function BookingLayout({ children }) {
  return (
    <div className="min-h-screen flex flex-col bg-stone-50">
      <header className="bg-white border-b border-stone-200">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
          <a href="/booking" className="flex items-center gap-2.5">
            <span className="text-2xl">🏡</span>
            <span className="text-lg font-bold text-stone-800">Desa Pangkor<span className="text-amber-600">Homestay</span></span>
          </a>
          <a href="/booking" className="text-sm text-stone-500 hover:text-stone-700">Browse Rooms</a>
        </div>
      </header>
      <main className="flex-1">{children}</main>
      <footer className="bg-white border-t border-stone-200 py-8">
        <div className="max-w-7xl mx-auto px-4 text-center text-sm text-stone-400">
          &copy; {new Date().getFullYear()} Desa Pangkor Homestay. Powered by WebMy Services.
        </div>
      </footer>
    </div>
  )
}
