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
    public function index()
    {
        $subCategories = SubCategory::with('mainCategory')->orderBy('id', 'desc')->get();

        return view('admin.sub_categories.index', compact('subCategories'));
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
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:webp|max:2048',
            'main_category_id' => 'required|exists:main_categories,id',
        ]);

        $data = $request->only('title', 'description', 'main_category_id');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('sub_categories', 'public');
        }

        SubCategory::create($data);

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
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:webp|max:2048',
            'main_category_id' => 'required|exists:main_categories,id',
        ]);

        $data = $request->only('title', 'description', 'main_category_id');

        if ($request->hasFile('image')) {
            if ($subCategory->image) {
                Storage::disk('public')->delete($subCategory->image);
            }
            $data['image'] = $request->file('image')->store('sub_categories', 'public');
        }

        $subCategory->update($data);

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
