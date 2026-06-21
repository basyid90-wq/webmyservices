import { useForm } from '@inertiajs/react'
import { route } from '@/lib/ziggy'
import ShopLayout from '@/components/Shop/ShopLayout'

export default function Register() {
  const { data, setData, post, processing, errors } = useForm({
    name: '', email: '', phone: '', password: '', password_confirmation: ''
  })

  return (
    <ShopLayout>
      <div className="max-w-md mx-auto px-4 py-16 lg:py-24">
        <div className="text-center mb-8">
          <h1 className="text-2xl font-bold text-slate-800 mb-2">Daftar Akaun</h1>
          <p className="text-sm text-slate-500">Buat akaun untuk mula membeli-belah</p>
        </div>
        <form onSubmit={e => { e.preventDefault(); post(route('shop.register.submit')) }} className="space-y-4">
          {['name', 'email', 'phone', 'password', 'password_confirmation'].map(field => (
            <div key={field}>
              <label className="block text-xs text-slate-500 mb-1">
                {field === 'password_confirmation' ? 'Sahkan Kata Laluan' : field === 'name' ? 'Nama' : field === 'phone' ? 'Telefon' : field === 'email' ? 'Emel' : 'Kata Laluan'}
              </label>
              <input
                type={field.includes('password') ? 'password' : field === 'email' ? 'email' : 'text'}
                value={data[field]}
                onChange={e => setData(field, e.target.value)}
                className="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:border-cyan-500 outline-none"
              />
              {errors[field] && <p className="text-red-500 text-xs mt-1">{errors[field]}</p>}
            </div>
          ))}
          <button type="submit" disabled={processing}
            className="w-full bg-cyan-500 hover:bg-cyan-600 text-white py-2.5 rounded-xl text-sm font-medium transition-colors">
            {processing ? 'Mendaftar...' : 'Daftar'}
          </button>
        </form>
        <p className="text-center text-sm text-slate-400 mt-6">
          Sudah ada akaun? <a href={route('shop.login')} className="text-cyan-600 hover:underline">Log Masuk</a>
        </p>
      </div>
    </ShopLayout>
  )
}