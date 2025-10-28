<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'login' => 'StZD',
            'name' => 'Админ',
            'password' => Hash::make('10031999Sasha'),
        ]);
    }
}
