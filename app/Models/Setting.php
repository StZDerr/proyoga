<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    // Явно указываем имя таблицы (по желанию)
    protected $table = 'settings';

    protected $fillable = [
        'logo_navbar',
        'logo_footer',
        'favicon',
    ];

    /**
     * Возвращает единственную запись настроек, создавая её при необходимости
     */
    public static function current()
    {
        return self::first() ?? self::create([]);
    }

    // Удобные аксессоры для URL (если храните путь в storage)
    public function getNavbarLogoUrlAttribute()
    {
        return $this->logo_navbar ? asset('storage/'.$this->logo_navbar) : null;
    }

    public function getFooterLogoUrlAttribute()
    {
        return $this->logo_footer ? asset('storage/'.$this->logo_footer) : null;
    }

    public function getFaviconUrlAttribute()
    {
        return $this->favicon ? asset('storage/'.$this->favicon) : null;
    }
}
