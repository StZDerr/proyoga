<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::orderBy('id', 'desc')->paginate(25);

        return view('admin.companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.companies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // базовая валидация (без проверки файлов social_icons)
        $baseRules = [
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'photo' => 'nullable|file|image|mimes:webp|max:150', // max 150 KB
            'advantages' => 'nullable|string',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'socials' => 'nullable|array',
            'socials.*' => 'nullable|url',
        ];

        // подготовим правила только для реально загруженных файлов social_icons
        $fileRules = [];
        $files = $request->file('social_icons', []);
        if (is_array($files) && count($files)) {
            foreach ($files as $key => $file) {
                if ($file instanceof UploadedFile) {
                    $fileRules["social_icons.$key"] = 'file|mimes:svg|max:2048';
                }
            }
        }

        $rules = array_merge($baseRules, $fileRules);

        $validated = $request->validate($rules);

        // socials из формы
        $socials = $validated['socials'] ?? [];

        // Подготовим данные для создания компании — убираем файлы и socials
        $companyData = $validated;
        unset($companyData['socials'], $companyData['social_icons'], $companyData['photo']);

        // Создаём компанию (без файлов)
        $company = Company::create($companyData);

        // Обработка и сохранение фото компании (если есть)
        try {
            $photoFile = $request->file('photo');
            if ($photoFile instanceof UploadedFile) {
                $photoDest = public_path('images/companies');
                if (! file_exists($photoDest)) {
                    mkdir($photoDest, 0755, true);
                }

                $ext = $photoFile->getClientOriginalExtension() ?: 'webp';
                $base = Str::slug($company->name ?: 'company');
                $photoName = $base.'-'.time().'.'.$ext;

                $photoFile->move($photoDest, $photoName);

                // Сохраняем имя файла в модели (предполагается поле `photo` в БД)
                $company->photo = $photoName;
                $company->save();
            }
        } catch (\Throwable $e) {
            \Log::warning("CompanyController@store: ошибка при сохранении фото для компании #{$company->id}: ".$e->getMessage());
        }

        // Обработка и сохранение SVG-иконок (если загружены)
        if (is_array($files) && count($files)) {
            $svgDest = public_path('images/svg');
            if (! file_exists($svgDest)) {
                mkdir($svgDest, 0755, true);
            }

            foreach ($files as $key => $file) {
                if ($file instanceof UploadedFile) {
                    $slug = Str::slug((string) $key);
                    $filename = $slug.'.svg';
                    $targetPath = $svgDest.DIRECTORY_SEPARATOR.$filename;

                    try {
                        // move перезапишет существующий файл
                        $file->move($svgDest, $filename);
                    } catch (\Throwable $e) {
                        \Log::error("CompanyController@store: не удалось сохранить SVG {$filename}: ".$e->getMessage());
                    }
                }
            }
        }

        // Сохраняем socials (модель должна иметь 'socials' => 'array' в $casts)
        try {
            $company->socials = $socials;
            $company->save();
        } catch (\Throwable $e) {
            \Log::error("CompanyController@store: не удалось сохранить socials для компании #{$company->id}: ".$e->getMessage());
        }

        return redirect()
            ->route('admin.companies.index')
            ->with('success', 'Компания успешно создана.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        // Приводим socials к массиву для удобства в шаблоне
        $socials = is_array($company->socials) ? $company->socials : ([]);

        return view('admin.companies.show', compact('company', 'socials'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        // передаём модель в view — форма будет заполняться значениями из $company
        return view('admin.companies.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        // базовая валидация (без проверки файлов social_icons)
        $baseRules = [
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'photo' => 'nullable|file|image|mimes:webp|max:150', // max 150кб
            'advantages' => 'nullable|string',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'socials' => 'nullable|array',
            'socials.*' => 'nullable|url',
        ];

        // подготовим правила только для реально загруженных файлов social_icons
        $fileRules = [];
        $files = $request->file('social_icons', []);
        if (is_array($files) && count($files)) {
            foreach ($files as $key => $file) {
                if ($file instanceof UploadedFile) {
                    $fileRules["social_icons.$key"] = 'file|mimes:svg|max:2048';
                }
            }
        }

        $rules = array_merge($baseRules, $fileRules);

        $validated = $request->validate($rules);

        $socials = $validated['socials'] ?? [];

        // Подготовим данные для массового обновления (без socials, social_icons и photo)
        $companyData = $validated;
        unset($companyData['socials'], $companyData['social_icons'], $companyData['photo']);

        // Обновляем модель (без файлов)
        $company->update($companyData);

        // Обработка и сохранение новой фотографии (если была загружена)
        try {
            $photoFile = $request->file('photo');
            if ($photoFile instanceof UploadedFile) {
                $photoDest = public_path('images/companies');
                if (! file_exists($photoDest)) {
                    mkdir($photoDest, 0755, true);
                }

                $ext = $photoFile->getClientOriginalExtension() ?: 'webp';
                $base = Str::slug($company->name ?: 'company');
                $photoName = $base.'-'.time().'.'.$ext;
                $targetPath = $photoDest.DIRECTORY_SEPARATOR.$photoName;

                // Сохраняем новый файл
                try {
                    $photoFile->move($photoDest, $photoName);
                } catch (\Throwable $e) {
                    \Log::error("CompanyController@update: не удалось сохранить фото {$photoName}: ".$e->getMessage());
                    // не прерываем выполнение, но не будем менять значение photo в модели
                    $photoName = null;
                }

                if (! empty($photoName)) {
                    // Удаляем старый файл, если он существует и отличается по имени
                    if (! empty($company->photo)) {
                        $oldPath = $photoDest.DIRECTORY_SEPARATOR.$company->photo;
                        if (file_exists($oldPath) && is_file($oldPath)) {
                            try {
                                @unlink($oldPath);
                            } catch (\Throwable $e) {
                                \Log::warning("CompanyController@update: не удалось удалить старое фото {$oldPath}: ".$e->getMessage());
                            }
                        }
                    }

                    // Сохраняем новое имя в модели
                    $company->photo = $photoName;
                    $company->save();
                }
            }
        } catch (\Throwable $e) {
            \Log::warning("CompanyController@update: ошибка при обработке фото для компании #{$company->id}: ".$e->getMessage());
        }

        // Обрабатываем и сохраняем SVG иконки (если есть реальные файлы)
        if (is_array($files) && count($files)) {
            $dest = public_path('images/svg');
            if (! file_exists($dest)) {
                mkdir($dest, 0755, true);
            }

            foreach ($files as $key => $file) {
                if ($file instanceof UploadedFile) {
                    $slug = Str::slug((string) $key);
                    $filename = $slug.'.svg';
                    $targetPath = $dest.DIRECTORY_SEPARATOR.$filename;

                    // Если старый файл существует — удаляем его перед сохранением нового
                    if (file_exists($targetPath)) {
                        try {
                            @unlink($targetPath);
                        } catch (\Throwable $e) {
                            \Log::warning("Не удалось удалить старую иконку {$targetPath}: ".$e->getMessage());
                        }
                    }

                    // Перемещаем новый файл
                    try {
                        $file->move($dest, $filename);
                    } catch (\Throwable $e) {
                        \Log::error("Ошибка при сохранении иконки {$filename}: ".$e->getMessage());
                    }
                }
            }
        }

        // Сохраняем socials как JSON (в модели Company есть cast 'socials' => 'array')
        try {
            $company->socials = $socials;
            $company->save();
        } catch (\Throwable $e) {
            \Log::error("CompanyController@update: не удалось сохранить socials для компании #{$company->id}: ".$e->getMessage());
        }

        return redirect()
            ->route('admin.companies.index')
            ->with('success', 'Компания успешно обновлена.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        // Путь к папке с иконками
        $dest = public_path('images/svg');

        // Удаление фото компании (если есть)
        $photoRaw = $company->photo ?? null;
        if (! empty($photoRaw)) {
            $deleted = false;

            // 1) Если файл хранится на public disk (storage/app/public) — попробуем через Storage
            try {
                if (\Illuminate\Support\Facades\Storage::disk('public')->exists($photoRaw)) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($photoRaw);
                    $deleted = true;
                }
            } catch (\Throwable $e) {
                \Log::warning("CompanyController@destroy: Storage::delete error for photo '{$photoRaw}': ".$e->getMessage());
            }

            // 2) Попробуем набор локальных путей: имя файла в public/images/companies, абсолютный/относительный путь, storage_path
            if (! $deleted) {
                $candidates = [];

                // Если в поле хранится полный URL — возьмём basename и путь из URL
                if (preg_match('@^https?://@i', $photoRaw)) {
                    $urlPath = parse_url($photoRaw, PHP_URL_PATH) ?: '';
                    $basename = basename($urlPath);
                    if ($basename) {
                        $candidates[] = public_path('images/companies/'.$basename);
                        $candidates[] = storage_path('app/public/'.$basename);
                    }
                    if ($urlPath) {
                        $candidates[] = public_path(ltrim($urlPath, '/'));
                        $candidates[] = storage_path('app/public/'.ltrim($urlPath, '/'));
                    }
                } elseif (strpos($photoRaw, '/') === 0) {
                    // относительный путь от public, например /images/companies/xxx.webp
                    $candidates[] = public_path(ltrim($photoRaw, '/'));
                    $candidates[] = storage_path('app/public/'.ltrim($photoRaw, '/'));
                } else {
                    // просто имя файла
                    $candidates[] = public_path('images/companies/'.$photoRaw);
                    $candidates[] = storage_path('app/public/'.$photoRaw);
                }

                foreach ($candidates as $path) {
                    if (! $path) {
                        continue;
                    }
                    if (file_exists($path) && is_file($path)) {
                        try {
                            @unlink($path);
                            $deleted = true;
                            break;
                        } catch (\Throwable $e) {
                            \Log::warning("CompanyController@destroy: не удалось удалить фото {$path}: ".$e->getMessage());
                        }
                    }
                }
            }

            if (! $deleted) {
                \Log::info("CompanyController@destroy: фото для компании #{$company->id} ({$photoRaw}) не найдено для удаления.");
            } else {
                \Log::info("CompanyController@destroy: фото для компании #{$company->id} удалено.");
            }
        }

        // Получаем ключи соцсетей у удаляемой компании
        $socials = is_array($company->socials) ? $company->socials : [];

        // Получаем socials всех остальных компаний (для проверки использования иконки)
        $otherSocials = Company::where('id', '<>', $company->id)
            ->pluck('socials')
            ->filter()
            ->map(function ($s) {
                return is_array($s) ? $s : [];
            })
            ->all();

        foreach ($socials as $key => $link) {
            // Пропускаем пустые ссылки
            if (trim((string) $link) === '') {
                continue;
            }

            $slug = Str::slug((string) $key);
            $filename = $slug.'.svg';
            $targetPath = $dest.DIRECTORY_SEPARATOR.$filename;

            // Проверим, используется ли этот ключ у других компаний
            $usedByOthers = false;
            foreach ($otherSocials as $other) {
                if (is_array($other) && array_key_exists($key, $other) && trim((string) ($other[$key] ?? '')) !== '') {
                    $usedByOthers = true;
                    break;
                }
            }

            // Если никто не использует — удаляем файл
            if (! $usedByOthers && file_exists($targetPath)) {
                try {
                    @unlink($targetPath);
                } catch (\Throwable $e) {
                    \Log::warning("CompanyController@destroy: не удалось удалить иконку {$targetPath}: ".$e->getMessage());
                }
            }
        }

        // Теперь безопасно удаляем запись из БД
        try {
            $company->delete();
        } catch (\Throwable $e) {
            \Log::error("CompanyController@destroy: ошибка при удалении компании #{$company->id}: ".$e->getMessage());

            return redirect()
                ->route('admin.companies.index')
                ->with('error', 'Не удалось удалить компанию. Подробнее в логах.');
        }

        return redirect()
            ->route('admin.companies.index')
            ->with('success', 'Компания, её фотография и связанные неиспользуемые иконки успешно удалены.');
    }
}
