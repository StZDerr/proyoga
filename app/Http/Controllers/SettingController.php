<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $setting = Setting::current();

        return view('admin.settings.edit', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $setting = Setting::current();

        $data = $request->validate([
            'logo_navbar' => 'nullable|file|mimes:svg,svgz,webp|mimetypes:image/svg+xml,image/webp|max:500',
            'logo_footer' => 'nullable|file|mimes:svg,svgz,webp|mimetypes:image/svg+xml,image/webp|max:500',
            'favicon' => 'nullable|file|mimes:svg,svgz,webp|mimetypes:image/svg+xml,image/webp|max:500',
        ]);

        // Обработка загрузок (если есть) и удаление старых файлов
        if ($request->hasFile('logo_navbar')) {
            $path = $request->file('logo_navbar')->store('settings', 'public');
            if ($setting->logo_navbar) {
                Storage::disk('public')->delete($setting->logo_navbar);
            }
            $setting->logo_navbar = $path;
        }

        if ($request->hasFile('logo_footer')) {
            $path = $request->file('logo_footer')->store('settings', 'public');
            if ($setting->logo_footer) {
                Storage::disk('public')->delete($setting->logo_footer);
            }
            $setting->logo_footer = $path;
        }

        if ($request->hasFile('favicon')) {
            $path = $request->file('favicon')->store('settings', 'public');
            if ($setting->favicon) {
                Storage::disk('public')->delete($setting->favicon);
            }
            $setting->favicon = $path;
        }

        $setting->save();

        return redirect()->route('admin.settings.edit')->with('success', 'Настройки сохранены');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
