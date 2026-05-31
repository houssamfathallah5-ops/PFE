<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AdminArtistController extends Controller
{
    public function index()
    {
        $artist = auth()->user()->artist;
        if (!$artist) {
            return redirect('/')->with('error', 'Profil artiste introuvable.');
        }
        return redirect()->route('admin.artists.edit', $artist);
    }

    public function create()
    {
        abort(403, 'Action non autorisée.');
    }

    public function store(Request $request)
    {
        abort(403, 'Action non autorisée.');
    }

    public function edit(Artist $artist)
    {
        $userArtist = auth()->user()->artist;
        if (!$userArtist || $artist->id !== $userArtist->id) {
            abort(403, 'Action non autorisée.');
        }

        return view('admin.artists.edit', compact('artist'));
    }

    public function update(Request $request, Artist $artist)
    {
        $userArtist = auth()->user()->artist;
        if (!$userArtist || $artist->id !== $userArtist->id) {
            abort(403, 'Action non autorisée.');
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'genre' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'image_url' => 'nullable|url',
            'cover_url' => 'nullable|url',
        ]);

        DB::transaction(function () use ($artist, $data) {
            $artist->update($data);
        });

        return redirect()->route('admin.dashboard')->with('success', 'Votre profil artiste a été mis à jour!');
    }

    public function destroy(Artist $artist)
    {
        abort(403, 'Action non autorisée.');
    }

    public function show(Artist $artist)
    {
        return redirect()->route('admin.artists.edit', $artist);
    }
}
