<?php

namespace App\Http\Controllers;

use App\Models\PriceCategory;
use App\Models\PriceTable;
use Illuminate\Http\Request;

class PriceTableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tables = PriceTable::with('category')->get();

        return view('admin.price_tables.index', compact('tables'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = PriceCategory::all();

        return view('admin.price_tables.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|integer|exists:price_categories,id',
        ], [
            'title.required' => 'Название обязательно',
            'title.string' => 'Название должно быть строкой',
            'title.max' => 'Название не должно превышать 255 символов',

            'category_id.required' => 'Категория обязательна',
            'category_id.integer' => 'Неверный идентификатор категории',
            'category_id.exists' => 'Выбранная категория не найдена',
        ]);

        PriceTable::create($validated);

        return redirect()->route('admin.price-tables.index')
            ->with('success', 'Таблица добавлена!');
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
    public function edit(PriceTable $priceTable)
    {
        $categories = PriceCategory::all();

        return view('admin.price_tables.edit', compact('priceTable', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PriceTable $priceTable)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|integer|exists:price_categories,id',
        ], [
            'title.required' => 'Название обязательно',
            'title.string' => 'Название должно быть строкой',
            'title.max' => 'Название не должно превышать 255 символов',

            'category_id.required' => 'Категория обязательна',
            'category_id.integer' => 'Неверный идентификатор категории',
            'category_id.exists' => 'Выбранная категория не найдена',
        ]);

        $priceTable->update($validated);

        return redirect()->route('admin.price-tables.index')
            ->with('success', 'Таблица обновлена!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PriceTable $priceTable)
    {
        $priceTable->delete();

        return redirect()->route('admin.price-tables.index')
            ->with('success', 'Таблица удалена!');
    }
}
