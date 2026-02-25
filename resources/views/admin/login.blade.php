<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Вход — ЕВРОПЕЙСКИЙ Админ-панель</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-primary font-sans antialiased flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="bg-card rounded-xl border border-surface-border p-8">
            <div class="text-center mb-8">
                <div class="w-12 h-12 bg-accent rounded-lg flex items-center justify-center font-bold text-white text-xl mx-auto mb-4">E</div>
                <h1 class="text-xl font-bold text-white">ЕВРОПЕЙСКИЙ</h1>
                <p class="text-sm text-text-muted mt-1">Админ-панель</p>
            </div>

            @error('email')
                <div class="mb-4 p-3 bg-danger/10 border border-danger/30 text-danger rounded-lg text-sm">{{ $message }}</div>
            @enderror
            @error('password')
                <div class="mb-4 p-3 bg-danger/10 border border-danger/30 text-danger rounded-lg text-sm">{{ $message }}</div>
            @enderror

            <form action="{{ route('admin.login') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-text-primary mb-1">Эл. почта</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-4 py-2.5 bg-input-bg border border-input-border text-text-primary rounded-lg focus:ring-2 focus:ring-accent focus:border-accent">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-text-primary mb-1">Пароль</label>
                    <input type="password" name="password" id="password" required
                        class="w-full px-4 py-2.5 bg-input-bg border border-input-border text-text-primary rounded-lg focus:ring-2 focus:ring-accent focus:border-accent">
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember"
                        class="w-4 h-4 text-accent bg-input-bg border-input-border rounded focus:ring-accent">
                    <label for="remember" class="ml-2 text-sm text-text-secondary">Запомнить меня</label>
                </div>
                <button type="submit" class="w-full py-2.5 bg-accent hover:bg-accent-hover text-white font-medium rounded-lg transition-colors">
                    Войти
                </button>
            </form>
        </div>
    </div>
</body>
</html>
