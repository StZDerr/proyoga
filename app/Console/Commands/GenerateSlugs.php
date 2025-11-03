<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MainCategory;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use Illuminate\Support\Str;

class GenerateSlugs extends Command
{
    protected $signature = 'generate:slugs';
    protected $description = 'Генерирует slug для всех существующих категорий';

    public function handle()
    {
        $this->info('Генерация slug для категорий...');

        // Главные категории
        $mainCategories = MainCategory::whereNull('slug')->get();
        foreach ($mainCategories as $category) {
            $category->slug = $this->generateUniqueSlug($category->title, MainCategory::class);
            $category->save();
            $this->info("MainCategory: {$category->title} -> {$category->slug}");
        }

        // Подкатегории
        $subCategories = SubCategory::whereNull('slug')->get();
        foreach ($subCategories as $category) {
            $category->slug = $this->generateUniqueSlug($category->title, SubCategory::class);
            $category->save();
            $this->info("SubCategory: {$category->title} -> {$category->slug}");
        }

        // Подподкатегории
        $subSubCategories = SubSubCategory::whereNull('slug')->get();
        foreach ($subSubCategories as $category) {
            $category->slug = $this->generateUniqueSlug($category->title, SubSubCategory::class);
            $category->save();
            $this->info("SubSubCategory: {$category->title} -> {$category->slug}");
        }

        $this->info('Генерация slug завершена!');
    }

    private function generateUniqueSlug($title, $modelClass)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        while ($modelClass::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}