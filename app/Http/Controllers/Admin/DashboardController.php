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
        $stats = [
            'artists' => Artist::count(),
            'albums' => Album::count(),
            'songs' => Song::count(),
            'total_streams' => Song::sum('play_count'),
            'top_songs' => Song::with(['artist', 'album'])
                ->orderByDesc('play_count')
                ->take(5)
                ->get(),
            'top_artists' => Artist::orderByDesc('monthly_listeners')
                ->take(5)
                ->get(),
            'recent_albums' => Album::with('artist')
                ->orderByDesc('created_at')
                ->take(5)
                ->get(),
            'streams_by_genre' => Song::selectRaw('genre, SUM(play_count) as total')
                ->groupBy('genre')
                ->orderByDesc('total')
                ->take(6)
                ->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
