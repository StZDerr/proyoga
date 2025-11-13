<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\MainCategory;
use App\Models\Personal;
use App\Models\PriceCategory;
use App\Models\Promotion;
use App\Models\Question;
use App\Models\Story;
use App\Models\SubCategory;
use App\Models\SubSubCategory;

class IstokiController extends Controller
{
    public function index()
    {
        $promotions = Promotion::all();
        // $categories = PriceCategory::with(['tables.items'])->get();
        $personals = Personal::all();
        $galleries = Gallery::where('is_active', 1)
            ->orderBy('sort_order', 'desc')->get();
        $stories = Story::all();
        $questions = Question::orderBy('order')->get();
        $mainCategories = MainCategory::with('subCategories')->orderBy('id', 'desc')->get();

        return view('welcome', compact('promotions', 'stories', 'personals', 'galleries', 'questions', 'mainCategories'));
    }

    public function priceList()
    {
        $categories = PriceCategory::select('id', 'name', 'file')->get();

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

    public function thanks()
    {
        return view('thanks');
    }

    public function photoGalleries()
    {
        $photos = Gallery::orderBy('sort_order', 'asc')->get();

        return view('photo-galleries', compact('photos'));
    }
}
