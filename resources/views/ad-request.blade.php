@extends('layouts.app')

@section('title', 'Разместить рекламу')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-white mb-8">Разместить рекламу</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Form --}}
        <div class="lg:col-span-2">
            <form action="{{ route('ad-request.store') }}" method="POST" class="bg-card rounded-xl border border-surface-border p-8">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="company_name" class="block text-sm font-medium text-text-primary mb-2">Название компании *</label>
                        <input type="text" name="company_name" id="company_name" value="{{ old('company_name') }}" required
                            class="w-full px-4 py-2.5 rounded-lg bg-input-bg border border-input-border text-text-primary placeholder-text-muted focus:ring-2 focus:ring-accent focus:border-accent @error('company_name') border-danger @enderror">
                        @error('company_name')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="contact_person" class="block text-sm font-medium text-text-primary mb-2">Контактное лицо *</label>
                        <input type="text" name="contact_person" id="contact_person" value="{{ old('contact_person') }}" required
                            class="w-full px-4 py-2.5 rounded-lg bg-input-bg border border-input-border text-text-primary placeholder-text-muted focus:ring-2 focus:ring-accent focus:border-accent @error('contact_person') border-danger @enderror">
                        @error('contact_person')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-text-primary mb-2">Email *</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                            class="w-full px-4 py-2.5 rounded-lg bg-input-bg border border-input-border text-text-primary placeholder-text-muted focus:ring-2 focus:ring-accent focus:border-accent @error('email') border-danger @enderror">
                        @error('email')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-text-primary mb-2">Телефон *</label>
                        <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required
                            class="w-full px-4 py-2.5 rounded-lg bg-input-bg border border-input-border text-text-primary placeholder-text-muted focus:ring-2 focus:ring-accent focus:border-accent @error('phone') border-danger @enderror">
                        @error('phone')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label for="inn" class="block text-sm font-medium text-text-primary mb-2">ИНН (необязательно)</label>
                        <input type="text" name="inn" id="inn" value="{{ old('inn') }}" maxlength="12"
                            class="w-full px-4 py-2.5 rounded-lg bg-input-bg border border-input-border text-text-primary placeholder-text-muted focus:ring-2 focus:ring-accent focus:border-accent @error('inn') border-danger @enderror">
                        @error('inn')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label for="screen_id" class="block text-sm font-medium text-text-primary mb-2">Экран *</label>
                        <select name="screen_id" id="screen_id" required
                            class="w-full px-4 py-2.5 rounded-lg bg-input-bg border border-input-border text-text-primary focus:ring-2 focus:ring-accent focus:border-accent @error('screen_id') border-danger @enderror">
                            <option value="">Выберите экран</option>
                            @foreach($screens as $screen)
                            <option value="{{ $screen->id }}" {{ old('screen_id') == $screen->id ? 'selected' : '' }}>
                                {{ $screen->name }} ({{ $screen->width_px }}×{{ $screen->height_px }})
                            </option>
                            @endforeach
                        </select>
                        @error('screen_id')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="file_name" class="block text-sm font-medium text-text-primary mb-2">Имя файла *</label>
                        <input type="text" name="file_name" id="file_name" value="{{ old('file_name') }}" required placeholder="video.mp4"
                            class="w-full px-4 py-2.5 rounded-lg bg-input-bg border border-input-border text-text-primary placeholder-text-muted focus:ring-2 focus:ring-accent focus:border-accent @error('file_name') border-danger @enderror">
                        @error('file_name')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="duration_sec" class="block text-sm font-medium text-text-primary mb-2">Длительность (сек) *</label>
                        <select name="duration_sec" id="duration_sec" required
                            class="w-full px-4 py-2.5 rounded-lg bg-input-bg border border-input-border text-text-primary focus:ring-2 focus:ring-accent focus:border-accent @error('duration_sec') border-danger @enderror">
                            <option value="15" {{ old('duration_sec') == '15' ? 'selected' : '' }}>15</option>
                            <option value="30" {{ old('duration_sec') == '30' ? 'selected' : '' }}>30</option>
                        </select>
                        @error('duration_sec')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="width_px" class="block text-sm font-medium text-text-primary mb-2">Ширина (px) *</label>
                        <input type="number" name="width_px" id="width_px" value="{{ old('width_px') }}" required min="1"
                            class="w-full px-4 py-2.5 rounded-lg bg-input-bg border border-input-border text-text-primary placeholder-text-muted focus:ring-2 focus:ring-accent focus:border-accent @error('width_px') border-danger @enderror">
                        @error('width_px')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="height_px" class="block text-sm font-medium text-text-primary mb-2">Высота (px) *</label>
                        <input type="number" name="height_px" id="height_px" value="{{ old('height_px') }}" required min="1"
                            class="w-full px-4 py-2.5 rounded-lg bg-input-bg border border-input-border text-text-primary placeholder-text-muted focus:ring-2 focus:ring-accent focus:border-accent @error('height_px') border-danger @enderror">
                        @error('height_px')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="file_size_mb" class="block text-sm font-medium text-text-primary mb-2">Размер файла (МБ) *</label>
                        <input type="number" name="file_size_mb" id="file_size_mb" value="{{ old('file_size_mb') }}" required min="1" max="400"
                            class="w-full px-4 py-2.5 rounded-lg bg-input-bg border border-input-border text-text-primary placeholder-text-muted focus:ring-2 focus:ring-accent focus:border-accent @error('file_size_mb') border-danger @enderror">
                        @error('file_size_mb')
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
                    <div class="md:col-span-2">
                        <label for="notes" class="block text-sm font-medium text-text-primary mb-2">Комментарий</label>
                        <textarea name="notes" id="notes" rows="4"
                            class="w-full px-4 py-2.5 rounded-lg bg-input-bg border border-input-border text-text-primary placeholder-text-muted focus:ring-2 focus:ring-accent focus:border-accent @error('notes') border-danger @enderror">{{ old('notes') }}</textarea>
                        @error('notes')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-8">
                    <button type="submit" class="px-8 py-3 bg-accent hover:bg-accent-hover text-white rounded-lg font-semibold transition-colors">
                        Отправить заявку
                    </button>
                </div>
            </form>
        </div>

        {{-- Info sidebar --}}
        <div class="space-y-6">
            <div class="bg-surface-lighter rounded-xl border border-surface-border p-6">
                <h3 class="font-semibold text-lg text-white mb-4">Требования к видео</h3>
                <ul class="space-y-2 text-sm text-text-secondary">
                    <li>• Формат: MP4</li>
                    <li>• Кодек: H264</li>
                    <li>• Частота кадров: 25 fps</li>
                    <li>• Длительность: 15 или 30 секунд</li>
                    <li>• Максимальный размер: 400 МБ</li>
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
