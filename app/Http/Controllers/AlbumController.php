<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function show(string $slug)
    {
        $album = Album::where('slug', $slug)
            ->with(['artist', 'songs' => fn($q) => $q->orderBy('track_number')])
            ->firstOrFail();

        $relatedAlbums = Album::where('artist_id', $album->artist_id)
            ->where('id', '!=', $album->id)
            ->where('is_published', true)
            ->take(4)
            ->get();

        return view('albums.show', compact('album', 'relatedAlbums'));
    }

    public function apiSongs(int $id)
    {
        $album = Album::with(['songs.artist'])->findOrFail($id);
        return response()->json($album->songs);
    }
}
