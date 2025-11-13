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
            // Если title изменился, автоматически обновляем slug
            if ($model->isDirty('title')) {
                $oldSlug = $model->getOriginal('slug');
                $model->slug = $model->generateSlug($model->title);
                
                // Обновляем URL в indexable_pages, если slug изменился
                if ($oldSlug && $oldSlug !== $model->slug) {
                    // Обновляем запись подкатегории
                    \App\Models\IndexablePage::where('url', $oldSlug)
                        ->update(['url' => $model->slug]);
                    
                    // Обновляем все связанные подподкатегории
                    $subSubCategories = $model->subSubCategories;
                    foreach ($subSubCategories as $subSub) {
                        $oldUrl = $oldSlug . '/' . $subSub->slug;
                        $newUrl = $model->slug . '/' . $subSub->slug;
                        
                        \App\Models\IndexablePage::where('url', $oldUrl)
                            ->update(['url' => $newUrl]);
                    }
                }
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
