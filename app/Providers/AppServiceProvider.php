<?php

namespace App\Providers;

use App\Models\ExternalService;
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

        // Регистрируем основной View Composer
        View::composer('*', \App\View\Composers\PageMetaComposer::class);

        // Подгружаем активные ExternalService во все view
        View::composer('*', function ($view) {
            $view->with('externalServices', ExternalService::active()->get());
        });
    }
}
