@extends('layouts.app')

@section('title', 'Организовать мероприятие')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-white mb-2">Организовать мероприятие</h1>
    <p class="text-text-secondary mb-8">Подайте заявку на проведение мероприятия в ТРЦ «Европейский». Администрация рассмотрит вашу заявку и свяжется с вами.</p>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <form action="{{ route('event-request.store') }}" method="POST" class="bg-card rounded-xl border border-surface-border p-8">
                @csrf

                <h2 class="text-lg font-semibold text-white mb-6 pb-4 border-b border-surface-border">Данные организатора</h2>

                @if($tenant)
                <div class="mb-6 p-4 bg-accent/10 border border-accent/30 rounded-lg">
                    <p class="text-sm text-accent">Вы авторизованы как <strong>{{ $tenant->company_name }}</strong>. Реквизиты заполнены автоматически.</p>
                </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label for="company_name" class="block text-sm font-medium text-text-primary mb-2">Название компании / организатор *</label>
                        <input type="text" name="company_name" id="company_name" value="{{ old('company_name', $tenant?->company_name) }}" required {{ $tenant ? 'readonly' : '' }}
                            class="w-full px-4 py-2.5 rounded-lg bg-input-bg border border-input-border text-text-primary placeholder-text-muted focus:ring-2 focus:ring-accent focus:border-accent @error('company_name') border-danger @enderror {{ $tenant ? 'opacity-70' : '' }}">
                        @error('company_name')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="contact_person" class="block text-sm font-medium text-text-primary mb-2">Контактное лицо *</label>
                        <input type="text" name="contact_person" id="contact_person" value="{{ old('contact_person', $tenant?->contact_person) }}" required {{ $tenant ? 'readonly' : '' }}
                            class="w-full px-4 py-2.5 rounded-lg bg-input-bg border border-input-border text-text-primary placeholder-text-muted focus:ring-2 focus:ring-accent focus:border-accent @error('contact_person') border-danger @enderror {{ $tenant ? 'opacity-70' : '' }}">
                        @error('contact_person')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-text-primary mb-2">Эл. почта *</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $tenant?->email) }}" required {{ $tenant ? 'readonly' : '' }}
                            class="w-full px-4 py-2.5 rounded-lg bg-input-bg border border-input-border text-text-primary placeholder-text-muted focus:ring-2 focus:ring-accent focus:border-accent @error('email') border-danger @enderror {{ $tenant ? 'opacity-70' : '' }}">
                        @error('email')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-text-primary mb-2">Телефон *</label>
                        <input type="tel" name="phone" id="phone" value="{{ old('phone', $tenant?->phone) }}" required {{ $tenant ? 'readonly' : '' }}
                            class="w-full px-4 py-2.5 rounded-lg bg-input-bg border border-input-border text-text-primary placeholder-text-muted focus:ring-2 focus:ring-accent focus:border-accent @error('phone') border-danger @enderror {{ $tenant ? 'opacity-70' : '' }}">
                        @error('phone')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label for="inn" class="block text-sm font-medium text-text-primary mb-2">ИНН {{ $tenant ? '' : '(необязательно)' }}</label>
                        <input type="text" name="inn" id="inn" value="{{ old('inn', $tenant?->inn) }}" maxlength="12" {{ $tenant ? 'readonly' : '' }}
                            class="w-full px-4 py-2.5 rounded-lg bg-input-bg border border-input-border text-text-primary placeholder-text-muted focus:ring-2 focus:ring-accent focus:border-accent @error('inn') border-danger @enderror {{ $tenant ? 'opacity-70' : '' }}">
                        @error('inn')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <h2 class="text-lg font-semibold text-white mb-6 pb-4 border-b border-surface-border">Информация о мероприятии</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-medium text-text-primary mb-2">Название мероприятия *</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required
                            class="w-full px-4 py-2.5 rounded-lg bg-input-bg border border-input-border text-text-primary placeholder-text-muted focus:ring-2 focus:ring-accent focus:border-accent @error('title') border-danger @enderror">
                        @error('title')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-text-primary mb-2">Описание мероприятия *</label>
                        <textarea name="description" id="description" rows="4" required
                            class="w-full px-4 py-2.5 rounded-lg bg-input-bg border border-input-border text-text-primary placeholder-text-muted focus:ring-2 focus:ring-accent focus:border-accent @error('description') border-danger @enderror">{{ old('description') }}</textarea>
                        @error('description')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label for="zone_id" class="block text-sm font-medium text-text-primary mb-2">Зона проведения *</label>
                        <select name="zone_id" id="zone_id" required
                            class="w-full px-4 py-2.5 rounded-lg bg-input-bg border border-input-border text-text-primary focus:ring-2 focus:ring-accent focus:border-accent @error('zone_id') border-danger @enderror">
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
                        <label for="start_date" class="block text-sm font-medium text-text-primary mb-2">Дата начала *</label>
                        <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" required
                            class="w-full px-4 py-2.5 rounded-lg bg-input-bg border border-input-border text-text-primary focus:ring-2 focus:ring-accent focus:border-accent @error('start_date') border-danger @enderror">
                        @error('start_date')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-text-primary mb-2">Дата окончания *</label>
                        <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" required
                            class="w-full px-4 py-2.5 rounded-lg bg-input-bg border border-input-border text-text-primary focus:ring-2 focus:ring-accent focus:border-accent @error('end_date') border-danger @enderror">
                        @error('end_date')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="expected_visitors" class="block text-sm font-medium text-text-primary mb-2">Ожидаемое кол-во посетителей</label>
                        <input type="number" name="expected_visitors" id="expected_visitors" value="{{ old('expected_visitors') }}" min="1"
                            class="w-full px-4 py-2.5 rounded-lg bg-input-bg border border-input-border text-text-primary placeholder-text-muted focus:ring-2 focus:ring-accent focus:border-accent @error('expected_visitors') border-danger @enderror">
                        @error('expected_visitors')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="budget" class="block text-sm font-medium text-text-primary mb-2">Бюджет (₽)</label>
                        <input type="number" name="budget" id="budget" value="{{ old('budget') }}" min="0" step="0.01"
                            class="w-full px-4 py-2.5 rounded-lg bg-input-bg border border-input-border text-text-primary placeholder-text-muted focus:ring-2 focus:ring-accent focus:border-accent @error('budget') border-danger @enderror">
                        @error('budget')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label for="notes" class="block text-sm font-medium text-text-primary mb-2">Дополнительные пожелания</label>
                        <textarea name="notes" id="notes" rows="3"
                            class="w-full px-4 py-2.5 rounded-lg bg-input-bg border border-input-border text-text-primary placeholder-text-muted focus:ring-2 focus:ring-accent focus:border-accent @error('notes') border-danger @enderror">{{ old('notes') }}</textarea>
                        @error('notes')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <button type="submit" class="px-8 py-3 bg-accent hover:bg-accent-hover text-white rounded-lg font-semibold transition-colors">
                        Отправить заявку
                    </button>
                </div>
            </form>
        </div>

        <div class="space-y-6">
            <div class="bg-surface-lighter rounded-xl border border-surface-border p-6">
                <h3 class="font-semibold text-lg text-white mb-4">Как это работает?</h3>
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
                        <span>С вами связывается менеджер для обсуждения деталей и подтверждения</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex-shrink-0 w-6 h-6 bg-accent rounded-full flex items-center justify-center text-xs font-bold text-white">4</span>
                        <span>Мероприятие проводится в выбранной зоне ТРЦ</span>
                    </li>
                </ol>
            </div>
            <div class="bg-card rounded-xl border border-surface-border p-6">
                <h3 class="font-semibold text-white mb-4">Доступные зоны</h3>
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
            <div class="bg-card rounded-xl border border-surface-border p-6">
                <h3 class="font-semibold text-white mb-4">Контакты</h3>
                <p class="text-sm text-text-secondary mb-2">+7 (495) 921-34-44</p>
                <p class="text-sm text-text-secondary">Москва, площадь Киевского вокзала, 2</p>
                <p class="text-sm text-text-secondary mt-1">ст. метро «Киевская»</p>
            </div>
        </div>
    </div>
</div>
@endsection
