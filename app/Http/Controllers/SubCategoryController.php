<?php

namespace App\Http\Controllers;

use App\Models\MainCategory;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = SubCategory::with('mainCategory');
        
        // Фильтр по главной категории
        if ($request->filled('main_category_id')) {
            $query->where('main_category_id', $request->main_category_id);
        }
        
        $subCategories = $query->orderBy('id', 'desc')->get();
        $mainCategories = MainCategory::orderBy('title')->get();

        return view('admin.sub_categories.index', compact('subCategories', 'mainCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mainCategories = MainCategory::all();

        return view('admin.sub_categories.create', compact('mainCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'sometimes|image|mimes:webp|max:2048',
            'main_category_id' => 'required|integer|exists:main_categories,id',
        ], [
            'title.required' => 'Название обязательно',
            'title.string' => 'Название должно быть строкой',
            'title.max' => 'Название не должно превышать 255 символов',

            'description.string' => 'Описание должно быть строкой',

            'image.image' => 'Файл должен быть изображением',
            'image.mimes' => 'Изображение должно быть в формате .webp',
            'image.max' => 'Размер изображения не должен превышать 2 МБ',

            'main_category_id.required' => 'Нужно указать главную категорию',
            'main_category_id.integer' => 'Неверный идентификатор главной категории',
            'main_category_id.exists' => 'Выбранная главная категория не найдена',
        ]);

        $validated = $request->only('title', 'description', 'main_category_id');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('sub_categories', 'public');
        }

        SubCategory::create($validated);

        return redirect()->route('admin.sub-categories.index')
            ->with('success', 'Подкатегория успешно добавлена');
    }

    /**
     * Display the specified resource.
     */
    public function show(SubCategory $subCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubCategory $subCategory)
    {
        $mainCategories = MainCategory::all();

        return view('admin.sub_categories.edit', compact('subCategory', 'mainCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubCategory $subCategory)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'sometimes|image|mimes:webp|max:2048',
            'main_category_id' => 'required|integer|exists:main_categories,id',
        ], [
            'title.required' => 'Название обязательно',
            'title.string' => 'Название должно быть строкой',
            'title.max' => 'Название не должно превышать 255 символов',

            'description.string' => 'Описание должно быть строкой',

            'image.image' => 'Файл должен быть изображением',
            'image.mimes' => 'Изображение должно быть в формате .webp',
            'image.max' => 'Размер изображения не должен превышать 2 МБ',

            'main_category_id.required' => 'Нужно указать главную категорию',
            'main_category_id.integer' => 'Неверный идентификатор главной категории',
            'main_category_id.exists' => 'Выбранная главная категория не найдена',
        ]);

        $validated = $request->only('title', 'description', 'main_category_id');

        if ($request->hasFile('image')) {
            if ($subCategory->image) {
                Storage::disk('public')->delete($subCategory->image);
            }
            $validated['image'] = $request->file('image')->store('sub_categories', 'public');
        }

        $subCategory->update($validated);

        return redirect()->route('admin.sub-categories.index')
            ->with('success', 'Подкатегория успешно обновлена');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubCategory $subCategory)
    {
        if ($subCategory->image) {
            Storage::disk('public')->delete($subCategory->image);
        }

        $subCategory->delete();

        return redirect()->route('admin.sub-categories.index')
            ->with('success', 'Подкатегория успешно удалена');
    }
}
