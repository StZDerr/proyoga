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
        if (!$settings->sitemap_enabled) {
            abort(404, 'Sitemap отключен в настройках');
        }
        
        // Получаем только индексируемые страницы
        $staticPages = IndexablePage::getIndexablePages();
        
        // Получаем динамические страницы
        $dynamicPages = $this->getDynamicPages();
        
        // Объединяем все страницы
        $allPages = $staticPages->concat($dynamicPages);
        
        // Генерируем XML-контент
        $xmlContent = '<?xml version="1.0" encoding="UTF-8"?>' . "\n" . 
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
                $pages->push((object)[
                    'url' => '/direction/' . $subCategory->slug,
                    'priority' => 0.8,
                    'changefreq' => 'weekly',
                    'last_modified' => $subCategory->updated_at,
                ]);
            }
        }

        // Добавляем страницы под-подкатегорий: /direction/{subCategory}/{subSubCategory}
        $subSubCategories = SubSubCategory::with('subCategory')->get();
        foreach ($subSubCategories as $subSubCategory) {
            if ($subSubCategory->subCategory && $subSubCategory->subCategory->slug && $subSubCategory->slug) {
                $pages->push((object)[
                    'url' => '/direction/' . 
                            $subSubCategory->subCategory->slug . '/' . 
                            $subSubCategory->slug,
                    'priority' => 0.7,
                    'changefreq' => 'weekly',
                    'last_modified' => $subSubCategory->updated_at,
                ]);
            }
        }

        return $pages;
    }
}