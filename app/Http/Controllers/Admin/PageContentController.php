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
            'og_image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Обработка SEO данных
        $seoData = [];
        if ($request->filled('og_title')) {
            $seoData['og_title'] = $request->og_title;
        }
        if ($request->filled('og_description')) {
            $seoData['og_description'] = $request->og_description;
        }

        // Обработка загрузки изображения
        if ($request->hasFile('og_image_file')) {
            $file = $request->file('og_image_file');
            $fileName = 'og-'.$request->slug.'-'.time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('images'), $fileName);
            $seoData['og_image'] = '/images/'.$fileName;
        }

        $validated['seo_data'] = $seoData;
        $validated['is_active'] = $request->has('is_active');

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
            'og_image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Обработка SEO данных
        $seoData = $page->seo_data ?? [];

        if ($request->filled('og_title')) {
            $seoData['og_title'] = $request->og_title;
        }
        if ($request->filled('og_description')) {
            $seoData['og_description'] = $request->og_description;
        }

        // Обработка загрузки изображения
        if ($request->hasFile('og_image_file')) {
            // Удаляем старое изображение, если оно есть
            if (! empty($seoData['og_image'])) {
                $oldImagePath = public_path($seoData['og_image']);
                if (file_exists($oldImagePath) && is_file($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Загружаем новое изображение
            $file = $request->file('og_image_file');
            $fileName = 'og-'.$page->slug.'-'.time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('images'), $fileName);
            $seoData['og_image'] = '/images/'.$fileName;
        } elseif ($request->filled('og_image_current')) {
            // Если файл не загружен, сохраняем текущее изображение
            $seoData['og_image'] = $request->og_image_current;
        }

        $validated['seo_data'] = $seoData;
        $validated['is_active'] = $request->has('is_active');

        $page->update($validated);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Страница успешно обновлена!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PageContent $page)
    {
        // Удаляем изображение, если оно есть
        if (! empty($page->seo_data['og_image'])) {
            $imagePath = public_path($page->seo_data['og_image']);
            if (file_exists($imagePath) && is_file($imagePath)) {
                unlink($imagePath);
            }
        }

        $page->delete();

        return redirect()->route('admin.pages.index')
            ->with('success', 'Страница успешно удалена!');
    }
}
