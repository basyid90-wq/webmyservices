@extends('layouts.app')

@section('title', 'WebMy Services — Pembangunan Web & Hosting')

@section('content')



{{-- Hero Section --}}
<section class="relative min-h-screen flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,rgba(99,102,241,0.1),transparent_50%)]"></div>
    <div class="absolute inset-0" style="background-image: radial-gradient(rgba(255,255,255,0.03) 1px, transparent 1px); background-size: 40px 40px;"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32 text-center">
        <div class="animate-fade-in">
            <p class="text-indigo-400 text-sm lg:text-base font-medium tracking-widest uppercase mb-6">
                <span lang="ms">Pembangunan Web &bull; Hosting &bull; Domain &bull; Servis Digital</span>
                <span lang="en" class="hidden">Web Development &bull; Hosting &bull; Domain &bull; Digital Services</span>
            </p>
            <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold text-white leading-tight mb-6 max-w-5xl mx-auto">
                <span lang="ms">Kami Bantu <span class="text-indigo-400">Perniagaan Anda</span> Online</span>
                <span lang="en" class="hidden">We Help <span class="text-indigo-400">Your Business</span> Go Online</span>
            </h1>
            <p class="text-gray-400 text-base lg:text-lg max-w-2xl mx-auto mb-10 leading-relaxed">
                <span lang="ms">Dari pendaftaran domain, hosting, sehingga pembangunan laman web profesional — kami uruskan semuanya untuk anda.</span>
                <span lang="en" class="hidden">From domain registration, hosting, to professional website development — we handle everything for you.</span>
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="#portfolio" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3.5 rounded-lg font-medium transition-colors inline-flex items-center gap-2">
                    <span lang="ms">Lihat Hasil Kerja</span>
                    <span lang="en" class="hidden">View Our Work</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </a>
                <a href="{{ route('contact') }}" class="border border-gray-700 hover:border-indigo-500 text-white px-8 py-3.5 rounded-lg font-medium transition-colors">
                    <span lang="ms">Hubungi Kami</span>
                    <span lang="en" class="hidden">Get In Touch</span>
                </a>
            </div>
        </div>
    </div>

    <div class="absolute bottom-10 left-1/2 -translate-x-1/2 animate-bounce">
        <a href="#services" class="text-gray-500 hover:text-gray-300 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
        </a>
    </div>
</section>

{{-- Services Section --}}
<section id="services" class="py-24 lg:py-32">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <p class="text-indigo-400 text-sm font-semibold tracking-widest uppercase mb-3">
                <span lang="ms">Apa Yang Kami Buat</span>
                <span lang="en" class="hidden">What We Do</span>
            </p>
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                <span lang="ms">Perkhidmatan Kami</span>
                <span lang="en" class="hidden">Our Services</span>
            </h2>
            <p class="text-gray-400 max-w-2xl mx-auto">
                <span lang="ms">Kami sediakan servis lengkap dari mula sampai siap — domain, hosting, web, semuanya.</span>
                <span lang="en" class="hidden">We provide end-to-end digital services — from domain and hosting to complete web solutions.</span>
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($services ?? App\Models\Service::orderBy('sort_order')->get() as $service)
            <div class="bg-gray-900 border border-gray-800 rounded-xl p-6 hover:border-indigo-500/50 transition-all duration-300 hover:shadow-lg hover:shadow-indigo-500/5 group animate-slide-up">
                <div class="w-12 h-12 flex items-center justify-center rounded-lg bg-indigo-500/10 text-indigo-400 mb-5 group-hover:bg-indigo-500/20 transition-colors">
                    @if($service->icon)
                    <x-dynamic-component :component="$service->icon" class="w-6 h-6" />
                    @else
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    @endif
                </div>
                <h3 class="text-lg font-semibold text-white mb-3">{{ $service->title }}</h3>
                <p class="text-gray-400 text-sm leading-relaxed">{{ $service->description }}</p>
            </div>
            @empty
            <div class="col-span-full text-center text-gray-500 py-12">
                <p lang="ms">Tiada servis buat masa ini.</p>
                <p lang="en" class="hidden">No services listed yet.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

