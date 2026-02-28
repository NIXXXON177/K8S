@extends('layouts.admin')
@section('page-title', 'Медиафайлы')
@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-xl shadow-sm p-4">
        <form action="{{ route('admin.media.index') }}" method="GET" class="flex flex-wrap gap-3 items-center">
            <label class="text-sm font-medium text-gray-700">Фильтр по статусу:</label>
            <select name="status" onchange="this.form.submit()" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm">
                <option value="">Все</option>
                @foreach($statuses ?? [] as $status)
                    <option value="{{ $status->id }}" {{ request('status') == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                @endforeach
            </select>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Файл</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Арендатор</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Разрешение</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Длительность</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Размер</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Статус</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Действия</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($media as $item)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $item->file_name ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $item->tenant->company_name ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ ($item->width_px ?? 0) }} × {{ ($item->height_px ?? 0) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $item->duration_sec ?? '—' }} сек</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ number_format($item->file_size_mb ?? 0, 2) }} МБ</td>
                        <td class="px-6 py-4">
                            @php $statusName = $item->status->name ?? '—'; @endphp
                            <span class="inline-flex rounded-full px-2 py-1 text-xs font-medium
                                @if($statusName === 'Одобрено') bg-green-100 text-green-800
                                @elseif($statusName === 'На модерации') bg-yellow-100 text-yellow-800
                                @elseif($statusName === 'Отклонено') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">{{ $statusName }}</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.media.show', $item) }}" class="text-primary hover:text-primary-light font-medium text-sm">Просмотр</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">Нет медиафайлов</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($media->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $media->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
