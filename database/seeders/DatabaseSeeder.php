<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventStatus;
use App\Models\MediaFile;
use App\Models\MediaStatus;
use App\Models\Role;
use App\Models\Screen;
use App\Models\ScreenBooking;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Zone;
use App\Models\ZoneBooking;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->seedRoles();
        $this->seedUsers();
        $this->seedEventStatuses();
        $this->seedMediaStatuses();
        $this->seedScreens();
        $this->seedZones();
        $this->seedTenants();
        $this->seedEvents();
        $this->seedMediaFiles();
        $this->seedZoneBookings();
        $this->seedScreenBookings();
    }

    private function seedRoles(): void
    {
        $roles = [
            ['name' => 'admin', 'description' => 'Администратор системы'],
            ['name' => 'manager', 'description' => 'Менеджер ТРЦ'],
            ['name' => 'tenant', 'description' => 'Арендатор'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }

    private function seedUsers(): void
    {
        User::create([
            'role_id' => 1,
            'name' => 'Администратор',
            'email' => 'admin@trc.ru',
            'password' => Hash::make('password'),
            'phone' => '+7 (495) 100-00-01',
            'is_active' => true,
        ]);

        User::create([
            'role_id' => 2,
            'name' => 'Иванов Пётр Сергеевич',
            'email' => 'manager@trc.ru',
            'password' => Hash::make('password'),
            'phone' => '+7 (495) 100-00-02',
            'is_active' => true,
        ]);

        $tenantUsers = [
            ['name' => 'Смирнова Анна Владимировна', 'email' => 'smirnova@company.ru', 'phone' => '+7 (495) 200-00-01'],
            ['name' => 'Козлов Дмитрий Игоревич', 'email' => 'kozlov@brand.ru', 'phone' => '+7 (495) 200-00-02'],
            ['name' => 'Петрова Елена Александровна', 'email' => 'petrova@shop.ru', 'phone' => '+7 (495) 200-00-03'],
            ['name' => 'Волков Артём Николаевич', 'email' => 'volkov@media.ru', 'phone' => '+7 (495) 200-00-04'],
            ['name' => 'Новикова Мария Дмитриевна', 'email' => 'novikova@retail.ru', 'phone' => '+7 (495) 200-00-05'],
        ];

        foreach ($tenantUsers as $user) {
            User::create([
                'role_id' => 3,
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make('password'),
                'phone' => $user['phone'],
                'is_active' => true,
            ]);
        }
    }

    private function seedEventStatuses(): void
    {
        $statuses = ['Планируется', 'Подтверждено', 'Активно', 'Завершено', 'Отменено'];

        foreach ($statuses as $status) {
            EventStatus::create(['name' => $status]);
        }
    }

    private function seedMediaStatuses(): void
    {
        $statuses = ['На модерации', 'Одобрено', 'Отклонено', 'Архив'];

        foreach ($statuses as $status) {
            MediaStatus::create(['name' => $status]);
        }
    }

    private function seedScreens(): void
    {
        $screens = [
            ['name' => 'Москва, межэтажка', 'location' => 'Зал Москва, межэтажное пространство', 'floor' => '1', 'zone_name' => 'Москва', 'width_px' => 8192, 'height_px' => 1056, 'has_night_version' => false, 'pos_x' => 45, 'pos_y' => 30],
            ['name' => 'Лифты (2944x320)', 'location' => 'Лифтовые зоны', 'floor' => '1', 'zone_name' => 'Лифты', 'width_px' => 2944, 'height_px' => 320, 'has_night_version' => false, 'pos_x' => 70, 'pos_y' => 50],
            ['name' => 'Лифты (256x512)', 'location' => 'Лифтовые зоны', 'floor' => '1', 'zone_name' => 'Лифты', 'width_px' => 256, 'height_px' => 512, 'has_night_version' => false, 'pos_x' => 72, 'pos_y' => 55],
            ['name' => 'Лифты (384x512)', 'location' => 'Лифтовые зоны', 'floor' => '2', 'zone_name' => 'Лифты', 'width_px' => 384, 'height_px' => 512, 'has_night_version' => false, 'pos_x' => 70, 'pos_y' => 50],
            ['name' => 'Лифты (512x512)', 'location' => 'Лифтовые зоны', 'floor' => '3', 'zone_name' => 'Лифты', 'width_px' => 512, 'height_px' => 512, 'has_night_version' => false, 'pos_x' => 70, 'pos_y' => 50],
            ['name' => 'Москва, колонны', 'location' => 'Зал Москва, колонны', 'floor' => '1', 'zone_name' => 'Москва', 'width_px' => 768, 'height_px' => 896, 'has_night_version' => false, 'pos_x' => 40, 'pos_y' => 45],
            ['name' => 'Межэт. у эскалаторов (6-7 эт.)', 'location' => 'Эскалаторы между 6 и 7 этажами', 'floor' => '6', 'zone_name' => 'Эскалаторы', 'width_px' => 1792, 'height_px' => 256, 'has_night_version' => false, 'pos_x' => 50, 'pos_y' => 40],
            ['name' => 'Межэт. у эскалаторов (5-6 эт.)', 'location' => 'Эскалаторы между 5 и 6 этажами', 'floor' => '5', 'zone_name' => 'Эскалаторы', 'width_px' => 2048, 'height_px' => 192, 'has_night_version' => false, 'pos_x' => 50, 'pos_y' => 40],
            ['name' => 'Межэт. у эскалаторов (4-5 эт.)', 'location' => 'Эскалаторы между 4 и 5 этажами, парковка', 'floor' => '4', 'zone_name' => 'Эскалаторы', 'width_px' => 2048, 'height_px' => 384, 'has_night_version' => false, 'pos_x' => 55, 'pos_y' => 35],
            ['name' => 'Межэт. у эскалаторов (4-5 эт.)', 'location' => 'Эскалаторы между 4 и 5 этажами', 'floor' => '4', 'zone_name' => 'Эскалаторы', 'width_px' => 1792, 'height_px' => 384, 'has_night_version' => false, 'pos_x' => 50, 'pos_y' => 40],
            ['name' => 'Межэт. у эскалаторов (3-4 эт.)', 'location' => 'Эскалаторы между 3 и 4 этажами', 'floor' => '3', 'zone_name' => 'Эскалаторы', 'width_px' => 2048, 'height_px' => 320, 'has_night_version' => false, 'pos_x' => 50, 'pos_y' => 40],
            ['name' => 'Межэт. у эскалаторов (2-3 эт.)', 'location' => 'Эскалаторы между 2 и 3 этажами', 'floor' => '2', 'zone_name' => 'Эскалаторы', 'width_px' => 2048, 'height_px' => 320, 'has_night_version' => false, 'pos_x' => 50, 'pos_y' => 40],
            ['name' => 'Межэт. у эскалаторов (1-2 эт.)', 'location' => 'Эскалаторы между 1 и 2 этажами', 'floor' => '1', 'zone_name' => 'Эскалаторы', 'width_px' => 2048, 'height_px' => 384, 'has_night_version' => false, 'pos_x' => 50, 'pos_y' => 60],
            ['name' => 'Межэт. у эскалаторов (0-1 эт.)', 'location' => 'Эскалаторы между 0 и 1 этажами', 'floor' => '0', 'zone_name' => 'Эскалаторы', 'width_px' => 2048, 'height_px' => 320, 'has_night_version' => false, 'pos_x' => 50, 'pos_y' => 40],
            ['name' => 'Берлин, межэтажка (1-2 эт.)', 'location' => 'Зал Берлин, 1-2 этажи', 'floor' => '1', 'zone_name' => 'Берлин', 'width_px' => 7168, 'height_px' => 384, 'has_night_version' => false, 'pos_x' => 25, 'pos_y' => 65],
            ['name' => 'Берлин, межэтажка (3 эт.)', 'location' => 'Зал Берлин, 3 этаж', 'floor' => '3', 'zone_name' => 'Берлин', 'width_px' => 8320, 'height_px' => 320, 'has_night_version' => false, 'pos_x' => 25, 'pos_y' => 65],
            ['name' => 'Париж, межэтажка', 'location' => 'Зал Париж, межэтажное пространство', 'floor' => '2', 'zone_name' => 'Париж', 'width_px' => 3840, 'height_px' => 352, 'has_night_version' => false, 'pos_x' => 75, 'pos_y' => 30],
            ['name' => 'Париж, напольные (наружные)', 'location' => 'Зал Париж, наружные напольные экраны', 'floor' => '2', 'zone_name' => 'Париж', 'width_px' => 3840, 'height_px' => 704, 'has_night_version' => false, 'pos_x' => 80, 'pos_y' => 25],
            ['name' => 'Париж, напольные (внутренние)', 'location' => 'Зал Париж, внутренние напольные экраны', 'floor' => '2', 'zone_name' => 'Париж', 'width_px' => 3840, 'height_px' => 800, 'has_night_version' => false, 'pos_x' => 78, 'pos_y' => 35],
            ['name' => 'Вход №3, тамбур', 'location' => 'Вход №3, тамбурная зона', 'floor' => '0', 'zone_name' => 'Входы', 'width_px' => 2176, 'height_px' => 1108, 'has_night_version' => false, 'pos_x' => 60, 'pos_y' => 80],
            ['name' => 'Full HD (колонна)', 'location' => 'Колонна, Full HD экран', 'floor' => '1', 'zone_name' => 'Москва', 'width_px' => 1920, 'height_px' => 1080, 'has_night_version' => false, 'pos_x' => 35, 'pos_y' => 40],
            ['name' => 'Фасады Дорогомиловская (4 шт.)', 'location' => 'Фасад, ул. Дорогомиловская', 'floor' => 'Фасад', 'zone_name' => 'Фасад', 'width_px' => 1152, 'height_px' => 792, 'has_night_version' => true, 'pos_x' => 20, 'pos_y' => 15],
            ['name' => 'Фасад Дорогомиловская (центральный)', 'location' => 'Фасад, ул. Дорогомиловская', 'floor' => 'Фасад', 'zone_name' => 'Фасад', 'width_px' => 1216, 'height_px' => 896, 'has_night_version' => true, 'pos_x' => 40, 'pos_y' => 10],
            ['name' => 'Фасады площадь Евразии (3 шт.)', 'location' => 'Фасад, площадь Евразии', 'floor' => 'Фасад', 'zone_name' => 'Фасад', 'width_px' => 576, 'height_px' => 544, 'has_night_version' => true, 'pos_x' => 65, 'pos_y' => 15],
            ['name' => 'Вход №1, левый', 'location' => 'Вход №1', 'floor' => '0', 'zone_name' => 'Входы', 'width_px' => 520, 'height_px' => 200, 'has_night_version' => true, 'pos_x' => 15, 'pos_y' => 50],
            ['name' => 'Вход №1, правый', 'location' => 'Вход №1', 'floor' => '0', 'zone_name' => 'Входы', 'width_px' => 560, 'height_px' => 200, 'has_night_version' => true, 'pos_x' => 18, 'pos_y' => 55],
            ['name' => 'Вход №2', 'location' => 'Вход №2', 'floor' => '0', 'zone_name' => 'Входы', 'width_px' => 840, 'height_px' => 200, 'has_night_version' => true, 'pos_x' => 35, 'pos_y' => 80],
            ['name' => 'Вход №3', 'location' => 'Вход №3', 'floor' => '0', 'zone_name' => 'Входы', 'width_px' => 1160, 'height_px' => 240, 'has_night_version' => false, 'pos_x' => 60, 'pos_y' => 85],
            ['name' => 'Вход №4', 'location' => 'Вход №4', 'floor' => '0', 'zone_name' => 'Входы', 'width_px' => 1240, 'height_px' => 240, 'has_night_version' => false, 'pos_x' => 80, 'pos_y' => 70],
            ['name' => 'Вход №5', 'location' => 'Вход №5', 'floor' => '0', 'zone_name' => 'Входы', 'width_px' => 1040, 'height_px' => 280, 'has_night_version' => false, 'pos_x' => 85, 'pos_y' => 50],
            ['name' => 'Витрина у входа №1', 'location' => 'Витрина рядом с входом №1', 'floor' => '0', 'zone_name' => 'Входы', 'width_px' => 360, 'height_px' => 216, 'has_night_version' => true, 'pos_x' => 12, 'pos_y' => 48],
            ['name' => 'Витрина у входа №2', 'location' => 'Витрина рядом с входом №2', 'floor' => '0', 'zone_name' => 'Входы', 'width_px' => 350, 'height_px' => 144, 'has_night_version' => true, 'pos_x' => 32, 'pos_y' => 78],
            ['name' => 'Берлин, напольный (2 эт.)', 'location' => 'Зал Берлин, напольный экран', 'floor' => '2', 'zone_name' => 'Берлин', 'width_px' => 2048, 'height_px' => 1408, 'has_night_version' => false, 'pos_x' => 25, 'pos_y' => 60],
            ['name' => 'Экран над выходом №3', 'location' => 'Над выходом №3', 'floor' => '0', 'zone_name' => 'Входы', 'width_px' => 4480, 'height_px' => 640, 'has_night_version' => false, 'pos_x' => 58, 'pos_y' => 82],
        ];

        foreach ($screens as $screen) {
            Screen::create(array_merge($screen, ['is_active' => true]));
        }
    }

    private function seedZones(): void
    {
        $zones = [
            ['name' => 'Атриум (центральная площадка)', 'floor' => '1', 'section' => 'Москва', 'area_sqm' => 150.00, 'price_per_day' => 50000.00, 'description' => 'Центральная площадка атриума для крупных мероприятий'],
            ['name' => 'Промо-зона у эскалаторов', 'floor' => '2', 'section' => 'Москва', 'area_sqm' => 30.00, 'price_per_day' => 15000.00, 'description' => 'Зона для промо-стоек и стендов'],
            ['name' => 'Выставочная зона Берлин', 'floor' => '1', 'section' => 'Берлин', 'area_sqm' => 80.00, 'price_per_day' => 35000.00, 'description' => 'Выставочное пространство в зале Берлин'],
            ['name' => 'Фуд-корт (промо-зона)', 'floor' => '3', 'section' => 'Париж', 'area_sqm' => 25.00, 'price_per_day' => 20000.00, 'description' => 'Промо-зона на фуд-корте'],
            ['name' => 'Входная группа №1', 'floor' => '0', 'section' => 'Вход', 'area_sqm' => 20.00, 'price_per_day' => 25000.00, 'description' => 'Зона у главного входа'],
            ['name' => 'Галерея 2 этаж', 'floor' => '2', 'section' => 'Берлин', 'area_sqm' => 45.00, 'price_per_day' => 18000.00, 'description' => 'Галерея второго этажа для выставок'],
            ['name' => 'Парковка (промо-зона)', 'floor' => '-1', 'section' => 'Парковка', 'area_sqm' => 40.00, 'price_per_day' => 8000.00, 'description' => 'Промо-зона на парковке'],
            ['name' => 'Детская зона', 'floor' => '3', 'section' => 'Москва', 'area_sqm' => 60.00, 'price_per_day' => 22000.00, 'description' => 'Зона для детских мероприятий и анимации'],
        ];

        foreach ($zones as $zone) {
            Zone::create(array_merge($zone, ['is_active' => true]));
        }
    }

    private function seedTenants(): void
    {
        $tenants = [
            ['user_id' => 3, 'company_name' => 'ООО "МедиаГрупп"', 'contact_person' => 'Смирнова А.В.', 'phone' => '+7 (495) 200-00-01', 'email' => 'info@mediagroup.ru', 'address' => 'г. Москва, ул. Тверская, д. 10', 'inn' => '7701234567'],
            ['user_id' => 4, 'company_name' => 'ИП Козлов Д.И.', 'contact_person' => 'Козлов Д.И.', 'phone' => '+7 (495) 200-00-02', 'email' => 'kozlov@brand.ru', 'address' => 'г. Москва, ул. Арбат, д. 5', 'inn' => '770987654321'],
            ['user_id' => 5, 'company_name' => 'ООО "РитейлПро"', 'contact_person' => 'Петрова Е.А.', 'phone' => '+7 (495) 200-00-03', 'email' => 'info@retailpro.ru', 'address' => 'г. Москва, Кутузовский пр-т, д. 20', 'inn' => '7702345678'],
            ['user_id' => 6, 'company_name' => 'ООО "ВидеоАрт"', 'contact_person' => 'Волков А.Н.', 'phone' => '+7 (495) 200-00-04', 'email' => 'info@videoart.ru', 'address' => 'г. Москва, ул. Новый Арбат, д. 15', 'inn' => '7703456789'],
            ['user_id' => 7, 'company_name' => 'ООО "ФэшнМолл"', 'contact_person' => 'Новикова М.Д.', 'phone' => '+7 (495) 200-00-05', 'email' => 'info@fashionmall.ru', 'address' => 'г. Москва, Ленинский пр-т, д. 30', 'inn' => '7704567890'],
        ];

        foreach ($tenants as $tenant) {
            Tenant::create(array_merge($tenant, ['is_active' => true]));
        }
    }

    private function seedEvents(): void
    {
        $events = [
            ['title' => 'Весенняя распродажа 2026', 'description' => 'Масштабная весенняя распродажа со скидками до 70%', 'status_id' => 1, 'organizer_id' => 2, 'start_date' => '2026-03-01 10:00:00', 'end_date' => '2026-03-15 22:00:00', 'location' => 'Весь ТРЦ', 'expected_visitors' => 50000, 'budget' => 500000.00],
            ['title' => 'Детский фестиваль "Весёлые каникулы"', 'description' => 'Развлекательная программа для детей: аниматоры, мастер-классы, конкурсы', 'status_id' => 2, 'organizer_id' => 2, 'start_date' => '2026-03-22 11:00:00', 'end_date' => '2026-03-29 20:00:00', 'location' => 'Зал Москва, 3 этаж', 'expected_visitors' => 15000, 'budget' => 200000.00],
            ['title' => 'Выставка современного искусства', 'description' => 'Экспозиция работ молодых художников', 'status_id' => 3, 'organizer_id' => 1, 'start_date' => '2026-02-15 10:00:00', 'end_date' => '2026-03-01 21:00:00', 'location' => 'Галерея, 2 этаж', 'expected_visitors' => 8000, 'budget' => 150000.00],
            ['title' => 'Ночь шопинга', 'description' => 'Ночная распродажа с DJ и развлекательной программой', 'status_id' => 4, 'organizer_id' => 2, 'start_date' => '2026-01-25 20:00:00', 'end_date' => '2026-01-26 02:00:00', 'location' => 'Весь ТРЦ', 'expected_visitors' => 20000, 'budget' => 300000.00],
            ['title' => 'Фуд-фестиваль "Вкусы мира"', 'description' => 'Дегустация блюд от ресторанов ТРЦ', 'status_id' => 1, 'organizer_id' => 2, 'start_date' => '2026-04-10 12:00:00', 'end_date' => '2026-04-12 21:00:00', 'location' => 'Фуд-корт, 3 этаж', 'expected_visitors' => 12000, 'budget' => 180000.00],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }

    private function seedMediaFiles(): void
    {
        $files = [
            ['tenant_id' => 1, 'file_name' => 'spring_sale_8192x1056.mp4', 'file_path' => 'media/tenant_1/spring_sale_8192x1056.mp4', 'original_name' => 'Весенняя распродажа.mp4', 'duration_sec' => 30, 'width_px' => 8192, 'height_px' => 1056, 'file_size_mb' => 280, 'codec' => 'H264', 'fps' => 25, 'status_id' => 2, 'reviewed_by' => 1],
            ['tenant_id' => 1, 'file_name' => 'promo_1920x1080.mp4', 'file_path' => 'media/tenant_1/promo_1920x1080.mp4', 'original_name' => 'Промо ролик.mp4', 'duration_sec' => 15, 'width_px' => 1920, 'height_px' => 1080, 'file_size_mb' => 120, 'codec' => 'H264', 'fps' => 25, 'status_id' => 2, 'reviewed_by' => 1],
            ['tenant_id' => 2, 'file_name' => 'brand_ad_2048x320.mp4', 'file_path' => 'media/tenant_2/brand_ad_2048x320.mp4', 'original_name' => 'Реклама бренда.mp4', 'duration_sec' => 15, 'width_px' => 2048, 'height_px' => 320, 'file_size_mb' => 85, 'codec' => 'H264', 'fps' => 25, 'status_id' => 2, 'reviewed_by' => 1],
            ['tenant_id' => 3, 'file_name' => 'new_collection_3840x352.mp4', 'file_path' => 'media/tenant_3/new_collection_3840x352.mp4', 'original_name' => 'Новая коллекция.mp4', 'duration_sec' => 30, 'width_px' => 3840, 'height_px' => 352, 'file_size_mb' => 200, 'codec' => 'H264', 'fps' => 25, 'status_id' => 1],
            ['tenant_id' => 4, 'file_name' => 'art_expo_768x896.mp4', 'file_path' => 'media/tenant_4/art_expo_768x896.mp4', 'original_name' => 'Выставка арт.mp4', 'duration_sec' => 30, 'width_px' => 768, 'height_px' => 896, 'file_size_mb' => 150, 'codec' => 'H264', 'fps' => 25, 'status_id' => 2, 'reviewed_by' => 1],
            ['tenant_id' => 5, 'file_name' => 'fashion_show_bad.mp4', 'file_path' => 'media/tenant_5/fashion_show_bad.mp4', 'original_name' => 'Показ мод.mp4', 'duration_sec' => 45, 'width_px' => 1920, 'height_px' => 1080, 'file_size_mb' => 350, 'codec' => 'H264', 'fps' => 30, 'status_id' => 3, 'reviewed_by' => 1, 'rejection_reason' => 'Длительность 45 сек (допустимо 15 или 30). Частота кадров 30 fps (требуется 25).'],
            ['tenant_id' => 2, 'file_name' => 'elevator_ad_256x512.mp4', 'file_path' => 'media/tenant_2/elevator_ad_256x512.mp4', 'original_name' => 'Реклама лифты.mp4', 'duration_sec' => 15, 'width_px' => 256, 'height_px' => 512, 'file_size_mb' => 40, 'codec' => 'H264', 'fps' => 25, 'status_id' => 2, 'reviewed_by' => 1],
            ['tenant_id' => 4, 'file_name' => 'facade_night_1152x792.mp4', 'file_path' => 'media/tenant_4/facade_night_1152x792.mp4', 'original_name' => 'Фасад ночь.mp4', 'duration_sec' => 15, 'width_px' => 1152, 'height_px' => 792, 'file_size_mb' => 95, 'codec' => 'H264', 'fps' => 25, 'status_id' => 2, 'reviewed_by' => 1],
        ];

        foreach ($files as $file) {
            MediaFile::create($file);
        }
    }

    private function seedZoneBookings(): void
    {
        $bookings = [
            ['zone_id' => 1, 'tenant_id' => 1, 'event_id' => 1, 'start_date' => '2026-03-01', 'end_date' => '2026-03-15', 'total_price' => 750000.00, 'status' => 'confirmed'],
            ['zone_id' => 2, 'tenant_id' => 2, 'event_id' => null, 'start_date' => '2026-03-10', 'end_date' => '2026-03-20', 'total_price' => 165000.00, 'status' => 'confirmed'],
            ['zone_id' => 4, 'tenant_id' => 3, 'event_id' => 5, 'start_date' => '2026-04-10', 'end_date' => '2026-04-12', 'total_price' => 60000.00, 'status' => 'pending'],
            ['zone_id' => 8, 'tenant_id' => 1, 'event_id' => 2, 'start_date' => '2026-03-22', 'end_date' => '2026-03-29', 'total_price' => 176000.00, 'status' => 'confirmed'],
            ['zone_id' => 6, 'tenant_id' => 4, 'event_id' => 3, 'start_date' => '2026-02-15', 'end_date' => '2026-03-01', 'total_price' => 270000.00, 'status' => 'confirmed'],
        ];

        foreach ($bookings as $booking) {
            ZoneBooking::create($booking);
        }
    }

    private function seedScreenBookings(): void
    {
        $bookings = [
            ['screen_id' => 1, 'media_id' => 1, 'tenant_id' => 1, 'start_date' => '2026-03-01', 'end_date' => '2026-03-15', 'plays_per_day' => 48, 'total_price' => 450000.00, 'status' => 'confirmed'],
            ['screen_id' => 21, 'media_id' => 2, 'tenant_id' => 1, 'start_date' => '2026-03-01', 'end_date' => '2026-03-31', 'plays_per_day' => 60, 'total_price' => 180000.00, 'status' => 'confirmed'],
            ['screen_id' => 11, 'media_id' => 3, 'tenant_id' => 2, 'start_date' => '2026-03-10', 'end_date' => '2026-03-25', 'plays_per_day' => 40, 'total_price' => 120000.00, 'status' => 'confirmed'],
            ['screen_id' => 6, 'media_id' => 5, 'tenant_id' => 4, 'start_date' => '2026-02-15', 'end_date' => '2026-03-01', 'plays_per_day' => 36, 'total_price' => 90000.00, 'status' => 'confirmed'],
            ['screen_id' => 22, 'media_id' => 8, 'tenant_id' => 4, 'start_date' => '2026-03-01', 'end_date' => '2026-03-31', 'plays_per_day' => 24, 'total_price' => 200000.00, 'status' => 'pending'],
            ['screen_id' => 3, 'media_id' => 7, 'tenant_id' => 2, 'start_date' => '2026-03-05', 'end_date' => '2026-03-20', 'plays_per_day' => 50, 'total_price' => 75000.00, 'status' => 'confirmed'],
        ];

        foreach ($bookings as $booking) {
            ScreenBooking::create($booking);
        }
    }
}
