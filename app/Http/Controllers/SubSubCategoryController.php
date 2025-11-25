<?php

namespace App\Http\Controllers;

use App\Models\MainCategory;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubSubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = SubSubCategory::with('subCategory.mainCategory');

        // Фильтр по подкатегории
        if ($request->filled('sub_category_id')) {
            $query->where('sub_category_id', $request->sub_category_id);
        }

        // Фильтр по главной категории (через подкатегорию)
        if ($request->filled('main_category_id')) {
            $query->whereHas('subCategory', function ($q) use ($request) {
                $q->where('main_category_id', $request->main_category_id);
            });
        }

        $subSubCategories = $query->orderBy('id', 'desc')->get();
        $mainCategories = MainCategory::orderBy('title')->get();
        $subCategories = SubCategory::orderBy('title')->get();

        return view('admin.sub_sub_categories.index', compact('subSubCategories', 'mainCategories', 'subCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mainCategories = MainCategory::all();
        $subCategories = SubCategory::all();

        return view('admin.sub_sub_categories.create', compact('mainCategories', 'subCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Валидация
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'about_title' => 'required|string|max:255',
            'benefit_title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'about' => 'nullable|string',
            'image' => 'sometimes|image|mimes:webp|max:2048',
            'photos.*' => 'nullable|image|mimes:webp|max:2048',
            'sub_category_id' => 'required|integer|exists:sub_categories,id',
            'benefit_groups' => 'nullable|array',
            'benefit_groups.*.title' => 'nullable|string',
            'benefit_groups.*.benefits' => 'nullable|array',
            'benefit_groups.*.benefits.*' => 'nullable|string',
        ], [
            'title.required' => 'Название обязательно',
            'title.string' => 'Название должно быть строкой',
            'title.max' => 'Название не должно превышать 255 символов',

            'about_title.required' => 'Название обязательно',
            'about_title.string' => 'Название должно быть строкой',
            'about_title.max' => 'Название не должно превышать 255 символов',

            'benefit_title.required' => 'Название обязательно',
            'benefit_title.string' => 'Название должно быть строкой',
            'benefit_title.max' => 'Название не должно превышать 255 символов',

            'description.string' => 'Описание должно быть строкой',
            'about.string' => 'Поле "о программе" должно быть строкой',

            'image.image' => 'Файл должен быть изображением',
            'image.mimes' => 'Фотография должна быть в формате .webp',
            'image.max' => 'Размер изображения не должен превышать 2 МБ',

            'photos.*.image' => 'Файл должен быть изображением',
            'photos.*.mimes' => 'Фотография должна быть в формате .webp',
            'photos.*.max' => 'Размер фотографии не должен превышать 2 МБ',

            'sub_category_id.required' => 'Необходимо указать подкатегорию',
            'sub_category_id.integer' => 'Неверный идентификатор подкатегории',
            'sub_category_id.exists' => 'Выбранная подкатегория не найдена',

            'benefit_groups.array' => 'Неверный формат групп преимуществ',
            'benefit_groups.*.title.max' => 'Название группы не должно превышать 255 символов',
            'benefit_groups.*.benefits.*.max' => 'Размер преимущества не должен превышать 255 символов',
        ]);

        // Основные поля
        $data = [
            'title' => trim($validated['title']),
            'about_title' => trim($validated['about_title']),
            'benefit_title' => trim($validated['benefit_title']),
            'description' => $validated['description'] ? trim($validated['description']) : null,
            'about' => $validated['about'] ? trim($validated['about']) : null,
            'sub_category_id' => $validated['sub_category_id'],
        ];

        // Обработка групп преимуществ
        $benefitGroups = [];
        foreach ($validated['benefit_groups'] ?? [] as $group) {
            $groupTitle = trim($group['title'] ?? '');
            $rawBenefits = $group['benefits'] ?? [];

            $benefits = array_values(array_filter(array_map(function ($b) {
                return is_string($b) ? trim($b) : null;
            }, $rawBenefits)));

            if ($groupTitle !== '' && ! empty($benefits)) {
                $benefitGroups[] = [
                    'title' => $groupTitle,
                    'benefits' => $benefits,
                ];
            }
        }
        $data['benefits'] = $benefitGroups;

        // Основное изображение
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('sub_sub_categories', 'public');
        }

        // Создаём подподкатегорию
        $subSub = SubSubCategory::create($data);

        // Множественные фотографии
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $subSub->photos()->create([
                    'image' => $photo->store('sub_sub_photos', 'public'),
                ]);
            }
        }

        return redirect()->route('admin.sub-sub-categories.index')
            ->with('success', 'Подподкатегория успешно добавлена');
    }

    /**
     * Display the specified resource.
     */
    public function show(SubSubCategory $subSubCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubSubCategory $subSubCategory)
    {
        $mainCategories = MainCategory::all();
        $subCategories = SubCategory::all();

        return view('admin.sub_sub_categories.edit', compact('subSubCategory', 'mainCategories', 'subCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubSubCategory $subSubCategory)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'about_title' => 'required|string|max:255',
            'benefit_title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'about' => 'nullable|string',
            'image' => 'sometimes|image|mimes:webp|max:2048',
            'photos.*' => 'nullable|image|mimes:webp|max:2048',
            'sub_category_id' => 'required|integer|exists:sub_categories,id',
            'benefit_groups' => 'nullable|array',
            'benefit_groups.*.title' => 'nullable|string',
            'benefit_groups.*.benefits' => 'nullable|array',
            'benefit_groups.*.benefits.*' => 'nullable|string',
        ], [
            'title.required' => 'Название обязательно',
            'title.string' => 'Название должно быть строкой',
            'title.max' => 'Название не должно превышать 255 символов',

            'about_title.required' => 'Название обязательно',
            'about_title.string' => 'Название должно быть строкой',
            'about_title.max' => 'Название не должно превышать 255 символов',

            'benefit_title.required' => 'Название обязательно',
            'benefit_title.string' => 'Название должно быть строкой',
            'benefit_title.max' => 'Название не должно превышать 255 символов',

            'description.string' => 'Описание должно быть строкой',
            'about.string' => 'Поле "о программе" должно быть строкой',

            'image.image' => 'Файл должен быть изображением',
            'image.mimes' => 'Фотография должна быть в формате .webp',
            'image.max' => 'Размер изображения не должен превышать 2 МБ',

            'photos.*.image' => 'Файл должен быть изображением',
            'photos.*.mimes' => 'Фотография должна быть в формате .webp',
            'photos.*.max' => 'Размер фотографии не должен превышать 2 МБ',

            'sub_category_id.required' => 'Необходимо указать подкатегорию',
            'sub_category_id.integer' => 'Неверный идентификатор подкатегории',
            'sub_category_id.exists' => 'Выбранная подкатегория не найдена',

            'benefit_groups.array' => 'Неверный формат групп преимуществ',
            'benefit_groups.*.title.max' => 'Название группы не должно превышать 255 символов',
            'benefit_groups.*.benefits.*.max' => 'Размер преимущества не должен превышать 255 символов',
        ]);

        // Основные поля
        $data = [
            'title' => trim($validated['title']),
            'about_title' => trim($validated['about_title']),
            'benefit_title' => trim($validated['benefit_title']),
            'description' => $validated['description'] ? trim($validated['description']) : null,
            'about' => $validated['about'] ? trim($validated['about']) : null,
            'sub_category_id' => $validated['sub_category_id'],
        ];

        // Обработка групп преимуществ
        $benefitGroups = [];
        foreach ($validated['benefit_groups'] ?? [] as $group) {
            $groupTitle = trim($group['title'] ?? '');
            $rawBenefits = $group['benefits'] ?? [];
            $benefits = array_values(array_filter(array_map(function ($b) {
                return is_string($b) ? trim($b) : null;
            }, $rawBenefits)));
            if ($groupTitle !== '' && ! empty($benefits)) {
                $benefitGroups[] = [
                    'title' => $groupTitle,
                    'benefits' => $benefits,
                ];
            }
        }
        $data['benefits'] = $benefitGroups;

        // Основное изображение: если загружено — удаляем старое и сохраняем новое
        if ($request->hasFile('image')) {
            if ($subSubCategory->image && Storage::disk('public')->exists($subSubCategory->image)) {
                Storage::disk('public')->delete($subSubCategory->image);
            }
            $data['image'] = $request->file('image')->store('sub_sub_categories', 'public');
        }

        // Обновляем подподкатегорию
        $subSubCategory->update($data);

        // Множественные фотографии: добавляем новые
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $subSubCategory->photos()->create([
                    'image' => $photo->store('sub_sub_photos', 'public'),
                ]);
            }
        }

        return redirect()->route('admin.sub-sub-categories.index')
            ->with('success', 'Подподкатегория успешно обновлена');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubSubCategory $subSubCategory)
    {
        if ($subSubCategory->image) {
            Storage::disk('public')->delete($subSubCategory->image);
        }

        $subSubCategory->delete();

        return redirect()->route('admin.sub-sub-categories.index')
            ->with('success', 'Подподкатегория успешно удалена');
    }
}
