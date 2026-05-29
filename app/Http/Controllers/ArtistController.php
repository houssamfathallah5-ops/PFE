<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    public function index()
    {
        $artists = Artist::withCount(['albums', 'songs'])
            ->orderByDesc('monthly_listeners')
            ->paginate(12);

        return view('artists.index', compact('artists'));
    }

    public function show(string $slug)
    {
        $artist = Artist::where('slug', $slug)
            ->withCount(['albums', 'songs'])
            ->firstOrFail();

        $albums = $artist->albums()
            ->where('is_published', true)
            ->withCount('songs')
            ->orderByDesc('release_date')
            ->get();

        $popularSongs = $artist->songs()
            ->with('album')
            ->where('is_published', true)
            ->orderByDesc('play_count')
            ->take(5)
            ->get();

        return view('artists.show', compact('artist', 'albums', 'popularSongs'));
    }
}
