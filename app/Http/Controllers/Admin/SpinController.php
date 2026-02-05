<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prize;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SpinController extends Controller
{
    public function index()
    {
        $prizes = Prize::orderBy('order')->get();

        return view('admin.spins.index', compact('prizes'));
    }

    public function create()
    {
        return view('admin.spins.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'chance' => 'required|integer|min:0|max:100',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'order' => 'nullable|integer|min:0',
        ]);

        $validated['is_active'] = (bool) ($request->has('is_active'));

        Prize::create($validated);

        return redirect()->route('admin.spins.index')->with('success', 'Сегмент успешно создан');
    }

    public function edit(Prize $spin)
    {
        return view('admin.spins.edit', ['spin' => $spin]);
    }

    public function update(Request $request, Prize $spin)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'chance' => 'required|integer|min:0|max:100',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'order' => 'nullable|integer|min:0',
        ]);

        $validated['is_active'] = (bool) ($request->has('is_active'));

        $spin->update($validated);

        return redirect()->route('admin.spins.index')->with('success', 'Сегмент успешно обновлён');
    }

    public function destroy(Prize $spin)
    {
        $spin->delete();

        return redirect()->route('admin.spins.index')->with('success', 'Сегмент успешно удалён');
    }
}
