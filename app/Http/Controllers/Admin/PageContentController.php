<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageContent;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PageContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pages = PageContent::orderBy('slug')->get();
        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'slug' => 'required|string|max:255|unique:page_contents,slug',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'keywords' => 'nullable|string|max:500',
            'content' => 'nullable|string',
        ]);

        // Обработка SEO данных
        $seoData = [];
        if ($request->filled('og_title')) {
            $seoData['og_title'] = $request->og_title;
        }
        if ($request->filled('og_description')) {
            $seoData['og_description'] = $request->og_description;
        }
        if ($request->filled('og_image')) {
            $seoData['og_image'] = $request->og_image;
        }

        $validated['seo_data'] = $seoData;
        $validated['is_active'] = $request->has('is_active'); // checkbox правильно обрабатывается

        PageContent::create($validated);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Страница успешно создана!');
    }

    /**
     * Display the specified resource.
     */
    public function show(PageContent $page)
    {
        return view('admin.pages.show', compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PageContent $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PageContent $page)
    {
        $validated = $request->validate([
            'slug' => ['required', 'string', 'max:255', Rule::unique('page_contents')->ignore($page->id)],
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'keywords' => 'nullable|string|max:500',
            'content' => 'nullable|string',
        ]);

        // Обработка SEO данных
        $seoData = [];
        if ($request->filled('og_title')) {
            $seoData['og_title'] = $request->og_title;
        }
        if ($request->filled('og_description')) {
            $seoData['og_description'] = $request->og_description;
        }
        if ($request->filled('og_image')) {
            $seoData['og_image'] = $request->og_image;
        }

        $validated['seo_data'] = $seoData;
        $validated['is_active'] = $request->has('is_active'); // checkbox правильно обрабатывается

        $page->update($validated);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Страница успешно обновлена!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PageContent $page)
    {
        $page->delete();

        return redirect()->route('admin.pages.index')
            ->with('success', 'Страница успешно удалена!');
    }
}
