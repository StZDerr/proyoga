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
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        PriceCategory::create($request->all());

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
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $priceCategory->update($request->all());

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
