<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Artist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'slug', 'bio', 'genre', 'country',
        'image_url', 'cover_url', 'monthly_listeners',
        'total_streams', 'is_verified',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'monthly_listeners' => 'integer',
        'total_streams' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function albums(): HasMany
    {
        return $this->hasMany(Album::class);
    }

    public function songs(): HasMany
    {
        return $this->hasMany(Song::class);
    }

    public function getFormattedListenersAttribute(): string
    {
        $n = $this->monthly_listeners;
        if ($n >= 1_000_000) return round($n / 1_000_000, 1) . 'M';
        if ($n >= 1_000) return round($n / 1_000, 1) . 'K';
        return $n;
    }
}
