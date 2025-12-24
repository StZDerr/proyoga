<?php

namespace App\Http\Controllers;

use App\Models\IndexablePage;
use App\Models\IndexingSettings;
use App\Models\SubCategory;
use App\Models\SubSubCategory;

class SitemapController extends Controller
{
    public function index()
    {
        $settings = IndexingSettings::current();

        // Проверяем, включен ли sitemap
        if (! $settings->sitemap_enabled) {
            abort(404, 'Sitemap отключен в настройках');
        }

        // Получаем только индексируемые страницы
        $staticPages = IndexablePage::getIndexablePages();

        // Получаем динамические страницы
        $dynamicPages = $this->getDynamicPages();

        // Объединяем все страницы и удаляем дубликаты по нормализованному URL
        $allPages = $staticPages->concat($dynamicPages)
            ->unique(function ($item) {
                // Нормализуем URL: убираем ведущие слеши и приводим к нижнему регистру
                $url = isset($item->url) ? (string) $item->url : '';

                return strtolower(trim($url, '/'));
            })
            ->values();

        // Генерируем XML-контент
        $xmlContent = '<?xml version="1.0" encoding="UTF-8"?>'."\n".
                     view('sitemap.index', compact('allPages'))->render();

        return response($xmlContent)
            ->header('Content-Type', 'application/xml')
            ->header('Cache-Control', 'public, max-age=3600'); // Кэш на 1 час
    }

    /**
     * Получить динамические страницы для sitemap
     */
    private function getDynamicPages()
    {
        $pages = collect();

        // Добавляем страницы подкатегорий: /direction/{subCategory}
        $subCategories = SubCategory::all();
        foreach ($subCategories as $subCategory) {
            if ($subCategory->slug) {
                $url = $subCategory->slug;

                // Синхронизируем с indexable_pages
                $indexablePage = IndexablePage::firstOrCreate(
                    ['url' => $url],
                    [
                        'title' => $subCategory->title ?? 'Подкатегория',
                        'description' => $subCategory->description ?? '',
                        'priority' => 0.8,
                        'changefreq' => 'weekly',
                        'is_indexed' => true,
                        'last_modified' => $subCategory->updated_at,
                    ]
                );

                // Обновляем last_modified
                if ($indexablePage->last_modified < $subCategory->updated_at) {
                    $indexablePage->update(['last_modified' => $subCategory->updated_at]);
                }

                // Добавляем только если индексируется
                if ($indexablePage->is_indexed) {
                    $pages->push((object) [
                        'url' => $url,
                        'priority' => $indexablePage->priority,
                        'changefreq' => $indexablePage->changefreq,
                        'last_modified' => $indexablePage->last_modified,
                    ]);
                }
            }
        }

        // Добавляем страницы под-подкатегорий: /direction/{subCategory}/{subSubCategory}
        $subSubCategories = SubSubCategory::with('subCategory')->get();
        foreach ($subSubCategories as $subSubCategory) {
            if ($subSubCategory->subCategory && $subSubCategory->subCategory->slug && $subSubCategory->slug) {
                $url = $subSubCategory->subCategory->slug.'/'.
                       $subSubCategory->slug;

                // Синхронизируем с indexable_pages
                $indexablePage = IndexablePage::firstOrCreate(
                    ['url' => $url],
                    [
                        'title' => $subSubCategory->title ?? 'Направление',
                        'description' => $subSubCategory->description ?? '',
                        'priority' => 0.7,
                        'changefreq' => 'weekly',
                        'is_indexed' => true,
                        'last_modified' => $subSubCategory->updated_at,
                    ]
                );

                // Обновляем last_modified
                if ($indexablePage->last_modified < $subSubCategory->updated_at) {
                    $indexablePage->update(['last_modified' => $subSubCategory->updated_at]);
                }

                // Добавляем только если индексируется
                if ($indexablePage->is_indexed) {
                    $pages->push((object) [
                        'url' => $url,
                        'priority' => $indexablePage->priority,
                        'changefreq' => $indexablePage->changefreq,
                        'last_modified' => $indexablePage->last_modified,
                    ]);
                }
            }
        }

        return $pages;
    }
}
