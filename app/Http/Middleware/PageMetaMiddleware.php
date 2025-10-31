<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Helpers\PageContentHelper;

class PageMetaMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Получаем имя маршрута и путь
        $routeName = $request->route()?->getName();
        $path = $request->path();
        
        // Определяем slug на основе маршрута
        $slug = $this->getSlugFromRoute($routeName, $path);
        
        if ($slug) {
            // Загружаем мета-данные и контент для страницы
            $pageMeta = PageContentHelper::getMeta($slug);
            $pageContent = PageContentHelper::getContent($slug);
            
            // Делимся данными со всеми представлениями
            view()->share('pageMeta', $pageMeta);
            view()->share('pageContent', $pageContent);
        }

        return $next($request);
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

        // Возвращаем соответствующий slug или имя маршрута как slug
        return $routeToSlugMap[$routeName] ?? $routeName;
    }
}
