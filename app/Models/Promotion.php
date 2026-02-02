<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\ClearsHomeCache;

class Promotion extends Model
{
    use HasFactory, ClearsHomeCache;

    /** Cache keys to forget on model changes */
    protected static $homeCacheKeys = ['home:promotions'];

    protected $fillable = [
        'title',
        'description',
        'photo',
        'start_date',
        'end_date',
    ];
}
