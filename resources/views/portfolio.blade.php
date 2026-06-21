@extends('layouts.app')

@section('title', 'Portfolio — WebMy Services')

@section('content')

<section class="pt-28 lg:pt-36 pb-24 lg:pb-32">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <p class="text-indigo-400 text-sm font-semibold tracking-widest uppercase mb-3">Our Work</p>
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4">Portfolio</h1>
            <p class="text-gray-400 max-w-2xl mx-auto">A selection of projects we've delivered for our amazing clients.</p>
        </div>

        {{-- Filter Tabs --}}
        <div class="flex flex-wrap items-center justify-center gap-2 mb-12">
            <button class="filter-btn active px-4 py-2 rounded-lg text-sm font-medium bg-indigo-600 text-white transition-colors" data-filter="all">All</button>
            <button class="filter-btn px-4 py-2 rounded-lg text-sm font-medium bg-gray-800 text-gray-300 hover:bg-gray-700 transition-colors" data-filter="Web App">Web App</button>
            <button class="filter-btn px-4 py-2 rounded-lg text-sm font-medium bg-gray-800 text-gray-300 hover:bg-gray-700 transition-colors" data-filter="E-Commerce">E-Commerce</button>
            <button class="filter-btn px-4 py-2 rounded-lg text-sm font-medium bg-gray-800 text-gray-300 hover:bg-gray-700 transition-colors" data-filter="Landing Page">Landing Page</button>
            <button class="filter-btn px-4 py-2 rounded-lg text-sm font-medium bg-gray-800 text-gray-300 hover:bg-gray-700 transition-colors" data-filter="Branding">Branding</button>
        </div>

        @php
            $allProjects = $projects ?? App\Models\Project::where('is_published', true)->orderBy('sort_order')->get();
        @endphp

        <div id="portfolio-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($allProjects as $project)
            <a href="{{ route('project.detail', $project->slug) }}" class="group bg-gray-900 border border-gray-800 rounded-xl overflow-hidden hover:border-indigo-500/50 transition-all duration-300 hover:shadow-lg hover:shadow-indigo-500/5 animate-slide-up" data-category="{{ $project->category }}">
                <div class="relative overflow-hidden aspect-video bg-gray-800">
                    @if($project->thumbnail)
                    <img src="{{ asset('storage/' . $project->thumbnail) }}" alt="{{ $project->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                    @else
                    <div class="w-full h-full flex items-center justify-center text-gray-600">
                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    @endif
                    <span class="absolute top-3 left-3 bg-indigo-600/90 text-white text-xs font-medium px-2.5 py-1 rounded-full">
                        {{ $project->category }}
                    </span>
                </div>
                <div class="p-5">
                    <h3 class="text-lg font-semibold text-white mb-1 group-hover:text-indigo-400 transition-colors">{{ $project->title }}</h3>
                    @if($project->client)
                    <p class="text-sm text-gray-500">{{ $project->client->name }}</p>
                    @endif
                </div>
            </a>
            @empty
            <div class="col-span-full text-center py-20">
                <div class="text-gray-600 mb-4">
                    <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
                <p class="text-gray-500 text-lg">No projects published yet.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const filterBtns = document.querySelectorAll('.filter-btn');
        const grid = document.getElementById('portfolio-grid');
        if (!grid) return;

        const items = grid.querySelectorAll('[data-category]');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                filterBtns.forEach(b => {
                    b.classList.remove('active', 'bg-indigo-600', 'text-white');
                    b.classList.add('bg-gray-800', 'text-gray-300');
                });
                btn.classList.add('active', 'bg-indigo-600', 'text-white');
                btn.classList.remove('bg-gray-800', 'text-gray-300');

                const filter = btn.dataset.filter;

                items.forEach(item => {
                    if (filter === 'all' || item.dataset.category === filter) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    });
</script>

@endsection
