<?php

namespace App\Http\Controllers;

use App\Models\Personal;
use App\Models\PersonalPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PersonalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $personals = Personal::withCount('photos')->orderBy('sort_order')->get();

        return view('admin.personal.index', compact('personals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.personal.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'position' => 'required|string|max:255',
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('personals', 'slug')],
            'sort_order' => 'nullable|integer',
            'description' => 'nullable|string',
            'photo' => 'sometimes|file|mimes:webp|max:2048', // webp, до 2 МБ
            'photos' => 'sometimes|array',
            'photos.*' => 'file|mimes:webp|max:2048',
        ], [
            'first_name.required' => 'Имя обязательно',
            'first_name.string' => 'Имя должно быть строкой',
            'first_name.max' => 'Имя не должно превышать 255 символов',

            'last_name.required' => 'Фамилия обязательна',
            'last_name.string' => 'Фамилия должна быть строкой',
            'last_name.max' => 'Фамилия не должна превышать 255 символов',

            'middle_name.string' => 'Отчество должно быть строкой',
            'middle_name.max' => 'Отчество не должно превышать 255 символов',

            'position.required' => 'Должность обязательна',
            'position.string' => 'Должность должна быть строкой',
            'position.max' => 'Должность не должна превышать 255 символов',

            'sort_order.integer' => 'Порядок должен быть числом',
            'description.string' => 'Описание должно быть строкой',

            'photo.mimes' => 'Фотография должна быть в формате .webp',
            'photo.max' => 'Размер фотографии не должен превышать 2 МБ',

            'photos.*.mimes' => 'Дополнительные фотографии должны быть в формате .webp',
            'photos.*.max' => 'Размер дополнительной фотографии не должен превышать 2 МБ',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('personal', 'public');
        }

        // generate slug if missing
        if (empty($validated['slug'])) {
            $base = Str::slug($validated['first_name'].' '.$validated['last_name']);
            $slug = $base;
            $i = 1;
            while (Personal::where('slug', $slug)->exists()) {
                $slug = $base.'-'.$i++;
            }
            $validated['slug'] = $slug;
        }

        $personal = Personal::create($validated);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $path = $file->store('personal', 'public');
                PersonalPhoto::create([
                    'personal_id' => $personal->id,
                    'path' => $path,
                ]);
            }
        }

        return redirect()->route('admin.personal.index')->with('success', 'Сотрудник успешно добавлен!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Personal $personal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Personal $personal)
    {
        return view('admin.personal.edit', compact('personal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Personal $personal)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'position' => 'required|string|max:255',
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('personals', 'slug')->ignore($personal->id)],
            'sort_order' => 'nullable|integer',
            'description' => 'nullable|string',
            'photo' => 'sometimes|file|mimes:webp|max:2048', // сделал тот же лимит (2 МБ)
            'photos' => 'sometimes|array',
            'photos.*' => 'file|mimes:webp|max:2048',
        ], [
            'first_name.required' => 'Имя обязательно',
            'first_name.string' => 'Имя должно быть строкой',
            'first_name.max' => 'Имя не должно превышать 255 символов',

            'last_name.required' => 'Фамилия обязательна',
            'last_name.string' => 'Фамилия должна быть строкой',
            'last_name.max' => 'Фамилия не должна превышать 255 символов',

            'middle_name.string' => 'Отчество должно быть строкой',
            'middle_name.max' => 'Отчество не должно превышать 255 символов',

            'position.required' => 'Должность обязательна',
            'position.string' => 'Должность должна быть строкой',
            'position.max' => 'Должность не должна превышать 255 символов',

            'sort_order.integer' => 'Порядок должен быть числом',
            'description.string' => 'Описание должно быть строкой',

            'photo.mimes' => 'Фотография должна быть в формате .webp',
            'photo.max' => 'Размер фотографии не должен превышать 2 МБ',

            'photos.*.mimes' => 'Дополнительные фотографии должны быть в формате .webp',
            'photos.*.max' => 'Размер дополнительной фотографии не должен превышать 2 МБ',
        ]);

        if ($request->hasFile('photo')) {
            // Удаляем старое фото, если есть
            if ($personal->photo) {
                Storage::disk('public')->delete($personal->photo);
            }
            $validated['photo'] = $request->file('photo')->store('personal', 'public');
        }

        // generate slug if missing
        if (empty($validated['slug'])) {
            $base = Str::slug($validated['first_name'].' '.$validated['last_name']);
            $slug = $base;
            $i = 1;
            while (Personal::where('slug', $slug)->where('id', '!=', $personal->id)->exists()) {
                $slug = $base.'-'.$i++;
            }
            $validated['slug'] = $slug;
        }

        $personal->update($validated);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $path = $file->store('personal', 'public');
                PersonalPhoto::create([
                    'personal_id' => $personal->id,
                    'path' => $path,
                ]);
            }
        }

        return redirect()->route('admin.personal.index')
            ->with('success', 'Персонал успешно обновлен!');
    }

    /**
     * Удалить фотографию из галереи
     */
    public function destroyPhoto(Request $request, Personal $personal, $photoId)
    {
        $photo = $personal->photos()->findOrFail($photoId);

        // Попытка удалить файл — игнорируем результат
        try {
            Storage::disk('public')->delete($photo->path);
        } catch (\Exception $e) {
            // логирование не критично, продолжаем
        }

        $photo->delete();

        // Если запрос ожидает JSON (AJAX) — возвращаем JSON-ответ
        if ($request->expectsJson() || $request->wantsJson()) {
            return response()->json(['success' => true], 200);
        }

        return redirect()->back()->with('success', 'Фото удалено!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Personal $personal)
    {
        // удалить главное фото
        if ($personal->photo) {
            Storage::disk('public')->delete($personal->photo);
        }

        // удалить файлы галереи
        foreach ($personal->photos as $photo) {
            Storage::disk('public')->delete($photo->path);
            $photo->delete();
        }

        $personal->delete();

        return redirect()->route('admin.personal.index')
            ->with('success', 'Персонал успешно удалён!');
    }
}
