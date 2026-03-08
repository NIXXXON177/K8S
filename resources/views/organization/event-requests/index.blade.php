@extends('layouts.organization')
@section('page-title', 'Заявки на мероприятия')
@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <p class="text-sm text-text-secondary">Все ваши заявки на проведение мероприятий в ТРЦ</p>
        <a href="{{ route('organization.event-requests.create') }}" class="px-4 py-2 bg-accent text-white rounded-lg text-sm font-medium hover:bg-accent-hover transition-colors">
            + Новая заявка
        </a>
    </div>

    <div class="bg-card rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-surface-border">
                <thead class="bg-surface">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase">Мероприятие</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase">Зона</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase">Даты</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase">Сумма</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase">Статус</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-border">
                    @forelse($bookings as $booking)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-text-primary">{{ $booking->event->title ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-text-secondary">{{ $booking->zone->name ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-text-secondary">{{ $booking->start_date?->format('d.m.Y') }} — {{ $booking->end_date?->format('d.m.Y') }}</td>
                        <td class="px-6 py-4 text-sm text-text-secondary">{{ number_format($booking->total_price ?? 0, 0, ',', ' ') }} ₽</td>
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
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-text-secondary">
                            У вас пока нет заявок на мероприятия.
                            <a href="{{ route('organization.event-requests.create') }}" class="text-accent hover:text-accent-hover">Подать первую заявку</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($bookings->hasPages())
        <div class="px-6 py-4 border-t border-surface-border">
            {{ $bookings->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
