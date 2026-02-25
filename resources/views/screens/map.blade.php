@extends('layouts.app')

@section('title', 'Карта экранов ТРЦ')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white">Схема рекламных экранов</h1>
            <p class="text-text-secondary mt-2">Интерактивная карта расположения экранов по этажам ТРЦ «Европейский»</p>
        </div>
        <a href="{{ route('screens.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-surface-lighter text-text-secondary hover:text-white rounded-lg text-sm font-medium transition-colors border border-surface-border">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
            Список экранов
        </a>
    </div>

    {{-- Floor tabs --}}
    <div class="flex flex-wrap gap-2 mb-6" id="floor-tabs">
        @foreach($floors as $floor => $floorScreens)
        <button
            data-floor="{{ $floor }}"
            class="floor-tab px-5 py-2.5 rounded-lg text-sm font-semibold transition-all border
                {{ $loop->first ? 'bg-accent text-white border-accent' : 'bg-surface-lighter text-text-secondary border-surface-border hover:text-white hover:bg-primary-lighter' }}"
        >
            @if($floor === 'Фасад')
                Фасад
            @else
                {{ $floor }} этаж
            @endif
            <span class="ml-1 text-xs opacity-70">({{ $floorScreens->count() }})</span>
        </button>
        @endforeach
    </div>

    {{-- Map area --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Visual map --}}
        <div class="lg:col-span-2">
            <div class="bg-card rounded-xl border border-surface-border overflow-hidden">
                <div class="p-4 border-b border-surface-border flex items-center justify-between">
                    <h2 class="text-sm font-semibold text-white" id="floor-title">
                        @php $firstFloor = $floors->keys()->first(); @endphp
                        @if($firstFloor === 'Фасад') Фасад @else {{ $firstFloor }} этаж @endif
                    </h2>
                    <div class="flex items-center gap-3 text-xs text-text-muted">
                        <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-accent inline-block"></span> Экран</span>
                        <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-gold inline-block"></span> Ночная версия</span>
                    </div>
                </div>
                <div class="relative bg-surface" style="min-height: 500px;" id="map-container">
                    {{-- Floor plan background grid --}}
                    <svg class="absolute inset-0 w-full h-full" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <pattern id="grid" width="50" height="50" patternUnits="userSpaceOnUse">
                                <path d="M 50 0 L 0 0 0 50" fill="none" stroke="rgba(255,255,255,0.03)" stroke-width="1"/>
                            </pattern>
                        </defs>
                        <rect width="100%" height="100%" fill="url(#grid)" />
                        <rect x="5%" y="5%" width="90%" height="90%" rx="12" fill="none" stroke="rgba(255,255,255,0.06)" stroke-width="2" stroke-dasharray="8 4"/>
                        <text x="50%" y="50%" text-anchor="middle" dominant-baseline="middle" fill="rgba(255,255,255,0.04)" font-size="48" font-weight="bold">ТРЦ ЕВРОПЕЙСКИЙ</text>
                    </svg>

                    @foreach($floors as $floor => $floorScreens)
                    <div class="floor-layer absolute inset-0 {{ $loop->first ? '' : 'hidden' }}" data-floor="{{ $floor }}">
                        @foreach($floorScreens as $screen)
                        <button
                            class="screen-pin absolute transform -translate-x-1/2 -translate-y-1/2 group z-10"
                            style="left: {{ $screen->pos_x }}%; top: {{ $screen->pos_y }}%;"
                            data-screen-id="{{ $screen->id }}"
                        >
                            <span class="flex items-center justify-center w-8 h-8 rounded-full {{ $screen->has_night_version ? 'bg-gold' : 'bg-accent' }} text-white text-xs font-bold shadow-lg ring-2 ring-black/20 transition-transform group-hover:scale-125">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </span>
                            {{-- Tooltip --}}
                            <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-3 py-2 bg-card border border-surface-border rounded-lg text-xs text-white whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none shadow-xl z-20">
                                <span class="font-semibold">{{ $screen->name }}</span><br>
                                <span class="text-text-secondary">{{ $screen->width_px }}×{{ $screen->height_px }} px</span>
                                @if($screen->has_night_version)
                                <br><span class="text-gold">Ночная версия</span>
                                @endif
                                <span class="absolute top-full left-1/2 -translate-x-1/2 w-2 h-2 bg-card border-r border-b border-surface-border rotate-45 -mt-1"></span>
                            </span>
                        </button>
                        @endforeach

                        {{-- Zone labels --}}
                        @foreach($floorScreens->groupBy('zone_name') as $zoneName => $zoneScreens)
                        @php
                            $avgX = $zoneScreens->avg('pos_x');
                            $avgY = $zoneScreens->avg('pos_y');
                        @endphp
                        <div class="absolute text-xs font-medium text-text-muted/50 uppercase tracking-wider pointer-events-none"
                             style="left: {{ $avgX }}%; top: {{ max(5, $avgY - 12) }}%; transform: translateX(-50%);">
                            {{ $zoneName }}
                        </div>
                        @endforeach
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Screen list sidebar --}}
        <div>
            <div class="bg-card rounded-xl border border-surface-border overflow-hidden">
                <div class="p-4 border-b border-surface-border">
                    <h3 class="text-sm font-semibold text-white">Экраны на этаже</h3>
                    <p class="text-xs text-text-muted mt-1" id="screen-count">{{ $floors->first()?->count() ?? 0 }} экранов</p>
                </div>
                <div class="divide-y divide-surface-border max-h-[440px] overflow-y-auto" id="screen-list">
                    @foreach($floors as $floor => $floorScreens)
                    @foreach($floorScreens as $screen)
                    <div class="screen-item p-4 hover:bg-card-hover transition-colors cursor-pointer {{ $loop->parent->first ? '' : 'hidden' }}"
                         data-floor="{{ $floor }}" data-screen-id="{{ $screen->id }}">
                        <div class="flex items-start justify-between gap-2">
                            <div>
                                <div class="text-sm font-medium text-white">{{ $screen->name }}</div>
                                <div class="text-xs text-text-secondary mt-0.5">{{ $screen->location }}</div>
                            </div>
                            <div class="flex flex-col items-end gap-1">
                                <span class="text-xs font-mono text-text-muted">{{ $screen->width_px }}×{{ $screen->height_px }}</span>
                                @if($screen->has_night_version)
                                <span class="text-[10px] font-medium text-gold bg-gold/10 px-1.5 py-0.5 rounded">Ночь</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endforeach
                </div>
            </div>

            <a href="{{ route('ad-request.create') }}" class="mt-4 flex items-center justify-center gap-2 w-full px-5 py-3 bg-accent hover:bg-accent-hover text-white rounded-xl text-sm font-semibold transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Разместить рекламу
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.floor-tab');
    const layers = document.querySelectorAll('.floor-layer');
    const items = document.querySelectorAll('.screen-item');
    const title = document.getElementById('floor-title');
    const count = document.getElementById('screen-count');
    const pins = document.querySelectorAll('.screen-pin');
    const listItems = document.querySelectorAll('.screen-item');

    function switchFloor(floor) {
        tabs.forEach(t => {
            if (t.dataset.floor === floor) {
                t.classList.remove('bg-surface-lighter', 'text-text-secondary', 'border-surface-border');
                t.classList.add('bg-accent', 'text-white', 'border-accent');
            } else {
                t.classList.add('bg-surface-lighter', 'text-text-secondary', 'border-surface-border');
                t.classList.remove('bg-accent', 'text-white', 'border-accent');
            }
        });

        layers.forEach(l => l.classList.toggle('hidden', l.dataset.floor !== floor));

        let visibleCount = 0;
        items.forEach(i => {
            const show = i.dataset.floor === floor;
            i.classList.toggle('hidden', !show);
            if (show) visibleCount++;
        });

        title.textContent = floor === 'Фасад' ? 'Фасад' : floor + ' этаж';
        count.textContent = visibleCount + ' ' + pluralize(visibleCount, 'экран', 'экрана', 'экранов');
    }

    function pluralize(n, one, few, many) {
        const mod10 = n % 10, mod100 = n % 100;
        if (mod10 === 1 && mod100 !== 11) return one;
        if (mod10 >= 2 && mod10 <= 4 && (mod100 < 10 || mod100 >= 20)) return few;
        return many;
    }

    tabs.forEach(tab => tab.addEventListener('click', () => switchFloor(tab.dataset.floor)));

    pins.forEach(pin => {
        pin.addEventListener('click', () => {
            const id = pin.dataset.screenId;
            const item = document.querySelector(`.screen-item[data-screen-id="${id}"]`);
            if (item) {
                item.scrollIntoView({ behavior: 'smooth', block: 'center' });
                item.classList.add('bg-accent/10');
                setTimeout(() => item.classList.remove('bg-accent/10'), 2000);
            }
        });
    });

    listItems.forEach(item => {
        item.addEventListener('click', () => {
            const id = item.dataset.screenId;
            const pin = document.querySelector(`.screen-pin[data-screen-id="${id}"]`);
            if (pin) {
                const circle = pin.querySelector('span');
                circle.classList.add('scale-150');
                setTimeout(() => circle.classList.remove('scale-150'), 600);
            }
        });
    });
});
</script>
@endpush
@endsection
