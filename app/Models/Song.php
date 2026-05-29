<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Song extends Model
{
    use HasFactory;

    protected $fillable = [
        'album_id', 'artist_id', 'title', 'slug', 'audio_url',
        'duration', 'track_number', 'play_count', 'like_count',
        'genre', 'lyrics', 'is_explicit', 'is_published',
    ];

    protected $casts = [
        'is_explicit' => 'boolean',
        'is_published' => 'boolean',
        'play_count' => 'integer',
        'like_count' => 'integer',
    ];

    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class);
    }

    public function artist(): BelongsTo
    {
        return $this->belongsTo(Artist::class);
    }

    public function playlists(): BelongsToMany
    {
        return $this->belongsToMany(Playlist::class, 'playlist_song')
                    ->withPivot('position')
                    ->withTimestamps();
    }

    public function getFormattedDurationAttribute(): string
    {
        $m = intdiv($this->duration, 60);
        $s = $this->duration % 60;
        return sprintf('%d:%02d', $m, $s);
    }

    public function getFormattedPlayCountAttribute(): string
    {
        $n = $this->play_count;
        if ($n >= 1_000_000_000) return round($n / 1_000_000_000, 1) . 'B';
        if ($n >= 1_000_000) return round($n / 1_000_000, 1) . 'M';
        if ($n >= 1_000) return round($n / 1_000, 1) . 'K';
        return $n;
    }
}
