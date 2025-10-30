<?php

namespace App\Http\Controllers;

use App\Models\Personal;
use Illuminate\Http\Request;

class PersonalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $personals = Personal::all();

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
            'photo' => 'nullable|file|mimes:webp|max:2048', // проверка на webp и размер до 2МБ
        ], [
            'photo.mimes' => 'Фотография должна быть в формате .webp',
            'photo.max' => 'Размер фотографии не должен превышать 2 МБ',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('personal', 'public');
        }

        Personal::create($validated);

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
            'photo' => 'nullable|file|mimes:webp|max:1024',
        ], [
            'photo.mimes' => 'Фотография должна быть в формате .webp',
            'photo.max' => 'Размер фотографии не должен превышать 1 МБ',
        ]);

        if ($request->hasFile('photo')) {
            // Удаляем старое фото, если есть
            if ($personal->photo) {
                \Storage::disk('public')->delete($personal->photo);
            }
            $validated['photo'] = $request->file('photo')->store('personal', 'public');
        }

        $personal->update($validated);

        return redirect()->route('admin.personal.index')
            ->with('success', 'Персонал успешно обновлен!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Personal $personal)
    {
        $personal->delete();

        return redirect()->route('admin.personal.index')
            ->with('success', 'Персонал успешно удалён!');
    }
}
