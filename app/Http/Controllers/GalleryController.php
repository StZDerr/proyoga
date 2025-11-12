<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galleries = Gallery::orderBy('sort_order')->get();

        return view('admin.gallery.index', compact('galleries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.gallery.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|file|mimes:webp|max:1024',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ], [
            'title.required' => 'Заголовок обязателен',
            'title.string' => 'Заголовок должен быть строкой',
            'title.max' => 'Заголовок не должен превышать 255 символов',

            'description.string' => 'Описание должно быть строкой',

            'image.required' => 'Фотография обязательна',
            'image.file' => 'Фотография должна быть файлом',
            'image.mimes' => 'Фотография должна быть в формате .webp',
            'image.max' => 'Размер фотографии не должен превышать 1 МБ',

            'is_active.boolean' => 'Неверное значение для поля "Активна"',
            'sort_order.integer' => 'Порядок должен быть числом',
            'sort_order.min' => 'Порядок не может быть меньше 0',
        ]);

        // Обработка чекбокса (если не отмечен, ставим 0)
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        // Если загружена картинка — сохраняем и меняем путь
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('gallery', 'public');
        }

        // Создаем запись
        Gallery::create($validated);

        return redirect()->route('admin.gallery.index')->with('success', 'Фото успешно добавлено!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Gallery $gallery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gallery $gallery)
    {
        return view('admin.gallery.edit', compact('gallery'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gallery $gallery)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|file|mimes:webp|max:1024',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ], [
            'title.required' => 'Заголовок обязателен',
            'title.string' => 'Заголовок должен быть строкой',
            'title.max' => 'Заголовок не должен превышать 255 символов',

            'description.string' => 'Описание должно быть строкой',

            'image.file' => 'Фотография должна быть файлом',
            'image.mimes' => 'Фотография должна быть в формате .webp',
            'image.max' => 'Размер фотографии не должен превышать 1 МБ',

            'is_active.boolean' => 'Неверное значение для поля "Активна"',
            'sort_order.integer' => 'Порядок должен быть числом',
            'sort_order.min' => 'Порядок не может быть меньше 0',
        ]);

        // Обработка чекбокса is_active (если не отмечен, ставим 0)
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        // Обработка загруженного изображения
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('gallery', 'public');
        }

        $gallery->update($validated);

        return redirect()->route('admin.gallery.index')->with('success', 'Фото успешно обновлено!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gallery $gallery)
    {
        $gallery->delete();

        return redirect()->route('admin.gallery.index')->with('success', 'Фото успешно удалено!');
    }

    public function reorder(Request $request)
    {
        $data = $request->validate([
            'order' => 'required|array',
            'order.*' => 'required|integer|exists:galleries,id',
        ]);

        $order = $data['order'];

        DB::transaction(function () use ($order) {
            foreach ($order as $index => $id) {
                // Устанавливаем порядковый номер начиная с 1
                DB::table('galleries')->where('id', $id)->update(['sort_order' => $index + 1]);
            }
        });

        // Возвращаем map id => order для обновления UI (опционально)
        $updated = [];
        foreach ($order as $index => $id) {
            $updated[$id] = $index + 1;
        }

        return response()->json(['status' => 'ok', 'updated' => $updated]);
    }

    public function toggleActive(Request $request, Gallery $gallery)
    {
        // Доп. авторизация, если нужно:
        // $this->authorize('update', $gallery);

        $gallery->is_active = $gallery->is_active ? 0 : 1;
        $gallery->save();

        // Сообщение можно не показывать — это опционально
        return redirect()->back()->with('success', 'Статус фото обновлён.');
    }
}
