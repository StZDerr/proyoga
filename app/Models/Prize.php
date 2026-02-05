<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prize extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'color',
        'chance',
        'description',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Pick a prize using chance (stored as integer percentages).
     * Works even if chances don't sum to 100 by using relative accumulation.
     *
     * @return Prize|null
     */
    public static function pickOne(): ?self
    {
        $prizes = self::where('is_active', true)->orderBy('order')->get();

        $total = $prizes->sum('chance');
        if ($total <= 0) {
            return null;
        }

        $r = random_int(1, $total);
        $acc = 0;
        foreach ($prizes as $prize) {
            $acc += $prize->chance;
            if ($r <= $acc) {
                return $prize;
            }
        }

        // fallback (shouldn't happen)
        return $prizes->last();
    }
}
