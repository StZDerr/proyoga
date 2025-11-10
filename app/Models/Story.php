<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    protected $table = 'stories';

    protected $fillable = [
        'title',
        'preview',
        'description',
        'published_at',
        'is_active',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function media()
    {
        return $this->hasMany(StoryMedia::class)->orderBy('sort')->orderBy('id');
    }

    public function photos()
    {
        return $this->media()->where('type', 'photo');
    }

    public function videos()
    {
        return $this->media()->where('type', 'video');
    }
}
