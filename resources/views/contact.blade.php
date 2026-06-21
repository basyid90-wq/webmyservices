@extends('layouts.app')

@section('title', 'Contact Us — WebMy Services')

@section('content')

<section class="pt-28 lg:pt-36 pb-24 lg:pb-32">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <p class="text-indigo-400 text-sm font-semibold tracking-widest uppercase mb-3">Get In Touch</p>
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4">Contact Us</h1>
            <p class="text-gray-400 max-w-2xl mx-auto">Have a question or want to work together? Fill out the form below and we'll get back to you as soon as possible.</p>
        </div>

        @if(session('success'))
        <div class="max-w-3xl mx-auto mb-8 p-4 bg-emerald-500/10 border border-emerald-500/30 rounded-lg text-emerald-400 text-sm">
            {{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div class="max-w-3xl mx-auto mb-8 p-4 bg-red-500/10 border border-red-500/30 rounded-lg">
            <ul class="list-disc list-inside text-red-400 text-sm space-y-1">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 max-w-5xl mx-auto">
            <div>
                <form action="{{ route('contact.submit') }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Nama / Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Nama penuh anda" required
                            class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-colors">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Emel / Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="anda@email.com" required
                            class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-colors">
                    </div>
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-300 mb-2">Subjek / Subject</label>
                        <input type="text" name="subject" id="subject" value="{{ old('subject') }}" placeholder="Tajuk pertanyaan" required
                            class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-colors">
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-300 mb-2">Mesej / Message</label>
                        <textarea name="message" id="message" rows="6" placeholder="Ceritakan tentang projek anda..." required
                            class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-colors resize-none">{{ old('message') }}</textarea>
                    </div>
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3.5 rounded-lg font-medium transition-colors">
                        Hantar / Send
                    </button>
                </form>
            </div>

            <div class="flex flex-col justify-center">
                <div class="bg-gray-900 border border-gray-800 rounded-xl p-8 space-y-8">
                    <h3 class="text-lg font-semibold text-white mb-2">Maklumat Hubungan / Contact Information</h3>

                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-indigo-500/10 text-indigo-400 flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-white mb-1">Emel / Email</h4>
                            <p class="text-sm text-gray-400">basyid90@gmail.com</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-indigo-500/10 text-indigo-400 flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-white mb-1">Telefon / Phone</h4>
                            <p class="text-sm text-gray-400">019-4920559</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-indigo-500/10 text-indigo-400 flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-white mb-1">Lokasi / Location</h4>
                            <p class="text-sm text-gray-400">No 2-2A Taman Desa Pangkor, 32300 Pulau Pangkor, Perak</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
