<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\SoftDeletes;

trait ClearsHomeCache
{
    /**
     * Регистрирует обработчики событий модели для очистки списка кеш-ключей
     * Ожидается, что в модели будет объявлено:
     * protected static $homeCacheKeys = ['key1', 'key2'];
     */
    public static function bootClearsHomeCache()
    {
        $keys = property_exists(static::class, 'homeCacheKeys') ? static::$homeCacheKeys : [];

        if (empty($keys)) {
            return;
        }

        $handler = function ($model) use ($keys) {
            foreach ($keys as $key) {
                Cache::forget($key);
            }
        };

        static::saved($handler);
        static::deleted($handler);

        // Если модель использует SoftDeletes — регистрируем restored
        if (in_array(SoftDeletes::class, class_uses_recursive(static::class))) {
            static::restored($handler);
        }
    }
}
