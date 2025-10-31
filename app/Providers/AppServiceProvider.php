<?php

namespace App\Providers;

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
        // Добавляем в компилятор класс для автозагрузки
        if (file_exists(app_path('Helpers/PageContentHelper.php'))) {
            require_once app_path('Helpers/PageContentHelper.php');
        }
    }
}
