@extends('layouts.organization')
@section('page-title', 'Новая заявка на рекламу')
@section('content')
<div class="max-w-5xl">
    <a href="{{ route('organization.ad-requests.index') }}" class="inline-flex items-center text-sm text-text-secondary hover:text-text-primary mb-6">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Назад к списку
    </a>

    <div class="flex items-center gap-4 mb-8">
        <div id="stepIndicator1" class="flex items-center gap-2">
            <span id="step1Circle" class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold bg-accent text-white">1</span>
            <span id="step1Label" class="text-sm font-medium text-text-primary">Проверка видео</span>
        </div>
        <div class="flex-1 h-px bg-surface-border"></div>
        <div id="stepIndicator2" class="flex items-center gap-2">
            <span id="step2Circle" class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold bg-surface-lighter text-text-muted">2</span>
            <span id="step2Label" class="text-sm font-medium text-text-muted">Параметры размещения</span>
        </div>
    </div>

    {{-- STEP 1: Video check (embedded iframe) --}}
    <div id="step1">
        <div class="bg-card rounded-xl overflow-hidden border border-surface-border">
            <div class="px-6 py-4 border-b border-surface-border flex items-center justify-between">
                <div>
                    <h3 class="font-semibold text-text-primary">Проверка видео — EuroReact</h3>
                    <p class="text-xs text-text-muted mt-0.5">Загрузите видеоролик для проверки параметров. При успешной проверке вы перейдёте к оформлению заявки.</p>
                </div>
                <div id="videoCheckStatus" class="hidden px-3 py-1.5 rounded-lg text-sm font-medium"></div>
            </div>
            <div class="relative" style="height: 600px;">
                <iframe id="euroReactFrame" src="" class="w-full h-full border-0" allow="clipboard-read; clipboard-write"></iframe>
                <div id="iframeLoader" class="absolute inset-0 bg-surface flex items-center justify-center">
                    <div class="text-center">
                        <svg class="w-8 h-8 text-text-muted animate-spin mx-auto mb-3" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        <p class="text-sm text-text-muted">Загрузка системы проверки...</p>
                    </div>
                </div>
            </div>
        </div>

        <div id="videoFailedMsg" class="hidden mt-4">
            <div class="bg-danger/10 border border-danger/30 rounded-xl p-4 flex items-center gap-3">
                <svg class="w-5 h-5 text-danger flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-sm text-danger">Видео не прошло проверку. Исправьте параметры и попробуйте снова.</p>
            </div>
        </div>
    </div>

    {{-- STEP 2: Placement params (screen, dates) — shown after video passes --}}
    <div id="step2" class="hidden">
        <div class="mb-4">
            <div class="bg-success/10 border border-success/30 rounded-xl p-4 flex items-center gap-3">
                <svg class="w-5 h-5 text-success flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-sm text-success font-medium">Видео прошло проверку! Заполните параметры размещения и отправьте заявку администратору.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2">
                <form action="{{ route('organization.ad-requests.store') }}" method="POST" id="adRequestForm" class="bg-card rounded-xl p-6">
                    @csrf
                    <input type="hidden" name="video_checked" value="1">
                    <input type="hidden" name="video_file_name" id="video_file_name">
                    <input type="hidden" name="video_duration" id="video_duration">
                    <input type="hidden" name="video_width" id="video_width">
                    <input type="hidden" name="video_height" id="video_height">
                    <input type="hidden" name="video_size" id="video_size">
                    <input type="hidden" name="video_codec" id="video_codec">
                    <input type="hidden" name="video_fps" id="video_fps">

                    <h3 class="text-lg font-semibold text-text-primary mb-6 pb-4 border-b border-surface-border">Параметры размещения</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="md:col-span-2">
                            <label for="screen_id" class="block text-sm font-medium text-text-primary mb-1">Экран *</label>
                            <select name="screen_id" id="screen_id" required
                                class="w-full px-4 py-2.5 bg-input-bg border border-input-border text-text-primary rounded-lg focus:ring-2 focus:ring-accent focus:border-accent">
                                <option value="">Выберите экран</option>
                                @foreach($screens as $screen)
                                <option value="{{ $screen->id }}" {{ old('screen_id') == $screen->id ? 'selected' : '' }}>
                                    {{ $screen->name }} ({{ $screen->width_px }}x{{ $screen->height_px }})
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="start_date" class="block text-sm font-medium text-text-primary mb-1">Дата начала *</label>
                            <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" required
                                class="w-full px-4 py-2.5 bg-input-bg border border-input-border text-text-primary rounded-lg focus:ring-2 focus:ring-accent focus:border-accent">
                        </div>

                        <div>
                            <label for="end_date" class="block text-sm font-medium text-text-primary mb-1">Дата окончания *</label>
                            <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" required
                                class="w-full px-4 py-2.5 bg-input-bg border border-input-border text-text-primary rounded-lg focus:ring-2 focus:ring-accent focus:border-accent">
                        </div>

                        <div class="md:col-span-2">
                            <label for="notes" class="block text-sm font-medium text-text-primary mb-1">Комментарий</label>
                            <textarea name="notes" id="notes" rows="3"
                                class="w-full px-4 py-2.5 bg-input-bg border border-input-border text-text-primary rounded-lg focus:ring-2 focus:ring-accent focus:border-accent">{{ old('notes') }}</textarea>
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="px-6 py-2.5 bg-accent text-white rounded-lg font-medium hover:bg-accent-hover transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                            Отправить заявку администратору
                        </button>
                    </div>
                </form>
            </div>

            <div class="space-y-4">
                <div class="bg-card rounded-xl p-6">
                    <h4 class="font-semibold text-text-primary mb-3">Данные видео</h4>
                    <dl id="videoInfo" class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <dt class="text-text-muted">Файл</dt>
                            <dd id="infoFileName" class="text-text-primary font-medium">—</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-text-muted">Длительность</dt>
                            <dd id="infoDuration" class="text-text-primary font-medium">—</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-text-muted">Разрешение</dt>
                            <dd id="infoResolution" class="text-text-primary font-medium">—</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-text-muted">Размер</dt>
                            <dd id="infoSize" class="text-text-primary font-medium">—</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-text-muted">Кодек</dt>
                            <dd id="infoCodec" class="text-text-primary font-medium">—</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-text-muted">FPS</dt>
                            <dd id="infoFps" class="text-text-primary font-medium">—</dd>
                        </div>
                    </dl>
                </div>

                <div class="bg-info/10 border border-info/30 rounded-xl p-6">
                    <h4 class="font-semibold text-info mb-2">Подсказка</h4>
                    <p class="text-sm text-info">Параметры видео были определены автоматически при проверке. Выберите экран и укажите даты размещения.</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const step1 = document.getElementById('step1');
        const step2 = document.getElementById('step2');
        const step1Circle = document.getElementById('step1Circle');
        const step1Label = document.getElementById('step1Label');
        const step2Circle = document.getElementById('step2Circle');
        const step2Label = document.getElementById('step2Label');
        const iframe = document.getElementById('euroReactFrame');
        const iframeLoader = document.getElementById('iframeLoader');
        const statusDiv = document.getElementById('videoCheckStatus');
        const videoFailedMsg = document.getElementById('videoFailedMsg');

        const tenant = @json(auth()->user()->tenant);
        const params = new URLSearchParams({
            company: tenant.company_name || '',
            email: '{{ auth()->user()->email }}',
            autoAuth: '1'
        });
        iframe.src = 'https://y8shikage.github.io/EuroReact/home?' + params.toString();

        iframe.addEventListener('load', function() {
            iframeLoader.classList.add('hidden');
        }, { once: true });

        window.addEventListener('message', function(event) {
            if (event.origin !== 'https://y8shikage.github.io') return;

            const data = event.data;
            if (!data) return;

            statusDiv.classList.remove('hidden');

            if (data.success === true || data.status === 'success' || data.passed === true) {
                statusDiv.className = 'px-3 py-1.5 rounded-lg text-sm font-medium bg-success/20 text-success';
                statusDiv.textContent = 'Проверка пройдена';
                videoFailedMsg.classList.add('hidden');

                var fileName = data.fileName || data.file_name || data.name || 'video.mp4';
                var duration = data.duration || data.duration_sec || 15;
                var width = data.width || data.width_px || 1920;
                var height = data.height || data.height_px || 1080;
                var size = data.size || data.file_size_mb || data.fileSize || 0;
                var codec = data.codec || 'H264';
                var fps = data.fps || data.frameRate || 25;

                document.getElementById('video_file_name').value = fileName;
                document.getElementById('video_duration').value = duration;
                document.getElementById('video_width').value = width;
                document.getElementById('video_height').value = height;
                document.getElementById('video_size').value = size;
                document.getElementById('video_codec').value = codec;
                document.getElementById('video_fps').value = fps;

                document.getElementById('infoFileName').textContent = fileName;
                document.getElementById('infoDuration').textContent = duration + ' сек';
                document.getElementById('infoResolution').textContent = width + ' × ' + height;
                document.getElementById('infoSize').textContent = size ? (size + ' МБ') : '—';
                document.getElementById('infoCodec').textContent = codec;
                document.getElementById('infoFps').textContent = fps;

                setTimeout(function() {
                    step1.classList.add('hidden');
                    step2.classList.remove('hidden');

                    step1Circle.className = 'w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold bg-success text-white';
                    step1Label.className = 'text-sm font-medium text-success';
                    step2Circle.className = 'w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold bg-accent text-white';
                    step2Label.className = 'text-sm font-medium text-text-primary';
                }, 1000);

            } else if (data.success === false || data.status === 'error' || data.passed === false) {
                statusDiv.className = 'px-3 py-1.5 rounded-lg text-sm font-medium bg-danger/20 text-danger';
                statusDiv.textContent = 'Не пройдена';
                videoFailedMsg.classList.remove('hidden');
            }
        });
    });
</script>
@endpush
@endsection
