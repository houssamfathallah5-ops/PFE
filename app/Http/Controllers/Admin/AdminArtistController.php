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
        $artists = Artist::withCount(['albums', 'songs'])
            ->orderByDesc('monthly_listeners')
            ->paginate(15);
        return view('admin.artists.index', compact('artists'));
    }

    public function create()
    {
        return view('admin.artists.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'genre' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'image_url' => 'nullable|url',
            'cover_url' => 'nullable|url',
            'monthly_listeners' => 'nullable|integer|min:0',
            'is_verified' => 'boolean',
        ]);

        DB::transaction(function () use ($data) {
            Artist::create(array_merge($data, [
                'slug' => Str::slug($data['name']) . '-' . Str::random(4),
                'is_verified' => $data['is_verified'] ?? false,
            ]));
        });

        return redirect()->route('admin.artists.index')->with('success', 'Artiste créé avec succès!');
    }

    public function edit(Artist $artist)
    {
        return view('admin.artists.edit', compact('artist'));
    }

    public function update(Request $request, Artist $artist)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'genre' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'image_url' => 'nullable|url',
            'cover_url' => 'nullable|url',
            'monthly_listeners' => 'nullable|integer|min:0',
            'is_verified' => 'boolean',
        ]);

        DB::transaction(function () use ($artist, $data) {
            $artist->update(array_merge($data, [
                'is_verified' => $data['is_verified'] ?? false,
            ]));
        });

        return redirect()->route('admin.artists.index')->with('success', 'Artiste mis à jour!');
    }

    public function destroy(Artist $artist)
    {
        DB::transaction(fn() => $artist->delete());
        return redirect()->route('admin.artists.index')->with('success', 'Artiste supprimé.');
    }

    public function show(Artist $artist)
    {
        return redirect()->route('admin.artists.edit', $artist);
    }
}
