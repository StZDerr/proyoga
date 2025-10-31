<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreatePagesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pages:create-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Создать все необходимые страницы в БД';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $pages = [
            [
                'slug' => 'direction',
                'title' => 'Направления йоги - ProYoga студия',
                'description' => 'Ознакомьтесь с различными направлениями йоги в студии ProYoga. Хатха йога, виньяса, аштанга, кундалини и другие стили.',
                'keywords' => 'направления йоги, хатха йога, виньяса йога, аштанга йога, кундалини йога, стили йоги',
                'content' => '<h1>Направления йоги в ProYoga</h1><p>Выберите подходящий для вас стиль йоги.</p>',
                'seo_data' => [
                    'og_title' => 'Направления йоги в ProYoga',
                    'og_description' => 'Все стили и направления йоги в одной студии',
                    'og_image' => '/images/og-direction.jpg',
                ],
            ],
            [
                'slug' => 'price-list',
                'title' => 'Прайс-лист - Цены на йогу в ProYoga',
                'description' => 'Актуальные цены на занятия йогой в студии ProYoga. Абонементы, разовые занятия, персональные тренировки.',
                'keywords' => 'цены на йогу, прайс-лист, абонементы, стоимость занятий йогой',
                'content' => '<h1>Прайс-лист ProYoga</h1><p>Доступные цены и тарифы.</p>',
                'seo_data' => [
                    'og_title' => 'Цены на йогу в ProYoga',
                    'og_description' => 'Доступные тарифы и абонементы',
                    'og_image' => '/images/og-price.jpg',
                ],
            ],
            [
                'slug' => 'contacts',
                'title' => 'Контакты - Студия йоги ProYoga',
                'description' => 'Контактная информация студии йоги ProYoga: адрес, телефон, email, время работы. Как найти и связаться с нами.',
                'keywords' => 'контакты, адрес студии йоги, телефон, email, как добраться',
                'content' => '<h1>Контакты ProYoga</h1><p>Свяжитесь с нами любым удобным способом.</p>',
                'seo_data' => [
                    'og_title' => 'Контакты ProYoga',
                    'og_description' => 'Найдите нас и запишитесь на занятия',
                    'og_image' => '/images/og-contacts.jpg',
                ],
            ],
            [
                'slug' => 'tea',
                'title' => 'Чайная церемония - ProYoga',
                'description' => 'Присоединяйтесь к нашим чайным церемониям в студии ProYoga. Медитативное чаепитие и общение.',
                'keywords' => 'чайная церемония, медитативное чаепитие, релаксация, общение',
                'content' => '<h1>Чайная церемония</h1><p>Место для медитативного чаепития.</p>',
                'seo_data' => [
                    'og_title' => 'Чайная церемония ProYoga',
                    'og_description' => 'Медитативное чаепитие в уютной атмосфере',
                    'og_image' => '/images/og-tea.jpg',
                ],
            ],
        ];

        foreach ($pages as $pageData) {
            $pageData['is_active'] = true;

            $existing = \App\Models\PageContent::where('slug', $pageData['slug'])->first();

            if ($existing) {
                $this->info("Страница '{$pageData['slug']}' уже существует - пропускаем");

                continue;
            }

            \App\Models\PageContent::create($pageData);
            $this->info("✓ Создана страница: {$pageData['slug']} - {$pageData['title']}");
        }

        $this->info('Готово! Все страницы созданы.');
    }
}
