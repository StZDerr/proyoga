<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\ClearsHomeCache;

class Question extends Model
{
    use HasFactory, ClearsHomeCache;

    /** Cache keys to forget on model changes */
    protected static $homeCacheKeys = ['home:questions'];

    protected $fillable = [
        'question',
        'answer',
        'order',
    ];
}
