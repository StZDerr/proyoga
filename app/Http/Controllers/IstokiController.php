<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Company;
use App\Models\Gallery;
use App\Models\MainCategory;
use App\Models\Personal;
use App\Models\PriceCategory;
use App\Models\Promotion;
use App\Models\Question;
use App\Models\Story;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class IstokiController extends Controller
{
    public function index()
    {
        // Домашние данные кешируем, чтобы не собирать их на каждый визит
        $promotions = Cache::remember('home:promotions', now()->addMinutes(30), function () {
            return Promotion::orderBy('created_at', 'desc')->get();
        });

        $personals = Cache::remember('home:personals', now()->addMinutes(30), function () {
            return Personal::orderBy('sort_order')->get();
        });

        $galleries = Cache::remember('home:galleries', now()->addMinutes(30), function () {
            return Gallery::where('is_active', 1)
                ->orderBy('sort_order', 'desc')
                ->get();
        });

        $stories = Story::inRandomOrder()
            ->limit(5)
            ->get();

        $questions = Cache::remember('home:questions', now()->addMinutes(30), function () {
            return Question::orderBy('order')->get();
        });

        $mainCategories = Cache::remember('home:main_categories', now()->addMinutes(30), function () {
            return MainCategory::with('subCategories')->orderBy('id', 'desc')->get();
        });

        $articles = Cache::remember('home:articles', now()->addMinutes(15), function () {
            return Article::orderBy('created_at', 'desc')->take(3)->get();
        });

        // Spin visibility: check active prizes and total chance
        $spinPrizes = \App\Models\Prize::where('is_active', true)->get(['id', 'chance']);
        $spinPrizesCount = $spinPrizes->count();
        $spinPrizesChanceTotal = (int) $spinPrizes->sum('chance');

        // By default require total chances >= 100 to show the spin block.
        // This prevents showing the wheel when no prizes configured or chances not set.
        $showSpin = $spinPrizesCount > 0 && $spinPrizesChanceTotal >= 100;

        return view('welcome', compact('promotions', 'stories', 'personals', 'galleries', 'questions', 'mainCategories', 'articles', 'showSpin', 'spinPrizesCount', 'spinPrizesChanceTotal'));
    }

    public function priceList()
    {
        $categories = PriceCategory::with(['tables' => function ($q) {
            $q->ordered()->select('id','category_id','title','sort_order')->with(['items' => function ($q2) {
                $q2->select('id','table_id','name','duration','price');
            }]);
        }])->get(['id','name','file']);

        return view('price-list', compact('categories'));
    }

    public function direction()
    {
        $mainCategories = MainCategory::with('subCategories')->orderBy('id', 'desc')->get();

        return view('direction', compact('mainCategories'));
    }

    public function PodDirection(SubCategory $subCategory)
    {
        // Laravel автоматически найдет SubCategory по slug благодаря getRouteKeyName()
        $subCategory->load(['subSubCategories', 'mainCategory']);

        return view('PodDirection', compact('subCategory'));
    }

    public function subSubCategoryDetail($subCategorySlug, $subSubCategorySlug)
    {
        // Находим подкатегорию по slug
        $subCategory = SubCategory::where('slug', $subCategorySlug)->firstOrFail();

        // Находим подподкатегорию по slug и проверяем принадлежность к подкатегории
        $subSubCategory = SubSubCategory::where('slug', $subSubCategorySlug)
            ->where('sub_category_id', $subCategory->id)
            ->firstOrFail();

        $subSubCategory->load(['subCategory.mainCategory']);

        // Загружаем все FAQ для подподкатегории, сортируем по sort_order
        $questions = $subSubCategory->faqs()
            ->orderBy('sort_order')
            ->orderBy('created_at')
            ->get();

        return view('hatha-uoga', compact('subSubCategory', 'questions'));
    }

    public function about()
    {
        $personals = Personal::all();
        // Загружаем мета-данные для страницы about
        // $pageMeta = \App\Helpers\PageContentHelper::getMeta('about');
        // $pageContent = \App\Helpers\PageContentHelper::getContent('about');

        return view('about', compact('personals'));
    }

    public function recording()
    {
        return view('recording');
    }

    public function personalData()
    {
        return view('personal-data');
    }

    public function privacyPolicy()
    {
        return view('privacy-policy');
    }

    public function oferta()
    {
        return view('oferta');
    }

    public function thanks()
    {
        return view('thanks');
    }

    public function photoGalleries()
    {
        $photos = Gallery::orderBy('sort_order', 'asc')->get();

        return view('photo-galleries', compact('photos'));
    }

    public function instruction(Request $request)
    {
        $userAgent = $request->header('User-Agent');
        if (preg_match('/iPhone|iPad|iPod/', $userAgent)) {
            // iOS → редирект на роут AppStore
            return redirect()->route('instruction.ios');
        } elseif (preg_match('/Android/', $userAgent)) {
            // Android → редирект на роут Android
            return redirect()->route('instruction.android');
        } else {
            // Десктоп / другое устройство → редирект на общий роут
            return redirect()->route('instruction.desktop');
        }
    }

    public function taplink()
    {
        $companies = Company::all();

        return view('taplink', compact('companies'));
    }

    public function articles()
    {
        $articles = Article::orderBy('created_at', 'desc')->paginate(9);

        return view('articles', compact('articles'));
    }

    public function showArticle(Article $article)
    {
        return view('showArticle', compact('article'));
    }

    public function personal(Personal $personal)
    {
        $personal->load('photos');

        return view('personal', compact('personal'));
    }
}
