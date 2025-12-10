<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExternalService extends Model
{
    protected $fillable = [
        'name',
        'key',
        'token',
        'script',
        'config',
        'active',
    ];

    protected $casts = [
        'config' => 'array',
        'active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
