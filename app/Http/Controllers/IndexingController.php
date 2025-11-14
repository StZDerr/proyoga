<?php

namespace App\Http\Controllers;

use App\Models\IndexablePage;
use App\Models\IndexingSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class IndexingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = IndexingSettings::current();
        $pages = IndexablePage::orderBy('priority', 'desc')->get();

        return view('admin.indexing.index', compact('settings', 'pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.indexing.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'url' => 'required|string|unique:indexable_pages,url',
            'title' => 'required|string',
            'description' => 'nullable|string',
            'priority' => 'required|numeric|between:0,1',
            'changefreq' => 'required|in:always,hourly,daily,weekly,monthly,yearly,never',
            'is_indexed' => 'sometimes|boolean',
            'notes' => 'nullable|string',
        ], [
            'url.required' => 'URL обязателен',
            'url.string' => 'URL должен быть строкой',
            'url.unique' => 'Этот URL уже используется',

            'title.required' => 'Заголовок обязателен',
            'title.string' => 'Заголовок должен быть строкой',

            'description.string' => 'Описание должно быть строкой',

            'priority.required' => 'Приоритет обязателен',
            'priority.numeric' => 'Приоритет должен быть числом',
            'priority.between' => 'Приоритет должен быть между 0 и 1',

            'changefreq.required' => 'Частота изменения обязателена',
            'changefreq.in' => 'Недопустимое значение для частоты изменения',

            'is_indexed.boolean' => 'Поле "индексировать" должно быть логическим (true/false)',

            'notes.string' => 'Примечания должны быть строкой',
        ]);

        $data = $request->all();
        $data['last_modified'] = now();
        $data['is_indexed'] = $request->has('is_indexed');

        IndexablePage::create($data);

        return redirect()->route('admin.indexing.index')->with('success', 'Страница добавлена в индексацию!');
    }

    /**
     * Display the specified resource.
     */
    public function show(IndexablePage $indexing)
    {
        return view('admin.indexing.show', compact('indexing'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IndexablePage $indexing)
    {
        return view('admin.indexing.edit', compact('indexing'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, IndexablePage $indexing)
    {
        $request->validate([
            'url' => 'required|string|unique:indexable_pages,url,'.$indexing->id,
            'title' => 'required|string',
            'description' => 'nullable|string',
            'og_image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'priority' => 'required|numeric|between:0,1',
            'changefreq' => 'required|in:always,hourly,daily,weekly,monthly,yearly,never',
            'is_indexed' => 'boolean',
            'notes' => 'nullable|string',
        ], [
            'url.required' => 'URL обязателен',
            'url.string' => 'URL должен быть строкой',
            'url.unique' => 'Этот URL уже используется',

            'title.required' => 'Заголовок обязателен',
            'title.string' => 'Заголовок должен быть строкой',

            'description.string' => 'Описание должно быть строкой',

            'priority.required' => 'Приоритет обязателен',
            'priority.numeric' => 'Приоритет должен быть числом',
            'priority.between' => 'Приоритет должен быть между 0 и 1',

            'changefreq.required' => 'Частота изменения обязателена',
            'changefreq.in' => 'Недопустимое значение для частоты изменения',

            'is_indexed.boolean' => 'Поле "индексировать" должно быть логическим (true/false)',

            'notes.string' => 'Примечания должны быть строкой',
        ]);

        // Обработка загрузки OG изображения
        if ($request->hasFile('og_image_file')) {
            // Удаляем старое изображение, если оно есть
            if (!empty($indexing->og_image)) {
                $oldImagePath = public_path($indexing->og_image);
                if (file_exists($oldImagePath) && is_file($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Загружаем новое изображение
            $file = $request->file('og_image_file');
            $fileName = 'og-'.str_replace('/', '-', $indexing->url).'-'.time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('images'), $fileName);
            $indexing->og_image = '/images/'.$fileName;
        }

        $data = $request->all();
        $data['last_modified'] = now();
        $data['is_indexed'] = $request->has('is_indexed');
        
        // Убираем og_image_file из данных для сохранения (это временное поле)
        unset($data['og_image_file']);
        // Добавляем обновленный путь к изображению
        $data['og_image'] = $indexing->og_image;

        $indexing->update($data);

        return redirect()->route('admin.indexing.index')->with('success', 'Страница обновлена!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IndexablePage $indexing)
    {
        $indexing->delete();

        return redirect()->route('admin.indexing.index')->with('success', 'Страница удалена из индексации!');
    }

    /**
     * Дополнительные методы для управления индексацией
     */
    public function updateSettings(Request $request)
    {
        $request->validate([
            'global_indexing_enabled' => 'nullable|boolean',
            'sitemap_enabled' => 'nullable|boolean',
            'robots_txt_content' => 'required|string',
            'notes' => 'nullable|string',
        ], [
            'global_indexing_enabled.boolean' => 'Значение поля "Глобальная индексация" должно быть true или false',
            'sitemap_enabled.boolean' => 'Значение поля "Генерация sitemap" должно быть true или false',
            'robots_txt_content.required' => 'Содержимое robots.txt обязательно',
            'robots_txt_content.string' => 'Содержимое robots.txt должно быть строкой',
            'notes.string' => 'Примечания должны быть строкой',
        ]);

        $settings = IndexingSettings::current();
        $settings->update([
            'global_indexing_enabled' => $request->has('global_indexing_enabled'),
            'sitemap_enabled' => $request->has('sitemap_enabled'),
            'robots_txt_content' => $request->robots_txt_content,
            'notes' => $request->notes,
        ]);

        // Обновляем robots.txt файл
        $this->updateRobotsTxt($settings);

        return redirect()->route('admin.indexing.index')->with('success', 'Настройки индексации обновлены!');
    }

    public function toggleIndexing()
    {
        $settings = IndexingSettings::current();
        $settings->global_indexing_enabled = ! $settings->global_indexing_enabled;

        // Автоматически обновляем robots.txt
        if ($settings->global_indexing_enabled) {
            $settings->robots_txt_content = IndexingSettings::defaultRobotsTxt();
        } else {
            $settings->robots_txt_content = IndexingSettings::disallowAllRobotsTxt();
        }

        $settings->save();
        $this->updateRobotsTxt($settings);

        $status = $settings->global_indexing_enabled ? 'включена' : 'отключена';

        return redirect()->back()->with('success', "Индексация {$status}!");
    }

    public function togglePageIndexing(IndexablePage $indexing)
    {
        $indexing->is_indexed = ! $indexing->is_indexed;
        $indexing->last_modified = now();
        $indexing->save();

        $status = $indexing->is_indexed ? 'включена' : 'отключена';

        return redirect()->back()->with('success', "Индексация страницы {$status}!");
    }

    public function generateSitemap()
    {
        $settings = IndexingSettings::current();

        if (! $settings->sitemap_enabled) {
            return redirect()->back()->with('error', 'Генерация sitemap отключена в настройках!');
        }

        try {
            // Вызываем SitemapController напрямую (без HTTP-запроса)
            $sitemapController = new \App\Http\Controllers\SitemapController();
            $response = $sitemapController->index();
            $content = $response->getContent();

            if ($content && strlen($content) > 100) {
                // Создаем backup
                $backupPath = public_path('sitemap-backup.xml');
                $mainPath = public_path('sitemap.xml');

                // Если основной файл существует, делаем его бэкап
                if (File::exists($mainPath)) {
                    File::copy($mainPath, $backupPath);
                }

                // Записываем новый sitemap
                File::put($mainPath, $content);

                return redirect()->back()->with('success', 'Sitemap успешно обновлен! Файл: public/sitemap.xml');
            }

            return redirect()->back()->with('error', 'Sitemap содержит недостаточно данных');

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Ошибка генерации sitemap: '.$e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()->with('error', 'Ошибка при генерации sitemap: '.$e->getMessage());
        }
    }

    public function initializeDefaults()
    {
        // Создаем настройки индексации
        IndexingSettings::firstOrCreate([], [
            'global_indexing_enabled' => true,
            'robots_txt_content' => IndexingSettings::defaultRobotsTxt(),
            'sitemap_enabled' => true,
            'notes' => 'Настройки индексации по умолчанию',
        ]);

        // Создаем дефолтные страницы
        IndexablePage::createDefaultPages();
        
        // Синхронизируем динамические страницы
        $this->syncDynamicPages();

        return redirect()->back()->with('success', 'Настройки индексации и дефолтные страницы созданы!');
    }
    
    /**
     * Синхронизировать все динамические страницы с indexable_pages
     */
    public function syncDynamicPages()
    {
        $synced = 0;
        
        // Собираем все существующие URL
        $validUrls = [];
        
        // Синхронизируем подкатегории
        $subCategories = \App\Models\SubCategory::all();
        foreach ($subCategories as $subCategory) {
            if ($subCategory->slug) {
                $validUrls[] = $subCategory->slug;
                
                IndexablePage::updateOrCreate(
                    ['url' => $subCategory->slug],
                    [
                        'title' => $subCategory->title ?? 'Подкатегория',
                        'description' => $subCategory->description ?? '',
                        'priority' => 0.8,
                        'changefreq' => 'weekly',
                        'is_indexed' => true,
                        'last_modified' => $subCategory->updated_at,
                    ]
                );
                $synced++;
            }
        }
        
        // Синхронизируем под-подкатегории
        $subSubCategories = \App\Models\SubSubCategory::with('subCategory')->get();
        foreach ($subSubCategories as $subSubCategory) {
            if ($subSubCategory->subCategory && $subSubCategory->subCategory->slug && $subSubCategory->slug) {
                $url = $subSubCategory->subCategory->slug . '/' . $subSubCategory->slug;
                $validUrls[] = $url;
                
                IndexablePage::updateOrCreate(
                    ['url' => $url],
                    [
                        'title' => $subSubCategory->title ?? 'Направление',
                        'description' => $subSubCategory->description ?? '',
                        'priority' => 0.7,
                        'changefreq' => 'weekly',
                        'is_indexed' => true,
                        'last_modified' => $subSubCategory->updated_at,
                    ]
                );
                $synced++;
            }
        }
        
        // Удаляем устаревшие динамические страницы (которых уже нет в БД)
        $staticPages = ['/', '/about', '/direction', '/price-list', '/contacts', '/tea', '/calendar', '/recording', '/privacy-policy', '/personal-data'];
        
        $deleted = IndexablePage::whereNotIn('url', array_merge($validUrls, $staticPages))->delete();
        
        $message = "Синхронизировано страниц: {$synced}";
        if ($deleted > 0) {
            $message .= ". Удалено устаревших: {$deleted}";
        }
        
        return redirect()->back()->with('success', $message);
    }
    
    /**
     * Очистить устаревшие записи страниц
     */
    public function cleanupOrphanedPages()
    {
        $deleted = 0;
        
        // Получаем все страницы из indexable_pages
        $allPages = IndexablePage::all();
        
        foreach ($allPages as $page) {
            $url = $page->url;
            
            // Пропускаем статические страницы
            $staticPages = ['/', '/about', '/direction', '/price-list', '/contacts', '/tea', '/calendar', '/recording', '/privacy-policy', '/personal-data'];
            if (in_array($url, $staticPages)) {
                continue;
            }
            
            // Проверяем, существует ли эта динамическая страница
            $exists = false;
            
            // Проверяем подкатегории (одиночный slug)
            if (!str_contains($url, '/')) {
                $exists = \App\Models\SubCategory::where('slug', $url)->exists();
            } else {
                // Проверяем подподкатегории (slug/slug)
                $parts = explode('/', $url);
                if (count($parts) === 2) {
                    $exists = \App\Models\SubSubCategory::whereHas('subCategory', function($q) use ($parts) {
                        $q->where('slug', $parts[0]);
                    })->where('slug', $parts[1])->exists();
                }
            }
            
            // Если страница не существует, удаляем запись
            if (!$exists) {
                $page->delete();
                $deleted++;
            }
        }
        
        if ($deleted > 0) {
            \Illuminate\Support\Facades\Log::info("Очищено устаревших страниц: {$deleted}");
            return redirect()->back()->with('success', "Удалено устаревших страниц: {$deleted}");
        }
        
        return redirect()->back()->with('info', 'Устаревших страниц не найдено');
    }

    private function updateRobotsTxt($settings)
    {
        File::put(public_path('robots.txt'), $settings->robots_txt_content);
    }
}
