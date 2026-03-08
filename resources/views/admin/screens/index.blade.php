@extends('layouts.admin')
@section('page-title', 'Рекламные экраны')
@section('content')
<div class="space-y-6">
    <div class="bg-card rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-surface-border">
                <thead class="bg-surface">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase">Название</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase">Расположение</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase">Разрешение</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase">Ночная версия</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase">Активен</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-text-secondary uppercase">Действия</th>
                    </tr>
                </thead>
                <tbody class="bg-card divide-y divide-surface-border">
                    @forelse($screens as $screen)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-text-primary">{{ $screen->name }}</td>
                        <td class="px-6 py-4 text-sm text-text-secondary">{{ $screen->location ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-text-secondary">{{ $screen->width_px ?? 0 }} × {{ $screen->height_px ?? 0 }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex rounded-full px-2 py-1 text-xs font-medium {{ ($screen->has_night_version ?? false) ? 'bg-info/20 text-info' : 'bg-surface-lighter text-text-secondary' }}">
                                {{ ($screen->has_night_version ?? false) ? 'Да' : 'Нет' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex rounded-full px-2 py-1 text-xs font-medium {{ ($screen->is_active ?? true) ? 'bg-success/20 text-success' : 'bg-surface-lighter text-text-secondary' }}">
                                {{ ($screen->is_active ?? true) ? 'Да' : 'Нет' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.screens.edit', $screen) }}" class="text-accent hover:text-accent-hover font-medium text-sm">Редактировать</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-text-secondary">Нет экранов</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($screens->hasPages())
        <div class="px-6 py-4 border-t border-surface-border">
            {{ $screens->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
