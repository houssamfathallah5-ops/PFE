<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use Illuminate\Http\Request;

class PlaylistController extends Controller
{
    public function index()
    {
        $playlists = Playlist::with('user')->where('is_public', true)->paginate(12);
        return view('playlists.index', compact('playlists'));
    }

    public function show(string $slug)
    {
        $playlist = Playlist::where('slug', $slug)
            ->with(['songs.artist', 'songs.album', 'user'])
            ->firstOrFail();
        return view('playlists.show', compact('playlist'));
    }
}
