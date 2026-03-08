@extends('layouts.organization')
@section('page-title', 'Новая заявка на мероприятие')
@section('content')
<div class="max-w-4xl">
    <a href="{{ route('organization.event-requests.index') }}" class="inline-flex items-center text-sm text-text-secondary hover:text-text-primary mb-6">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Назад к списку
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <form action="{{ route('organization.event-requests.store') }}" method="POST" class="bg-card rounded-xl p-6">
                @csrf

                <h3 class="text-lg font-semibold text-text-primary mb-6 pb-4 border-b border-surface-border">Информация о мероприятии</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-medium text-text-primary mb-1">Название мероприятия *</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required
                            class="w-full px-4 py-2.5 bg-input-bg border border-input-border text-text-primary rounded-lg focus:ring-2 focus:ring-accent focus:border-accent @error('title') border-danger @enderror">
                        @error('title')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-text-primary mb-1">Описание мероприятия *</label>
                        <textarea name="description" id="description" rows="4" required
                            class="w-full px-4 py-2.5 bg-input-bg border border-input-border text-text-primary rounded-lg focus:ring-2 focus:ring-accent focus:border-accent @error('description') border-danger @enderror">{{ old('description') }}</textarea>
                        @error('description')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="zone_id" class="block text-sm font-medium text-text-primary mb-1">Зона проведения *</label>
                        <select name="zone_id" id="zone_id" required
                            class="w-full px-4 py-2.5 bg-input-bg border border-input-border text-text-primary rounded-lg focus:ring-2 focus:ring-accent focus:border-accent @error('zone_id') border-danger @enderror">
                            <option value="">Выберите зону</option>
                            @foreach($zones as $zone)
                            <option value="{{ $zone->id }}" {{ old('zone_id') == $zone->id ? 'selected' : '' }}>
                                {{ $zone->name }} — {{ $zone->floor }} эт., {{ $zone->area_sqm }} м² ({{ number_format($zone->price_per_day, 0, ',', ' ') }} ₽/день)
                            </option>
                            @endforeach
                        </select>
                        @error('zone_id')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="start_date" class="block text-sm font-medium text-text-primary mb-1">Дата начала *</label>
                        <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" required
                            class="w-full px-4 py-2.5 bg-input-bg border border-input-border text-text-primary rounded-lg focus:ring-2 focus:ring-accent focus:border-accent @error('start_date') border-danger @enderror">
                        @error('start_date')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="end_date" class="block text-sm font-medium text-text-primary mb-1">Дата окончания *</label>
                        <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" required
                            class="w-full px-4 py-2.5 bg-input-bg border border-input-border text-text-primary rounded-lg focus:ring-2 focus:ring-accent focus:border-accent @error('end_date') border-danger @enderror">
                        @error('end_date')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="expected_visitors" class="block text-sm font-medium text-text-primary mb-1">Ожидаемое кол-во посетителей</label>
                        <input type="number" name="expected_visitors" id="expected_visitors" value="{{ old('expected_visitors') }}" min="1"
                            class="w-full px-4 py-2.5 bg-input-bg border border-input-border text-text-primary rounded-lg focus:ring-2 focus:ring-accent focus:border-accent @error('expected_visitors') border-danger @enderror">
                        @error('expected_visitors')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="budget" class="block text-sm font-medium text-text-primary mb-1">Бюджет (₽)</label>
                        <input type="number" name="budget" id="budget" value="{{ old('budget') }}" min="0" step="0.01"
                            class="w-full px-4 py-2.5 bg-input-bg border border-input-border text-text-primary rounded-lg focus:ring-2 focus:ring-accent focus:border-accent @error('budget') border-danger @enderror">
                        @error('budget')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="notes" class="block text-sm font-medium text-text-primary mb-1">Дополнительные пожелания</label>
                        <textarea name="notes" id="notes" rows="3"
                            class="w-full px-4 py-2.5 bg-input-bg border border-input-border text-text-primary rounded-lg focus:ring-2 focus:ring-accent focus:border-accent @error('notes') border-danger @enderror">{{ old('notes') }}</textarea>
                        @error('notes')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="px-6 py-2.5 bg-accent text-white rounded-lg font-medium hover:bg-accent-hover transition-colors">
                        Отправить заявку
                    </button>
                </div>
            </form>
        </div>

        <div class="space-y-4">
            <div class="bg-card rounded-xl p-6">
                <h4 class="font-semibold text-text-primary mb-3">Как это работает?</h4>
                <ol class="space-y-3 text-sm text-text-secondary">
                    <li class="flex gap-3">
                        <span class="flex-shrink-0 w-6 h-6 bg-accent rounded-full flex items-center justify-center text-xs font-bold text-white">1</span>
                        <span>Вы заполняете заявку с описанием мероприятия и выбираете зону</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex-shrink-0 w-6 h-6 bg-accent rounded-full flex items-center justify-center text-xs font-bold text-white">2</span>
                        <span>Администрация ТРЦ рассматривает заявку и проверяет доступность зоны</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex-shrink-0 w-6 h-6 bg-accent rounded-full flex items-center justify-center text-xs font-bold text-white">3</span>
                        <span>Заявка одобряется или отклоняется с указанием причины</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex-shrink-0 w-6 h-6 bg-accent rounded-full flex items-center justify-center text-xs font-bold text-white">4</span>
                        <span>Мероприятие проводится в выбранной зоне ТРЦ</span>
                    </li>
                </ol>
            </div>

            <div class="bg-card rounded-xl p-6">
                <h4 class="font-semibold text-text-primary mb-3">Доступные зоны</h4>
                <ul class="space-y-3 text-sm text-text-secondary">
                    @foreach($zones as $zone)
                    <li class="flex justify-between items-start">
                        <div>
                            <div class="font-medium text-text-primary">{{ $zone->name }}</div>
                            <div class="text-xs text-text-muted">{{ $zone->floor }} эт., {{ $zone->area_sqm }} м²</div>
                        </div>
                        <div class="text-xs font-medium text-gold whitespace-nowrap">{{ number_format($zone->price_per_day, 0, ',', ' ') }} ₽/день</div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
