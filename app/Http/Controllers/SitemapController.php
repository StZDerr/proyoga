<?php

namespace App\Http\Controllers;

use App\Models\IndexablePage;
use App\Models\IndexingSettings;

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
        $pages = IndexablePage::getIndexablePages();
        
        // Генерируем XML-контент
        $xmlContent = '<?xml version="1.0" encoding="UTF-8"?>' . "\n" . 
                     view('sitemap.index', compact('pages'))->render();
        
        return response($xmlContent)
            ->header('Content-Type', 'application/xml')
            ->header('Cache-Control', 'public, max-age=3600'); // Кэш на 1 час
    }
}