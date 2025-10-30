<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubSubCategory extends Model
{
    protected $fillable = [
        'title',
        'description',
        'about',
        'benefits',
        'image',
        'sub_category_id',
    ];

    protected $casts = [
        'benefits' => 'array', // автоматически преобразуем JSON в массив
    ];

    // Связь с подкатегорией
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }
}
