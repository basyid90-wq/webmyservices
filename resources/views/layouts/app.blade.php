<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'WebMy Services')</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700,800,900" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-950 text-gray-100 font-sans antialiased">

    <div id="preloader" class="fixed inset-0 z-[9999] bg-slate-950 flex items-center justify-center transition-opacity duration-500">
        <div class="flex flex-col items-center gap-4">
            <div class="w-10 h-10 border-2 border-indigo-500 border-t-transparent rounded-full animate-spin"></div>
            <span class="text-sm text-gray-500 tracking-widest uppercase">Loading</span>
        </div>
    </div>

    @include('partials.header')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    <script>
        window.addEventListener('load', () => {
            const preloader = document.getElementById('preloader');
            preloader.classList.add('opacity-0', 'pointer-events-none');
            setTimeout(() => preloader.remove(), 500);
        });
    </script>

    <script>
        (() => {
            const btnMs = document.getElementById('lang-ms');
            const btnEn = document.getElementById('lang-en');
            if (!btnMs || !btnEn) return;

            function setLang(lang) {
                document.querySelectorAll('span[lang], p[lang]').forEach(el => {
                    el.classList.toggle('hidden', el.getAttribute('lang') !== lang);
                });
                btnMs.classList.toggle('bg-indigo-600', lang === 'ms');
                btnMs.classList.toggle('text-white', lang === 'ms');
                btnMs.classList.toggle('text-gray-400', lang !== 'ms');
                btnEn.classList.toggle('bg-indigo-600', lang === 'en');
                btnEn.classList.toggle('text-white', lang === 'en');
                btnEn.classList.toggle('text-gray-400', lang !== 'en');
            }

            btnMs.addEventListener('click', () => setLang('ms'));
            btnEn.addEventListener('click', () => setLang('en'));
            setLang('ms');
        })();
    </script>
</body>
</html>
