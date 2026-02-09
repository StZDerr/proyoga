<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spin extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'prize_id',
        'payload',
    ];

    protected $casts = [
        'payload' => 'array',
    ];

    public function prize()
    {
        return $this->belongsTo(Prize::class);
    }
}
