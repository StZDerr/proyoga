<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoryMedia extends Model
{
    use HasFactory;

    protected $table = 'story_media';

    protected $fillable = [
        'story_id',
        'type',
        'path',
        'sort',
    ];

    public function story()
    {
        return $this->belongsTo(Story::class);
    }
}
