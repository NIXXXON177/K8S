@extends('layouts.admin')
@section('page-title', 'Мероприятия')
@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-lg font-semibold text-gray-800">Список мероприятий</h2>
        <a href="{{ route('admin.events.create') }}" class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-light transition-colors text-sm font-medium">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Создать мероприятие
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Название</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Статус</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Даты</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Расположение</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Посетители</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Действия</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($events as $event)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $event->title }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex rounded-full px-2 py-1 text-xs font-medium
                                @if(($event->status->name ?? '') === 'Активно') bg-green-100 text-green-800
                                @elseif(($event->status->name ?? '') === 'Завершено') bg-gray-100 text-gray-800
                                @else bg-yellow-100 text-yellow-800 @endif">{{ $event->status->name ?? '—' }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $event->start_date?->format('d.m.Y') ?? '—' }} — {{ $event->end_date?->format('d.m.Y') ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $event->location ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $event->expected_visitors ?? '—' }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.events.edit', $event) }}" class="text-primary hover:text-primary-light font-medium text-sm">Редактировать</a>
                            <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="inline ml-3" onsubmit="return confirm('Удалить мероприятие?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-700 font-medium text-sm">Удалить</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">Нет мероприятий</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($events->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $events->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
