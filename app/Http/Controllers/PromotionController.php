<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $promotions = Promotion::orderBy('id', 'desc')->paginate(20);

        $promotions->getCollection()->transform(function ($promotion) {
            $path = $promotion->photo; // предполагается, что это относительный путь, например 'promotions/1.jpg'
            if ($path && Storage::disk('public')->exists($path)) {
                $promotion->photo_size = Storage::disk('public')->size($path); // размер в байтах
            } else {
                $promotion->photo_size = null;
            }

            return $promotion;
        });

        return view('admin.promotions.index', compact('promotions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.promotions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'photo' => 'required|image|mimes:webp|max:2048',
        ], [
            'photo.required' => 'Фотография обязательна',
            'photo.image' => 'Файл должен быть изображением',
            'photo.mimes' => 'Фотография должна быть в формате .webp',
            'photo.max' => 'Размер фотографии не должен превышать 2 МБ',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('promotions', 'public');
        }

        Promotion::create($validated);

        return redirect()->route('admin.promotions.index')->with('success', 'Акция успешно добавлена!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Promotion $promotion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Promotion $promotion)
    {
        return view('admin.promotions.edit', compact('promotion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Promotion $promotion)
    {
        $validated = $request->validate([
            // фото не обязателен при обновлении
            'photo' => 'sometimes|image|mimes:webp|max:2048',
        ], [
            'photo.image' => 'Файл должен быть изображением',
            'photo.mimes' => 'Фотография должна быть в формате .webp',
            'photo.max' => 'Размер фотографии не должен превышать 2 МБ',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('promotions', 'public');
        }

        $promotion->update($validated);

        return redirect()->route('admin.promotions.index')->with('success', 'Акция успешно обновлена!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Promotion $promotion)
    {
        $promotion->delete();

        return redirect()->route('admin.promotions.index')->with('success', 'Акция успешно удалена!');
    }
}
