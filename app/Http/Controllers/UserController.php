<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('login', '!=', 'StZD')
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'login' => 'required|string|max:255|unique:users,login',
            'name' => 'nullable|string|max:255',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'login.required' => 'Логин обязателен',
            'login.string' => 'Логин должен быть строкой',
            'login.max' => 'Логин не должен превышать 255 символов',
            'login.unique' => 'Пользователь с таким логином уже существует',

            'name.string' => 'Имя должно быть строкой',
            'name.max' => 'Имя не должно превышать 255 символов',

            'password.required' => 'Пароль обязателен',
            'password.string' => 'Пароль должен быть строкой',
            'password.min' => 'Пароль должен содержать минимум :min символов',
            'password.confirmed' => 'Подтверждение пароля не совпадает',
        ]);

        // Хэшируем пароль
        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'Пользователь успешно добавлен!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'login' => 'required|string|max:255|unique:users,login,'.$user->id,
            'name' => 'nullable|string|max:255',
            'password' => 'nullable|string|confirmed|min:6',
        ], [
            'login.required' => 'Логин обязателен',
            'login.string' => 'Логин должен быть строкой',
            'login.max' => 'Логин не должен превышать 255 символов',
            'login.unique' => 'Пользователь с таким логином уже существует',

            'name.string' => 'Имя должно быть строкой',
            'name.max' => 'Имя не должно превышать 255 символов',

            'password.string' => 'Пароль должен быть строкой',
            'password.min' => 'Пароль должен содержать минимум :min символов',
            'password.confirmed' => 'Подтверждение пароля не совпадает',
        ]);

        // Применяем изменения безопасно
        $user->login = $validated['login'];
        $user->name = $validated['name'] ?? null;

        if (! empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('admin.users.index')
            ->with('success', 'Пользователь успешно обновлён!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Пользователь успешно удалён!');
    }
}
