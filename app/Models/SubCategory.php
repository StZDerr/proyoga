<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $fillable = ['main_category_id', 'title', 'description', 'image'];

    // Связь с главной категорией
    public function mainCategory()
    {
        return $this->belongsTo(MainCategory::class);
    }

    // Связь с под-подкатегориями
    public function subSubCategories()
    {
        return $this->hasMany(SubSubCategory::class);
    }
}
