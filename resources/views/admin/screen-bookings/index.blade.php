@extends('layouts.admin')
@section('page-title', 'Бронирования экранов')
@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Экран</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Арендатор</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Медиафайл</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Даты</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Показов/день</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Сумма</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Статус</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Действия</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($bookings as $booking)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $booking->screen->name ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $booking->tenant->company_name ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $booking->media->file_name ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $booking->start_date?->format('d.m.Y') ?? '—' }} — {{ $booking->end_date?->format('d.m.Y') ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $booking->plays_per_day ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ number_format($booking->total_price ?? 0, 0) }} ₽</td>
                        <td class="px-6 py-4">
                            @php $statusName = is_object($booking->status) ? ($booking->status->name ?? '—') : ($booking->status ?? '—'); @endphp
                            <span class="inline-flex rounded-full px-2 py-1 text-xs font-medium
                                @if($statusName === 'Подтверждено' || $statusName === 'confirmed') bg-green-100 text-green-800
                                @elseif($statusName === 'Ожидает' || $statusName === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($statusName === 'Отменено' || $statusName === 'cancelled') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">{{ $statusName }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <form action="{{ route('admin.screen-bookings.update-status', $booking) }}" method="POST" class="flex items-center gap-2 justify-end">
                                @csrf
                                <select name="status" class="text-sm border border-gray-300 rounded px-2 py-1 focus:ring-2 focus:ring-primary">
                                    <option value="pending" {{ $statusName === 'Ожидает' || $statusName === 'pending' ? 'selected' : '' }}>Ожидает</option>
                                    <option value="confirmed" {{ $statusName === 'Подтверждено' || $statusName === 'confirmed' ? 'selected' : '' }}>Подтверждено</option>
                                    <option value="cancelled" {{ $statusName === 'Отменено' || $statusName === 'cancelled' ? 'selected' : '' }}>Отменено</option>
                                </select>
                                <button type="submit" class="text-sm text-primary hover:text-primary-light font-medium">Изменить</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-gray-500">Нет бронирований</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($bookings->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $bookings->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
