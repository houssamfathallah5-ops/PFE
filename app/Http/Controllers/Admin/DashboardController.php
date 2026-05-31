<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\Album;
use App\Models\Song;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $artist = $user->artist;

        if (!$artist) {
            return redirect('/')->with('error', 'Profil artiste introuvable.');
        }

        $stats = [
            'artists' => 1, // Just them
            'albums' => $artist->albums()->count(),
            'songs' => $artist->songs()->count(),
            'total_streams' => $artist->songs()->sum('play_count'),
            'top_songs' => $artist->songs()
                ->with(['artist', 'album'])
                ->orderByDesc('play_count')
                ->take(5)
                ->get(),
            'top_artists' => collect([$artist]),
            'recent_albums' => $artist->albums()
                ->orderByDesc('created_at')
                ->take(5)
                ->get(),
            'streams_by_genre' => $artist->songs()
                ->selectRaw('genre, SUM(play_count) as total')
                ->groupBy('genre')
                ->orderByDesc('total')
                ->take(6)
                ->get(),
        ];

        return view('admin.dashboard', compact('stats', 'artist'));
    }
}
