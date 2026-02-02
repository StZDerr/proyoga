<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\ClearsHomeCache;

class Personal extends Model
{
    use HasFactory, ClearsHomeCache;

    /** Cache keys to forget on model changes */
    protected static $homeCacheKeys = ['home:personals'];

    protected $fillable = [
        'first_name',
        'last_name',
        'middle_name',
        'photo',
        'position',
    ];
}
