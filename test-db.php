<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\PageContent;
use App\Helpers\PageContentHelper;

echo "=== Проверка данных в базе ===\n";

// Проверяем страницу home
$homePage = PageContent::where('slug', 'home')->first();

if ($homePage) {
    echo "✅ Страница 'home' найдена:\n";
    echo "- Title: " . $homePage->title . "\n";
    echo "- Description: " . $homePage->description . "\n";
    echo "- Keywords: " . $homePage->keywords . "\n";
    echo "- Active: " . ($homePage->is_active ? 'Да' : 'Нет') . "\n";
    echo "- SEO Data: " . json_encode($homePage->seo_data, JSON_UNESCAPED_UNICODE) . "\n";
} else {
    echo "❌ Страница 'home' не найдена в базе данных\n";
}

echo "\n=== Проверка через Helper ===\n";

// Проверяем через Helper
$meta = PageContentHelper::getMeta('home');
echo "Meta данные через Helper:\n";
print_r($meta);

echo "\n=== Список всех страниц ===\n";
$allPages = PageContent::all();
foreach ($allPages as $page) {
    echo "- ID: {$page->id}, Slug: {$page->slug}, Title: {$page->title} (активна: " . ($page->is_active ? 'Да' : 'Нет') . ")\n";
}