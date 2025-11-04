<?php

namespace App\Http\Controllers;

use App\Models\PriceItem;
use App\Models\PriceTable;
use Illuminate\Http\Request;

class PriceItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = PriceItem::with('table.category')->get();

        return view('admin.price_items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tables = PriceTable::with('category')->get();

        return view('admin.price_items.create', compact('tables'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'duration' => 'required|string|max:50',
            'price' => 'required|string|max:50',
            'table_id' => 'required|integer|exists:price_tables,id',
        ], [
            'name.required' => 'Название обязательно',
            'name.string' => 'Название должно быть строкой',
            'name.max' => 'Название не должно превышать 255 символов',

            'duration.required' => 'Длительность обязательна',
            'duration.string' => 'Длительность должна быть строкой',
            'duration.max' => 'Длительность не должна превышать 50 символов',

            'price.required' => 'Цена обязательна',
            'price.string' => 'Цена должна быть строкой',
            'price.max' => 'Цена не должна превышать 50 символов',

            'table_id.required' => 'Таблица цены обязательна',
            'table_id.integer' => 'Неверный идентификатор таблицы',
            'table_id.exists' => 'Выбранная таблица не найдена',
        ]);

        PriceItem::create($validated);

        return redirect()->route('admin.price-items.index')
            ->with('success', 'Элемент добавлен!');
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
    public function edit(PriceItem $priceItem)
    {
        $tables = PriceTable::with('category')->get();

        return view('admin.price_items.edit', compact('priceItem', 'tables'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PriceItem $priceItem)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'duration' => 'required|string|max:50',
            'price' => 'required|string|max:50',
            'table_id' => 'required|integer|exists:price_tables,id',
        ], [
            'name.required' => 'Название обязательно',
            'name.string' => 'Название должно быть строкой',
            'name.max' => 'Название не должно превышать 255 символов',

            'duration.required' => 'Длительность обязательна',
            'duration.string' => 'Длительность должна быть строкой',
            'duration.max' => 'Длительность не должна превышать 50 символов',

            'price.required' => 'Цена обязательна',
            'price.string' => 'Цена должна быть строкой',
            'price.max' => 'Цена не должна превышать 50 символов',

            'table_id.required' => 'Таблица цены обязательна',
            'table_id.integer' => 'Неверный идентификатор таблицы',
            'table_id.exists' => 'Выбранная таблица не найдена',
        ]);

        $priceItem->update($validated);

        return redirect()->route('admin.price-items.index')
            ->with('success', 'Элемент обновлен!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PriceItem $priceItem)
    {
        $priceItem->delete();

        return redirect()->route('admin.price-items.index')
            ->with('success', 'Элемент удален!');
    }
}
