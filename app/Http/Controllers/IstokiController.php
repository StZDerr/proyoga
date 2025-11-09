<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\MainCategory;
use App\Models\Personal;
use App\Models\PriceCategory;
use App\Models\Promotion;
use App\Models\Question;
use App\Models\SubCategory;
use App\Models\SubSubCategory;

class IstokiController extends Controller
{
    public function index()
    {
        $promotions = Promotion::all();
        $categories = PriceCategory::with(['tables.items'])->get();
        $personals = Personal::all();
        $galleries = Gallery::all();
        $questions = Question::orderBy('order')->get();
        $mainCategories = MainCategory::with('subCategories')->orderBy('id', 'desc')->get();

        // Загружаем мета-данные для главной страницы
        $pageMeta = \App\Helpers\PageContentHelper::getMeta('home');
        $pageContent = \App\Helpers\PageContentHelper::getContent('home');

        return view('welcome', compact('promotions', 'categories', 'personals', 'galleries', 'questions', 'mainCategories', 'pageMeta', 'pageContent'));
    }

    public function priceList()
    {
        $categories = PriceCategory::with(['tables' => function ($q) {
            $q->ordered()->with('items'); // использует scopeOrdered() в модели PriceTable
        }])->get();

        // Загружаем мета-данные для страницы price-list
        $pageMeta = \App\Helpers\PageContentHelper::getMeta('price-list');
        $pageContent = \App\Helpers\PageContentHelper::getContent('price-list');

        return view('price-list', compact('categories', 'pageMeta', 'pageContent'));
    }

    public function direction()
    {
        $mainCategories = MainCategory::with('subCategories')->orderBy('id', 'desc')->get();
        // Загружаем мета-данные для страницы direction
        $pageMeta = \App\Helpers\PageContentHelper::getMeta('direction');
        $pageContent = \App\Helpers\PageContentHelper::getContent('direction');

        return view('direction', compact('mainCategories', 'pageMeta', 'pageContent'));
    }

    public function PodDirection(SubCategory $subCategory)
    {
        // Laravel автоматически найдет SubCategory по slug благодаря getRouteKeyName()
        $subCategory->load(['subSubCategories', 'mainCategory']);

        // Загружаем мета-данные для страницы direction
        $pageMeta = \App\Helpers\PageContentHelper::getMeta('direction');
        $pageContent = \App\Helpers\PageContentHelper::getContent('direction');

        return view('PodDirection', compact('subCategory', 'pageMeta', 'pageContent'));
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

        // Загружаем мета-данные для страницы direction
        $pageMeta = \App\Helpers\PageContentHelper::getMeta('direction');
        $pageContent = \App\Helpers\PageContentHelper::getContent('direction');

        return view('hatha-uoga', compact('subSubCategory', 'pageMeta', 'pageContent'));
    }

    public function about()
    {
        $personals = Personal::all();
        // Загружаем мета-данные для страницы direction
        $pageMeta = \App\Helpers\PageContentHelper::getMeta('direction');
        $pageContent = \App\Helpers\PageContentHelper::getContent('direction');

        return view('about', compact('personals', 'pageMeta', 'pageContent'));
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

    public function thanks()
    {
        return view('thanks');
    }
}
