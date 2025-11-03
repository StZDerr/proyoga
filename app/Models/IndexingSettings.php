<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndexingSettings extends Model
{
    protected $fillable = [
        'global_indexing_enabled',
        'robots_txt_content',
        'sitemap_enabled',
        'notes',
    ];

    protected $casts = [
        'global_indexing_enabled' => 'boolean',
        'sitemap_enabled' => 'boolean',
    ];

    /**
     * Получить текущие настройки индексации
     */
    public static function current()
    {
        return self::first() ?? self::create([
            'global_indexing_enabled' => true,
            'robots_txt_content' => self::defaultRobotsTxt(),
            'sitemap_enabled' => true,
            'notes' => 'Настройки индексации по умолчанию',
        ]);
    }

    /**
     * Дефолтный robots.txt
     */
    public static function defaultRobotsTxt()
    {
        return "User-agent: *\nAllow: /\nDisallow: /admin/\nDisallow: /storage/\nDisallow: /vendor/\n\nSitemap: ".url('/sitemap.xml');
    }

    /**
     * robots.txt для отключенной индексации
     */
    public static function disallowAllRobotsTxt()
    {
        return "User-agent: *\nDisallow: /";
    }
}
