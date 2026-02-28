@extends('layouts.app')

@section('title', 'О ТРЦ')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-white mb-10">О ТРЦ «Европейский»</h1>

    <div class="space-y-12">
        <section class="bg-card rounded-xl border border-surface-border p-8">
            <h2 class="text-xl font-semibold text-white mb-4">О центре</h2>
            <p class="text-text-secondary leading-relaxed">ТРЦ «Европейский» — один из крупнейших торгово-развлекательных центров Москвы, расположенный на площади Киевского вокзала. В центре представлено более 392 магазинов, ресторанов и развлекательных заведений. Современная инфраструктура и удобное расположение делают «Европейский» популярным местом для шопинга и отдыха.</p>
        </section>

        <section class="bg-card rounded-xl border border-surface-border p-8">
            <h2 class="text-xl font-semibold text-white mb-4">Мероприятия в ТРЦ</h2>
            <p class="text-text-secondary leading-relaxed mb-4">ТРЦ «Европейский» регулярно проводит яркие мероприятия — концерты, выставки, детские праздники, промо-акции и презентации. Вы можете организовать своё мероприятие в одной из 8 зон торгового центра.</p>
            <a href="{{ route('event-request.create') }}" class="inline-flex items-center px-6 py-3 bg-gold/20 text-gold hover:bg-gold hover:text-white rounded-lg font-medium transition-colors border border-gold/30">Организовать мероприятие</a>
        </section>

        <section class="bg-card rounded-xl border border-surface-border p-8">
            <h2 class="text-xl font-semibold text-white mb-4">Реклама в ТРЦ</h2>
            <p class="text-text-secondary leading-relaxed mb-4">В торговом центре размещено 34 рекламных экрана и 8 рекламных зон в ключевых точках с высокой проходимостью. Размещение рекламы в «Европейском» позволяет охватить широкую аудиторию посетителей.</p>
            <a href="{{ route('ad-request.create') }}" class="inline-flex items-center px-6 py-3 bg-accent hover:bg-accent-hover text-white rounded-lg font-medium transition-colors">Разместить рекламу</a>
        </section>

        <section class="bg-surface-lighter rounded-xl border border-surface-border p-8">
            <h2 class="text-xl font-semibold text-white mb-6">Контакты</h2>
            <dl class="space-y-4">
                <div>
                    <dt class="text-sm text-text-muted">Адрес</dt>
                    <dd class="mt-1 text-text-primary">Москва, площадь Киевского вокзала, 2</dd>
                </div>
                <div>
                    <dt class="text-sm text-text-muted">Метро</dt>
                    <dd class="mt-1 text-text-primary">ст. метро «Киевская»</dd>
                </div>
                <div>
                    <dt class="text-sm text-text-muted">Телефон</dt>
                    <dd class="mt-1 text-text-primary">+7 (495) 921-34-44</dd>
                </div>
                <div>
                    <dt class="text-sm text-text-muted">Режим работы</dt>
                    <dd class="mt-1 text-text-primary">Пн-Чт, Вс: 10:00–22:00</dd>
                    <dd class="mt-0.5 text-text-primary">Пт-Сб: 10:00–23:00</dd>
                </div>
            </dl>
        </section>
    </div>
</div>
@endsection
