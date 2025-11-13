<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndexablePage extends Model
{
    protected $fillable = [
        'url',
        'title',
        'description',
        'priority',
        'changefreq',
        'is_indexed',
        'last_modified',
        'notes',
    ];

    protected $casts = [
        'is_indexed' => 'boolean',
        'last_modified' => 'datetime',
        'priority' => 'decimal:1',
    ];

    /**
     * Получить все индексируемые страницы
     */
    public static function getIndexablePages()
    {
        return self::where('is_indexed', true)->orderBy('priority', 'desc')->get();
    }

    /**
     * Проверить, индексируется ли страница по URL
     */
    public static function isPageIndexed($url)
    {
        // Убираем ведущий слэш для сравнения
        $url = ltrim($url, '/');
        
        $page = self::where('url', $url)
            ->orWhere('url', '/' . $url)
            ->first();
        
        if (!$page) {
            // Если страница не найдена в БД, по умолчанию индексируется
            return true;
        }
        
        return $page->is_indexed;
    }

    /**
     * Создать дефолтные страницы если их нет
     */
    public static function createDefaultPages()
    {
        $defaultPages = [
            [
                'url' => '/',
                'title' => 'Главная страница',
                'description' => 'Главная страница студии йоги ИстокиЯ',
                'priority' => 1.0,
                'changefreq' => 'weekly',
                'is_indexed' => true,
                'last_modified' => now(),
            ],
            [
                'url' => '/about',
                'title' => 'О нас',
                'description' => 'Информация о студии йоги ИстокиЯ',
                'priority' => 0.8,
                'changefreq' => 'monthly',
                'is_indexed' => true,
                'last_modified' => now(),
            ],
            [
                'url' => '/direction',
                'title' => 'Направления',
                'description' => 'Направления йоги в студии ИстокиЯ',
                'priority' => 0.9,
                'changefreq' => 'monthly',
                'is_indexed' => true,
                'last_modified' => now(),
            ],
            [
                'url' => '/price-list',
                'title' => 'Прайс-лист',
                'description' => 'Цены на занятия йогой',
                'priority' => 0.8,
                'changefreq' => 'monthly',
                'is_indexed' => true,
                'last_modified' => now(),
            ],
            [
                'url' => '/contacts',
                'title' => 'Контакты',
                'description' => 'Контактная информация студии',
                'priority' => 0.7,
                'changefreq' => 'monthly',
                'is_indexed' => true,
                'last_modified' => now(),
            ],
            [
                'url' => '/tea',
                'title' => 'Чайная церемония',
                'description' => 'Чайные церемонии в студии',
                'priority' => 0.7,
                'changefreq' => 'monthly',
                'is_indexed' => true,
                'last_modified' => now(),
            ],
            [
                'url' => '/calendar',
                'title' => 'Календарь занятий',
                'description' => 'Расписание занятий йогой в студии ИстокиЯ',
                'priority' => 0.9,
                'changefreq' => 'weekly',
                'is_indexed' => true,
                'last_modified' => now(),
            ],
            [
                'url' => '/recording',
                'title' => 'Запись на занятия',
                'description' => 'Онлайн запись на занятия йогой',
                'priority' => 0.8,
                'changefreq' => 'weekly',
                'is_indexed' => true,
                'last_modified' => now(),
            ],
            [
                'url' => '/privacy-policy',
                'title' => 'Политика конфиденциальности',
                'description' => 'Политика конфиденциальности сайта',
                'priority' => 0.3,
                'changefreq' => 'yearly',
                'is_indexed' => true,
                'last_modified' => now(),
            ],
            [
                'url' => '/personal-data',
                'title' => 'Обработка персональных данных',
                'description' => 'Согласие на обработку персональных данных',
                'priority' => 0.3,
                'changefreq' => 'yearly',
                'is_indexed' => true,
                'last_modified' => now(),
            ],
        ];

        foreach ($defaultPages as $page) {
            self::firstOrCreate(['url' => $page['url']], $page);
        }
    }
}
