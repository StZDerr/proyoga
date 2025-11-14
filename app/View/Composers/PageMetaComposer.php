<?php

namespace App\View\Composers;

use Illuminate\View\View;
use App\Helpers\PageContentHelper;
use App\Models\IndexablePage;

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

        if ($slug) {
            // Загружаем мета-данные
            $pageMeta = PageContentHelper::getMeta($slug);
            $pageContent = PageContentHelper::getContent($slug);

            // Проверяем индексацию страницы
            $isPageIndexed = IndexablePage::isPageIndexed($path);

            // Передаём в view
            $view->with('pageMeta', $pageMeta);
            $view->with('pageContent', $pageContent);
            $view->with('isPageIndexed', $isPageIndexed);
        }
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
