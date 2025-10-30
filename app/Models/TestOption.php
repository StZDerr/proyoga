<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TestOption extends Model
{
    protected $fillable = [
        'test_question_id',
        'option_text',
        'order_position',
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo(TestQuestion::class, 'test_question_id');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(TestAnswer::class);
    }
}
