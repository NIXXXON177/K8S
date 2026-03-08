@extends('layouts.admin')
@section('page-title', 'Редактировать экран')
@section('content')
<div class="max-w-2xl">
    <a href="{{ route('admin.screens.index') }}" class="inline-flex items-center text-sm text-text-secondary hover:text-text-primary mb-6">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Назад к списку
    </a>

    <div class="bg-card rounded-xl p-6">
        <form action="{{ route('admin.screens.update', $screen) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')
            <div>
                <label for="name" class="block text-sm font-medium text-text-primary mb-1">Название *</label>
                <input type="text" name="name" id="name" value="{{ old('name', $screen->name) }}" required
                    class="w-full px-4 py-2 bg-input-bg border border-input-border text-text-primary rounded-lg focus:ring-2 focus:ring-accent focus:border-accent @error('name') border-danger @enderror">
                @error('name')
                    <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="location" class="block text-sm font-medium text-text-primary mb-1">Расположение</label>
                <input type="text" name="location" id="location" value="{{ old('location', $screen->location) }}"
                    class="w-full px-4 py-2 bg-input-bg border border-input-border text-text-primary rounded-lg focus:ring-2 focus:ring-accent focus:border-accent @error('location') border-danger @enderror">
                @error('location')
                    <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="width_px" class="block text-sm font-medium text-text-primary mb-1">Ширина (пикс.) *</label>
                    <input type="number" name="width_px" id="width_px" value="{{ old('width_px', $screen->width_px) }}" required min="1"
                        class="w-full px-4 py-2 bg-input-bg border border-input-border text-text-primary rounded-lg focus:ring-2 focus:ring-accent focus:border-accent @error('width_px') border-danger @enderror">
                    @error('width_px')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="height_px" class="block text-sm font-medium text-text-primary mb-1">Высота (пикс.) *</label>
                    <input type="number" name="height_px" id="height_px" value="{{ old('height_px', $screen->height_px) }}" required min="1"
                        class="w-full px-4 py-2 bg-input-bg border border-input-border text-text-primary rounded-lg focus:ring-2 focus:ring-accent focus:border-accent @error('height_px') border-danger @enderror">
                    @error('height_px')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div>
                <label for="description" class="block text-sm font-medium text-text-primary mb-1">Описание</label>
                <textarea name="description" id="description" rows="3"
                    class="w-full px-4 py-2 bg-input-bg border border-input-border text-text-primary rounded-lg focus:ring-2 focus:ring-accent focus:border-accent @error('description') border-danger @enderror">{{ old('description', $screen->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex flex-col gap-3">
                <div class="flex items-center">
                    <input type="hidden" name="has_night_version" value="0">
                    <input type="checkbox" name="has_night_version" id="has_night_version" value="1" {{ old('has_night_version', $screen->has_night_version) ? 'checked' : '' }}
                        class="w-4 h-4 text-primary border-input-border rounded focus:ring-accent">
                    <label for="has_night_version" class="ml-2 text-sm text-text-primary">Есть ночная версия</label>
                </div>
                <div class="flex items-center">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $screen->is_active ?? true) ? 'checked' : '' }}
                        class="w-4 h-4 text-primary border-input-border rounded focus:ring-accent">
                    <label for="is_active" class="ml-2 text-sm text-text-primary">Активен</label>
                </div>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary-light transition-colors font-medium">Сохранить</button>
                <a href="{{ route('admin.screens.index') }}" class="px-6 py-2 border border-input-border text-text-primary rounded-lg hover:bg-surface transition-colors font-medium">Отмена</a>
            </div>
        </form>
    </div>
</div>
@endsection
