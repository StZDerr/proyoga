<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Проверить созданные категории';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== ГЛАВНЫЕ КАТЕГОРИИ ===');
        $mainCategories = \App\Models\MainCategory::all();
        foreach ($mainCategories as $main) {
            $this->line("ID: {$main->id} | Название: {$main->title}");
        }

        $this->info('');
        $this->info('=== ПОДКАТЕГОРИИ ===');
        $subCategories = \App\Models\SubCategory::with('mainCategory')->get();
        foreach ($subCategories as $sub) {
            $this->line("ID: {$sub->id} | Название: {$sub->title}");
            $this->line("Главная категория: {$sub->mainCategory->title}");
            $this->line('Описание: '.substr($sub->description, 0, 100).'...');
            $this->line('---');
        }

        return 0;
    }
}
