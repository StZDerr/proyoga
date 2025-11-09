<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceTable extends Model
{
    protected $fillable = ['category_id', 'title', 'sort_order'];

    public function category()
    {
        return $this->belongsTo(PriceCategory::class);
    }

    public function items()
    {
        return $this->hasMany(PriceItem::class, 'table_id');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    /**
     * Поднять текущую запись выше (обменяться sort_order с предыдущей).
     */
    public function moveUp(): bool
    {
        $above = self::where('sort_order', '<', $this->sort_order)
            ->orderByDesc('sort_order')
            ->first();

        if (! $above) {
            return false;
        }

        $tmp = $above->sort_order;
        $above->sort_order = $this->sort_order;
        $this->sort_order = $tmp;

        // Сохраняем в рамках транзакции
        return \DB::transaction(function () use ($above) {
            $above->save();
            $this->save();

            return true;
        });
    }

    /**
     * Опустить текущую запись ниже (обменяться sort_order с следующей).
     */
    public function moveDown(): bool
    {
        $below = self::where('sort_order', '>', $this->sort_order)
            ->orderBy('sort_order')
            ->first();

        if (! $below) {
            return false;
        }

        $tmp = $below->sort_order;
        $below->sort_order = $this->sort_order;
        $this->sort_order = $tmp;

        return \DB::transaction(function () use ($below) {
            $below->save();
            $this->save();

            return true;
        });
    }
}
