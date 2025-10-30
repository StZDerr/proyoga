<?php

namespace App\Http\Controllers;

use App\Models\MainCategory;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubSubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subSubCategories = SubSubCategory::with('subCategory.mainCategory')->orderBy('id', 'desc')->get();

        return view('admin.sub_sub_categories.index', compact('subSubCategories'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mainCategories = MainCategory::all();
        $subCategories = SubCategory::all();

        return view('admin.sub_sub_categories.create', compact('mainCategories', 'subCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'about' => 'nullable|string',
            'image' => 'nullable|image|mimes:webp|max:2048',
            'sub_category_id' => 'required|exists:sub_categories,id',
            'benefits' => 'nullable|array',
            'benefits.*' => 'nullable|string|max:255',
        ], [
            'image.mimes' => 'Фотография должна быть в формате .webp',
            'image.max' => 'Размер фотографии не должен превышать 2 МБ',
            'benefits.*.max' => 'Размер преимущества не должен превышать 255 символов',

        ]);

        $data = $request->only('title', 'description', 'sub_category_id');
        // Фильтруем пустые значения из benefits
        $benefits = array_filter($request->input('benefits', []), function ($benefit) {
            return ! empty(trim($benefit));
        });
        $data['benefits'] = array_values($benefits); // Переиндексируем массив

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('sub_sub_categories', 'public');
        }

        SubSubCategory::create($data);

        return redirect()->route('admin.sub-sub-categories.index')
            ->with('success', 'Подподкатегория успешно добавлена');
    }

    /**
     * Display the specified resource.
     */
    public function show(SubSubCategory $subSubCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubSubCategory $subSubCategory)
    {
        $mainCategories = MainCategory::all();
        $subCategories = SubCategory::all();

        return view('admin.sub_sub_categories.edit', compact('subSubCategory', 'mainCategories', 'subCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubSubCategory $subSubCategory)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'about' => 'nullable|string',
            'image' => 'nullable|image|mimes:webp|max:2048',
            'sub_category_id' => 'required|exists:sub_categories,id',
            'benefits' => 'nullable|array',
            'benefits.*' => 'nullable|string|max:255',
        ]);

        $data = $request->only('title', 'description', 'about', 'sub_category_id');
        // Фильтруем пустые значения из benefits
        $benefits = array_filter($request->input('benefits', []), function ($benefit) {
            return ! empty(trim($benefit));
        });
        $data['benefits'] = array_values($benefits); // Переиндексируем массив

        if ($request->hasFile('image')) {
            if ($subSubCategory->image) {
                Storage::disk('public')->delete($subSubCategory->image);
            }
            $data['image'] = $request->file('image')->store('sub_sub_categories', 'public');
        }

        $subSubCategory->update($data);

        return redirect()->route('admin.sub-sub-categories.index')
            ->with('success', 'Подподкатегория успешно обновлена');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubSubCategory $subSubCategory)
    {
        if ($subSubCategory->image) {
            Storage::disk('public')->delete($subSubCategory->image);
        }

        $subSubCategory->delete();

        return redirect()->route('admin.sub-sub-categories.index')
            ->with('success', 'Подподкатегория успешно удалена');
    }
}
