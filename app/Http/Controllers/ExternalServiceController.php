<?php

namespace App\Http\Controllers;

use App\Models\ExternalService;
use Illuminate\Http\Request;

class ExternalServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = ExternalService::latest()->get();

        return view('admin.ExternalService.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.ExternalService.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'key' => ['nullable', 'string', 'max:255'],
            'token' => ['nullable', 'string'],
            'script' => ['nullable', 'string'],
            'config' => ['nullable', 'string'], // JSON в текстовом поле
            'active' => ['nullable', 'boolean'],
        ]);

        // Если поле config заполнено — пытаемся преобразовать в JSON
        if (! empty($data['config'])) {
            $decoded = json_decode($data['config'], true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return back()
                    ->withInput()
                    ->withErrors(['config' => 'Неверный формат JSON']);
            }

            $data['config'] = $decoded;
        }

        // Чекбокс 'active' = true/false
        $data['active'] = $request->has('active');

        ExternalService::create($data);

        return redirect()
            ->route('admin.external-services.index')
            ->with('success', 'Сервис успешно добавлен!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ExternalService $externalService)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ExternalService $externalService)
    {
        return view('admin.ExternalService.edit', compact('externalService'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExternalService $externalService)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'key' => ['nullable', 'string', 'max:255'],
            'token' => ['nullable', 'string'],
            'script' => ['nullable', 'string'],
            'config' => ['nullable', 'string'], // JSON в текстовом поле
            'active' => ['nullable', 'boolean'],
        ]);

        // Проверка и декодирование JSON
        if (! empty($data['config'])) {
            $decoded = json_decode($data['config'], true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return back()
                    ->withInput()
                    ->withErrors(['config' => 'Неверный формат JSON']);
            }

            $data['config'] = $decoded;
        }

        // Обработка чекбокса
        $data['active'] = $request->has('active');

        $externalService->update($data);

        return redirect()
            ->route('admin.external-services.index')
            ->with('success', 'Сервис успешно обновлён!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExternalService $externalService)
    {
        $externalService->delete();

        return redirect()
            ->route('admin.external-services.index')
            ->with('success', 'Сервис успешно удалён!');
    }
}
