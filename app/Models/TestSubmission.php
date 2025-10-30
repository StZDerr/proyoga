<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TestSubmission extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'visited_free_class',
        'completed_at',
    ];

    protected $casts = [
        'visited_free_class' => 'boolean',
        'completed_at' => 'datetime',
    ];

    public function answers(): HasMany
    {
        return $this->hasMany(TestAnswer::class);
    }

    public function getAnswersWithQuestionsAttribute()
    {
        return $this->answers()->with(['question', 'option'])->get();
    }
}
