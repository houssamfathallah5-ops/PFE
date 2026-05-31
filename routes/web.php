<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminArtistController;
use App\Http\Controllers\Admin\AdminAlbumController;
use App\Http\Controllers\Admin\AdminSongController;

// Frontend routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Locale switch (accessible to guests too)
Route::get('/locale/{lang}', function($lang) {
    if (in_array($lang, ['en', 'fr', 'ar'])) {
        session(['locale' => $lang]);
    }
    return back();
})->name('locale.switch');

// Protected Frontend routes (must be logged in)
Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/songs', [SongController::class, 'index'])->name('songs.index');
    Route::get('/favorites', [SongController::class, 'favorites'])->name('songs.favorites');
    Route::get('/search', [HomeController::class, 'search'])->name('search');
    Route::get('/artists', [ArtistController::class, 'index'])->name('artists.index');
    Route::get('/artists/{slug}', [ArtistController::class, 'show'])->name('artists.show');
    Route::get('/albums/{slug}', [AlbumController::class, 'show'])->name('albums.show');
    Route::get('/playlists', [PlaylistController::class, 'index'])->name('playlists.index');
    Route::get('/playlists/{slug}', [PlaylistController::class, 'show'])->name('playlists.show');
});

// API routes for the player
Route::prefix('api')->group(function () {
    Route::get('/songs/{id}', [SongController::class, 'apiShow'])->name('api.songs.show');
    Route::get('/songs/{id}/play', [SongController::class, 'incrementPlay'])->name('api.songs.play');
    Route::get('/albums/{id}/songs', [AlbumController::class, 'apiSongs'])->name('api.albums.songs');
    Route::get('/search', [HomeController::class, 'apiSearch'])->name('api.search');
    
    // Likes
    Route::post('/songs/{id}/like', [\App\Http\Controllers\LikeController::class, 'toggle'])->name('api.songs.like');
    Route::get('/songs/{id}/like', [\App\Http\Controllers\LikeController::class, 'check']);
    
    // Playlist management
    Route::get('/user/playlists', [\App\Http\Controllers\PlaylistSongController::class, 'userPlaylists']);
    Route::post('/playlists/add-song', [\App\Http\Controllers\PlaylistSongController::class, 'store'])->name('api.playlists.add');
    Route::delete('/playlists/{playlist}/songs/{song}', [\App\Http\Controllers\PlaylistSongController::class, 'destroy']);
});

// Admin routes (restricted to artists)
Route::middleware(['auth', 'role:artist'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('artists', AdminArtistController::class);
    Route::resource('albums', AdminAlbumController::class);
    Route::resource('songs', AdminSongController::class);
});