{{-- Tech Stack --}}
<section class="py-20 bg-slate-900/20 overflow-hidden">
    <div class="text-center mb-8">
        <p class="text-indigo-400 text-sm font-semibold tracking-widest uppercase mb-3">
            <span lang="ms">Teknologi Yang Kami Guna</span>
            <span lang="en" class="hidden">Technologies We Use</span>
        </p>
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
            <span lang="ms">Tech Stack</span>
            <span lang="en" class="hidden">Our Tech Stack</span>
        </h2>
    </div>


    @php $techs = App\Models\TechStack::orderBy('sort_order')->get(); @endphp

    @if($techs->count())
    <div class="max-w-3xl mx-auto px-8">
        <div id="tech-track" class="flex items-center justify-center gap-10 md:gap-14 flex-wrap transition-transform duration-500">
            @foreach($techs as $t)
            <div class="flex flex-col items-center gap-1.5 hover:opacity-100 transition-all duration-300 hover:scale-110">
                @if($t->logo)
                <img src="{{ asset('storage/'.$t->logo) }}" alt="{{ $t->name }}" class="h-12 md:h-16 w-auto object-contain">
                @endif
                <span class="text-[11px] text-white font-semibold bg-indigo-600 px-2.5 py-0.5 rounded-full">{{ $t->name }}</span>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</section>

{{-- Portfolio Section --}}
<section id="portfolio" class="py-24 lg:py-32 bg-slate-900/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <p class="text-indigo-400 text-sm font-semibold tracking-widest uppercase mb-3">
                <span lang="ms">Hasil Kerja Terkini</span>
                <span lang="en" class="hidden">Recent Work</span>
            </p>
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                <span lang="ms">Portfolio Kami</span>
                <span lang="en" class="hidden">Our Portfolio</span>
            </h2>
            <p class="text-gray-400 max-w-2xl mx-auto">
                <span lang="ms">Antara projek yang pernah kami siapkan untuk client.</span>
                <span lang="en" class="hidden">Some of the projects we've completed for our clients.</span>
            </p>
        </div>

        <div class="flex flex-wrap items-center justify-center gap-2 mb-10">
            <button class="filter-btn active px-4 py-2 rounded-lg text-sm font-medium bg-indigo-600 text-white transition-colors" data-filter="all">
                <span lang="ms">Semua</span><span lang="en" class="hidden">All</span>
            </button>
            @foreach(App\Models\ProjectCategory::orderBy('sort_order')->get() as $cat)
            <button class="filter-btn px-4 py-2 rounded-lg text-sm font-medium bg-gray-800 text-gray-300 hover:bg-gray-700 transition-colors" data-filter="{{ $cat->name }}">{{ $cat->name }}</button>
            @endforeach
        </div>

        @php
            $featuredProjects = $projects ?? App\Models\Project::where('is_published', true)->orderBy('sort_order')->take(6)->get();
        @endphp

        <div id="portfolio-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($featuredProjects as $project)
            <a href="{{ route('project.detail', $project->slug) }}" class="group bg-gray-900 border border-gray-800 rounded-xl overflow-hidden hover:border-indigo-500/50 transition-all duration-300 hover:shadow-lg hover:shadow-indigo-500/5 animate-slide-up" data-category="{{ $project->category }}">
                <div class="relative overflow-hidden aspect-video bg-gray-800">
                    @if($project->thumbnail)
                    <img src="{{ asset('storage/' . $project->thumbnail) }}" alt="{{ $project->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                    <div class="w-full h-full flex items-center justify-center text-gray-600">
                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    @endif
                    <span class="absolute top-3 left-3 bg-indigo-600/90 text-white text-xs font-medium px-2.5 py-1 rounded-full">{{ $project->category }}</span>
                </div>
                <div class="p-5">
                    <h3 class="text-lg font-semibold text-white mb-1 group-hover:text-indigo-400 transition-colors">{{ $project->title }}</h3>
                    @if($project->client)<p class="text-sm text-gray-500">{{ $project->client->name }}</p>@endif
                </div>
            </a>
            @empty
            <div class="col-span-full text-center text-gray-500 py-12">
                <p lang="ms">Belum ada projek dipaparkan.</p>
                <p lang="en" class="hidden">No projects published yet.</p>
            </div>
            @endforelse
        </div>

        @if($featuredProjects->count() >= 6)
        <div class="text-center mt-12">
            <a href="{{ route('portfolio') }}" class="inline-flex items-center gap-2 text-indigo-400 hover:text-indigo-300 font-medium transition-colors">
                <span lang="ms">Lihat Semua</span>
                <span lang="en" class="hidden">View All</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
        @endif
    </div>
</section>

