<?php

use App\Models\MainCategory;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Главная
Breadcrumbs::for('welcome', function (BreadcrumbTrail $trail) {
    $trail->push('Главная', route('welcome'));
});

// Чайная зона
Breadcrumbs::for('tea', function (BreadcrumbTrail $trail) {
    $trail->parent('welcome');
    $trail->push('Чайная зона', route('tea'));
});

// О нас
Breadcrumbs::for('about', function (BreadcrumbTrail $trail) {
    $trail->parent('welcome');
    $trail->push('О нас', route('about'));
});

// Прайс-лист
Breadcrumbs::for('price-list', function (BreadcrumbTrail $trail) {
    $trail->parent('welcome');
    $trail->push('Прайс-лист', route('price-list'));
});

// Направления
Breadcrumbs::for('direction', function (BreadcrumbTrail $trail) {
    $trail->parent('welcome');
    $trail->push('Направления', route('direction'));
});

// Основная категория направления (опционально)
Breadcrumbs::for('mainCategory', function (BreadcrumbTrail $trail, MainCategory $mainCategory) {
    $trail->parent('direction');
    $trail->push($mainCategory->title);
});

// Подкатегория направления
Breadcrumbs::for('PodDirection', function (BreadcrumbTrail $trail, SubCategory $subCategory) {
    // Показываем путь: Главная → Направления → Подкатегория
    $trail->parent('direction');
    // Убираем основной раздел (mainCategory) из хлебных крошек
    $trail->push($subCategory->title, route('PodDirection', $subCategory->slug));
});

// Детальная страница подподкатегории
Breadcrumbs::for('subSubCategoryDetail', function (BreadcrumbTrail $trail, SubSubCategory $subSubCategory) {
    // Показываем путь: Главная → Направления → Подкатегория → Подподкатегория(текст)
    // Оставляем Подкатегорию ссылкой, а саму Подподкатегорию добавляем как обычный текст (без route)
    $trail->parent('PodDirection', $subSubCategory->subCategory);
    $trail->push($subSubCategory->title);
});

// Хатха йога
// Breadcrumbs::for('hatha-uoga', function (BreadcrumbTrail $trail) {
//     $trail->parent('welcome');
//     $trail->push('Хатха йога', route('hatha-uoga'));
// });
