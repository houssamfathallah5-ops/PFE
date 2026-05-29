<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Models\User;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggle(int $id)
    {
        // For demo purposes, we'll use the first user
        $user = User::first();
        if (!$user) return response()->json(['error' => 'No user found'], 404);

        $song = Song::findOrFail($id);
        
        $isLiked = $user->likedSongs()->where('song_id', $id)->exists();
        
        if ($isLiked) {
            $user->likedSongs()->detach($id);
            $song->decrement('like_count');
            $liked = false;
        } else {
            $user->likedSongs()->attach($id);
            $song->increment('like_count');
            $liked = true;
        }

        return response()->json([
            'success' => true,
            'liked' => $liked,
            'count' => $song->like_count
        ]);
    }

    public function check(int $id)
    {
        $user = User::first();
        if (!$user) return response()->json(['liked' => false]);

        $isLiked = $user->likedSongs()->where('song_id', $id)->exists();
        return response()->json(['liked' => $isLiked]);
    }
}
