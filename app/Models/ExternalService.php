<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ExternalService extends Model
{
    protected $fillable = [
        'name',
        'key',
        'token',
        'script',
        'config',
        'active',
    ];

    protected $casts = [
        'config' => 'array',
        'active' => 'boolean',
    ];

    /**
     * Автоматически очищаем кеш external_services_active при изменениях
     */
    protected static function booted()
    {
        static::saved(function ($model) {
            Cache::forget('external_services_active');
        });

        static::deleted(function ($model) {
            Cache::forget('external_services_active');
        });

        // Если используется SoftDeletes — регистрируем обработчик восстановление только при наличии трейта
        if (in_array(\Illuminate\Database\Eloquent\SoftDeletes::class, class_uses_recursive(static::class))) {
            static::restored(function ($model) {
                Cache::forget('external_services_active');
            });
        }
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
