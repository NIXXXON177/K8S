@extends('layouts.app')

@section('title', 'Рекламные экраны')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-10">
        <div>
            <h1 class="text-3xl font-bold text-white mb-4">Рекламные экраны</h1>
            <p class="text-text-secondary max-w-3xl">В ТРЦ «Европейский» размещено 34 рекламных экрана в ключевых точках торгового центра. Выберите подходящий экран для размещения вашей рекламы.</p>
        </div>
        <a href="{{ route('screens.map') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-surface-lighter text-text-secondary hover:text-white rounded-lg text-sm font-medium transition-colors border border-surface-border shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
            Схема экранов
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($screens as $screen)
        <div class="bg-card rounded-xl border border-surface-border overflow-hidden hover:bg-card-hover hover:border-accent/30 transition-all duration-200">
            <div class="p-6">
                <div class="flex items-start justify-between gap-2 mb-3">
                    <h2 class="font-semibold text-lg text-white">{{ $screen->name }}</h2>
                    @if($screen->has_night_version)
                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-gold/20 text-gold">Ночная версия</span>
                    @endif
                </div>
                <p class="text-sm font-medium text-text-secondary mb-1">{{ $screen->width_px }} × {{ $screen->height_px }} px</p>
                @if($screen->location)
                <p class="text-sm text-text-muted flex items-center gap-1">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                    {{ $screen->location }}
                </p>
                @endif
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-16 text-text-muted bg-card rounded-xl border border-surface-border">Нет доступных экранов</div>
        @endforelse
    </div>

    {{-- Video requirements info --}}
    <div class="mt-12 bg-card rounded-xl border border-surface-border p-8">
        <h3 class="text-xl font-semibold text-white mb-4">Требования к видео</h3>
        <ul class="space-y-2 text-text-secondary">
            <li>Формат: MP4</li>
            <li>Кодек: H264</li>
            <li>Частота кадров: 25 fps</li>
            <li>Длительность: 15 или 30 секунд</li>
            <li>Максимальный размер файла: 400 МБ</li>
        </ul>
        <a href="{{ route('ad-request.create') }}" class="inline-flex items-center mt-6 px-6 py-3 bg-accent hover:bg-accent-hover text-white rounded-lg font-medium transition-colors">Разместить рекламу</a>
    </div>
</div>
@endsection
