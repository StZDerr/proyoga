<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    use \App\Models\Traits\ClearsHomeCache;

    /** Cache keys to forget on model changes */
    protected static $homeCacheKeys = ['home:articles'];

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'image',
    ];
    // Генерация slug по title, если не задан
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($article) {
            if (empty($article->slug)) {
                $article->slug = Str::slug($article->title);
            }
        });
    }

    // Найти по slug вместо id
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
