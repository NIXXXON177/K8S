@extends('layouts.organization')
@section('page-title', 'Заявка на мероприятие')
@section('content')
<div class="max-w-4xl">
    <a href="{{ route('organization.event-requests.index') }}" class="inline-flex items-center text-sm text-text-secondary hover:text-text-primary mb-6">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Назад к списку
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-card rounded-xl p-6">
                <h3 class="text-lg font-semibold text-text-primary mb-4">Информация о мероприятии</h3>
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm text-text-secondary">Название</dt>
                        <dd class="font-medium text-text-primary text-lg">{{ $zoneBooking->event->title ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-text-secondary">Описание</dt>
                        <dd class="text-text-primary">{{ $zoneBooking->event->description ?? '—' }}</dd>
                    </div>
                </dl>
            </div>

            <div class="bg-card rounded-xl p-6">
                <h3 class="text-lg font-semibold text-text-primary mb-4">Детали бронирования</h3>
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm text-text-secondary">Зона</dt>
                        <dd class="font-medium text-text-primary">{{ $zoneBooking->zone->name ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-text-secondary">Этаж / Площадь</dt>
                        <dd class="font-medium text-text-primary">{{ $zoneBooking->zone->floor ?? '—' }} эт., {{ $zoneBooking->zone->area_sqm ?? '—' }} м²</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-text-secondary">Дата начала</dt>
                        <dd class="font-medium text-text-primary">{{ $zoneBooking->start_date?->format('d.m.Y') ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-text-secondary">Дата окончания</dt>
                        <dd class="font-medium text-text-primary">{{ $zoneBooking->end_date?->format('d.m.Y') ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-text-secondary">Стоимость</dt>
                        <dd class="font-medium text-text-primary">{{ number_format($zoneBooking->total_price ?? 0, 0, ',', ' ') }} ₽</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-text-secondary">Ожидаемое кол-во посетителей</dt>
                        <dd class="font-medium text-text-primary">{{ $zoneBooking->event->expected_visitors ?? '—' }}</dd>
                    </div>
                    @if($zoneBooking->notes)
                    <div class="md:col-span-2">
                        <dt class="text-sm text-text-secondary">Дополнительные пожелания</dt>
                        <dd class="font-medium text-text-primary">{{ $zoneBooking->notes }}</dd>
                    </div>
                    @endif
                </dl>
            </div>
        </div>

        <div class="space-y-4">
            <div class="bg-card rounded-xl p-6">
                <h4 class="font-semibold text-text-primary mb-4">Статус заявки</h4>
                @php
                    $statusMap = ['pending' => 'Ожидает рассмотрения', 'confirmed' => 'Одобрено', 'cancelled' => 'Отклонено'];
                @endphp
                <span class="inline-flex rounded-full px-3 py-1.5 text-sm font-medium
                    @if($zoneBooking->status === 'confirmed') bg-success/20 text-success
                    @elseif($zoneBooking->status === 'pending') bg-warning/20 text-warning
                    @else bg-danger/20 text-danger @endif">{{ $statusMap[$zoneBooking->status] ?? $zoneBooking->status }}</span>

                @if($zoneBooking->rejection_reason)
                <div class="mt-4 p-3 bg-danger/10 border border-danger/30 rounded-lg">
                    <p class="text-sm font-medium text-danger mb-1">Причина отклонения:</p>
                    <p class="text-sm text-danger">{{ $zoneBooking->rejection_reason }}</p>
                </div>
                @endif
            </div>

            <div class="bg-card rounded-xl p-6">
                <h4 class="font-semibold text-text-primary mb-3">Дата подачи</h4>
                <p class="text-sm text-text-secondary">{{ $zoneBooking->created_at?->format('d.m.Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
