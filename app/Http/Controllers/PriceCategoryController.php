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
        ], [
            'name.required' => 'Название обязательно',
            'name.string' => 'Название должно быть строкой',
            'name.max' => 'Название не должно превышать 255 символов',
            'name.unique' => 'Категория с таким названием уже существует',
        ]);

        PriceCategory::create($validated);

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
            'name' => 'required|string|max:255|unique:price_categories,name,'.$priceCategory->id,
        ], [
            'name.required' => 'Название обязательно',
            'name.string' => 'Название должно быть строкой',
            'name.max' => 'Название не должно превышать 255 символов',
            'name.unique' => 'Категория с таким названием уже существует',
        ]);

        $priceCategory->update($validated);

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
