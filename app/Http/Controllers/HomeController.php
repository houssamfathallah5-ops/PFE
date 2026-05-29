<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Album;
use App\Models\Song;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredArtists = Artist::withCount('songs')
            ->orderByDesc('monthly_listeners')
            ->take(6)
            ->get();

        $recentAlbums = Album::with('artist')
            ->where('is_published', true)
            ->orderByDesc('release_date')
            ->take(8)
            ->get();

        $popularSongs = Song::with(['artist', 'album'])
            ->where('is_published', true)
            ->orderByDesc('play_count')
            ->take(10)
            ->get();

        $trendingAlbums = Album::with('artist')
            ->where('is_published', true)
            ->orderByDesc('total_streams')
            ->take(6)
            ->get();

        return view('home', compact(
            'featuredArtists',
            'recentAlbums',
            'popularSongs',
            'trendingAlbums'
        ));
    }

    public function search(Request $request, \App\Services\SpotifyService $spotify)
    {
        $q = $request->input('q');
        $artists = Artist::where('name', 'like', "%$q%")->take(6)->get();
        $songs = Song::with(['artist', 'album'])->where('title', 'like', "%$q%")->take(20)->get();
        $albums = Album::with('artist')->where('title', 'like', "%$q%")->take(6)->get();

        $spotifySongs = collect();
        if (config('services.spotify.client_id')) {
            $spotifySongs = $spotify->searchTracks($q, 20);
        }

        return view('search', compact('artists', 'songs', 'albums', 'spotifySongs'));
    }

    public function apiSearch(Request $request, \App\Services\SpotifyService $spotify)
    {
        $q = $request->input('q');
        if (!$q) return response()->json(['artists' => [], 'songs' => []]);

        $artists = Artist::where('name', 'like', "%$q%")->take(3)->get();
        $localSongs = Song::with(['artist', 'album'])->where('title', 'like', "%$q%")->take(5)->get();

        $spotifySongs = [];
        if (config('services.spotify.client_id')) {
            $spotifySongs = $spotify->searchTracks($q, 10);
        }

        $allSongs = $localSongs->map(fn($s) => [
            'id' => $s->id,
            'title' => $s->title,
            'duration' => $s->duration,
            'audio_url' => $s->audio_url,
            'artist' => ['name' => $s->artist->name],
            'album' => ['cover_url' => $s->album->cover_url ?? '']
        ])->concat($spotifySongs);

        return response()->json([
            'artists' => $artists,
            'songs' => $allSongs
        ]);
    }
}
