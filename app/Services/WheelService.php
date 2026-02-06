<?php

namespace App\Services;

use App\Models\Prize;
use App\Models\Spin;
use Illuminate\Validation\ValidationException;

class WheelService
{
    /**
     * Perform a spin for a phone number. Only one spin allowed per phone.
     *
     * @param string $phone
     * @param array $payload
     * @return Spin
     */
    public function spinByPhone(string $phone, array $payload = []): Spin
    {
        // enforce single spin per phone
        if (Spin::where('phone', $phone)->exists()) {
            throw ValidationException::withMessages([
                'phone' => 'Этот номер телефона уже участвовал в розыгрыше.',
            ]);
        }

        $prize = Prize::pickOne();

        $spin = Spin::create([
            'phone' => $phone,
            'prize_id' => $prize?->id,
            'payload' => $payload,
        ]);

        return $spin;
    }
}
