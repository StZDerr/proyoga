<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LoadPageContent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Получаем текущий маршрут
        $routeName = $request->route() ? $request->route()->getName() : null;
        $path = $request->path();

        // Определяем slug страницы на основе маршрута или пути
        $slug = $this->getSlugFromRoute($routeName, $path);

        // Отладочная информация (удалить в продакшене)
        if (config('app.debug')) {
            \Log::info('LoadPageContent middleware:', [
                'route' => $routeName,
                'path' => $path,
                'slug' => $slug,
            ]);
        }

        if ($slug) {
            try {
                // Загружаем мета-данные и делимся ими с представлением ДО формирования response
                $meta = \App\Helpers\PageContentHelper::getMeta($slug);
                view()->share('pageMeta', $meta);

                // Загружаем контент страницы
                $content = \App\Helpers\PageContentHelper::getContent($slug);
                view()->share('pageContent', $content);

                // Отладочная информация
                if (config('app.debug')) {
                    \Log::info("Meta data loaded for slug: {$slug}", $meta);
                }
            } catch (\Exception $e) {
                \Log::error('Error loading page content: '.$e->getMessage());
            }
        }

        $response = $next($request);

        return $response;
    }

    /**
     * Определяет slug страницы на основе имени маршрута или пути
     */
    private function getSlugFromRoute($routeName, $path): ?string
    {
        // Сначала проверяем корневой домен (главная страница)
        if ($path === '/' || $routeName === 'welcome') {
            return 'home';
        }

        $routeToSlugMap = [
            'welcome' => 'home',
            'about' => 'about',
            'contacts' => 'contact',
            'direction' => 'services',
        ];

        return $routeToSlugMap[$routeName] ?? null;
    }
}
