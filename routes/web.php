<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Admin\PageContentController;
use App\Http\Controllers\Admin\TestAdminController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\IndexingController;
use App\Http\Controllers\IstokiController;
use App\Http\Controllers\MainCategoryController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\PriceCategoryController;
use App\Http\Controllers\PriceItemController;
use App\Http\Controllers\PriceTableController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\SubSubCategoryController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// === СИСТЕМНЫЕ МАРШРУТЫ (должны быть ДО catch-all) ===

// Только аутентификация, без регистрации
Auth::routes(['register' => false]);

// Админ-панель
Route::get('/admin', function () {
    return view('admin/index');
})->middleware('auth')->name('admin');

Route::middleware(['auth'])->prefix('admin')->as('admin.')->group(function () {
    // Управление страницами
    Route::resource('pages', PageContentController::class);

    // Дополнительные маршруты для управления индексацией (ПЕРЕД resource!)
    Route::group(['prefix' => 'indexing', 'as' => 'indexing.'], function () {
        Route::post('/settings', [IndexingController::class, 'updateSettings'])->name('update-settings');
        Route::get('/toggle', [IndexingController::class, 'toggleIndexing'])->name('toggle');
        Route::get('/generate-sitemap', [IndexingController::class, 'generateSitemap'])->name('generate-sitemap');
        Route::get('/initialize', [IndexingController::class, 'initializeDefaults'])->name('initialize');
        Route::get('/{indexing}/toggle-page', [IndexingController::class, 'togglePageIndexing'])->name('toggle-page');
    });

    // Управление индексацией (ПОСЛЕ дополнительных маршрутов!)
    Route::resource('indexing', IndexingController::class);

    Route::softDeletableResources([
        'news' => NewsController::class,
        'stories' => StoryController::class,
        'activity' => ActivityController::class,
        'users' => UserController::class,
        'personal' => PersonalController::class,
        'gallery' => GalleryController::class,
        'questions' => QuestionController::class,
        'promotions' => PromotionController::class,
        'price-categories' => PriceCategoryController::class,
        'price-tables' => PriceTableController::class,
        'price-items' => PriceItemController::class,
        'main-categories' => MainCategoryController::class,
        'sub-categories' => SubCategoryController::class,
        'sub-sub-categories' => SubSubCategoryController::class,
    ]);
    Route::delete('stories/{story}/media/{media}', [StoryController::class, 'destroyMedia'])->name('stories.media.destroy');
    Route::post('price-tables/{priceTable}/move-up', [PriceTableController::class, 'moveUp'])->name('price-tables.move-up');
    Route::post('price-tables/{priceTable}/move-down', [PriceTableController::class, 'moveDown'])->name('price-tables.move-down');

    // Маршруты для управления тестами
    Route::prefix('test')->as('test.')->group(function () {
        // Результаты тестов
        Route::get('/submissions', [TestAdminController::class, 'submissions'])->name('submissions');
        Route::get('/submission/{id}', [TestAdminController::class, 'showSubmission'])->name('submission.show');
        Route::post('/submission/{id}/mark-visited', [TestAdminController::class, 'markVisited'])->name('submission.mark-visited');

        // Управление вопросами
        Route::get('/questions', [TestAdminController::class, 'questions'])->name('questions');
        Route::get('/question/create', [TestAdminController::class, 'createQuestion'])->name('question.create');
        Route::post('/question/store', [TestAdminController::class, 'storeQuestion'])->name('question.store');
        Route::get('/question/{id}/edit', [TestAdminController::class, 'editQuestion'])->name('question.edit');
        Route::put('/question/{id}', [TestAdminController::class, 'updateQuestion'])->name('question.update');
        Route::delete('/question/{id}', [TestAdminController::class, 'deleteQuestion'])->name('question.delete');
    });
});

// === ПУБЛИЧНЫЕ СТРАНИЦЫ (явные маршруты) ===

Route::get('/', [IstokiController::class, 'index'])->name('welcome');
Route::get('/price-list', [IstokiController::class, 'priceList'])->name('price-list');
Route::get('/direction', [IstokiController::class, 'direction'])->name('direction');
Route::get('/about', [IstokiController::class, 'about'])->name('about');
Route::get('/recording', [IstokiController::class, 'recording'])->name('recording');
Route::get('/personal-data', [IstokiController::class, 'personalData'])->name('personal-data');
Route::get('/privacy-policy', [IstokiController::class, 'privacyPolicy'])->name('privacy-policy');
Route::get('/thanks', [IstokiController::class, 'thanks'])->name('thanks');

Route::get('/dev', function () {
    return view('dev');
})->name('dev');

Route::get('/contacts', function () {
    return view('contacts');
})->name('contacts');

Route::get('/tea', function () {
    return view('tea');
})->name('tea');

Route::get('/calendar', function () {
    return view('calendar');
})->name('calendar');

// API маршруты для теста
Route::prefix('api/test')->group(function () {
    Route::get('/questions', [TestController::class, 'getQuestions']);
    Route::post('/submit', [TestController::class, 'submitTest']);
});

// API маршруты для отправки форм
Route::post('/contact/send', [ContactController::class, 'sendContactForm'])->name('contact.send');

// Sitemap.xml
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// === ДИНАМИЧЕСКИЕ МАРШРУТЫ (catch-all, должны быть В САМОМ КОНЦЕ!) ===

// Подподкатегория (двухуровневый slug) - ДОЛЖНА БЫТЬ ПЕРЕД одноуровневой!
Route::get('/{subCategorySlug}/{subSubCategorySlug}', [IstokiController::class, 'subSubCategoryDetail'])
    ->where('subCategorySlug', '^(?!admin|login|register|password|api|sitemap\.xml|storage|css|js|images|favicon|build|contacts|tea|calendar|about|recording|personal-data|privacy-policy|price-list|direction).*$')
    ->where('subSubCategorySlug', '.+')
    ->name('subSubCategoryDetail');

// Подкатегория (одноуровневый slug)
Route::get('/{subCategory}', [IstokiController::class, 'PodDirection'])
    ->where('subCategory', '^(?!admin|login|register|password|api|sitemap\.xml|storage|css|js|images|favicon|build|contacts|tea|calendar|about|recording|personal-data|privacy-policy|price-list|direction).*$')
    ->name('PodDirection');
