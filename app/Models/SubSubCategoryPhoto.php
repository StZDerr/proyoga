<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubSubCategoryPhoto extends Model
{
    protected $fillable = ['sub_sub_category_id', 'image'];

    public function subSubCategory()
    {
        return $this->belongsTo(SubSubCategory::class);
    }
}