{{-- Testimonials Section --}}
<section id="testimonials" class="py-24 lg:py-32">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <p class="text-indigo-400 text-sm font-semibold tracking-widest uppercase mb-3">
                <span lang="ms">Apa Kata Client</span>
                <span lang="en" class="hidden">Testimonials</span>
            </p>
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                <span lang="ms">Client Kami</span>
                <span lang="en" class="hidden">Our Clients</span>
            </h2>
            <p class="text-gray-400 max-w-2xl mx-auto">
                <span lang="ms">Antara maklum balas dari client yang pernah guna servis kami.</span>
                <span lang="en" class="hidden">Feedback from clients who have used our services.</span>
            </p>
        </div>

        @php $allTestimonials = $testimonials ?? App\Models\Testimonial::orderBy('sort_order')->get(); @endphp

        @if($allTestimonials->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($allTestimonials as $testimonial)
            <div class="bg-gray-900 border border-gray-800 rounded-xl p-6 hover:border-indigo-500/30 transition-all duration-300 animate-slide-up">
                <div class="flex items-center gap-4 mb-5">
                    <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-700 flex-shrink-0">
                        @if($testimonial->avatar)
                        <img src="{{ asset('storage/' . $testimonial->avatar) }}" alt="{{ $testimonial->client_name }}" class="w-full h-full object-cover">
                        @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400 text-lg font-bold">{{ strtoupper(substr($testimonial->client_name, 0, 1)) }}</div>
                        @endif
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-white">{{ $testimonial->client_name }}</h4>
                        @if($testimonial->role)<p class="text-xs text-gray-500">{{ $testimonial->role }}</p>@endif
                    </div>
                </div>
                <blockquote class="text-gray-400 text-sm leading-relaxed italic">&ldquo;{{ $testimonial->quote }}&rdquo;</blockquote>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center text-gray-500 py-12">
            <p lang="ms">Belum ada testimoni.</p>
            <p lang="en" class="hidden">No testimonials yet.</p>
        </div>
        @endif
    </div>
</section>

{{-- Contact Section --}}
<section id="contact" class="py-24 lg:py-32 bg-slate-900/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <p class="text-indigo-400 text-sm font-semibold tracking-widest uppercase mb-3">
                <span lang="ms">Hubungi Kami</span>
                <span lang="en" class="hidden">Get In Touch</span>
            </p>
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                <span lang="ms">Jom Bincang Projek Anda</span>
                <span lang="en" class="hidden">Let's Discuss Your Project</span>
            </h2>
            <p class="text-gray-400 max-w-2xl mx-auto">
                <span lang="ms">Ada projek nak dibangunkan? Hubungi kami, kita bincang.</span>
                <span lang="en" class="hidden">Got a project in mind? Reach out and let's discuss.</span>
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 max-w-5xl mx-auto">
            <div>
                <form action="{{ route('contact.submit') }}" method="POST" class="space-y-5">
                    @csrf
                    <input type="text" name="name" placeholder="Nama / Name" required class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-colors">
                    <input type="email" name="email" placeholder="Emel / Email" required class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-colors">
                    <input type="text" name="subject" placeholder="Subjek / Subject" required class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-colors">
                    <textarea name="message" rows="5" placeholder="Mesej / Message" required class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-colors resize-none"></textarea>
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3.5 rounded-lg font-medium transition-colors">
                        <span lang="ms">Hantar</span>
                        <span lang="en" class="hidden">Send Message</span>
                    </button>
                </form>
            </div>

            <div class="flex flex-col justify-center space-y-8">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-indigo-500/10 text-indigo-400 flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-white mb-1">
                            <span lang="ms">Emel</span>
                            <span lang="en" class="hidden">Email</span>
                        </h4>
                        <p class="text-sm text-gray-400">basyid90@gmail.com</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-indigo-500/10 text-indigo-400 flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-white mb-1">
                            <span lang="ms">Telefon</span>
                            <span lang="en" class="hidden">Phone</span>
                        </h4>
                        <p class="text-sm text-gray-400">019-4920559</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-indigo-500/10 text-indigo-400 flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-white mb-1">
                            <span lang="ms">Alamat</span>
                            <span lang="en" class="hidden">Location</span>
                        </h4>
                        <p class="text-sm text-gray-400">No 2-2A Taman Desa Pangkor, 32300 Pulau Pangkor, Perak</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- Portfolio Filter Script --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const filterBtns = document.querySelectorAll('.filter-btn');
        const grid = document.getElementById('portfolio-grid');
        if (!grid) return;
        const items = grid.querySelectorAll('[data-category]');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                filterBtns.forEach(b => { b.classList.remove('active','bg-indigo-600','text-white'); b.classList.add('bg-gray-800','text-gray-300'); });
                btn.classList.add('active','bg-indigo-600','text-white');
                btn.classList.remove('bg-gray-800','text-gray-300');
                const filter = btn.dataset.filter;
                items.forEach(item => {
                    item.style.display = (filter === 'all' || item.dataset.category === filter) ? '' : 'none';
                });
            });
        });
    });
</script>

@endsection
