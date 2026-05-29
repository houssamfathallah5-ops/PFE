<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;

class SongController extends Controller
{
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
