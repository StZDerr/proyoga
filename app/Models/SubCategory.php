<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SubCategory extends Model
{
    protected $fillable = ['main_category_id', 'title', 'description', 'image', 'slug'];

    // Связь с главной категорией
    public function mainCategory()
    {
        return $this->belongsTo(MainCategory::class);
    }

    // Связь с под-подкатегориями
    public function subSubCategories()
    {
        return $this->hasMany(SubSubCategory::class);
    }

    /**
     * Retrieve the child model for a bound value (for scoped route binding)
     */
    public function resolveChildRouteBinding($childType, $value, $field)
    {
        return $this->subSubCategories()
            ->where($field ?? (new SubSubCategory())->getRouteKeyName(), $value)
            ->firstOrFail();
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
