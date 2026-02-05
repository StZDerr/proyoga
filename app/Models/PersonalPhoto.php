<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalPhoto extends Model
{
    protected $fillable = [
        'personal_id',
        'path',
        'caption',
        'sort_order',
    ];

    public function personal()
    {
        return $this->belongsTo(Personal::class);
    }
}
