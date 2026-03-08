<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Личный кабинет') — ТРЦ Европейский</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 48 35'><path d='M6.209 8.589L3.731 10.185L1.729 9.569L2.191 11.172L0 12.677L2.492 12.173L2.961 13.797L4.207 11.802L7 11.186L4.97 10.563L6.209 8.589ZM10.255 4.011L9.821 5.887L7.056 7.021L9.562 7.056L9.128 8.96L11.123 7.077L13.65 7.112L12.341 5.922L14.315 4.06L11.543 5.187L10.255 4.011ZM19.978 0.959L18.739 2.919L15.953 3.507L17.969 4.144L16.716 6.125L19.229 4.536L21.273 5.18L20.776 3.556L23.268 1.974L20.468 2.562L19.978 0.959ZM29.505 0L27.51 1.855L24.969 1.792L26.278 3.003L24.262 4.879L27.09 3.766L28.413 4.991L28.833 3.066L31.661 1.946L29.092 1.89L29.505 0ZM38.514 3.878L35.644 4.438L34.377 6.461L33.873 4.788L31.003 5.341L33.565 3.752L33.068 2.107L35.133 2.779L37.681 1.204L36.428 3.199L38.514 3.878ZM43.26 7.665L40.6 7.595L38.57 9.52L38.962 7.553L36.323 7.476L39.207 6.335L39.599 4.396L40.985 5.635L43.862 4.501L41.853 6.412L43.26 7.665ZM45.36 13.006L43.197 12.278L40.579 13.916L41.86 11.837L39.704 11.116L42.644 10.549L43.911 8.498L44.464 10.206L47.404 9.646L44.807 11.27L45.36 13.006ZM44.569 19.341L43.078 18.039L40.131 19.236L42.161 17.241L40.677 15.946L43.414 16.009L45.423 14.035L45.101 16.044L47.838 16.114L44.898 17.304L44.569 19.341ZM40.558 26.306L40.012 24.486L37.002 25.032L39.662 23.366L39.116 21.56L41.314 22.33L43.96 20.671L42.672 22.813L44.877 23.59L41.86 24.143L40.558 26.306ZM33.271 32.62L33.691 30.485L30.954 30.352L33.943 29.176L34.363 27.069L35.798 28.455L38.787 27.286L36.687 29.316L38.129 30.716L35.385 30.576L33.271 32.62ZM28.595 20.881L8.4 26.957C9.989 29.127 13.923 29.834 18.543 28.455C20.7591 27.7899 22.8398 26.7376 24.689 25.347L30.45 27.041C26.9965 29.9667 22.9728 32.143 18.634 33.432C8.4 36.477 0.252 33.432 0.364 26.789C0.476 20.3 8.435 12.782 18.2 9.8C27.965 6.818 36.344 9.415 36.694 15.827C36.738 16.7375 36.6388 17.6493 36.4 18.529L28.595 20.881ZM8.225 22.183L28.602 16.009C27.069 13.713 23.002 12.978 18.298 14.413C13.594 15.848 9.646 19.005 8.225 22.183Z' fill='%23C0C0C0'/></svg>" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-surface font-sans antialiased">
    <div class="min-h-screen flex">
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-40 w-64 bg-primary text-white transform -translate-x-full lg:translate-x-0 lg:static lg:inset-auto transition-transform duration-200">
            <div class="flex items-center gap-3 px-6 h-16 border-b border-white/10">
                <svg width="48" height="35" viewBox="0 0 48 35" fill="none" xmlns="http://www.w3.org/2000/svg" class="euro-logo"><defs><linearGradient id="metallic-gradient" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color: rgb(232, 232, 232); stop-opacity: 1;"></stop><stop offset="25%" style="stop-color: rgb(255, 255, 255); stop-opacity: 1;"></stop><stop offset="50%" style="stop-color: rgb(192, 192, 192); stop-opacity: 1;"></stop><stop offset="75%" style="stop-color: rgb(255, 255, 255); stop-opacity: 1;"></stop><stop offset="100%" style="stop-color: rgb(232, 232, 232); stop-opacity: 1;"></stop></linearGradient></defs><path d="M6.209 8.589L3.731 10.185L1.729 9.569L2.191 11.172L0 12.677L2.492 12.173L2.961 13.797L4.207 11.802L7 11.186L4.97 10.563L6.209 8.589ZM10.255 4.011L9.821 5.887L7.056 7.021L9.562 7.056L9.128 8.96L11.123 7.077L13.65 7.112L12.341 5.922L14.315 4.06L11.543 5.187L10.255 4.011ZM19.978 0.959L18.739 2.919L15.953 3.507L17.969 4.144L16.716 6.125L19.229 4.536L21.273 5.18L20.776 3.556L23.268 1.974L20.468 2.562L19.978 0.959ZM29.505 0L27.51 1.855L24.969 1.792L26.278 3.003L24.262 4.879L27.09 3.766L28.413 4.991L28.833 3.066L31.661 1.946L29.092 1.89L29.505 0ZM38.514 3.878L35.644 4.438L34.377 6.461L33.873 4.788L31.003 5.341L33.565 3.752L33.068 2.107L35.133 2.779L37.681 1.204L36.428 3.199L38.514 3.878ZM43.26 7.665L40.6 7.595L38.57 9.52L38.962 7.553L36.323 7.476L39.207 6.335L39.599 4.396L40.985 5.635L43.862 4.501L41.853 6.412L43.26 7.665ZM45.36 13.006L43.197 12.278L40.579 13.916L41.86 11.837L39.704 11.116L42.644 10.549L43.911 8.498L44.464 10.206L47.404 9.646L44.807 11.27L45.36 13.006ZM44.569 19.341L43.078 18.039L40.131 19.236L42.161 17.241L40.677 15.946L43.414 16.009L45.423 14.035L45.101 16.044L47.838 16.114L44.898 17.304L44.569 19.341ZM40.558 26.306L40.012 24.486L37.002 25.032L39.662 23.366L39.116 21.56L41.314 22.33L43.96 20.671L42.672 22.813L44.877 23.59L41.86 24.143L40.558 26.306ZM33.271 32.62L33.691 30.485L30.954 30.352L33.943 29.176L34.363 27.069L35.798 28.455L38.787 27.286L36.687 29.316L38.129 30.716L35.385 30.576L33.271 32.62ZM28.595 20.881L8.4 26.957C9.989 29.127 13.923 29.834 18.543 28.455C20.7591 27.7899 22.8398 26.7376 24.689 25.347L30.45 27.041C26.9965 29.9667 22.9728 32.143 18.634 33.432C8.4 36.477 0.252 33.432 0.364 26.789C0.476 20.3 8.435 12.782 18.2 9.8C27.965 6.818 36.344 9.415 36.694 15.827C36.738 16.7375 36.6388 17.6493 36.4 18.529L28.595 20.881ZM8.225 22.183L28.602 16.009C27.069 13.713 23.002 12.978 18.298 14.413C13.594 15.848 9.646 19.005 8.225 22.183Z" fill="url(#metallic-gradient)"></path></svg>
                <div>
                    <div class="font-bold text-sm">ЕВРОПЕЙСКИЙ</div>
                    <div class="text-[10px] text-text-muted">Личный кабинет</div>
                </div>
            </div>

            <nav class="px-3 py-4 space-y-1">
                <a href="{{ route('organization.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-colors {{ request()->routeIs('organization.dashboard') ? 'bg-white/10 text-white' : 'text-text-muted hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1"/></svg>
                    Обзор
                </a>
                <a href="{{ route('organization.ad-requests.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-colors {{ request()->routeIs('organization.ad-requests.*') ? 'bg-white/10 text-white' : 'text-text-muted hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    Заявки на рекламу
                </a>
                <a href="{{ route('organization.event-requests.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-colors {{ request()->routeIs('organization.event-requests.*') ? 'bg-white/10 text-white' : 'text-text-muted hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Заявки на мероприятия
                </a>

                <div class="pt-4 mt-4 border-t border-white/10">
                    <a href="https://y8shikage.github.io/EuroReact/home" target="_blank" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gold hover:bg-white/5 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Проверка видео
                        <svg class="w-3 h-3 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>
                </div>
            </nav>

            <div class="absolute bottom-0 left-0 right-0 px-3 py-4 border-t border-white/10">
                <div class="flex items-center gap-3 px-3 mb-3">
                    <div class="w-8 h-8 bg-gold/20 rounded-full flex items-center justify-center text-sm font-medium text-gold">{{ mb_substr(auth()->user()->tenant->company_name ?? auth()->user()->name ?? 'О', 0, 1) }}</div>
                    <div class="text-sm">
                        <div class="font-medium">{{ auth()->user()->tenant->company_name ?? auth()->user()->name }}</div>
                        <div class="text-xs text-text-muted">{{ auth()->user()->email }}</div>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-text-muted hover:bg-white/5 hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Выйти
                    </button>
                </form>
            </div>
        </aside>

        <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-30 hidden lg:hidden"></div>

        <div class="flex-1 flex flex-col min-h-screen">
            <header class="bg-card border-b border-surface-border h-16 flex items-center px-4 lg:px-8 gap-4">
                <button id="sidebar-toggle" class="lg:hidden p-2 rounded-lg hover:bg-surface-lighter transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <h1 class="text-lg font-semibold text-text-primary">@yield('page-title', 'Личный кабинет')</h1>
            </header>

            @if(session('success'))
                <div class="mx-4 lg:mx-8 mt-4">
                    <div class="bg-success/10 border border-success/30 text-success px-4 py-3 rounded-lg text-sm">{{ session('success') }}</div>
                </div>
            @endif
            @if(session('error'))
                <div class="mx-4 lg:mx-8 mt-4">
                    <div class="bg-danger/10 border border-danger/30 text-danger px-4 py-3 rounded-lg text-sm">{{ session('error') }}</div>
                </div>
            @endif

            <main class="flex-1 p-4 lg:p-8">
                @yield('content')
            </main>

            <footer class="px-4 lg:px-8 py-4 border-t border-surface-border">
                <div class="flex items-center justify-between text-xs">
                    <span class="text-text-muted">&copy; {{ date('Y') }} ТРЦ «Европейский»</span>
                    <span class="shiny-text">Разработчик: Кудряшов Никола, ИСП-029</span>
                </div>
            </footer>
        </div>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const toggle = document.getElementById('sidebar-toggle');

        function openSidebar() {
            sidebar?.classList.remove('-translate-x-full');
            overlay?.classList.remove('hidden');
        }
        function closeSidebar() {
            sidebar?.classList.add('-translate-x-full');
            overlay?.classList.add('hidden');
        }

        toggle?.addEventListener('click', openSidebar);
        overlay?.addEventListener('click', closeSidebar);
    </script>
    @stack('scripts')
</body>
</html>
