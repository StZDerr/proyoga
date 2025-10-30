<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MainCategory extends Model
{
    protected $fillable = ['title'];

    // Связь с подкатегориями
    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }
}
