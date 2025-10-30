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

        return view('welcome', compact('promotions', 'categories', 'personals', 'galleries', 'questions', 'mainCategories'));
    }

    public function priceList()
    {
        $categories = PriceCategory::with(['tables.items'])->get();

        return view('price-list', compact('categories'));
    }

    public function direction()
    {
        $mainCategories = MainCategory::with('subCategories')->orderBy('id', 'desc')->get();

        return view('direction', compact('mainCategories'));
    }

    public function PodDirection($subCategoryId)
    {
        $subCategory = SubCategory::with(['subSubCategories', 'mainCategory'])
            ->where('id', $subCategoryId)
            ->firstOrFail();

        return view('PodDirection', compact('subCategory'));
    }

    public function subSubCategoryDetail($subCategoryId, $subSubCategoryId)
    {
        $subSubCategory = SubSubCategory::with(['subCategory.mainCategory'])
            ->where('id', $subSubCategoryId)
            ->firstOrFail();

        // Проверяем, что подподкатегория принадлежит правильной подкатегории
        if ($subSubCategory->subCategory->id != $subCategoryId) {
            abort(404);
        }

        return view('hatha-uoga', compact('subSubCategory'));
    }

    public function about()
    {
        $personals = Personal::all();

        return view('about', compact('personals'));
    }
}
