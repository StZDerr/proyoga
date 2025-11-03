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
            'is_indexed' => 'boolean',
            'notes' => 'nullable|string',
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
            'priority' => 'required|numeric|between:0,1',
            'changefreq' => 'required|in:always,hourly,daily,weekly,monthly,yearly,never',
            'is_indexed' => 'boolean',
            'notes' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['last_modified'] = now();
        $data['is_indexed'] = $request->has('is_indexed');

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

        if (!$settings->sitemap_enabled) {
            return redirect()->back()->with('error', 'Генерация sitemap отключена в настройках!');
        }

        // Проверяем, что динамический sitemap работает
        try {
            $response = file_get_contents(route('sitemap'));
            if ($response) {
                // Дополнительно создаем статический файл для резервного копирования
                File::put(public_path('sitemap-backup.xml'), $response);
                
                return redirect()->back()->with('success', 'Динамический sitemap работает! Доступен по адресу: ' . route('sitemap'));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ошибка при проверке sitemap: ' . $e->getMessage());
        }

        return redirect()->back()->with('error', 'Не удалось сгенерировать sitemap');
    }

    public function initializeDefaults()
    {
        // Создаем настройки индексации
        IndexingSettings::firstOrCreate([], [
            'global_indexing_enabled' => true,
            'robots_txt_content' => IndexingSettings::defaultRobotsTxt(),
            'sitemap_enabled' => true,
            'notes' => 'Настройки индексации по умолчанию'
        ]);

        // Создаем дефолтные страницы
        IndexablePage::createDefaultPages();

        return redirect()->back()->with('success', 'Настройки индексации и дефолтные страницы созданы!');
    }

    private function updateRobotsTxt($settings)
    {
        File::put(public_path('robots.txt'), $settings->robots_txt_content);
    }
}
