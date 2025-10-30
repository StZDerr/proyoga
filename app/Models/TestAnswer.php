<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestAnswer extends Model
{
    protected $fillable = [
        'test_submission_id',
        'test_question_id',
        'test_option_id',
    ];

    public function submission(): BelongsTo
    {
        return $this->belongsTo(TestSubmission::class, 'test_submission_id');
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(TestQuestion::class, 'test_question_id');
    }

    public function option(): BelongsTo
    {
        return $this->belongsTo(TestOption::class, 'test_option_id');
    }
}
