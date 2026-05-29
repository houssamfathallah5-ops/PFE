<?php

use App\Models\Artist;
use App\Models\Album;
use App\Models\Song;
use Illuminate\Support\Str;

$artist = Artist::create([
    'name' => 'Mehdi Zallal',
    'slug' => 'mehdi-zallal',
    'image_url' => 'file:///C:/Users/P1342/.gemini/antigravity/brain/f790c39a-c385-4594-be5c-94a0509ac098/mehdi_zallal_profile_1777721602109.png',
    'genre' => 'Moroccan Pop',
    'country' => 'Morocco',
    'is_verified' => true,
    'bio' => 'Mehdi Zallal est un artiste émergent de la scène pop marocaine, connu pour ses mélodies envoûtantes et sa voix unique.',
    'listeners_count' => 12500,
]);

$album = Album::create([
    'artist_id' => $artist->id,
    'title' => 'Konti Liya (Single)',
    'slug' => 'konti-liya-single',
    'cover_url' => 'file:///C:/Users/P1342/.gemini/antigravity/brain/f790c39a-c385-4594-be5c-94a0509ac098/konti_liya_album_cover_1777721655591.png',
    'release_date' => now(),
    'type' => 'single',
    'genre' => 'Moroccan Pop',
]);

Song::create([
    'album_id' => $album->id,
    'artist_id' => $artist->id,
    'title' => 'Konti Liya',
    'slug' => 'konti-liya',
    'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-8.mp3', // Sample for now
    'duration' => 245,
    'track_number' => 1,
    'play_count' => 5400,
    'is_published' => true,
]);

echo "Song 'Konti Liya' by Mehdi Zallal added successfully!";
