<?php

namespace App\Http\Controllers;

use App\Models\PriceCategory;
use Illuminate\Http\Request;

class PriceCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = PriceCategory::all();

        return view('admin.price_categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.price_categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:price_categories,name',
            'file' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png',
                'max:5120', // размер файла до 5 МБ
                'dimensions:min_width=1300,min_height=1000,max_width=2000,max_height=2000',
            ],
        ], [
            'name.required' => 'Название обязательно',
            'name.string' => 'Название должно быть строкой',
            'name.max' => 'Название не должно превышать 255 символов',
            'name.unique' => 'Категория с таким названием уже существует',
            'file.file' => 'Файл должен быть корректным',
            'file.mimes' => 'Допустимые форматы: jpg, jpeg, png',
            'file.max' => 'Файл не должен превышать 5 МБ',
            'file.dimensions' => 'Изображение должно быть минимум 1300x1000 и максимум 2000x2000 пикселей',
        ]);

        $category = new PriceCategory;
        $category->name = $validated['name'];

        // обработка файла
        if ($request->hasFile('file')) {
            $category->file = $request->file('file')->store('prices', 'public');
        }

        $category->save();

        return redirect()->route('admin.price-categories.index')
            ->with('success', 'Категория добавлена!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PriceCategory $priceCategory)
    {
        return view('admin.price_categories.edit', compact('priceCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PriceCategory $priceCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'file' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png',
                'max:5120', // размер файла до 5 МБ
                'dimensions:min_width=1300,min_height=1000,max_width=2000,max_height=2000',
            ],
        ], [
            'name.required' => 'Название обязательно',
            'name.string' => 'Название должно быть строкой',
            'name.max' => 'Название не должно превышать 255 символов',
            'name.unique' => 'Категория с таким названием уже существует',
            'file.file' => 'Файл должен быть корректным',
            'file.mimes' => 'Допустимые форматы: jpg, jpeg, png',
            'file.max' => 'Файл не должен превышать 5 МБ',
            'file.dimensions' => 'Изображение должно быть минимум 1300x1000 и максимум 2000x2000 пикселей',
        ]);

        $priceCategory->name = $validated['name'];

        if ($request->hasFile('file')) {
            // удаляем старый файл, если он существует
            if ($priceCategory->file && \Storage::disk('public')->exists($priceCategory->file)) {
                \Storage::disk('public')->delete($priceCategory->file);
            }

            $priceCategory->file = $request->file('file')->store('prices', 'public');
        }

        $priceCategory->save();

        return redirect()->route('admin.price-categories.index')
            ->with('success', 'Категория обновлена!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PriceCategory $priceCategory)
    {
        $priceCategory->delete();

        return redirect()->route('admin.price-categories.index')
            ->with('success', 'Категория удалена!');
    }
}
