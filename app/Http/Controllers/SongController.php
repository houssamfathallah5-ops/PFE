<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;

class SongController extends Controller
{
    public function index()
    {
        $songs = Song::with(['artist', 'album'])
            ->where('is_published', true)
            ->orderByDesc('play_count')
            ->paginate(30);

        return view('songs.index', compact('songs'));
    }

    public function favorites()
    {
        $user = auth()->user();
        if (!$user) return redirect()->route('login');

        $songs = $user->likedSongs()->with(['artist', 'album'])->paginate(30);

        return view('songs.favorites', compact('songs'));
    }

    public function apiShow(int $id)
    {
        $song = Song::with(['artist', 'album'])->findOrFail($id);
        return response()->json($song);
    }

    public function incrementPlay(int $id)
    {
        Song::where('id', $id)->increment('play_count');
        return response()->json(['success' => true]);
    }
}
