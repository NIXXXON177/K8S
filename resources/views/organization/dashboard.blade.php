@extends('layouts.organization')
@section('page-title', 'Обзор')
@section('content')
<div class="space-y-6">
    <div class="bg-card rounded-xl p-6">
        <h2 class="text-lg font-semibold text-text-primary mb-1">Добро пожаловать, {{ $tenant->company_name }}!</h2>
        <p class="text-sm text-text-secondary">Здесь вы можете управлять заявками на рекламу и мероприятия в ТРЦ «Европейский».</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-card rounded-xl p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-text-primary">Заявки на рекламу</h3>
                <a href="{{ route('organization.ad-requests.create') }}" class="text-sm text-accent hover:text-accent-hover font-medium">+ Новая заявка</a>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div class="bg-surface rounded-lg p-3 text-center">
                    <div class="text-2xl font-bold text-text-primary">{{ $adStats['total'] }}</div>
                    <div class="text-xs text-text-secondary mt-1">Всего</div>
                </div>
                <div class="bg-warning/10 rounded-lg p-3 text-center">
                    <div class="text-2xl font-bold text-warning">{{ $adStats['pending'] }}</div>
                    <div class="text-xs text-text-secondary mt-1">На рассмотрении</div>
                </div>
                <div class="bg-success/10 rounded-lg p-3 text-center">
                    <div class="text-2xl font-bold text-success">{{ $adStats['confirmed'] }}</div>
                    <div class="text-xs text-text-secondary mt-1">Одобрено</div>
                </div>
                <div class="bg-danger/10 rounded-lg p-3 text-center">
                    <div class="text-2xl font-bold text-danger">{{ $adStats['cancelled'] }}</div>
                    <div class="text-xs text-text-secondary mt-1">Отклонено</div>
                </div>
            </div>
        </div>

        <div class="bg-card rounded-xl p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-text-primary">Заявки на мероприятия</h3>
                <a href="{{ route('organization.event-requests.create') }}" class="text-sm text-accent hover:text-accent-hover font-medium">+ Новая заявка</a>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div class="bg-surface rounded-lg p-3 text-center">
                    <div class="text-2xl font-bold text-text-primary">{{ $eventStats['total'] }}</div>
                    <div class="text-xs text-text-secondary mt-1">Всего</div>
                </div>
                <div class="bg-warning/10 rounded-lg p-3 text-center">
                    <div class="text-2xl font-bold text-warning">{{ $eventStats['pending'] }}</div>
                    <div class="text-xs text-text-secondary mt-1">На рассмотрении</div>
                </div>
                <div class="bg-success/10 rounded-lg p-3 text-center">
                    <div class="text-2xl font-bold text-success">{{ $eventStats['confirmed'] }}</div>
                    <div class="text-xs text-text-secondary mt-1">Одобрено</div>
                </div>
                <div class="bg-danger/10 rounded-lg p-3 text-center">
                    <div class="text-2xl font-bold text-danger">{{ $eventStats['cancelled'] }}</div>
                    <div class="text-xs text-text-secondary mt-1">Отклонено</div>
                </div>
            </div>
        </div>
    </div>

    @if($recentAdRequests->count() > 0)
    <div class="bg-card rounded-xl overflow-hidden">
        <div class="px-6 py-4 border-b border-surface-border flex items-center justify-between">
            <h3 class="font-semibold text-text-primary">Последние заявки на рекламу</h3>
            <a href="{{ route('organization.ad-requests.index') }}" class="text-sm text-accent hover:text-accent-hover">Все заявки</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-surface-border">
                <thead class="bg-surface">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase">Экран</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase">Медиафайл</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase">Даты</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase">Статус</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-border">
                    @foreach($recentAdRequests as $booking)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-text-primary">{{ $booking->screen->name ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-text-secondary">{{ $booking->media->file_name ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-text-secondary">{{ $booking->start_date?->format('d.m.Y') }} — {{ $booking->end_date?->format('d.m.Y') }}</td>
                        <td class="px-6 py-4">
                            @php
                                $statusMap = ['pending' => 'Ожидает', 'confirmed' => 'Одобрено', 'cancelled' => 'Отклонено'];
                            @endphp
                            <span class="inline-flex rounded-full px-2 py-1 text-xs font-medium
                                @if($booking->status === 'confirmed') bg-success/20 text-success
                                @elseif($booking->status === 'pending') bg-warning/20 text-warning
                                @else bg-danger/20 text-danger @endif">{{ $statusMap[$booking->status] ?? $booking->status }}</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('organization.ad-requests.show', $booking) }}" class="text-sm text-accent hover:text-accent-hover">Подробнее</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    @if($recentEventRequests->count() > 0)
    <div class="bg-card rounded-xl overflow-hidden">
        <div class="px-6 py-4 border-b border-surface-border flex items-center justify-between">
            <h3 class="font-semibold text-text-primary">Последние заявки на мероприятия</h3>
            <a href="{{ route('organization.event-requests.index') }}" class="text-sm text-accent hover:text-accent-hover">Все заявки</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-surface-border">
                <thead class="bg-surface">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase">Мероприятие</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase">Зона</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase">Даты</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase">Статус</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-border">
                    @foreach($recentEventRequests as $booking)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-text-primary">{{ $booking->event->title ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-text-secondary">{{ $booking->zone->name ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-text-secondary">{{ $booking->start_date?->format('d.m.Y') }} — {{ $booking->end_date?->format('d.m.Y') }}</td>
                        <td class="px-6 py-4">
                            @php
                                $statusMap = ['pending' => 'Ожидает', 'confirmed' => 'Одобрено', 'cancelled' => 'Отклонено'];
                            @endphp
                            <span class="inline-flex rounded-full px-2 py-1 text-xs font-medium
                                @if($booking->status === 'confirmed') bg-success/20 text-success
                                @elseif($booking->status === 'pending') bg-warning/20 text-warning
                                @else bg-danger/20 text-danger @endif">{{ $statusMap[$booking->status] ?? $booking->status }}</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('organization.event-requests.show', $booking) }}" class="text-sm text-accent hover:text-accent-hover">Подробнее</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection
