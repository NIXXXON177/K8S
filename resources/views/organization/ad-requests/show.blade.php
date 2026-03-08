@extends('layouts.organization')
@section('page-title', 'Заявка на рекламу')
@section('content')
<div class="max-w-4xl">
    <a href="{{ route('organization.ad-requests.index') }}" class="inline-flex items-center text-sm text-text-secondary hover:text-text-primary mb-6">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Назад к списку
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-card rounded-xl p-6">
                <h3 class="text-lg font-semibold text-text-primary mb-4">Информация о бронировании</h3>
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm text-text-secondary">Экран</dt>
                        <dd class="font-medium text-text-primary">{{ $screenBooking->screen->name ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-text-secondary">Разрешение экрана</dt>
                        <dd class="font-medium text-text-primary">{{ $screenBooking->screen->width_px ?? 0 }} x {{ $screenBooking->screen->height_px ?? 0 }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-text-secondary">Дата начала</dt>
                        <dd class="font-medium text-text-primary">{{ $screenBooking->start_date?->format('d.m.Y') ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-text-secondary">Дата окончания</dt>
                        <dd class="font-medium text-text-primary">{{ $screenBooking->end_date?->format('d.m.Y') ?? '—' }}</dd>
                    </div>
                    @if($screenBooking->notes)
                    <div class="md:col-span-2">
                        <dt class="text-sm text-text-secondary">Комментарий</dt>
                        <dd class="font-medium text-text-primary">{{ $screenBooking->notes }}</dd>
                    </div>
                    @endif
                </dl>
            </div>

            @if($screenBooking->media)
            <div class="bg-card rounded-xl p-6">
                <h3 class="text-lg font-semibold text-text-primary mb-4">Медиафайл</h3>
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm text-text-secondary">Имя файла</dt>
                        <dd class="font-medium text-text-primary">{{ $screenBooking->media->file_name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-text-secondary">Разрешение</dt>
                        <dd class="font-medium text-text-primary">{{ $screenBooking->media->width_px }} x {{ $screenBooking->media->height_px }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-text-secondary">Длительность</dt>
                        <dd class="font-medium text-text-primary">{{ $screenBooking->media->duration_sec }} сек</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-text-secondary">Размер</dt>
                        <dd class="font-medium text-text-primary">{{ $screenBooking->media->file_size_mb }} МБ</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-text-secondary">Кодек</dt>
                        <dd class="font-medium text-text-primary">{{ $screenBooking->media->codec }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-text-secondary">Кадр/с</dt>
                        <dd class="font-medium text-text-primary">{{ $screenBooking->media->fps }}</dd>
                    </div>
                    @if($screenBooking->media->rejection_reason)
                    <div class="md:col-span-2">
                        <dt class="text-sm text-text-secondary">Причина отклонения видео</dt>
                        <dd class="font-medium text-danger">{{ $screenBooking->media->rejection_reason }}</dd>
                    </div>
                    @endif
                </dl>
            </div>
            @endif
        </div>

        <div class="space-y-4">
            <div class="bg-card rounded-xl p-6">
                <h4 class="font-semibold text-text-primary mb-4">Статус заявки</h4>
                @php
                    $statusMap = ['pending' => 'Ожидает рассмотрения', 'confirmed' => 'Одобрено', 'cancelled' => 'Отклонено'];
                @endphp
                <span class="inline-flex rounded-full px-3 py-1.5 text-sm font-medium
                    @if($screenBooking->status === 'confirmed') bg-success/20 text-success
                    @elseif($screenBooking->status === 'pending') bg-warning/20 text-warning
                    @else bg-danger/20 text-danger @endif">{{ $statusMap[$screenBooking->status] ?? $screenBooking->status }}</span>

                @if($screenBooking->rejection_reason)
                <div class="mt-4 p-3 bg-danger/10 border border-danger/30 rounded-lg">
                    <p class="text-sm font-medium text-danger mb-1">Причина отклонения:</p>
                    <p class="text-sm text-danger">{{ $screenBooking->rejection_reason }}</p>
                </div>
                @endif
            </div>

            @if($screenBooking->media)
            <div class="bg-card rounded-xl p-6">
                <h4 class="font-semibold text-text-primary mb-4">Статус видео</h4>
                @php $mediaStatus = $screenBooking->media->status->name ?? '—'; @endphp
                <span class="inline-flex rounded-full px-3 py-1.5 text-sm font-medium
                    @if($mediaStatus === 'Одобрено') bg-success/20 text-success
                    @elseif($mediaStatus === 'На модерации') bg-warning/20 text-warning
                    @elseif($mediaStatus === 'Отклонено') bg-danger/20 text-danger
                    @else bg-surface-lighter text-text-primary @endif">{{ $mediaStatus }}</span>
            </div>
            @endif

            <div class="bg-card rounded-xl p-6">
                <h4 class="font-semibold text-text-primary mb-3">Дата подачи</h4>
                <p class="text-sm text-text-secondary">{{ $screenBooking->created_at?->format('d.m.Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
