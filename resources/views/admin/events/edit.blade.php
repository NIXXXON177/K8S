@extends('layouts.admin')
@section('page-title', 'Редактировать мероприятие')
@section('content')
<div class="max-w-2xl">
    <a href="{{ route('admin.events.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-800 mb-6">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Назад к списку
    </a>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <form action="{{ route('admin.events.update', $event) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Название *</label>
                <input type="text" name="title" id="title" value="{{ old('title', $event->title) }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('title') border-red-500 @enderror">
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Описание</label>
                <textarea name="description" id="description" rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('description') border-red-500 @enderror">{{ old('description', $event->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="status_id" class="block text-sm font-medium text-gray-700 mb-1">Статус *</label>
                <select name="status_id" id="status_id" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('status_id') border-red-500 @enderror">
                    @foreach($statuses ?? [] as $status)
                        <option value="{{ $status->id }}" {{ old('status_id', $event->status_id) == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                    @endforeach
                </select>
                @error('status_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Дата начала *</label>
                    <input type="datetime-local" name="start_date" id="start_date" value="{{ old('start_date', $event->start_date?->format('Y-m-d\TH:i')) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('start_date') border-red-500 @enderror">
                    @error('start_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Дата окончания *</label>
                    <input type="datetime-local" name="end_date" id="end_date" value="{{ old('end_date', $event->end_date?->format('Y-m-d\TH:i')) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('end_date') border-red-500 @enderror">
                    @error('end_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div>
                <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Расположение</label>
                <input type="text" name="location" id="location" value="{{ old('location', $event->location) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('location') border-red-500 @enderror">
                @error('location')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="expected_visitors" class="block text-sm font-medium text-gray-700 mb-1">Ожидаемые посетители</label>
                    <input type="number" name="expected_visitors" id="expected_visitors" value="{{ old('expected_visitors', $event->expected_visitors) }}" min="0"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('expected_visitors') border-red-500 @enderror">
                    @error('expected_visitors')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="budget" class="block text-sm font-medium text-gray-700 mb-1">Бюджет</label>
                    <input type="number" name="budget" id="budget" value="{{ old('budget', $event->budget) }}" min="0" step="0.01"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('budget') border-red-500 @enderror">
                    @error('budget')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary-light transition-colors font-medium">Сохранить</button>
                <a href="{{ route('admin.events.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">Отмена</a>
            </div>
        </form>
    </div>
</div>
@endsection
