@extends('layouts.app')

@section('title', $event->title)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <a href="{{ route('events.index') }}" class="inline-flex items-center gap-2 text-text-secondary hover:text-accent transition-colors mb-8">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Назад к мероприятиям
    </a>

    <article class="bg-card rounded-xl border border-surface-border overflow-hidden">
        <div class="p-8">
            <div class="flex flex-wrap items-start gap-3 mb-6">
                <h1 class="text-2xl lg:text-3xl font-bold text-white">{{ $event->title }}</h1>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                    @if($event->status->name === 'Активно') bg-success/20 text-success
                    @elseif($event->status->name === 'Подтверждено') bg-info/20 text-info
                    @elseif($event->status->name === 'Планируется') bg-warning/20 text-warning
                    @elseif($event->status->name === 'Завершено') bg-surface-lighter text-text-muted
                    @else bg-danger/20 text-danger
                    @endif">
                    {{ $event->status->name }}
                </span>
            </div>

            <dl class="space-y-4 mb-8">
                <div>
                    <dt class="text-sm font-medium text-text-muted">Даты проведения</dt>
                    <dd class="mt-1 text-text-primary">{{ $event->start_date->format('d.m.Y') }} — {{ $event->end_date->format('d.m.Y') }}</dd>
                </div>
                @if($event->location)
                <div>
                    <dt class="text-sm font-medium text-text-muted">Место проведения</dt>
                    <dd class="mt-1 text-text-primary">{{ $event->location }}</dd>
                </div>
                @endif
                @if($event->expected_visitors)
                <div>
                    <dt class="text-sm font-medium text-text-muted">Ожидаемое количество посетителей</dt>
                    <dd class="mt-1 text-text-primary">{{ number_format($event->expected_visitors, 0, ',', ' ') }}</dd>
                </div>
                @endif
                @if($event->budget)
                <div>
                    <dt class="text-sm font-medium text-text-muted">Бюджет</dt>
                    <dd class="mt-1 text-text-primary">{{ number_format($event->budget, 0, ',', ' ') }} ₽</dd>
                </div>
                @endif
            </dl>

            @if($event->description)
            <div>
                <h3 class="text-lg font-semibold text-white mb-2">Описание</h3>
                <p class="text-text-secondary whitespace-pre-line">{{ $event->description }}</p>
            </div>
            @endif
        </div>

        @if($event->zoneBookings->isNotEmpty())
        <div class="border-t border-surface-border p-8 bg-surface">
            <h3 class="text-lg font-semibold text-white mb-4">Забронированные зоны</h3>
            <div class="space-y-3">
                @foreach($event->zoneBookings as $booking)
                <div class="flex items-center justify-between bg-card rounded-lg border border-surface-border px-4 py-3">
                    <span class="font-medium text-text-primary">{{ $booking->zone?->name ?? 'Зона #' . $booking->zone_id }}</span>
                    <span class="text-sm text-text-secondary">{{ $booking->start_date->format('d.m.Y') }} — {{ $booking->end_date->format('d.m.Y') }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </article>
</div>
@endsection
