@extends('layouts.admin')
@section('page-title', 'Мероприятия')
@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-lg font-semibold text-text-primary">Список мероприятий</h2>
        <a href="{{ route('admin.events.create') }}" class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-light transition-colors text-sm font-medium">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Создать мероприятие
        </a>
    </div>

    <div class="bg-card rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-surface-border">
                <thead class="bg-surface">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase">Название</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase">Статус</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase">Даты</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase">Расположение</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase">Посетители</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-text-secondary uppercase">Действия</th>
                    </tr>
                </thead>
                <tbody class="bg-card divide-y divide-surface-border">
                    @forelse($events as $event)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-text-primary">{{ $event->title }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex rounded-full px-2 py-1 text-xs font-medium
                                @if(($event->status->name ?? '') === 'Активно') bg-success/20 text-success
                                @elseif(($event->status->name ?? '') === 'Завершено') bg-surface-lighter text-text-primary
                                @else bg-warning/20 text-warning @endif">{{ $event->status->name ?? '—' }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-text-secondary">{{ $event->start_date?->format('d.m.Y') ?? '—' }} — {{ $event->end_date?->format('d.m.Y') ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-text-secondary">{{ $event->location ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-text-secondary">{{ $event->expected_visitors ?? '—' }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.events.edit', $event) }}" class="text-accent hover:text-accent-hover font-medium text-sm">Редактировать</a>
                            <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="inline ml-3" onsubmit="return confirm('Удалить мероприятие?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-danger hover:text-danger/80 font-medium text-sm">Удалить</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-text-secondary">Нет мероприятий</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($events->hasPages())
        <div class="px-6 py-4 border-t border-surface-border">
            {{ $events->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
