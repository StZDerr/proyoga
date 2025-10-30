<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceTable extends Model
{
    protected $fillable = ['category_id', 'title'];

    public function category()
    {
        return $this->belongsTo(PriceCategory::class);
    }

    public function items()
    {
        return $this->hasMany(PriceItem::class, 'table_id');
    }
}
