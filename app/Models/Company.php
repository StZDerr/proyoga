<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'category',
        'advantages',
        'phone',
        'photo',
        'email',
    ];

    protected $casts = [
        'socials' => 'array', // автоматически преобразуем JSON в массив
    ];
}
