<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servico extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'url',
        'icon',
        'category',
        'active',
        'internal',
        'order',
    ];

    protected $casts = [
        'active' => 'boolean',
        'internal' => 'boolean',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopePublic($query)
    {
        return $query->where('internal', false);
    }

    public function scopeInternal($query)
    {
        return $query->where('internal', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}

