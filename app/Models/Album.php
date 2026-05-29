<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Album extends Model
{
    use HasFactory;

    protected $fillable = [
        'artist_id', 'title', 'slug', 'description', 'cover_url',
        'type', 'release_date', 'genre', 'label',
        'total_streams', 'is_published',
    ];

    protected $casts = [
        'release_date' => 'date',
        'is_published' => 'boolean',
        'total_streams' => 'integer',
    ];

    public function artist(): BelongsTo
    {
        return $this->belongsTo(Artist::class);
    }

    public function songs(): HasMany
    {
        return $this->hasMany(Song::class)->orderBy('track_number');
    }

    public function getFormattedStreamsAttribute(): string
    {
        $n = $this->total_streams;
        if ($n >= 1_000_000_000) return round($n / 1_000_000_000, 1) . 'B';
        if ($n >= 1_000_000) return round($n / 1_000_000, 1) . 'M';
        if ($n >= 1_000) return round($n / 1_000, 1) . 'K';
        return $n;
    }
}
