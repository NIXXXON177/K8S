@extends('layouts.admin')
@section('page-title', 'Арендаторы')
@section('content')
<div class="space-y-6">
    <div class="bg-card rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-surface-border">
                <thead class="bg-surface">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase">Компания</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase">Контактное лицо</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase">Эл. почта</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase">Телефон</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase">ИНН</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase">Медиафайлов</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase">Броней экранов</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase">Активен</th>
                    </tr>
                </thead>
                <tbody class="bg-card divide-y divide-surface-border">
                    @forelse($tenants as $tenant)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-text-primary">{{ $tenant->company_name ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-text-secondary">{{ $tenant->contact_person ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-text-secondary">{{ $tenant->email ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-text-secondary">{{ $tenant->phone ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-text-secondary">{{ $tenant->inn ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-text-secondary">{{ $tenant->media_files_count ?? 0 }}</td>
                        <td class="px-6 py-4 text-sm text-text-secondary">{{ $tenant->screen_bookings_count ?? 0 }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex rounded-full px-2 py-1 text-xs font-medium {{ ($tenant->is_active ?? true) ? 'bg-success/20 text-success' : 'bg-surface-lighter text-text-secondary' }}">
                                {{ ($tenant->is_active ?? true) ? 'Да' : 'Нет' }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-text-secondary">Нет арендаторов</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($tenants->hasPages())
        <div class="px-6 py-4 border-t border-surface-border">
            {{ $tenants->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
