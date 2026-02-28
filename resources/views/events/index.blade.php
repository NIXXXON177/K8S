@extends('layouts.app')

@section('title', 'Мероприятия')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <h1 class="text-3xl font-bold text-white">Мероприятия</h1>
        <a href="{{ route('event-request.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gold/20 text-gold hover:bg-gold hover:text-white rounded-lg text-sm font-semibold transition-colors border border-gold/30">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Организовать мероприятие
        </a>
    </div>

    <div class="flex flex-wrap gap-2 mb-8">
        <a href="{{ route('events.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ !request('status') ? 'bg-accent text-white' : 'bg-surface-lighter text-text-secondary hover:text-white hover:bg-primary-lighter' }}">
            Все
        </a>
        @foreach($statuses as $status)
        <a href="{{ route('events.index', ['status' => $status->id]) }}" class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request('status') == $status->id ? 'bg-accent text-white' : 'bg-surface-lighter text-text-secondary hover:text-white hover:bg-primary-lighter' }}">
            {{ $status->name }}
        </a>
        @endforeach
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($events as $event)
        <a href="{{ route('events.show', $event) }}" class="group block bg-card rounded-xl border border-surface-border overflow-hidden hover:bg-card-hover hover:border-accent/30 transition-all duration-200">
            <div class="p-6">
                <div class="flex items-start justify-between gap-2 mb-3">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-surface-lighter text-text-secondary">
                        {{ $event->start_date->format('d.m.Y') }} — {{ $event->end_date->format('d.m.Y') }}
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
                <h2 class="font-semibold text-lg text-white group-hover:text-accent transition-colors mb-2 line-clamp-2">{{ $event->title }}</h2>
                <p class="text-sm text-text-secondary line-clamp-2 mb-4">{{ Str::limit($event->description, 120) }}</p>
                @if($event->location)
                <p class="text-xs text-text-muted flex items-center gap-1 mb-2">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                    {{ $event->location }}
                </p>
                @endif
                @if($event->expected_visitors)
                <p class="text-xs text-text-muted">Ожидаемо посетителей: {{ number_format($event->expected_visitors, 0, ',', ' ') }}</p>
                @endif
            </div>
        </a>
        @empty
        <div class="col-span-full text-center py-16 text-text-muted bg-card rounded-xl border border-surface-border">Мероприятия не найдены</div>
        @endforelse
    </div>

    @if($events->hasPages())
    <div class="mt-10">
        {{ $events->links() }}
    </div>
    @endif
</div>
@endsection
