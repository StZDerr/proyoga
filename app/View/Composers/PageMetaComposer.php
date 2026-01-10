<?php

namespace App\View\Composers;

use App\Helpers\PageContentHelper;
use App\Models\IndexablePage;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class PageMetaComposer
{
    /**
     * Привязываем данные к представлению
     */
    public function compose(View $view)
    {
        // Получаем текущий маршрут
        $request = request();
        $routeName = $request->route()?->getName();
        $path = $request->path();

        // Определяем slug
        $slug = $this->getSlugFromRoute($routeName, $path);

        if (! $slug) {
            return;
        }

        // Кешируем мета-данные и флаги индексации по конкретному URL
        $cacheKey = 'page_meta:'.md5($request->fullUrl());

        $metaPayload = Cache::remember($cacheKey, now()->addMinutes(60), function () use ($slug, $path) {
            return [
                'pageMeta' => PageContentHelper::getMeta($slug),
                'pageContent' => PageContentHelper::getContent($slug),
                'isPageIndexed' => IndexablePage::isPageIndexed($path),
            ];
        });

        $view->with('pageMeta', $metaPayload['pageMeta']);
        $view->with('pageContent', $metaPayload['pageContent']);
        $view->with('isPageIndexed', $metaPayload['isPageIndexed']);
    }

    /**
     * Определяет slug страницы на основе имени маршрута или пути
     */
    private function getSlugFromRoute($routeName, $path): ?string
    {
        // Если это корневая страница
        if ($path === '/' || $routeName === 'welcome') {
            return 'home';
        }

        // Маппинг маршрутов на slug'и
        $routeToSlugMap = [
            'welcome' => 'home',
            'about' => 'about',
            'contacts' => 'contacts',
            'direction' => 'direction',
            'price-list' => 'price-list',
            'tea' => 'tea',
        ];

        // Если есть прямой маппинг маршрута
        if (isset($routeToSlugMap[$routeName])) {
            return $routeToSlugMap[$routeName];
        }

        // Специальная обработка для динамических маршрутов
        if ($routeName === 'subSubCategoryDetail' || $routeName === 'PodDirection') {
            // Для динамических страниц используем полный путь
            return $path;
        }

        // Для остальных динамических страниц проверяем, есть ли запись в indexable_pages
        $indexablePage = IndexablePage::where('url', $path)->first();
        if ($indexablePage) {
            return $path; // Используем полный путь как slug
        }

        // Возвращаем имя маршрута как slug
        return $routeName;
    }
}
