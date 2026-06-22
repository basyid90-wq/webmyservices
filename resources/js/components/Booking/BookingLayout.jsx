import { Users, MapPin, Phone, Mail, Home, Shield, FileText } from 'lucide-react'

function LinkedInIcon() {
  return (
    <svg className="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
      <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
    </svg>
  )
}

function FacebookIcon() {
  return (
    <svg className="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
      <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
    </svg>
  )
}

function InstagramIcon() {
  return (
    <svg className="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
      <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
    </svg>
  )
}

const socialLinks = [
  { name: 'LinkedIn', href: '#', icon: LinkedInIcon },
  { name: 'Facebook', href: '#', icon: FacebookIcon },
  { name: 'Instagram', href: '#', icon: InstagramIcon },
]

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

      <footer className="bg-white border-t border-stone-200">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
          <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <div className="sm:col-span-2 lg:col-span-1">
              <a href="/booking" className="flex items-center gap-2.5 mb-4">
                <span className="text-2xl">🏡</span>
                <span className="text-lg font-bold text-stone-800">Desa Pangkor<span className="text-amber-600">Homestay</span></span>
              </a>
              <p className="text-sm text-stone-500 leading-relaxed max-w-xs">
                Penginapan selesa & tenang di tepi pantai Pulau Pangkor. Sesuai untuk percutian keluarga, honeymoon, atau team retreat.
              </p>
              <div className="flex items-center gap-3 mt-5">
                {socialLinks.map((link) => (
                  <a key={link.name} href={link.href} target="_blank" rel="noopener noreferrer"
                    className="w-8 h-8 flex items-center justify-center rounded-lg bg-stone-100 text-stone-400 hover:text-amber-600 hover:bg-amber-50 transition-colors"
                    aria-label={link.name}>
                    <link.icon />
                  </a>
                ))}
              </div>
            </div>

            <div>
              <h4 className="text-sm font-semibold text-stone-800 mb-4">Quick Links</h4>
              <ul className="space-y-2.5">
                <li><a href="/" className="text-sm text-stone-500 hover:text-amber-600 transition-colors flex items-center gap-1.5"><Home className="w-3 h-3" /> Home</a></li>
                <li><a href="/booking" className="text-sm text-stone-500 hover:text-amber-600 transition-colors flex items-center gap-1.5"><Users className="w-3 h-3" /> Browse Rooms</a></li>
                <li><a href="/terms" className="text-sm text-stone-500 hover:text-amber-600 transition-colors flex items-center gap-1.5"><FileText className="w-3 h-3" /> Terms of Service</a></li>
                <li><a href="/privacy" className="text-sm text-stone-500 hover:text-amber-600 transition-colors flex items-center gap-1.5"><Shield className="w-3 h-3" /> Privacy Policy</a></li>
              </ul>
            </div>

            <div>
              <h4 className="text-sm font-semibold text-stone-800 mb-4">Contact</h4>
              <ul className="space-y-3">
                <li>
                  <a href="tel:019-4920559" className="text-sm text-stone-500 hover:text-amber-600 transition-colors flex items-start gap-2">
                    <Phone className="w-3.5 h-3.5 mt-0.5 flex-shrink-0" />
                    <span>019-4920559</span>
                  </a>
                </li>
                <li>
                  <a href="mailto:basyid90@gmail.com" className="text-sm text-stone-500 hover:text-amber-600 transition-colors flex items-start gap-2">
                    <Mail className="w-3.5 h-3.5 mt-0.5 flex-shrink-0" />
                    <span>basyid90@gmail.com</span>
                  </a>
                </li>
                <li>
                  <div className="text-sm text-stone-500 flex items-start gap-2">
                    <MapPin className="w-3.5 h-3.5 mt-0.5 flex-shrink-0" />
                    <span>No 2-2A Taman Desa Pangkor,<br />32300 Pulau Pangkor, Perak</span>
                  </div>
                </li>
              </ul>
            </div>

            <div>
              <h4 className="text-sm font-semibold text-stone-800 mb-4">About Pangkor</h4>
              <ul className="space-y-2.5 text-sm text-stone-500 leading-relaxed">
                <li>🏖️ 5 minit ke Pantai Teluk Nipah</li>
                <li>🚤 10 minit ke Jeti Pangkor</li>
                <li>🍽️ Kedai makan walking distance</li>
                <li>🕌 Masjid berdekatan</li>
                <li>🅿️ Parking percuma</li>
              </ul>
            </div>
          </div>

          <div className="mt-12 pt-8 border-t border-stone-100 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div className="flex flex-col sm:flex-row items-start sm:items-center gap-2">
              <p className="text-sm text-stone-400">&copy; {new Date().getFullYear()} Desa Pangkor Homestay. All rights reserved.</p>
              <span className="hidden sm:inline text-stone-300">|</span>
              <p className="text-xs text-stone-400">SSM: 202403295472 (RA0118450-H)</p>
            </div>
            <p className="text-xs text-stone-400">
              Powered by{' '}
              <a href="/" className="text-amber-600 hover:text-amber-700 font-medium">WebMy Services</a>
            </p>
          </div>
        </div>
      </footer>
    </div>
  )
}
