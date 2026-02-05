<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Prize;

class PrizeSeeder extends Seeder
{
    public function run(): void
    {
        // Example segments summing to 100
        Prize::truncate();

        Prize::create(['name' => '10% скидка', 'color' => '#FFDD57', 'chance' => 40, 'description' => 'Получите 10% скидку', 'is_active' => true, 'order' => 1]);
        Prize::create(['name' => '20% скидка', 'color' => '#FFA07A', 'chance' => 25, 'description' => 'Получите 20% скидку', 'is_active' => true, 'order' => 2]);
        Prize::create(['name' => 'Бесплатная доставка', 'color' => '#8FD694', 'chance' => 20, 'description' => 'Бесплатная доставка заказа', 'is_active' => true, 'order' => 3]);
        Prize::create(['name' => 'Шанс 0', 'color' => '#CCCCCC', 'chance' => 15, 'description' => 'Редкий приз', 'is_active' => true, 'order' => 4]);
    }
}
