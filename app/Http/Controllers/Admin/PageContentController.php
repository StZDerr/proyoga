<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IndexablePage;
use App\Models\PageContent;
use App\Models\SubCategory;
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
        // Подсказки из уже существующих PageContent->slug
        $pageSlugs = PageContent::orderBy('slug')->pluck('slug')->toArray();

        // Подсказки из IndexablePage (убираем ведущий '/')
        $indexableUrls = IndexablePage::orderBy('url')->pluck('url')->map(function ($u) {
            return ltrim($u, '/');
        })->toArray();

        $suggested = collect($pageSlugs)->merge($indexableUrls)->unique()->values()->toArray();

        // Добавляем динамические варианты для направлений: {slug} и {slug}/{subslug}
        $subCategories = SubCategory::with('subSubCategories')->get();
        foreach ($subCategories as $sub) {
            $suggested[] = "{$sub->slug}";
            foreach ($sub->subSubCategories as $subSub) {
                $suggested[] = "{$sub->slug}/{$subSub->slug}";
            }
        }

        // Нормализуем и убираем дубликаты, пустые значения
        $suggested = array_values(array_filter(array_unique(array_map('trim', $suggested))));

        return view('admin.pages.create', compact('suggested'));
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

        // SEO данные
        $seoData = [
            'og_title' => $request->og_title ?? null,
            'og_description' => $request->og_description ?? null,
        ];

        // Папка для OG изображений
        $destinationPath = public_path('images/og');

        // Создаем папку, если её нет
        if (! is_dir($destinationPath)) {
            mkdir($destinationPath, 0775, true);
        }

        // Загрузка OG изображения
        if ($request->hasFile('og_image_file')) {
            $file = $request->file('og_image_file');

            // Уникальное безопасное имя
            $fileName = 'og_'.time().'_'.uniqid().'.'.$file->getClientOriginalExtension();

            // Перемещаем файл
            $file->move($destinationPath, $fileName);

            // Путь для базы
            $seoData['og_image'] = '/images/og/'.$fileName;
        }

        // Записываем SEO в данные
        $validated['seo_data'] = $seoData;
        $validated['is_active'] = $request->has('is_active');

        // Создаем запись
        PageContent::create($validated);

        return redirect()
            ->route('admin.pages.index')
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
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('page_contents')->ignore($page->id),
            ],
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'keywords' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            'og_image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Текущие SEO данные
        $seoData = $page->seo_data ?? [];

        // Текстовые SEO поля
        $seoData['og_title'] = $request->og_title ?? ($seoData['og_title'] ?? null);
        $seoData['og_description'] = $request->og_description ?? ($seoData['og_description'] ?? null);

        // Папка для OG изображений
        $destinationPath = public_path('images/og');

        // Создать папку, если нет
        if (! is_dir($destinationPath)) {
            mkdir($destinationPath, 0775, true);
        }

        // Загружаем новое OG изображение
        if ($request->hasFile('og_image_file')) {

            // Удаляем старое
            if (! empty($seoData['og_image'])) {
                $oldImagePath = public_path($seoData['og_image']);
                if (file_exists($oldImagePath) && is_file($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $file = $request->file('og_image_file');

            // Уникальное имя файла (без slug)
            $fileName = 'og_'.time().'_'.uniqid().'.'.$file->getClientOriginalExtension();

            // Сохраняем
            $file->move($destinationPath, $fileName);

            // Путь для базы
            $seoData['og_image'] = '/images/og/'.$fileName;

        } elseif ($request->filled('og_image_current')) {
            // Если файл не загружён — сохраняем старое изображение
            $seoData['og_image'] = $request->og_image_current;
        }

        // Записываем SEO в основной массив данных
        $validated['seo_data'] = $seoData;

        // Чекбокс активности
        $validated['is_active'] = $request->has('is_active');

        // Обновляем страницу
        $page->update($validated);

        return redirect()
            ->route('admin.pages.index')
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
