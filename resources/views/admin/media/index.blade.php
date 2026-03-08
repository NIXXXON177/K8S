@extends('layouts.admin')
@section('page-title', 'Медиафайлы')
@section('content')
<div class="space-y-6">
    <div class="bg-card rounded-xl p-4">
        <form action="{{ route('admin.media.index') }}" method="GET" class="flex flex-wrap gap-3 items-center">
            <label class="text-sm font-medium text-text-primary">Фильтр по статусу:</label>
            <select name="status" onchange="this.form.submit()" class="px-4 py-2 bg-input-bg border border-input-border text-text-primary rounded-lg focus:ring-2 focus:ring-accent focus:border-accent text-sm">
                <option value="">Все</option>
                @foreach($statuses ?? [] as $status)
                    <option value="{{ $status->id }}" {{ request('status') == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                @endforeach
            </select>
        </form>
    </div>

    <div class="bg-card rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-surface-border">
                <thead class="bg-surface">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase">Файл</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase">Арендатор</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase">Разрешение</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase">Длительность</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase">Размер</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase">Статус</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-text-secondary uppercase">Действия</th>
                    </tr>
                </thead>
                <tbody class="bg-card divide-y divide-surface-border">
                    @forelse($media as $item)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-text-primary">{{ $item->file_name ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-text-secondary">{{ $item->tenant->company_name ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-text-secondary">{{ ($item->width_px ?? 0) }} × {{ ($item->height_px ?? 0) }}</td>
                        <td class="px-6 py-4 text-sm text-text-secondary">{{ $item->duration_sec ?? '—' }} сек</td>
                        <td class="px-6 py-4 text-sm text-text-secondary">{{ number_format($item->file_size_mb ?? 0, 2) }} МБ</td>
                        <td class="px-6 py-4">
                            @php $statusName = $item->status->name ?? '—'; @endphp
                            <span class="inline-flex rounded-full px-2 py-1 text-xs font-medium
                                @if($statusName === 'Одобрено') bg-success/20 text-success
                                @elseif($statusName === 'На модерации') bg-warning/20 text-warning
                                @elseif($statusName === 'Отклонено') bg-danger/20 text-danger
                                @else bg-surface-lighter text-text-primary @endif">{{ $statusName }}</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.media.show', $item) }}" class="text-accent hover:text-accent-hover font-medium text-sm">Просмотр</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-text-secondary">Нет медиафайлов</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($media->hasPages())
        <div class="px-6 py-4 border-t border-surface-border">
            {{ $media->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
