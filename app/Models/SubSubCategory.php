<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SubSubCategory extends Model
{
    protected $fillable = [
        'title',
        'description',
        'about',
        'benefits',
        'image',
        'sub_category_id',
        'slug',
    ];

    protected $casts = [
        'benefits' => 'array', // автоматически преобразуем JSON в массив
    ];

    // Связь с подкатегорией
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    /**
     * Автоматическая генерация slug при сохранении
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = $model->generateSlug($model->title);
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('title') && empty($model->slug)) {
                $model->slug = $model->generateSlug($model->title);
            }
        });
    }

    /**
     * Генерация уникального slug
     */
    private function generateSlug($title)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        while (static::where('slug', $slug)->where('id', '!=', $this->id ?? 0)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Route model binding по slug
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
