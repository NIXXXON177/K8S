@extends('layouts.admin')
@section('page-title', 'Рекламные экраны')
@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Название</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Расположение</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Разрешение</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ночная версия</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Активен</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Действия</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($screens as $screen)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $screen->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $screen->location ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $screen->width_px ?? 0 }} × {{ $screen->height_px ?? 0 }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex rounded-full px-2 py-1 text-xs font-medium {{ ($screen->has_night_version ?? false) ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-600' }}">
                                {{ ($screen->has_night_version ?? false) ? 'Да' : 'Нет' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex rounded-full px-2 py-1 text-xs font-medium {{ ($screen->is_active ?? true) ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                {{ ($screen->is_active ?? true) ? 'Да' : 'Нет' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.screens.edit', $screen) }}" class="text-primary hover:text-primary-light font-medium text-sm">Редактировать</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">Нет экранов</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($screens->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $screens->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
