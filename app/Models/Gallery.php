<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\ClearsHomeCache;

class Gallery extends Model
{
    use HasFactory, ClearsHomeCache;

    /** Cache keys to forget on model changes */
    protected static $homeCacheKeys = ['home:galleries'];

    protected $fillable = [
        'title',
        'description',
        'is_active',
        'sort_order',
        'image',
    ];
}
