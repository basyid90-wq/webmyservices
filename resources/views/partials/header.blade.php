<header class="fixed top-0 left-0 w-full z-50 bg-slate-950/80 backdrop-blur-lg border-b border-white/5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-20">
            <a href="{{ route('home') }}" class="text-xl lg:text-2xl font-bold tracking-tight">
                Web<span class="text-indigo-400">My</span> <span class="text-white">Services</span>
            </a>

            <nav class="hidden lg:flex items-center gap-8">
                <a href="{{ route('home') }}" class="text-sm font-medium text-gray-300 hover:text-white transition-colors {{ request()->routeIs('home') ? 'text-white' : '' }}">Home</a>
                <a href="{{ route('portfolio') }}" class="text-sm font-medium text-gray-300 hover:text-white transition-colors {{ request()->routeIs('portfolio') ? 'text-white' : '' }}">Portfolio</a>
                <a href="{{ route('home') }}#services" class="text-sm font-medium text-gray-300 hover:text-white transition-colors">Services</a>
                <a href="{{ route('contact') }}" class="text-sm font-medium text-gray-300 hover:text-white transition-colors {{ request()->routeIs('contact') ? 'text-white' : '' }}">Contact</a>
            </nav>

            <div class="hidden lg:flex items-center gap-3">
                <div class="flex items-center gap-0.5 bg-gray-800/50 rounded-lg p-0.5">
                    <button id="lang-ms" class="lang-btn px-2.5 py-1.5 rounded-md text-xs font-semibold bg-indigo-600 text-white transition-colors">BM</button>
                    <button id="lang-en" class="lang-btn px-2.5 py-1.5 rounded-md text-xs font-semibold text-gray-400 hover:text-white transition-colors">EN</button>
                </div>
                <a href="{{ url('/admin') }}" class="text-sm font-medium text-gray-400 hover:text-white transition-colors border border-gray-700 hover:border-indigo-500 px-4 py-2 rounded-lg">
                    Login
                </a>
                <a href="{{ route('contact') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-5 py-2.5 rounded-lg transition-colors">
                    Get In Touch
                </a>
            </div>

            <button id="mobile-menu-toggle" class="lg:hidden relative w-8 h-8 flex flex-col items-center justify-center gap-1.5 group" aria-label="Toggle menu">
                <span class="block w-6 h-0.5 bg-white rounded transition-transform duration-300 origin-center group-[.open]:translate-y-1 group-[.open]:rotate-45"></span>
                <span class="block w-6 h-0.5 bg-white rounded transition-opacity duration-300 group-[.open]:opacity-0"></span>
                <span class="block w-6 h-0.5 bg-white rounded transition-transform duration-300 origin-center group-[.open]:-translate-y-1 group-[.open]:-rotate-45"></span>
            </button>
        </div>
    </div>

    <div id="mobile-menu" class="lg:hidden hidden bg-slate-900/95 backdrop-blur-lg border-b border-white/5">
        <nav class="max-w-7xl mx-auto px-4 py-6 flex flex-col gap-4">
            <a href="{{ route('home') }}" class="text-base font-medium text-gray-300 hover:text-white transition-colors py-2 {{ request()->routeIs('home') ? 'text-white' : '' }}">Home</a>
            <a href="{{ route('portfolio') }}" class="text-base font-medium text-gray-300 hover:text-white transition-colors py-2 {{ request()->routeIs('portfolio') ? 'text-white' : '' }}">Portfolio</a>
            <a href="{{ route('home') }}#services" class="text-base font-medium text-gray-300 hover:text-white transition-colors py-2">Services</a>
            <a href="{{ route('contact') }}" class="text-base font-medium text-gray-300 hover:text-white transition-colors py-2 {{ request()->routeIs('contact') ? 'text-white' : '' }}">Contact</a>
            <div class="flex items-center gap-2 mt-2">
                <a href="{{ url('/admin') }}" class="inline-flex justify-center border border-gray-700 hover:border-indigo-500 text-gray-300 text-sm font-medium px-5 py-3 rounded-lg transition-colors">
                    Login
                </a>
                <a href="{{ route('contact') }}" class="inline-flex flex-1 justify-center bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-5 py-3 rounded-lg transition-colors">
                    Get In Touch
                </a>
            </div>
        </nav>
    </div>
</header>

<script>
    (function() {
        const toggle = document.getElementById('mobile-menu-toggle');
        const menu = document.getElementById('mobile-menu');

        if (!toggle || !menu) return;

        toggle.addEventListener('click', () => {
            toggle.classList.toggle('open');
            menu.classList.toggle('hidden');
        });

        document.querySelectorAll('#mobile-menu a[href^="#"]').forEach(link => {
            link.addEventListener('click', () => {
                toggle.classList.remove('open');
                menu.classList.add('hidden');
            });
        });

        document.querySelectorAll('#mobile-menu a:not([href^="#"])').forEach(link => {
            link.addEventListener('click', () => {
                toggle.classList.remove('open');
                menu.classList.add('hidden');
            });
        });
    })();
</script>
