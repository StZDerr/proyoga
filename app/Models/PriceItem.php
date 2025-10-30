<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceItem extends Model
{
    protected $fillable = [
        'name',
        'duration',
        'price',
        'table_id',
    ];

    public function table()
    {
        return $this->belongsTo(PriceTable::class);
    }
}
