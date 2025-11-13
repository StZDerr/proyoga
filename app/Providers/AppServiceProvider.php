<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        // Добавляем в компилятор класс для автозагрузки
        if (file_exists(app_path('Helpers/PageContentHelper.php'))) {
            require_once app_path('Helpers/PageContentHelper.php');
        }

        // Регистрируем View Composer для всех страниц
        View::composer('*', \App\View\Composers\PageMetaComposer::class);
    }
}
