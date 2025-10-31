<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageContent extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'description',
        'keywords',
        'content',
        'seo_data',
        'is_active'
    ];

    protected $casts = [
        'seo_data' => 'array',
        'is_active' => 'boolean'
    ];

    /**
     * Получить контент страницы по slug
     */
    public static function getBySlug($slug)
    {
        return self::where('slug', $slug)->where('is_active', true)->first();
    }

    /**
     * Получить контент домашней страницы
     */
    public static function getHomePage()
    {
        return self::getBySlug('home');
    }

    /**
     * Проверить существует ли страница
     */
    public static function pageExists($slug)
    {
        return self::where('slug', $slug)->exists();
    }
}
