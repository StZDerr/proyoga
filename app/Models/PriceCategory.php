<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PriceCategory extends Model
{
    protected $fillable = [
        'name',
        'file',
    ];

    public function tables()
    {
        return $this->hasMany(PriceTable::class, 'category_id');
    }

    public function getSlugAttribute()
    {
        return Str::slug($this->name);
    }
}
