@extends('layouts.admin')
@section('page-title', 'Просмотр медиафайла')
@section('content')
@php
    $mediaFile = $media ?? $mediaFile ?? null;
    $statusName = $mediaFile?->status->name ?? '—';
@endphp
<div class="max-w-4xl">
    <a href="{{ route('admin.media.index') }}" class="inline-flex items-center text-sm text-text-secondary hover:text-text-primary mb-6">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Назад к списку
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-card rounded-xl p-6">
            <h3 class="text-lg font-semibold text-text-primary mb-4">Информация о файле</h3>
            <dl class="space-y-3">
                <div><dt class="text-sm text-text-muted">Имя файла</dt><dd class="font-medium text-text-primary">{{ $mediaFile->file_name ?? '—' }}</dd></div>
                <div><dt class="text-sm text-text-muted">Оригинальное имя</dt><dd class="font-medium text-text-primary">{{ $mediaFile->original_name ?? '—' }}</dd></div>
                <div><dt class="text-sm text-text-muted">Арендатор</dt><dd class="font-medium text-text-primary">{{ $mediaFile->tenant->company_name ?? '—' }}</dd></div>
                <div><dt class="text-sm text-text-muted">Разрешение</dt><dd class="font-medium text-text-primary">{{ ($mediaFile->width_px ?? 0) }} × {{ ($mediaFile->height_px ?? 0) }}</dd></div>
                <div><dt class="text-sm text-text-muted">Длительность</dt><dd class="font-medium text-text-primary">{{ $mediaFile->duration_sec ?? '—' }} сек</dd></div>
                <div><dt class="text-sm text-text-muted">Размер</dt><dd class="font-medium text-text-primary">{{ number_format($mediaFile->file_size_mb ?? 0, 2) }} МБ</dd></div>
                <div><dt class="text-sm text-text-muted">Кодек</dt><dd class="font-medium text-text-primary">{{ $mediaFile->codec ?? '—' }}</dd></div>
                <div><dt class="text-sm text-text-muted">Кадр/с</dt><dd class="font-medium text-text-primary">{{ $mediaFile->fps ?? '—' }}</dd></div>
                <div><dt class="text-sm text-text-secondary">Статус</dt>
                    <dd>
                        <span class="inline-flex rounded-full px-2 py-1 text-xs font-medium
                            @if($statusName === 'Одобрено') bg-success/20 text-success
                            @elseif($statusName === 'На модерации') bg-warning/20 text-warning
                            @elseif($statusName === 'Отклонено') bg-danger/20 text-danger
                            @else bg-surface-lighter text-text-primary @endif">{{ $statusName }}</span>
                    </dd>
                </div>
                <div><dt class="text-sm text-text-muted">Модератор</dt><dd class="font-medium text-text-primary">{{ $mediaFile->reviewer->name ?? '—' }}</dd></div>
                <div><dt class="text-sm text-text-muted">Дата проверки</dt><dd class="font-medium text-text-primary">{{ $mediaFile->reviewed_at?->format('d.m.Y H:i') ?? '—' }}</dd></div>
                @if($mediaFile->rejection_reason ?? null)
                <div><dt class="text-sm text-text-muted">Причина отклонения</dt><dd class="font-medium text-danger">{{ $mediaFile->rejection_reason }}</dd></div>
                @endif
            </dl>

            @if($mediaFile->screenBookings && $mediaFile->screenBookings->count() > 0)
            <div class="mt-6 pt-6 border-t border-surface-border">
                <h4 class="font-medium text-text-primary mb-3">Связанные экраны</h4>
                <ul class="space-y-2">
                    @foreach($mediaFile->screenBookings as $sb)
                    @php $screen = $sb->screen ?? null; @endphp
                    @if($screen)
                    <li class="flex items-center justify-between py-2 px-3 bg-surface rounded-lg">
                        <span>{{ $screen->name }} ({{ $screen->width_px ?? 0 }} × {{ $screen->height_px ?? 0 }})</span>
                        @if(method_exists($mediaFile, 'matchesScreen'))
                            @if($mediaFile->matchesScreen($screen))
                            <span class="text-xs text-success font-medium">✓ Совпадает</span>
                            @else
                            <span class="text-xs text-gold font-medium">Не совпадает</span>
                            @endif
                        @endif
                    </li>
                    @endif
                    @endforeach
                </ul>
            </div>
            @endif
        </div>

        <div class="space-y-4">
            @if($statusName === 'На модерации')
            <div class="bg-card rounded-xl p-6">
                <h4 class="font-medium text-text-primary mb-4">Модерация</h4>
                <form action="{{ route('admin.media.approve', $mediaFile) }}" method="POST" class="mb-4">
                    @csrf
                    <button type="submit" class="w-full py-2.5 bg-success text-white rounded-lg hover:bg-success/80 transition-colors font-medium text-sm">Одобрить</button>
                </form>
                <form action="{{ route('admin.media.reject', $mediaFile) }}" method="POST">
                    @csrf
                    <textarea name="rejection_reason" rows="3" placeholder="Причина отклонения (обязательно)"
                        class="w-full px-4 py-2 bg-input-bg border border-input-border text-text-primary rounded-lg focus:ring-2 focus:ring-accent focus:border-accent text-sm mb-3 @error('rejection_reason') border-danger @enderror"></textarea>
                    @error('rejection_reason')
                        <p class="text-sm text-danger mb-2">{{ $message }}</p>
                    @enderror
                    <button type="submit" class="w-full py-2.5 bg-danger text-white rounded-lg hover:bg-danger/80 transition-colors font-medium text-sm">Отклонить</button>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
