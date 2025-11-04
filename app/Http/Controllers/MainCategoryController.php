<?php

namespace App\Http\Controllers;

use App\Models\MainCategory;
use Illuminate\Http\Request;

class MainCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mainCategories = MainCategory::orderBy('id', 'desc')->get();

        return view('admin.main_categories.index', compact('mainCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.main_categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:main_categories,title',
        ], [
            'title.required' => 'Название категории обязательно',
            'title.string' => 'Название должно быть строкой',
            'title.max' => 'Название не должно превышать 255 символов',
            'title.unique' => 'Категория с таким названием уже существует',
        ]);

        MainCategory::create([
            'title' => $validated['title'],
        ]);

        return redirect()->route('admin.main-categories.index')
            ->with('success', 'Главная категория успешно добавлена');
    }

    /**
     * Display the specified resource.
     */
    public function show(MainCategory $mainCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MainCategory $mainCategory)
    {
        return view('admin.main_categories.edit', compact('mainCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MainCategory $mainCategory)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:main_categories,title,'.$mainCategory->id,
        ], [
            'title.required' => 'Название категории обязательно',
            'title.string' => 'Название должно быть строкой',
            'title.max' => 'Название не должно превышать 255 символов',
            'title.unique' => 'Категория с таким названием уже существует',
        ]);

        $mainCategory->update([
            'title' => $validated['title'],
        ]);

        return redirect()->route('admin.main-categories.index')
            ->with('success', 'Главная категория успешно обновлена');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MainCategory $mainCategory)
    {
        $mainCategory->delete();

        return redirect()->route('admin.main-categories.index')
            ->with('success', 'Главная категория успешно удалена');
    }
}
