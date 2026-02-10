<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Admin\PageContentController;
use App\Http\Controllers\Admin\TestAdminController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ExternalServiceController;
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
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\SpinController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\SubSubCategoryController;
use App\Http\Controllers\SubSubCategoryFaqController;
use App\Http\Controllers\SubSubCategoryPhotoController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// === СИСТЕМНЫЕ МАРШРУТЫ (должны быть ДО catch-all) ===

Route::redirect('/feisfitnes', '/massaz-i-telesnye-praktiki/feisfitnes', 301);

Route::redirect(
    '/feisfitnes/feisfitnes',
    '/massaz-i-telesnye-praktiki/feisfitnes',
    301
);

// Только аутентификация, без регистрации
Auth::routes(['register' => false]);

// Админ-панель
Route::get('/admin', function () {
    return view('admin/index');
})->middleware('auth')->name('admin');

Route::middleware(['auth'])->prefix('admin')->as('admin.')->group(function () {
    // Управление страницами
    Route::resource('pages', PageContentController::class);

    // Управление сегментами колеса (CRUD)
    Route::resource('spins', \App\Http\Controllers\Admin\SpinController::class);

    // Articles admin
    Route::post('articles/upload-image', [ArticleController::class, 'uploadImage'])->name('articles.upload-image');
    Route::resource('articles', ArticleController::class);

    Route::post('gallery/reorder', [GalleryController::class, 'reorder'])
        ->name('gallery.reorder');
    Route::post('gallery/{gallery}/toggle-active', [GalleryController::class, 'toggleActive'])
        ->name('gallery.toggle-active');
    // Дополнительные маршруты для управления индексацией (ПЕРЕД resource!)
    Route::group(['prefix' => 'indexing', 'as' => 'indexing.'], function () {
        Route::post('/settings', [IndexingController::class, 'updateSettings'])->name('update-settings');
        Route::get('/toggle', [IndexingController::class, 'toggleIndexing'])->name('toggle');
        Route::get('/generate-sitemap', [IndexingController::class, 'generateSitemap'])->name('generate-sitemap');
        Route::get('/initialize', [IndexingController::class, 'initializeDefaults'])->name('initialize');
        Route::get('/sync-dynamic', [IndexingController::class, 'syncDynamicPages'])->name('sync-dynamic');
        Route::get('/cleanup', [IndexingController::class, 'cleanupOrphanedPages'])->name('cleanup');
        Route::get('/{indexing}/toggle-page', [IndexingController::class, 'togglePageIndexing'])->name('toggle-page');
    });

    // Управление индексацией (ПОСЛЕ дополнительных маршрутов!)
    Route::resource('indexing', IndexingController::class);

    Route::softDeletableResources([
        'news' => NewsController::class,
        'sub-sub-category-faqs' => SubSubCategoryFaqController::class,
        'stories' => StoryController::class,
        'activity' => ActivityController::class,
        'users' => UserController::class,
        'personal' => PersonalController::class,
        'gallery' => GalleryController::class,
        'questions' => QuestionController::class,
        'companies' => CompanyController::class,
        'promotions' => PromotionController::class,
        'price-categories' => PriceCategoryController::class,
        'price-tables' => PriceTableController::class,
        'price-items' => PriceItemController::class,
        'main-categories' => MainCategoryController::class,
        'sub-categories' => SubCategoryController::class,
        'sub-sub-categories' => SubSubCategoryController::class,
        'external-services' => ExternalServiceController::class,
    ]);
    // routes/web.php (в админской группе)
    Route::get('settings', [SettingController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');

    Route::delete('sub-sub-categories/photos/{photo}', [SubSubCategoryPhotoController::class, 'destroy'])
        ->name('sub-sub-categories.photos.destroy');

    // Удаление фото из галереи персонала
    Route::delete('personal/{personal}/photos/{photo}', [\App\Http\Controllers\PersonalController::class, 'destroyPhoto'])
        ->name('personal.photos.destroy');
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
Route::get('/oferta', [IstokiController::class, 'oferta'])->name('oferta');
Route::get('/thanks', [IstokiController::class, 'thanks'])->name('thanks');
Route::get('/photo-galleries', [IstokiController::class, 'photoGalleries'])->name('photo-galleries');
Route::get('/taplink', [IstokiController::class, 'taplink'])->name('taplink');
Route::get('/personal/{personal}', [IstokiController::class, 'personal'])->name('personal');

// Статьи
Route::get('/articles', [IstokiController::class, 'articles'])->name('articles.index');
Route::get('/articles/{article:slug}', [IstokiController::class, 'showArticle'])->name('articles.show');

Route::get('/instruction', [IstokiController::class, 'instruction'])->name('instruction');

Route::get('/instruction/ios', function () {
    return view('instruction.ios'); // Или сразу редирект на AppStore
})->name('instruction.ios');

Route::get('/instruction/android', function () {
    return view('instruction.android'); // Или редирект на RuStore/Google Play
})->name('instruction.android');

Route::get('/instruction/desktop', function () {
    return view('instruction.desktop');
})->name('instruction.desktop');

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

// Маршруты для колеса удачи (публичные)
Route::get('/spin/prizes', [SpinController::class, 'prizes']);
Route::post('/spin', [SpinController::class, 'spin'])->name('spin');

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
