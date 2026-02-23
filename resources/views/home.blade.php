@extends('layouts.app')

@section('title', 'ТРЦ Европейский — Главная')

@section('content')
{{-- Hero Banner --}}
<section class="bg-surface border-b border-surface-border">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
        <div class="text-center max-w-3xl mx-auto">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold tracking-tight text-white mb-4">ТРЦ «Европейский»</h1>
            <p class="text-xl text-text-secondary mb-8">Мероприятия, рекламные возможности и яркие события в одном из крупнейших торговых центров Москвы</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('event-request.create') }}" class="inline-flex items-center justify-center px-8 py-4 bg-gold/20 text-gold hover:bg-gold hover:text-white rounded-lg text-lg font-semibold transition-colors border border-gold/30">
                    Организовать мероприятие
                </a>
                <a href="{{ route('ad-request.create') }}" class="inline-flex items-center justify-center px-8 py-4 bg-accent hover:bg-accent-hover text-white rounded-lg text-lg font-semibold transition-colors">
                    Разместить рекламу
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Ближайшие мероприятия --}}
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-white mb-8">Ближайшие мероприятия</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($events as $event)
            <a href="{{ route('events.show', $event) }}" class="group block bg-card rounded-xl border border-surface-border overflow-hidden hover:bg-card-hover hover:border-accent/30 transition-all duration-200">
                <div class="p-5">
                    <div class="flex items-start justify-between gap-2 mb-3">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-surface-lighter text-text-secondary">
                            {{ $event->start_date->format('d.m.Y') }}
                        </span>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                            @if($event->status->name === 'Активно') bg-success/20 text-success
                            @elseif($event->status->name === 'Подтверждено') bg-info/20 text-info
                            @elseif($event->status->name === 'Планируется') bg-warning/20 text-warning
                            @elseif($event->status->name === 'Завершено') bg-surface-lighter text-text-muted
                            @else bg-danger/20 text-danger
                            @endif">
                            {{ $event->status->name }}
                        </span>
                    </div>
                    <h3 class="font-semibold text-white group-hover:text-accent transition-colors mb-2 line-clamp-2">{{ $event->title }}</h3>
                    <p class="text-sm text-text-secondary line-clamp-2 mb-2">{{ $event->description }}</p>
                    @if($event->location)
                    <p class="text-xs text-text-muted flex items-center gap-1">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ $event->location }}
                    </p>
                    @endif
                </div>
            </a>
            @empty
            <div class="col-span-full text-center py-12 text-text-muted bg-card rounded-xl border border-surface-border">Нет запланированных мероприятий</div>
            @endforelse
        </div>
    </div>
</section>

{{-- Рекламные экраны --}}
<section class="py-16 bg-surface border-y border-surface-border">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-white mb-8">Рекламные экраны</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($screens as $screen)
            <a href="{{ route('screens.index') }}" class="group block bg-card rounded-xl border border-surface-border overflow-hidden hover:bg-card-hover hover:border-accent/30 transition-all duration-200">
                <div class="p-5">
                    <div class="flex items-start justify-between gap-2 mb-3">
                        <h3 class="font-semibold text-white group-hover:text-accent transition-colors">{{ $screen->name }}</h3>
                        @if($screen->has_night_version)
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-gold/20 text-gold">Ночная версия</span>
                        @endif
                    </div>
                    <p class="text-sm text-text-secondary mb-2">{{ $screen->width_px }} × {{ $screen->height_px }} px</p>
                    @if($screen->location)
                    <p class="text-xs text-text-muted flex items-center gap-1">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                        {{ $screen->location }}
                    </p>
                    @endif
                </div>
            </a>
            @empty
            <div class="col-span-full text-center py-12 text-text-muted bg-card rounded-xl border border-surface-border">Нет доступных экранов</div>
            @endforelse
        </div>
        <div class="mt-8 text-center">
            <a href="{{ route('screens.index') }}" class="inline-flex items-center px-6 py-3 bg-surface-lighter hover:bg-primary-lighter text-white rounded-lg font-medium transition-colors border border-surface-border">Все экраны</a>
        </div>
    </div>
</section>

{{-- Stats --}}
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            <div class="bg-card rounded-xl border border-surface-border p-8">
                <div class="text-4xl lg:text-5xl font-bold text-gold mb-2">34</div>
                <div class="text-text-secondary">экрана</div>
            </div>
            <div class="bg-card rounded-xl border border-surface-border p-8">
                <div class="text-4xl lg:text-5xl font-bold text-gold mb-2">8</div>
                <div class="text-text-secondary">рекламных зон</div>
            </div>
            <div class="bg-card rounded-xl border border-surface-border p-8">
                <div class="text-4xl lg:text-5xl font-bold text-gold mb-2">392</div>
                <div class="text-text-secondary">магазина</div>
            </div>
        </div>
    </div>
</section>

{{-- CTA blocks --}}
<section class="py-16 bg-surface border-t border-surface-border">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-card rounded-2xl border border-surface-border p-8 lg:p-10">
            <h2 class="text-2xl font-bold text-white mb-4">Организуйте мероприятие</h2>
            <p class="text-text-secondary mb-6">Проведите выставку, презентацию, концерт или промо-акцию в одной из зон ТРЦ «Европейский». Подайте заявку — администрация рассмотрит её и поможет с организацией.</p>
            <a href="{{ route('event-request.create') }}" class="inline-flex items-center px-6 py-3 bg-gold/20 text-gold hover:bg-gold hover:text-white rounded-lg font-semibold transition-colors border border-gold/30">Подать заявку на мероприятие</a>
        </div>
        <div class="bg-card rounded-2xl border border-surface-border p-8 lg:p-10">
            <h2 class="text-2xl font-bold text-white mb-4">Разместите рекламу</h2>
            <p class="text-text-secondary mb-6">Достигните тысяч посетителей ежедневно. Наши экраны расположены в ключевых точках торгового центра для максимального охвата аудитории.</p>
            <a href="{{ route('ad-request.create') }}" class="inline-flex items-center px-6 py-3 bg-accent hover:bg-accent-hover text-white rounded-lg font-semibold transition-colors">Подать заявку на рекламу</a>
        </div>
    </div>
</section>
@endsection
