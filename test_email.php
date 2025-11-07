<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Testing email with log driver...\n\n";

$data = [
    'name' => 'Тестовый пользователь',
    'phone' => '+7 (999) 123-45-67',
    'email' => 'test@example.com',
    'message' => 'Тестовое сообщение для проверки',
    'page_url' => 'http://127.0.0.1:8000/about',
    'page_title' => 'О нас - Йога студия ИстокиЯ',
];

$adminEmails = ['it@sumnikoff.ru', 'istokiya@yandex.ru'];

// Отправляем задачу в очередь
\App\Jobs\SendContactEmail::dispatch($data, $adminEmails);

echo "✓ Job dispatched successfully!\n";
echo "Now run: php artisan queue:work\n";
echo "Check logs: storage/logs/laravel.log\n";
