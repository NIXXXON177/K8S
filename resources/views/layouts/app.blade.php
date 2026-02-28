<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ТРЦ Европейский') — Управление мероприятиями и рекламой</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-primary text-text-primary font-sans antialiased">
    <header class="bg-primary border-b border-surface-border sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 lg:h-20">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <svg width="48" height="35" viewBox="0 0 48 35" fill="none" xmlns="http://www.w3.org/2000/svg" class="euro-logo"><defs><linearGradient id="metallic-gradient" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color: rgb(232, 232, 232); stop-opacity: 1;"></stop><stop offset="25%" style="stop-color: rgb(255, 255, 255); stop-opacity: 1;"></stop><stop offset="50%" style="stop-color: rgb(192, 192, 192); stop-opacity: 1;"></stop><stop offset="75%" style="stop-color: rgb(255, 255, 255); stop-opacity: 1;"></stop><stop offset="100%" style="stop-color: rgb(232, 232, 232); stop-opacity: 1;"></stop></linearGradient></defs><path d="M6.209 8.589L3.731 10.185L1.729 9.569L2.191 11.172L0 12.677L2.492 12.173L2.961 13.797L4.207 11.802L7 11.186L4.97 10.563L6.209 8.589ZM10.255 4.011L9.821 5.887L7.056 7.021L9.562 7.056L9.128 8.96L11.123 7.077L13.65 7.112L12.341 5.922L14.315 4.06L11.543 5.187L10.255 4.011ZM19.978 0.959L18.739 2.919L15.953 3.507L17.969 4.144L16.716 6.125L19.229 4.536L21.273 5.18L20.776 3.556L23.268 1.974L20.468 2.562L19.978 0.959ZM29.505 0L27.51 1.855L24.969 1.792L26.278 3.003L24.262 4.879L27.09 3.766L28.413 4.991L28.833 3.066L31.661 1.946L29.092 1.89L29.505 0ZM38.514 3.878L35.644 4.438L34.377 6.461L33.873 4.788L31.003 5.341L33.565 3.752L33.068 2.107L35.133 2.779L37.681 1.204L36.428 3.199L38.514 3.878ZM43.26 7.665L40.6 7.595L38.57 9.52L38.962 7.553L36.323 7.476L39.207 6.335L39.599 4.396L40.985 5.635L43.862 4.501L41.853 6.412L43.26 7.665ZM45.36 13.006L43.197 12.278L40.579 13.916L41.86 11.837L39.704 11.116L42.644 10.549L43.911 8.498L44.464 10.206L47.404 9.646L44.807 11.27L45.36 13.006ZM44.569 19.341L43.078 18.039L40.131 19.236L42.161 17.241L40.677 15.946L43.414 16.009L45.423 14.035L45.101 16.044L47.838 16.114L44.898 17.304L44.569 19.341ZM40.558 26.306L40.012 24.486L37.002 25.032L39.662 23.366L39.116 21.56L41.314 22.33L43.96 20.671L42.672 22.813L44.877 23.59L41.86 24.143L40.558 26.306ZM33.271 32.62L33.691 30.485L30.954 30.352L33.943 29.176L34.363 27.069L35.798 28.455L38.787 27.286L36.687 29.316L38.129 30.716L35.385 30.576L33.271 32.62ZM28.595 20.881L8.4 26.957C9.989 29.127 13.923 29.834 18.543 28.455C20.7591 27.7899 22.8398 26.7376 24.689 25.347L30.45 27.041C26.9965 29.9667 22.9728 32.143 18.634 33.432C8.4 36.477 0.252 33.432 0.364 26.789C0.476 20.3 8.435 12.782 18.2 9.8C27.965 6.818 36.344 9.415 36.694 15.827C36.738 16.7375 36.6388 17.6493 36.4 18.529L28.595 20.881ZM8.225 22.183L28.602 16.009C27.069 13.713 23.002 12.978 18.298 14.413C13.594 15.848 9.646 19.005 8.225 22.183Z" fill="url(#metallic-gradient)"></path></svg>
                    <div class="hidden sm:block">
                        <div class="text-lg font-bold tracking-wide text-white">ЕВРОПЕЙСКИЙ</div>
                        <div class="text-xs text-text-muted -mt-1">торгово-развлекательный центр</div>
                    </div>
                </a>

                <nav class="hidden lg:flex items-center gap-1">
                    <a href="{{ route('home') }}" class="px-4 py-2 rounded-lg text-sm font-medium text-text-secondary transition-colors hover:text-white hover:bg-surface-lighter {{ request()->routeIs('home') ? 'text-white bg-surface-lighter' : '' }}">Главная</a>
                    <a href="{{ route('events.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium text-text-secondary transition-colors hover:text-white hover:bg-surface-lighter {{ request()->routeIs('events.*') ? 'text-white bg-surface-lighter' : '' }}">Мероприятия</a>
                    <a href="{{ route('screens.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium text-text-secondary transition-colors hover:text-white hover:bg-surface-lighter {{ request()->routeIs('screens.index') ? 'text-white bg-surface-lighter' : '' }}">Рекламные экраны</a>
                    <a href="{{ route('screens.map') }}" class="px-4 py-2 rounded-lg text-sm font-medium text-text-secondary transition-colors hover:text-white hover:bg-surface-lighter {{ request()->routeIs('screens.map') ? 'text-white bg-surface-lighter' : '' }}">Схема экранов</a>
                    <a href="{{ route('about') }}" class="px-4 py-2 rounded-lg text-sm font-medium text-text-secondary transition-colors hover:text-white hover:bg-surface-lighter {{ request()->routeIs('about') ? 'text-white bg-surface-lighter' : '' }}">О ТРЦ</a>
                    <a href="{{ route('event-request.create') }}" class="ml-2 px-5 py-2 bg-gold/20 text-gold hover:bg-gold hover:text-white rounded-lg text-sm font-semibold transition-colors {{ request()->routeIs('event-request.*') ? 'bg-gold text-white' : '' }}">Организовать мероприятие</a>
                    <a href="{{ route('ad-request.create') }}" class="px-5 py-2 bg-accent hover:bg-accent-hover text-white rounded-lg text-sm font-semibold transition-colors">Разместить рекламу</a>
                </nav>

                <button id="mobile-menu-btn" class="lg:hidden p-2 rounded-lg hover:bg-surface-lighter text-text-secondary transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
        </div>

        <div id="mobile-menu" class="lg:hidden hidden border-t border-surface-border">
            <div class="px-4 py-3 space-y-1">
                <a href="{{ route('home') }}" class="block px-4 py-2 rounded-lg text-sm text-text-secondary hover:text-white hover:bg-surface-lighter">Главная</a>
                <a href="{{ route('events.index') }}" class="block px-4 py-2 rounded-lg text-sm text-text-secondary hover:text-white hover:bg-surface-lighter">Мероприятия</a>
                <a href="{{ route('screens.index') }}" class="block px-4 py-2 rounded-lg text-sm text-text-secondary hover:text-white hover:bg-surface-lighter">Рекламные экраны</a>
                <a href="{{ route('screens.map') }}" class="block px-4 py-2 rounded-lg text-sm text-text-secondary hover:text-white hover:bg-surface-lighter">Схема экранов</a>
                <a href="{{ route('about') }}" class="block px-4 py-2 rounded-lg text-sm text-text-secondary hover:text-white hover:bg-surface-lighter">О ТРЦ</a>
                <a href="{{ route('event-request.create') }}" class="block px-4 py-2 bg-gold/20 text-gold rounded-lg text-sm font-semibold text-center mt-2">Организовать мероприятие</a>
                <a href="{{ route('ad-request.create') }}" class="block px-4 py-2 bg-accent rounded-lg text-sm font-semibold text-white text-center mt-2">Разместить рекламу</a>
            </div>
        </div>
    </header>

    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-success/10 border border-success/30 text-success px-4 py-3 rounded-lg">{{ session('success') }}</div>
        </div>
    @endif
    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-danger/10 border border-danger/30 text-danger px-4 py-3 rounded-lg">{{ session('error') }}</div>
        </div>
    @endif

    <main>
        @yield('content')
    </main>

    <footer class="bg-surface border-t border-surface-border mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <svg width="48" height="35" viewBox="0 0 48 35" fill="none" xmlns="http://www.w3.org/2000/svg" class="euro-logo"><defs><linearGradient id="metallic-gradient" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color: rgb(232, 232, 232); stop-opacity: 1;"></stop><stop offset="25%" style="stop-color: rgb(255, 255, 255); stop-opacity: 1;"></stop><stop offset="50%" style="stop-color: rgb(192, 192, 192); stop-opacity: 1;"></stop><stop offset="75%" style="stop-color: rgb(255, 255, 255); stop-opacity: 1;"></stop><stop offset="100%" style="stop-color: rgb(232, 232, 232); stop-opacity: 1;"></stop></linearGradient></defs><path d="M6.209 8.589L3.731 10.185L1.729 9.569L2.191 11.172L0 12.677L2.492 12.173L2.961 13.797L4.207 11.802L7 11.186L4.97 10.563L6.209 8.589ZM10.255 4.011L9.821 5.887L7.056 7.021L9.562 7.056L9.128 8.96L11.123 7.077L13.65 7.112L12.341 5.922L14.315 4.06L11.543 5.187L10.255 4.011ZM19.978 0.959L18.739 2.919L15.953 3.507L17.969 4.144L16.716 6.125L19.229 4.536L21.273 5.18L20.776 3.556L23.268 1.974L20.468 2.562L19.978 0.959ZM29.505 0L27.51 1.855L24.969 1.792L26.278 3.003L24.262 4.879L27.09 3.766L28.413 4.991L28.833 3.066L31.661 1.946L29.092 1.89L29.505 0ZM38.514 3.878L35.644 4.438L34.377 6.461L33.873 4.788L31.003 5.341L33.565 3.752L33.068 2.107L35.133 2.779L37.681 1.204L36.428 3.199L38.514 3.878ZM43.26 7.665L40.6 7.595L38.57 9.52L38.962 7.553L36.323 7.476L39.207 6.335L39.599 4.396L40.985 5.635L43.862 4.501L41.853 6.412L43.26 7.665ZM45.36 13.006L43.197 12.278L40.579 13.916L41.86 11.837L39.704 11.116L42.644 10.549L43.911 8.498L44.464 10.206L47.404 9.646L44.807 11.27L45.36 13.006ZM44.569 19.341L43.078 18.039L40.131 19.236L42.161 17.241L40.677 15.946L43.414 16.009L45.423 14.035L45.101 16.044L47.838 16.114L44.898 17.304L44.569 19.341ZM40.558 26.306L40.012 24.486L37.002 25.032L39.662 23.366L39.116 21.56L41.314 22.33L43.96 20.671L42.672 22.813L44.877 23.59L41.86 24.143L40.558 26.306ZM33.271 32.62L33.691 30.485L30.954 30.352L33.943 29.176L34.363 27.069L35.798 28.455L38.787 27.286L36.687 29.316L38.129 30.716L35.385 30.576L33.271 32.62ZM28.595 20.881L8.4 26.957C9.989 29.127 13.923 29.834 18.543 28.455C20.7591 27.7899 22.8398 26.7376 24.689 25.347L30.45 27.041C26.9965 29.9667 22.9728 32.143 18.634 33.432C8.4 36.477 0.252 33.432 0.364 26.789C0.476 20.3 8.435 12.782 18.2 9.8C27.965 6.818 36.344 9.415 36.694 15.827C36.738 16.7375 36.6388 17.6493 36.4 18.529L28.595 20.881ZM8.225 22.183L28.602 16.009C27.069 13.713 23.002 12.978 18.298 14.413C13.594 15.848 9.646 19.005 8.225 22.183Z" fill="url(#metallic-gradient)"></path></svg>
                        <div>
                            <div class="text-lg font-bold text-white">ЕВРОПЕЙСКИЙ</div>
                            <div class="text-xs text-text-muted">ТРЦ</div>
                        </div>
                    </div>
                    <p class="text-text-muted text-sm leading-relaxed">Один из крупнейших торгово-развлекательных центров Москвы. Площадь Киевского вокзала, 2.</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4 text-white">Навигация</h4>
                    <ul class="space-y-2 text-sm text-text-secondary">
                        <li><a href="{{ route('home') }}" class="hover:text-white transition-colors">Главная</a></li>
                        <li><a href="{{ route('events.index') }}" class="hover:text-white transition-colors">Мероприятия</a></li>
                        <li><a href="{{ route('screens.index') }}" class="hover:text-white transition-colors">Рекламные экраны</a></li>
                        <li><a href="{{ route('screens.map') }}" class="hover:text-white transition-colors">Схема экранов</a></li>
                        <li><a href="{{ route('event-request.create') }}" class="hover:text-white transition-colors">Организовать мероприятие</a></li>
                        <li><a href="{{ route('ad-request.create') }}" class="hover:text-white transition-colors">Разместить рекламу</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4 text-white">Контакты</h4>
                    <ul class="space-y-2 text-sm text-text-secondary">
                        <li>+7 (495) 921-34-44</li>
                        <li>Москва, площадь Киевского вокзала, 2</li>
                        <li>ст. метро «Киевская»</li>
                        <li class="pt-2">Пн-Чт, Вс: 10:00-22:00</li>
                        <li>Пт-Сб: 10:00-23:00</li>
                    </ul>
                </div>
            </div>

            <div class="mt-8 rounded-xl overflow-hidden border border-surface-border">
                <iframe src="https://yandex.ru/map-widget/v1/?ll=37.565637%2C55.744574&z=16&mode=search&text=%D0%A2%D0%A0%D0%A6%20%D0%95%D0%B2%D1%80%D0%BE%D0%BF%D0%B5%D0%B9%D1%81%D0%BA%D0%B8%D0%B9&pt=37.565637%2C55.744574" width="100%" height="250" frameborder="0" allowfullscreen class="block"></iframe>
            </div>

            <div class="border-t border-surface-border mt-8 pt-8 text-center text-sm text-text-muted">
                &copy; {{ date('Y') }} ТРЦ «Европейский». Система управления мероприятиями и рекламными зонами.
            </div>
        </div>
    </footer>

    <script>
        document.getElementById('mobile-menu-btn')?.addEventListener('click', function() {
            document.getElementById('mobile-menu')?.classList.toggle('hidden');
        });
    </script>
    @stack('scripts')
</body>
</html>
