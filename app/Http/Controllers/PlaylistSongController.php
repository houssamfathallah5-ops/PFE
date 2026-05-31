<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use App\Models\Song;
use App\Models\User;
use Illuminate\Http\Request;

class PlaylistSongController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'playlist_id' => 'required|exists:playlists,id',
            'song_id' => 'required|exists:songs,id',
        ]);

        $playlist = Playlist::findOrFail($data['playlist_id']);
        
        // Prevent duplicates
        if (!$playlist->songs()->where('song_id', $data['song_id'])->exists()) {
            $lastPos = $playlist->songs()->max('position') ?? 0;
            $playlist->songs()->attach($data['song_id'], ['position' => $lastPos + 1]);
        }

        return response()->json(['success' => true, 'message' => 'Ajouté à la playlist']);
    }

    public function destroy(Playlist $playlist, Song $song)
    {
        $playlist->songs()->detach($song->id);
        return response()->json(['success' => true, 'message' => 'Retiré de la playlist']);
    }

    public function userPlaylists()
    {
        $user = auth()->user();
        if (!$user) return response()->json([]);
        return response()->json($user->playlists()->select('id', 'name')->get());
    }
}
