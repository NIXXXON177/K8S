@extends('layouts.admin')
@section('page-title', 'Панель управления')
@section('content')
<div class="space-y-8">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-card rounded-xl border-l-4 border-primary p-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-text-primary">{{ $stats['events'] ?? 0 }}</div>
                    <div class="text-sm text-text-secondary">Мероприятия</div>
                </div>
            </div>
        </div>
        <div class="bg-card rounded-xl border-l-4 border-accent p-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-accent/10 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-text-primary">{{ $stats['screens'] ?? 0 }}</div>
                    <div class="text-sm text-text-secondary">Экраны</div>
                </div>
            </div>
        </div>
        <div class="bg-card rounded-xl border-l-4 border-info p-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-info/10 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-info" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-text-primary">{{ $stats['tenants'] ?? 0 }}</div>
                    <div class="text-sm text-text-secondary">Арендаторы</div>
                </div>
            </div>
        </div>
        <div class="bg-card rounded-xl border-l-4 border-warning p-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-warning/10 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-text-primary">{{ $stats['pending_media'] ?? 0 }}</div>
                    <div class="text-sm text-text-secondary">На модерации</div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-card rounded-xl border-l-4 border-success p-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-success/10 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-text-primary">{{ $stats['active_events'] ?? 0 }}</div>
                    <div class="text-sm text-text-secondary">Активные мероприятия</div>
                </div>
            </div>
        </div>
        <div class="bg-card rounded-xl border-l-4 border-primary p-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-text-primary">{{ $stats['screen_bookings'] ?? 0 }}</div>
                    <div class="text-sm text-text-secondary">Брони экранов</div>
                </div>
            </div>
        </div>
        <div class="bg-card rounded-xl border-l-4 border-info p-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-info/10 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-info" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-text-primary">{{ $stats['zone_bookings'] ?? 0 }}</div>
                    <div class="text-sm text-text-secondary">Брони зон</div>
                </div>
            </div>
        </div>
        <div class="bg-card rounded-xl border-l-4 border-warning p-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-warning/10 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-text-primary">{{ $stats['pending_bookings'] ?? 0 }}</div>
                    <div class="text-sm text-text-secondary">Ожидают подтверждения</div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-card rounded-xl overflow-hidden">
        <div class="px-6 py-4 border-b border-surface-border">
            <h2 class="text-lg font-semibold text-text-primary">Последние медиафайлы</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-surface-border">
                <thead class="bg-surface">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase">Файл</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase">Арендатор</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase">Разрешение</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase">Статус</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase">Дата</th>
                    </tr>
                </thead>
                <tbody class="bg-card divide-y divide-surface-border">
                    @forelse($recentMedia ?? [] as $media)
                    <tr>
                        <td class="px-6 py-4 text-sm text-text-primary">{{ $media->file_name ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-text-secondary">{{ $media->tenant->company_name ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-text-secondary">{{ ($media->width_px ?? 0) }} × {{ ($media->height_px ?? 0) }}</td>
                        <td class="px-6 py-4">
                            @php $statusName = $media->status->name ?? '—'; @endphp
                            <span class="inline-flex rounded-full px-2 py-1 text-xs font-medium
                                @if($statusName === 'Одобрено') bg-success/20 text-success
                                @elseif($statusName === 'На модерации') bg-warning/20 text-warning
                                @elseif($statusName === 'Отклонено') bg-danger/20 text-danger
                                @else bg-surface-lighter text-text-primary @endif">{{ $statusName }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-text-secondary">{{ $media->created_at?->format('d.m.Y') ?? '—' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-text-secondary">Нет медиафайлов</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-card rounded-xl overflow-hidden">
        <div class="px-6 py-4 border-b border-surface-border">
            <h2 class="text-lg font-semibold text-text-primary">Последние бронирования</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-surface-border">
                <thead class="bg-surface">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase">Экран</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase">Арендатор</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase">Даты</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase">Статус</th>
                    </tr>
                </thead>
                <tbody class="bg-card divide-y divide-surface-border">
                    @forelse($recentBookings ?? [] as $booking)
                    <tr>
                        <td class="px-6 py-4 text-sm text-text-primary">{{ $booking->screen->name ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-text-secondary">{{ $booking->tenant->company_name ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-text-secondary">{{ $booking->start_date?->format('d.m.Y') ?? '—' }} — {{ $booking->end_date?->format('d.m.Y') ?? '—' }}</td>
                        <td class="px-6 py-4">
                            @php
                                $rawStatus = is_object($booking->status) ? ($booking->status->name ?? $booking->status) : ($booking->status ?? '—');
                                $statusMap = ['pending' => 'Ожидает', 'confirmed' => 'Подтверждено', 'cancelled' => 'Отменено'];
                                $statusLabel = $statusMap[$rawStatus] ?? $rawStatus;
                            @endphp
                            <span class="inline-flex rounded-full px-2 py-1 text-xs font-medium
                                @if($rawStatus === 'confirmed') bg-success/20 text-success
                                @elseif($rawStatus === 'pending') bg-warning/20 text-warning
                                @elseif($rawStatus === 'cancelled') bg-danger/20 text-danger
                                @else bg-surface-lighter text-text-primary @endif">{{ $statusLabel }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-text-secondary">Нет бронирований</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
