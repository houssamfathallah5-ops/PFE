<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Song;
use App\Models\Album;
use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AdminSongController extends Controller
{
    public function index()
    {
        $artist = auth()->user()->artist;
        if (!$artist) {
            return redirect('/')->with('error', 'Profil artiste introuvable.');
        }

        $songs = $artist->songs()->with('album')->orderByDesc('play_count')->paginate(20);
        return view('admin.songs.index', compact('songs'));
    }

    public function create()
    {
        $artist = auth()->user()->artist;
        if (!$artist) {
            return redirect('/')->with('error', 'Profil artiste introuvable.');
        }

        $albums = $artist->albums()->orderBy('title')->get();
        return view('admin.songs.create', compact('albums', 'artist'));
    }

    public function store(Request $request)
    {
        $artist = auth()->user()->artist;
        if (!$artist) {
            return redirect('/')->with('error', 'Profil artiste introuvable.');
        }

        $data = $request->validate([
            'album_id' => 'required|exists:albums,id',
            'title' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'track_number' => 'required|integer|min:1',
            'genre' => 'nullable|string|max:100',
            'is_explicit' => 'boolean',
            'is_published' => 'boolean',
        ]);

        // Verify that the album belongs to this artist
        $album = $artist->albums()->findOrFail($data['album_id']);

        DB::transaction(function () use ($data, $artist) {
            Song::create(array_merge($data, [
                'artist_id' => $artist->id,
                'slug' => Str::slug($data['title']) . '-' . Str::random(6),
                'is_explicit' => $data['is_explicit'] ?? false,
                'is_published' => $data['is_published'] ?? true,
            ]));
        });

        return redirect()->route('admin.songs.index')->with('success', 'Chanson créée!');
    }

    public function edit(Song $song)
    {
        $artist = auth()->user()->artist;
        if (!$artist || $song->artist_id !== $artist->id) {
            abort(403, 'Action non autorisée.');
        }

        $albums = $artist->albums()->orderBy('title')->get();
        return view('admin.songs.edit', compact('song', 'albums', 'artist'));
    }

    public function update(Request $request, Song $song)
    {
        $artist = auth()->user()->artist;
        if (!$artist || $song->artist_id !== $artist->id) {
            abort(403, 'Action non autorisée.');
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'track_number' => 'required|integer|min:1',
            'genre' => 'nullable|string|max:100',
            'is_explicit' => 'boolean',
            'is_published' => 'boolean',
        ]);

        DB::transaction(fn() => $song->update(array_merge($data, [
            'is_explicit' => $data['is_explicit'] ?? false,
            'is_published' => $data['is_published'] ?? false,
        ])));

        return redirect()->route('admin.songs.index')->with('success', 'Chanson mise à jour!');
    }

    public function destroy(Song $song)
    {
        $artist = auth()->user()->artist;
        if (!$artist || $song->artist_id !== $artist->id) {
            abort(403, 'Action non autorisée.');
        }

        DB::transaction(fn() => $song->delete());
        return redirect()->route('admin.songs.index')->with('success', 'Chanson supprimée.');
    }

    public function show(Song $song)
    {
        return redirect()->route('admin.songs.edit', $song);
    }
}
