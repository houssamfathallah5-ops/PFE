<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Artist;
use App\Models\Song;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AdminAlbumController extends Controller
{
    public function index()
    {
        $albums = Album::with('artist')->withCount('songs')->orderByDesc('release_date')->paginate(15);
        return view('admin.albums.index', compact('albums'));
    }

    public function create()
    {
        $artists = Artist::orderBy('name')->get();
        return view('admin.albums.create', compact('artists'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'artist_id' => 'required|exists:artists,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_url' => 'nullable|url',
            'type' => 'required|in:album,single,ep',
            'release_date' => 'nullable|date',
            'genre' => 'nullable|string|max:100',
            'label' => 'nullable|string|max:255',
            'is_published' => 'boolean',
            'songs' => 'array',
            'songs.*.title' => 'required|string|max:255',
            'songs.*.duration' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($data) {
            $album = Album::create([
                'artist_id' => $data['artist_id'],
                'title' => $data['title'],
                'slug' => Str::slug($data['title']) . '-' . Str::random(4),
                'description' => $data['description'] ?? null,
                'cover_url' => $data['cover_url'] ?? null,
                'type' => $data['type'],
                'release_date' => $data['release_date'] ?? null,
                'genre' => $data['genre'] ?? null,
                'label' => $data['label'] ?? null,
                'is_published' => $data['is_published'] ?? true,
            ]);

            if (!empty($data['songs'])) {
                foreach ($data['songs'] as $i => $songData) {
                    Song::create([
                        'album_id' => $album->id,
                        'artist_id' => $data['artist_id'],
                        'title' => $songData['title'],
                        'slug' => Str::slug($songData['title']) . '-' . $album->id . '-' . ($i + 1),
                        'duration' => $songData['duration'],
                        'track_number' => $i + 1,
                        'genre' => $data['genre'] ?? null,
                        'is_published' => true,
                    ]);
                }
            }
        });

        return redirect()->route('admin.albums.index')->with('success', 'Album créé avec succès!');
    }

    public function edit(Album $album)
    {
        $artists = Artist::orderBy('name')->get();
        $album->load('songs');
        return view('admin.albums.edit', compact('album', 'artists'));
    }

    public function update(Request $request, Album $album)
    {
        $data = $request->validate([
            'artist_id' => 'required|exists:artists,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_url' => 'nullable|url',
            'type' => 'required|in:album,single,ep',
            'release_date' => 'nullable|date',
            'genre' => 'nullable|string|max:100',
            'label' => 'nullable|string|max:255',
            'is_published' => 'boolean',
        ]);

        DB::transaction(fn() => $album->update(array_merge($data, [
            'is_published' => $data['is_published'] ?? false,
        ])));

        return redirect()->route('admin.albums.index')->with('success', 'Album mis à jour!');
    }

    public function destroy(Album $album)
    {
        DB::transaction(fn() => $album->delete());
        return redirect()->route('admin.albums.index')->with('success', 'Album supprimé.');
    }

    public function show(Album $album)
    {
        return redirect()->route('admin.albums.edit', $album);
    }
}
