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
        $songs = Song::with(['artist', 'album'])->orderByDesc('play_count')->paginate(20);
        return view('admin.songs.index', compact('songs'));
    }

    public function create()
    {
        $artists = Artist::orderBy('name')->get();
        $albums = Album::with('artist')->orderBy('title')->get();
        return view('admin.songs.create', compact('artists', 'albums'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'album_id' => 'required|exists:albums,id',
            'artist_id' => 'required|exists:artists,id',
            'title' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'track_number' => 'required|integer|min:1',
            'genre' => 'nullable|string|max:100',
            'is_explicit' => 'boolean',
            'is_published' => 'boolean',
        ]);

        DB::transaction(function () use ($data) {
            Song::create(array_merge($data, [
                'slug' => Str::slug($data['title']) . '-' . Str::random(6),
                'is_explicit' => $data['is_explicit'] ?? false,
                'is_published' => $data['is_published'] ?? true,
            ]));
        });

        return redirect()->route('admin.songs.index')->with('success', 'Chanson créée!');
    }

    public function edit(Song $song)
    {
        $artists = Artist::orderBy('name')->get();
        $albums = Album::with('artist')->orderBy('title')->get();
        return view('admin.songs.edit', compact('song', 'artists', 'albums'));
    }

    public function update(Request $request, Song $song)
    {
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
        DB::transaction(fn() => $song->delete());
        return redirect()->route('admin.songs.index')->with('success', 'Chanson supprimée.');
    }

    public function show(Song $song)
    {
        return redirect()->route('admin.songs.edit', $song);
    }
}
