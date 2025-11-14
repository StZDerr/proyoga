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

        // Если есть именованный маршрут
        if ($routeName && isset($routeToSlugMap[$routeName])) {
            return $routeToSlugMap[$routeName];
        }

        // Для динамических страниц проверяем в IndexablePage
        $indexablePage = IndexablePage::where('url', $path)->first();
        if ($indexablePage) {
            return $path; // Используем сам путь как slug для динамических страниц
        }

        // Фоллбек - используем имя маршрута если есть
        return $routeName;
    }
}
