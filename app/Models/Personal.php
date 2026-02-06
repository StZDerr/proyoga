<?php

namespace App\Models;

use App\Models\Traits\ClearsHomeCache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    use ClearsHomeCache, HasFactory;

    /** Cache keys to forget on model changes */
    protected static $homeCacheKeys = ['home:personals'];

    protected $fillable = [
        'first_name',
        'last_name',
        'middle_name',
        'photo',
        'position',
        'sort_order',
        'description',
        'slug',
    ];

    public function photos()
    {
        return $this->hasMany(PersonalPhoto::class)->orderBy('sort_order')->orderBy('id');
    }

    /**
     * Use slug for route model binding
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
} 
