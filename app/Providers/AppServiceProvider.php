<?php

namespace App\Providers;

use App\Models\ExternalService;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Подключаем Helpers
        if (file_exists(app_path('Helpers/PageContentHelper.php'))) {
            require_once app_path('Helpers/PageContentHelper.php');
        }

        // Общие настройки сайта кешируем единоразово
        $setting = Cache::remember('site_settings', now()->addDay(), function () {
            return Setting::current();
        });
        View::share('setting', $setting);

        // Мета и внешние сервисы подключаем только там, где реально рендерится <head>
        View::composer(['components.seo-meta', 'layouts.app'], \App\View\Composers\PageMetaComposer::class);

        View::composer(['components.seo-meta', 'layouts.app'], function ($view) {
            $externalServices = Cache::remember('external_services_active', now()->addMinutes(60), function () {
                return ExternalService::active()->get();
            });

            $view->with('externalServices', $externalServices);
        });

        View::composer(['partials.navbar', 'partials.footer'], function ($view) use ($setting) {
            $view->with('setting', $setting);
        });
    }
}
