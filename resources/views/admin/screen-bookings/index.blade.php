@extends('layouts.admin')
@section('page-title', 'Бронирования экранов')
@section('content')
<div class="space-y-6">
    <div class="bg-card rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-surface-border">
                <thead class="bg-surface">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase">Экран</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase">Арендатор</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase">Медиафайл</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase">Даты</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase">Показов/день</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase">Сумма</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase">Статус</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-text-secondary uppercase">Действия</th>
                    </tr>
                </thead>
                <tbody class="bg-card divide-y divide-surface-border">
                    @forelse($bookings as $booking)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-text-primary">{{ $booking->screen->name ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-text-secondary">{{ $booking->tenant->company_name ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-text-secondary">{{ $booking->media->file_name ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-text-secondary">{{ $booking->start_date?->format('d.m.Y') ?? '—' }} — {{ $booking->end_date?->format('d.m.Y') ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-text-secondary">{{ $booking->plays_per_day ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-text-secondary">{{ number_format($booking->total_price ?? 0, 0) }} ₽</td>
                        <td class="px-6 py-4">
                            @php
                                $rawStatus = is_object($booking->status) ? ($booking->status->name ?? '—') : ($booking->status ?? '—');
                                $statusMap = ['pending' => 'Ожидает', 'confirmed' => 'Подтверждено', 'cancelled' => 'Отменено'];
                                $statusLabel = $statusMap[$rawStatus] ?? $rawStatus;
                            @endphp
                            <span class="inline-flex rounded-full px-2 py-1 text-xs font-medium
                                @if($rawStatus === 'confirmed') bg-success/20 text-success
                                @elseif($rawStatus === 'pending') bg-warning/20 text-warning
                                @elseif($rawStatus === 'cancelled') bg-danger/20 text-danger
                                @else bg-surface-lighter text-text-primary @endif">{{ $statusLabel }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <form action="{{ route('admin.screen-bookings.update-status', $booking) }}" method="POST" class="space-y-2">
                                @csrf
                                <div class="flex items-center gap-2 justify-end">
                                    <select name="status" class="text-sm bg-input-bg text-text-primary border border-input-border rounded px-2 py-1 focus:ring-2 focus:ring-accent booking-status-select" data-booking-id="{{ $booking->id }}">
                                        <option value="pending" {{ $rawStatus === 'pending' ? 'selected' : '' }}>Ожидает</option>
                                        <option value="confirmed" {{ $rawStatus === 'confirmed' ? 'selected' : '' }}>Подтверждено</option>
                                        <option value="cancelled" {{ $rawStatus === 'cancelled' ? 'selected' : '' }}>Отменено</option>
                                    </select>
                                    <button type="submit" class="text-sm text-accent hover:text-accent-hover font-medium">Изменить</button>
                                </div>
                                <div class="rejection-reason-field hidden" id="rejection-reason-{{ $booking->id }}">
                                    <textarea name="rejection_reason" rows="2" placeholder="Причина отклонения (обязательно)"
                                        class="w-full text-sm px-3 py-1.5 bg-input-bg border border-input-border text-text-primary rounded focus:ring-2 focus:ring-accent">{{ $booking->rejection_reason }}</textarea>
                                </div>
                                @if($booking->rejection_reason && $rawStatus === 'cancelled')
                                <div class="text-xs text-danger text-right">Причина: {{ $booking->rejection_reason }}</div>
                                @endif
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-text-secondary">Нет бронирований</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($bookings->hasPages())
        <div class="px-6 py-4 border-t border-surface-border">
            {{ $bookings->links() }}
        </div>
        @endif
    </div>
</div>
@push('scripts')
<script>
document.querySelectorAll('.booking-status-select').forEach(function(select) {
    const bookingId = select.dataset.bookingId;
    const reasonField = document.getElementById('rejection-reason-' + bookingId);

    function toggleReason() {
        if (select.value === 'cancelled') {
            reasonField?.classList.remove('hidden');
        } else {
            reasonField?.classList.add('hidden');
        }
    }

    toggleReason();
    select.addEventListener('change', toggleReason);
});
</script>
@endpush
@endsection
