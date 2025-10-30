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
        $request->validate([
            'name' => 'required|string|max:255',
            'duration' => 'required|string|max:50',
            'price' => 'required|string|max:50',
            'table_id' => 'required|exists:price_tables,id',
        ]);

        PriceItem::create($request->all());

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
        $request->validate([
            'name' => 'required|string|max:255',
            'duration' => 'required|string|max:50',
            'price' => 'required|string|max:50',
            'table_id' => 'required|exists:price_tables,id',
        ]);

        $priceItem->update($request->all());

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
