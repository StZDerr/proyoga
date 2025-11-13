<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubSubCategoryFaq extends Model
{
    protected $table = 'sub_sub_category_faqs';

    protected $fillable = [
        'sub_sub_category_id',
        'question',
        'answer',
        'created_by',
        'sort_order',
    ];

    // Отношение к родительской под-подкатегории
    public function subSubCategory()
    {
        return $this->belongsTo(SubSubCategory::class);
    }

    // Автор (администратор)
    public function author()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }
}
