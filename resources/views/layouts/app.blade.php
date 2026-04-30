<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-slate-100 text-slate-800 antialiased">
    <div class="min-h-screen lg:grid lg:grid-cols-[260px_1fr]">
        <aside id="app-sidebar" class="fixed inset-y-0 left-0 z-40 w-64 -translate-x-full border-r border-slate-200 bg-slate-950 px-4 py-6 text-slate-200 transition-transform duration-300 lg:static lg:translate-x-0">
            <a href="{{ route('dashboard') }}" class="mb-8 flex items-center gap-3 rounded-2xl border border-emerald-500/20 bg-emerald-500/10 px-4 py-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-400/20 text-lg font-bold text-emerald-300">L</span>
                <div>
                    <p class="text-sm text-emerald-200">Library Console</p>
                    <p class="text-xs text-slate-400">Manajemen Perpustakaan</p>
                </div>
            </a>

            <nav class="space-y-2 text-sm">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('dashboard') ? 'bg-white/10 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('books.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('books.*') ? 'bg-white/10 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    <span>Books CRUD</span>
                </a>
                <a href="{{ route('loans.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('loans.*') ? 'bg-white/10 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    <span>Loans</span>
                </a>
                <a href="{{ route('ai.recommendation') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('ai.recommendation*') ? 'bg-white/10 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    <span>AI Chat</span>
                </a>
            </nav>

            <div class="mt-8 rounded-2xl border border-white/10 bg-white/5 p-4 text-xs text-slate-400">
                Sistem modern berbasis Laravel, Tailwind, dan Groq AI.
            </div>
        </aside>

        <div class="flex min-h-screen flex-col">
            <header class="sticky top-0 z-30 border-b border-slate-200 bg-white/90 px-4 py-3 backdrop-blur sm:px-6 lg:px-8">
                <div class="flex items-center justify-between gap-4">
                    <button id="sidebar-toggle" type="button" class="inline-flex items-center rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 shadow-sm lg:hidden">
                        Menu
                    </button>
                    <div class="hidden sm:block">
                        <h1 class="text-sm font-semibold text-slate-900">Library Management System</h1>
                        <p class="text-xs text-slate-500">Dashboard operasional perpustakaan</p>
                    </div>
                    <a href="{{ route('dashboard') }}" class="rounded-xl border border-emerald-300 bg-emerald-50 px-3 py-2 text-xs font-semibold text-emerald-700 transition hover:bg-emerald-100">
                        Kembali ke Dashboard
                    </a>
                </div>
            </header>

            <main class="flex-1 px-4 py-6 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-5 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-5 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
            </main>
        </div>
    </div>

    <script>
        const sidebar = document.getElementById('app-sidebar');
        const toggle = document.getElementById('sidebar-toggle');

        if (sidebar && toggle) {
            toggle.addEventListener('click', () => {
                sidebar.classList.toggle('-translate-x-full');
            });
        }
    </script>
    @livewireScripts
</body>
</html>
