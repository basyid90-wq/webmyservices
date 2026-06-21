@extends('layouts.app')

@section('title', ($project->title ?? 'Project') . ' — WebMy Services')

@section('content')

@php
    $project = $project ?? App\Models\Project::where('slug', request()->segment(2))->where('is_published', true)->firstOrFail();
@endphp

<section class="pt-28 lg:pt-36 pb-24 lg:pb-32">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Back Link --}}
        <a href="{{ route('portfolio') }}" class="inline-flex items-center gap-2 text-gray-400 hover:text-white transition-colors mb-8">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/></svg>
            <span class="text-sm">Back to Portfolio</span>
        </a>

        {{-- Hero Image --}}
        <div class="relative rounded-2xl overflow-hidden aspect-video lg:aspect-[21/9] bg-gray-900 border border-gray-800 mb-10">
            @if($project->thumbnail)
            <img src="{{ asset('storage/' . $project->thumbnail) }}" alt="{{ $project->title }}" class="w-full h-full object-cover">
            @else
            <div class="w-full h-full flex items-center justify-center text-gray-600">
                <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            @endif
            <span class="absolute top-4 left-4 bg-indigo-600/90 text-white text-sm font-medium px-3 py-1.5 rounded-full">
                {{ $project->category }}
            </span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            {{-- Main Content --}}
            <div class="lg:col-span-2">
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-4">{{ $project->title }}</h1>

                @if($project->client)
                <p class="text-gray-400 mb-8">Client: <span class="text-white font-medium">{{ $project->client->name }}</span></p>
                @endif

                @if($project->description)
                <div class="prose prose-invert prose-gray max-w-none mb-8">
                    <p class="text-gray-300 leading-relaxed">{{ $project->description }}</p>
                </div>
                @endif

                @if($project->technologies && count($project->technologies) > 0)
                <div class="mb-8">
                    <h3 class="text-sm font-semibold text-white tracking-wider uppercase mb-4">Technologies Used</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($project->technologies as $tech)
                        <span class="bg-gray-800 text-gray-300 text-sm px-3 py-1.5 rounded-lg border border-gray-700">{{ $tech }}</span>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">
                <div class="bg-gray-900 border border-gray-800 rounded-xl p-6">
                    <h3 class="text-sm font-semibold text-white tracking-wider uppercase mb-4">Project Details</h3>
                    <ul class="space-y-4">
                        @if($project->client)
                        <li>
                            <span class="block text-xs text-gray-500 mb-0.5">Client</span>
                            <span class="text-sm text-gray-200">{{ $project->client->name }}</span>
                        </li>
                        @endif
                        <li>
                            <span class="block text-xs text-gray-500 mb-0.5">Category</span>
                            <span class="text-sm text-gray-200">{{ $project->category }}</span>
                        </li>
                        @if($project->completion_date)
                        <li>
                            <span class="block text-xs text-gray-500 mb-0.5">Completion Date</span>
                            <span class="text-sm text-gray-200">{{ $project->completion_date->format('F Y') }}</span>
                        </li>
                        @endif
                    </ul>
                </div>

                @if($project->live_url)
                <a href="{{ $project->live_url }}" target="_blank" rel="noopener noreferrer"
                    class="flex items-center justify-center gap-2 w-full bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3.5 rounded-lg font-medium transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    Visit Live Site
                </a>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection
