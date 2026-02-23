@extends('layouts.admin')
@section('page-title', 'Просмотр медиафайла')
@section('content')
@php
    $mediaFile = $media ?? $mediaFile ?? null;
    $statusName = $mediaFile?->status->name ?? '—';
@endphp
<div class="max-w-4xl">
    <a href="{{ route('admin.media.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-800 mb-6">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Назад к списку
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- File info --}}
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Информация о файле</h3>
            <dl class="space-y-3">
                <div><dt class="text-sm text-gray-500">Имя файла</dt><dd class="font-medium">{{ $mediaFile->file_name ?? '—' }}</dd></div>
                <div><dt class="text-sm text-gray-500">Оригинальное имя</dt><dd class="font-medium">{{ $mediaFile->original_name ?? '—' }}</dd></div>
                <div><dt class="text-sm text-gray-500">Арендатор</dt><dd class="font-medium">{{ $mediaFile->tenant->company_name ?? '—' }}</dd></div>
                <div><dt class="text-sm text-gray-500">Разрешение</dt><dd class="font-medium">{{ ($mediaFile->width_px ?? 0) }} × {{ ($mediaFile->height_px ?? 0) }}</dd></div>
                <div><dt class="text-sm text-gray-500">Длительность</dt><dd class="font-medium">{{ $mediaFile->duration_sec ?? '—' }} сек</dd></div>
                <div><dt class="text-sm text-gray-500">Размер</dt><dd class="font-medium">{{ number_format($mediaFile->file_size_mb ?? 0, 2) }} MB</dd></div>
                <div><dt class="text-sm text-gray-500">Кодек</dt><dd class="font-medium">{{ $mediaFile->codec ?? '—' }}</dd></div>
                <div><dt class="text-sm text-gray-500">FPS</dt><dd class="font-medium">{{ $mediaFile->fps ?? '—' }}</dd></div>
                <div><dt class="text-sm text-gray-500">Статус</dt>
                    <dd>
                        <span class="inline-flex rounded-full px-2 py-1 text-xs font-medium
                            @if($statusName === 'Одобрено') bg-green-100 text-green-800
                            @elseif($statusName === 'На модерации') bg-yellow-100 text-yellow-800
                            @elseif($statusName === 'Отклонено') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800 @endif">{{ $statusName }}</span>
                    </dd>
                </div>
                <div><dt class="text-sm text-gray-500">Модератор</dt><dd class="font-medium">{{ $mediaFile->reviewer->name ?? '—' }}</dd></div>
                <div><dt class="text-sm text-gray-500">Дата проверки</dt><dd class="font-medium">{{ $mediaFile->reviewed_at?->format('d.m.Y H:i') ?? '—' }}</dd></div>
                @if($mediaFile->rejection_reason ?? null)
                <div><dt class="text-sm text-gray-500">Причина отклонения</dt><dd class="font-medium text-red-600">{{ $mediaFile->rejection_reason }}</dd></div>
                @endif
            </dl>

            @if($mediaFile->screenBookings && $mediaFile->screenBookings->count() > 0)
            <div class="mt-6 pt-6 border-t border-gray-200">
                <h4 class="font-medium text-gray-800 mb-3">Связанные экраны</h4>
                <ul class="space-y-2">
                    @foreach($mediaFile->screenBookings as $sb)
                    @php $screen = $sb->screen ?? null; @endphp
                    @if($screen)
                    <li class="flex items-center justify-between py-2 px-3 bg-gray-50 rounded-lg">
                        <span>{{ $screen->name }} ({{ $screen->width_px ?? 0 }} × {{ $screen->height_px ?? 0 }})</span>
                        @if(method_exists($mediaFile, 'matchesScreen'))
                            @if($mediaFile->matchesScreen($screen))
                            <span class="text-xs text-green-600 font-medium">✓ Совпадает</span>
                            @else
                            <span class="text-xs text-amber-600 font-medium">Не совпадает</span>
                            @endif
                        @endif
                    </li>
                    @endif
                    @endforeach
                </ul>
            </div>
            @endif
        </div>

        {{-- Actions --}}
        <div class="space-y-4">
            @if($statusName === 'На модерации')
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h4 class="font-medium text-gray-800 mb-4">Модерация</h4>
                <form action="{{ route('admin.media.approve', $mediaFile) }}" method="POST" class="mb-4">
                    @csrf
                    <button type="submit" class="w-full py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium text-sm">Одобрить</button>
                </form>
                <form action="{{ route('admin.media.reject', $mediaFile) }}" method="POST">
                    @csrf
                    <textarea name="rejection_reason" rows="3" placeholder="Причина отклонения (обязательно)"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm mb-3 @error('rejection_reason') border-red-500 @enderror"></textarea>
                    @error('rejection_reason')
                        <p class="text-sm text-red-600 mb-2">{{ $message }}</p>
                    @enderror
                    <button type="submit" class="w-full py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium text-sm">Отклонить</button>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
