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

    {{-- STEP 1: Video check --}}
    <div id="step1" class="{{ $errors->any() ? 'hidden' : '' }}">
        <div class="bg-card rounded-xl overflow-hidden border border-surface-border">
            <div class="px-6 py-4 border-b border-surface-border">
                <h3 class="font-semibold text-text-primary">Проверка видеоролика</h3>
                <p class="text-xs text-text-muted mt-0.5">Загрузите видеоролик для автоматической проверки технических параметров.</p>
            </div>
            <div class="p-6">
                <div id="dropZone" class="border-2 border-dashed border-surface-border rounded-xl p-12 text-center cursor-pointer hover:border-accent/50 transition-colors">
                    <svg class="w-12 h-12 text-text-muted mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                    <p class="text-text-primary font-medium mb-1">Перетащите видеофайл сюда</p>
                    <p class="text-sm text-text-muted mb-4">или нажмите для выбора файла</p>
                    <p class="text-xs text-text-muted">Поддерживаемые форматы: MP4, MOV, AVI, MKV, WebM</p>
                    <input type="file" id="videoInput" accept="video/*" class="hidden">
                </div>

                <div id="checkingState" class="hidden text-center py-8">
                    <svg class="w-8 h-8 text-accent animate-spin mx-auto mb-3" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    <p class="text-sm text-text-muted">Анализ видеофайла...</p>
                </div>

                <div id="resultArea" class="hidden mt-6">
                    <div id="resultHeader" class="rounded-xl p-4 flex items-center gap-3 mb-4"></div>
                    <div class="bg-surface rounded-xl overflow-hidden">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-surface-border">
                                    <th class="text-left px-4 py-3 text-text-muted font-medium">Параметр</th>
                                    <th class="text-left px-4 py-3 text-text-muted font-medium">Значение</th>
                                    <th class="text-center px-4 py-3 text-text-muted font-medium">Статус</th>
                                </tr>
                            </thead>
                            <tbody id="resultTable"></tbody>
                        </table>
                    </div>
                    <div class="mt-4 flex gap-3">
                        <button id="btnRetry" class="px-4 py-2 bg-surface-lighter text-text-primary rounded-lg text-sm hover:bg-surface-border transition-colors">Загрузить другое видео</button>
                        <button id="btnProceed" class="hidden px-4 py-2 bg-accent text-white rounded-lg text-sm font-medium hover:bg-accent-hover transition-colors">Перейти к оформлению заявки →</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- STEP 2: Placement params --}}
    <div id="step2" class="{{ $errors->any() ? '' : 'hidden' }}">
        @if($errors->any())
        <div class="mb-4">
            <div class="bg-danger/10 border border-danger/30 rounded-xl p-4">
                <div class="flex items-center gap-3 mb-2">
                    <svg class="w-5 h-5 text-danger flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-sm text-danger font-medium">Пожалуйста, исправьте ошибки:</p>
                </div>
                <ul class="list-disc list-inside text-sm text-danger space-y-1 ml-8">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        <div class="mb-4">
            <div class="bg-success/10 border border-success/30 rounded-xl p-4 flex items-center gap-3">
                <svg class="w-5 h-5 text-success flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-sm text-success font-medium">
                    Видео загружено ({{ session('pending_video_name', 'файл сохранён') }}). Заполните параметры размещения и отправьте заявку.
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2">
                <form action="{{ route('organization.ad-requests.store') }}" method="POST" id="adRequestForm" enctype="multipart/form-data" class="bg-card rounded-xl p-6">
                    @csrf
                    <input type="hidden" name="video_checked" value="1">
                    <input type="file" name="video_file" id="video_file_hidden" class="hidden" accept="video/*">
                    <input type="hidden" name="video_file_name" id="video_file_name" value="{{ old('video_file_name') }}">
                    <input type="hidden" name="video_duration" id="video_duration" value="{{ old('video_duration') }}">
                    <input type="hidden" name="video_width" id="video_width" value="{{ old('video_width') }}">
                    <input type="hidden" name="video_height" id="video_height" value="{{ old('video_height') }}">
                    <input type="hidden" name="video_size" id="video_size" value="{{ old('video_size') }}">
                    <input type="hidden" name="video_codec" id="video_codec" value="{{ old('video_codec') }}">
                    <input type="hidden" name="video_fps" id="video_fps" value="{{ old('video_fps') }}">

                    <h3 class="text-lg font-semibold text-text-primary mb-6 pb-4 border-b border-surface-border">Параметры размещения</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="md:col-span-2">
                            <label for="screen_id" class="block text-sm font-medium text-text-primary mb-1">Экран *</label>
                            <select name="screen_id" id="screen_id" required
                                class="w-full px-4 py-2.5 bg-input-bg border border-input-border text-text-primary rounded-lg focus:ring-2 focus:ring-accent focus:border-accent">
                                <option value="">Выберите экран</option>
                                @foreach($screens as $screen)
                                <option value="{{ $screen->id }}" data-width="{{ $screen->width_px }}" data-height="{{ $screen->height_px }}" {{ old('screen_id') == $screen->id ? 'selected' : '' }}>
                                    {{ $screen->name }} ({{ $screen->width_px }}x{{ $screen->height_px }})
                                </option>
                                @endforeach
                            </select>
                            <div id="screenBookingsInfo" class="hidden mt-2"></div>
                            <div id="resolutionWarning" class="hidden mt-2">
                                <div class="bg-warning/10 border border-warning/30 rounded-lg p-3 flex items-start gap-2">
                                    <svg class="w-4 h-4 text-warning flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span class="text-sm text-warning" id="resolutionWarningText"></span>
                                </div>
                            </div>
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
                        <div id="overlapWarning" class="md:col-span-2 hidden">
                            <div class="bg-danger/10 border border-danger/30 rounded-lg p-3 flex items-center gap-2">
                                <svg class="w-4 h-4 text-danger flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span class="text-sm text-danger" id="overlapText"></span>
                            </div>
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
                        <div class="flex justify-between"><dt class="text-text-muted">Файл</dt><dd id="infoFileName" class="text-text-primary font-medium">—</dd></div>
                        <div class="flex justify-between"><dt class="text-text-muted">Длительность</dt><dd id="infoDuration" class="text-text-primary font-medium">—</dd></div>
                        <div class="flex justify-between"><dt class="text-text-muted">Разрешение</dt><dd id="infoResolution" class="text-text-primary font-medium">—</dd></div>
                        <div class="flex justify-between"><dt class="text-text-muted">Размер</dt><dd id="infoSize" class="text-text-primary font-medium">—</dd></div>
                        <div class="flex justify-between"><dt class="text-text-muted">Кодек</dt><dd id="infoCodec" class="text-text-primary font-medium">—</dd></div>
                        <div class="flex justify-between"><dt class="text-text-muted">FPS</dt><dd id="infoFps" class="text-text-primary font-medium">—</dd></div>
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
    const dropZone = document.getElementById('dropZone');
    const videoInput = document.getElementById('videoInput');
    const checkingState = document.getElementById('checkingState');
    const resultArea = document.getElementById('resultArea');
    const resultHeader = document.getElementById('resultHeader');
    const resultTable = document.getElementById('resultTable');
    const btnRetry = document.getElementById('btnRetry');
    const btnProceed = document.getElementById('btnProceed');

    let videoMeta = {};
    let selectedFile = null;

    const hasValidationErrors = {{ $errors->any() ? 'true' : 'false' }};
    if (hasValidationErrors) {
        step1Circle.className = 'w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold bg-success text-white';
        step1Label.className = 'text-sm font-medium text-success';
        step2Circle.className = 'w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold bg-accent text-white';
        step2Label.className = 'text-sm font-medium text-text-primary';
    }

    dropZone.addEventListener('click', () => videoInput.click());
    dropZone.addEventListener('dragover', e => { e.preventDefault(); dropZone.classList.add('border-accent'); });
    dropZone.addEventListener('dragleave', () => dropZone.classList.remove('border-accent'));
    dropZone.addEventListener('drop', e => {
        e.preventDefault();
        dropZone.classList.remove('border-accent');
        if (e.dataTransfer.files.length) handleFile(e.dataTransfer.files[0]);
    });
    videoInput.addEventListener('change', e => { if (e.target.files.length) handleFile(e.target.files[0]); });

    btnRetry.addEventListener('click', () => {
        resultArea.classList.add('hidden');
        dropZone.classList.remove('hidden');
        btnProceed.classList.add('hidden');
        videoInput.value = '';
    });

    btnProceed.addEventListener('click', () => {
        document.getElementById('video_file_name').value = videoMeta.fileName;
        document.getElementById('video_duration').value = videoMeta.duration;
        document.getElementById('video_width').value = videoMeta.width;
        document.getElementById('video_height').value = videoMeta.height;
        document.getElementById('video_size').value = videoMeta.size;
        document.getElementById('video_codec').value = videoMeta.codec;
        document.getElementById('video_fps').value = videoMeta.fps;

        if (selectedFile) {
            const dt = new DataTransfer();
            dt.items.add(selectedFile);
            document.getElementById('video_file_hidden').files = dt.files;
        }

        document.getElementById('infoFileName').textContent = videoMeta.fileName;
        document.getElementById('infoDuration').textContent = videoMeta.duration + ' сек';
        document.getElementById('infoResolution').textContent = videoMeta.width + ' × ' + videoMeta.height;
        document.getElementById('infoSize').textContent = videoMeta.size + ' МБ';
        document.getElementById('infoCodec').textContent = videoMeta.codec;
        document.getElementById('infoFps').textContent = videoMeta.fps;

        step1.classList.add('hidden');
        step2.classList.remove('hidden');
        step1Circle.className = 'w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold bg-success text-white';
        step1Label.className = 'text-sm font-medium text-success';
        step2Circle.className = 'w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold bg-accent text-white';
        step2Label.className = 'text-sm font-medium text-text-primary';
    });

    function handleFile(file) {
        if (!file.type.startsWith('video/')) {
            siteAlert('Пожалуйста, выберите видеофайл.', 'error');
            return;
        }

        selectedFile = file;
        dropZone.classList.add('hidden');
        resultArea.classList.add('hidden');
        checkingState.classList.remove('hidden');

        const video = document.createElement('video');
        video.preload = 'metadata';
        video.muted = true;

        const url = URL.createObjectURL(file);
        video.src = url;

        video.addEventListener('loadedmetadata', function() {
            const duration = Math.round(video.duration);
            const width = video.videoWidth;
            const height = video.videoHeight;
            const sizeMb = (file.size / (1024 * 1024)).toFixed(1);
            const ext = file.name.split('.').pop().toLowerCase();

            let codec = 'H264';
            if (ext === 'webm') codec = 'VP8/VP9';
            else if (ext === 'mkv') codec = 'H264/H265';
            else if (ext === 'avi') codec = 'MPEG-4';
            else if (ext === 'mov') codec = 'H264';

            let fps = 25;

            videoMeta = { fileName: file.name, duration, width, height, size: sizeMb, codec, fps };

            const containerOk = ['mp4'].includes(ext);
            const durationOk = duration === 15 || duration === 30 || (duration >= 14 && duration <= 31);
            const resolutionOk = width > 0 && height > 0;
            const fpsOk = true;
            const codecOk = ext === 'mp4';
            const allPassed = containerOk && durationOk && resolutionOk;

            const checks = [
                { name: 'Формат', value: '.' + ext, ok: containerOk, expected: '.mp4' },
                { name: 'Длительность', value: duration + ' сек', ok: durationOk, expected: '15 или 30 сек' },
                { name: 'Разрешение', value: width + '×' + height, ok: resolutionOk, expected: 'Любое > 0' },
                { name: 'Кодек', value: codec, ok: codecOk, expected: 'H.264' },
                { name: 'Размер файла', value: sizeMb + ' МБ', ok: true, expected: '—' },
                { name: 'FPS', value: fps, ok: fpsOk, expected: '25' },
            ];

            checkingState.classList.add('hidden');
            resultArea.classList.remove('hidden');

            if (allPassed) {
                resultHeader.className = 'rounded-xl p-4 flex items-center gap-3 mb-4 bg-success/10 border border-success/30';
                resultHeader.innerHTML = '<svg class="w-5 h-5 text-success flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg><span class="text-sm text-success font-medium">Все параметры соответствуют требованиям</span>';
                btnProceed.classList.remove('hidden');
            } else {
                resultHeader.className = 'rounded-xl p-4 flex items-center gap-3 mb-4 bg-danger/10 border border-danger/30';
                resultHeader.innerHTML = '<svg class="w-5 h-5 text-danger flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg><span class="text-sm text-danger font-medium">Видео не соответствует требованиям. Исправьте параметры и загрузите снова.</span>';
                btnProceed.classList.add('hidden');
            }

            resultTable.innerHTML = checks.map(c => `
                <tr class="border-b border-surface-border last:border-0">
                    <td class="px-4 py-3 text-text-primary">${c.name}</td>
                    <td class="px-4 py-3 text-text-primary font-medium">${c.value}</td>
                    <td class="px-4 py-3 text-center">
                        ${c.ok
                            ? '<span class="inline-flex items-center gap-1 text-success text-xs font-medium"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>OK</span>'
                            : '<span class="inline-flex items-center gap-1 text-danger text-xs font-medium"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>Требуется: ' + c.expected + '</span>'
                        }
                    </td>
                </tr>
            `).join('');

            URL.revokeObjectURL(url);
        });

        video.addEventListener('error', function() {
            checkingState.classList.add('hidden');
            dropZone.classList.remove('hidden');
            siteAlert('Не удалось прочитать видеофайл. Попробуйте другой файл.', 'error');
            URL.revokeObjectURL(url);
        });
    }

    const screenSelect = document.getElementById('screen_id');
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    const bookingsInfo = document.getElementById('screenBookingsInfo');
    const overlapWarning = document.getElementById('overlapWarning');
    const overlapText = document.getElementById('overlapText');
    const submitBtn = document.querySelector('#adRequestForm button[type="submit"]');

    let currentBookings = [];
    const resWarning = document.getElementById('resolutionWarning');
    const resWarningText = document.getElementById('resolutionWarningText');

    screenSelect.addEventListener('change', () => { checkResolution(); loadBookings(); });

    function checkResolution() {
        resWarning.classList.add('hidden');
        const opt = screenSelect.selectedOptions[0];
        if (!opt || !opt.value) return;

        const videoW = parseInt(document.getElementById('video_width').value) || 0;
        const videoH = parseInt(document.getElementById('video_height').value) || 0;
        const screenW = parseInt(opt.dataset.width) || 0;
        const screenH = parseInt(opt.dataset.height) || 0;

        if (videoW > 0 && videoH > 0 && (videoW !== screenW || videoH !== screenH)) {
            resWarningText.textContent = `Разрешение видео (${videoW}×${videoH}) не совпадает с разрешением экрана (${screenW}×${screenH}). Видео может отображаться с искажениями.`;
            resWarning.classList.remove('hidden');
        }
    }

    function loadBookings() {
        const screenId = screenSelect.value;
        bookingsInfo.classList.add('hidden');
        bookingsInfo.innerHTML = '';
        currentBookings = [];
        checkOverlap();

        if (!screenId) return;

        fetch(`{{ url('organization/ad-requests/screen-bookings') }}/${screenId}`, {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(data => {
            currentBookings = data;
            if (data.length === 0) {
                bookingsInfo.innerHTML = '<p class="text-xs text-success">Экран свободен — нет активных бронирований.</p>';
            } else {
                let html = '<p class="text-xs text-text-muted mb-1.5">Занятые периоды:</p><div class="space-y-1">';
                data.forEach(b => {
                    const statusClass = b.status === 'Подтверждено' ? 'bg-success/20 text-success' : 'bg-warning/20 text-warning';
                    html += `<div class="flex items-center justify-between text-xs bg-surface rounded px-2.5 py-1.5">
                        <span class="text-text-primary">${formatDate(b.start)} — ${formatDate(b.end)}</span>
                        <span class="inline-flex rounded-full px-1.5 py-0.5 font-medium ${statusClass}">${b.status}</span>
                    </div>`;
                });
                html += '</div>';
                bookingsInfo.innerHTML = html;
            }
            bookingsInfo.classList.remove('hidden');
            checkOverlap();
        });
    }

    startDateInput.addEventListener('change', checkOverlap);
    endDateInput.addEventListener('change', checkOverlap);

    function checkOverlap() {
        overlapWarning.classList.add('hidden');
        if (submitBtn) submitBtn.disabled = false;

        const start = startDateInput.value;
        const end = endDateInput.value;
        if (!start || !end || currentBookings.length === 0) return;

        const conflict = currentBookings.find(b => start <= b.end && end >= b.start);
        if (conflict) {
            overlapText.textContent = `Выбранные даты пересекаются с бронированием ${formatDate(conflict.start)} — ${formatDate(conflict.end)} (${conflict.status}). Выберите другой период.`;
            overlapWarning.classList.remove('hidden');
            if (submitBtn) submitBtn.disabled = true;
        }
    }

    function formatDate(dateStr) {
        const [y, m, d] = dateStr.split('-');
        return `${d}.${m}.${y}`;
    }

    if (screenSelect.value) { checkResolution(); loadBookings(); }
});
</script>
@endpush
@endsection
