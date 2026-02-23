@extends('layouts.admin')
@section('page-title', 'Арендаторы')
@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Компания</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Контактное лицо</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Телефон</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ИНН</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Медиафайлов</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Броней экранов</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Активен</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($tenants as $tenant)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $tenant->company_name ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $tenant->contact_person ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $tenant->email ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $tenant->phone ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $tenant->inn ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $tenant->media_files_count ?? 0 }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $tenant->screen_bookings_count ?? 0 }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex rounded-full px-2 py-1 text-xs font-medium {{ ($tenant->is_active ?? true) ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                {{ ($tenant->is_active ?? true) ? 'Да' : 'Нет' }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-gray-500">Нет арендаторов</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($tenants->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $tenants->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
