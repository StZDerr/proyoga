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
    public function index()
    {
        $subSubCategories = SubSubCategory::with('subCategory.mainCategory')->orderBy('id', 'desc')->get();

        return view('admin.sub_sub_categories.index', compact('subSubCategories'));

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
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'about' => 'nullable|string',
            'image' => 'sometimes|image|mimes:webp|max:2048',
            'sub_category_id' => 'required|integer|exists:sub_categories,id',
            'benefit_groups' => 'nullable|array',
            'benefit_groups.*.title' => 'nullable|string',
            'benefit_groups.*.benefits' => 'nullable|array',
            'benefit_groups.*.benefits.*' => 'nullable|string',
        ], [
            'title.required' => 'Название обязательно',
            'title.string' => 'Название должно быть строкой',
            'title.max' => 'Название не должно превышать 255 символов',

            'description.string' => 'Описание должно быть строкой',
            'about.string' => 'Поле "о товаре" должно быть строкой',

            'image.image' => 'Файл должен быть изображением',
            'image.mimes' => 'Фотография должна быть в формате .webp',
            'image.max' => 'Размер изображения не должен превышать 2 МБ',

            'sub_category_id.required' => 'Необходимо указать подкатегорию',
            'sub_category_id.integer' => 'Неверный идентификатор подкатегории',
            'sub_category_id.exists' => 'Выбранная подкатегория не найдена',

            'benefit_groups.array' => 'Неверный формат групп преимуществ',
            'benefit_groups.*.title.max' => 'Название группы не должно превышать 255 символов',
            'benefit_groups.*.benefits.*.max' => 'Размер преимущества не должен превышать 255 символов',
        ]);

        // Берём основные поля из валидированных данных
        $data = [
            'title' => trim($validated['title']),
            'description' => isset($validated['description']) ? trim($validated['description']) : null,
            'about' => isset($validated['about']) ? trim($validated['about']) : null,
            'sub_category_id' => $validated['sub_category_id'],
        ];

        // Обрабатываем группы преимуществ безопасно из $validated
        $benefitGroups = [];
        foreach ($validated['benefit_groups'] ?? [] as $group) {
            $groupTitle = trim($group['title'] ?? '');
            $rawBenefits = $group['benefits'] ?? [];
            // Очищаем и тримим преимущества
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

        // Файл изображения
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('sub_sub_categories', 'public');
        }

        SubSubCategory::create($data);

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
            'description' => 'nullable|string',
            'about' => 'nullable|string',
            'image' => 'sometimes|image|mimes:webp|max:2048',
            'sub_category_id' => 'required|integer|exists:sub_categories,id',
            'benefit_groups' => 'nullable|array',
            'benefit_groups.*.title' => 'nullable|string',
            'benefit_groups.*.benefits' => 'nullable|array',
            'benefit_groups.*.benefits.*' => 'nullable|string',
        ], [
            'title.required' => 'Название обязательно',
            'title.string' => 'Название должно быть строкой',
            'title.max' => 'Название не должно превышать 255 символов',

            'description.string' => 'Описание должно быть строкой',
            'about.string' => 'Поле "о товаре" должно быть строкой',

            'image.image' => 'Файл должен быть изображением',
            'image.mimes' => 'Фотография должна быть в формате .webp',
            'image.max' => 'Размер изображения не должен превышать 2 МБ',

            'sub_category_id.required' => 'Необходимо указать подкатегорию',
            'sub_category_id.integer' => 'Неверный идентификатор подкатегории',
            'sub_category_id.exists' => 'Выбранная подкатегория не найдена',

            'benefit_groups.array' => 'Неверный формат групп преимуществ',
            'benefit_groups.*.title.max' => 'Название группы не должно превышать 255 символов',
            'benefit_groups.*.benefits.*.max' => 'Размер преимущества не должен превышать 255 символов',
        ]);

        $data = [
            'title' => trim($validated['title']),
            'description' => isset($validated['description']) ? trim($validated['description']) : null,
            'about' => isset($validated['about']) ? trim($validated['about']) : null,
            'sub_category_id' => $validated['sub_category_id'],
        ];

        // Обрабатываем benefit_groups из $validated
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

        // Обработка изображения: если загружено — удаляем старое и сохраняем новое
        if ($request->hasFile('image')) {
            if ($subSubCategory->image && Storage::disk('public')->exists($subSubCategory->image)) {
                Storage::disk('public')->delete($subSubCategory->image);
            }
            $data['image'] = $request->file('image')->store('sub_sub_categories', 'public');
        }

        $subSubCategory->update($data);

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
