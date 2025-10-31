<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class PageContentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // View Composer для автоматической загрузки мета-данных
        view()->composer('*', function ($view) {
            $request = request();
            $routeName = $request->route() ? $request->route()->getName() : null;
            $path = $request->path();

            // Определяем slug страницы
            $slug = $this->getSlugFromRoute($routeName, $path);

            if ($slug && ! $view->offsetExists('pageMeta')) {
                try {
                    $meta = \App\Helpers\PageContentHelper::getMeta($slug);
                    $content = \App\Helpers\PageContentHelper::getContent($slug);

                    $view->with('pageMeta', $meta);
                    $view->with('pageContent', $content);
                } catch (\Exception $e) {
                    \Log::error('Error loading page content in composer: '.$e->getMessage());
                }
            }
        });
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
