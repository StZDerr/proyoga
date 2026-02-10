<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Prize;
use App\Models\Spin;
use App\Services\WheelService;
use Illuminate\Validation\ValidationException;

class WheelTest extends TestCase
{
    use RefreshDatabase;

    public function test_one_spin_per_phone()
    {
        // create some prizes
        Prize::create(['name' => 'A', 'color' => '#FF0000', 'chance' => 50, 'is_active' => true]);
        Prize::create(['name' => 'B', 'color' => '#00FF00', 'chance' => 50, 'is_active' => true]);

        $service = new WheelService();

        $spin = $service->spinByPhone('+71234567890');
        $this->assertInstanceOf(Spin::class, $spin);

        // second spin must fail
        $this->expectException(ValidationException::class);
        $service->spinByPhone('+71234567890');
    }
}
