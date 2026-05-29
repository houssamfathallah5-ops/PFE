<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class SpotifyService
{
    protected $clientId;
    protected $clientSecret;

    public function __construct()
    {
        $this->clientId = config('services.spotify.client_id');
        $this->clientSecret = config('services.spotify.client_secret');
    }

    /**
     * Get Access Token using Client Credentials Flow
     */
    protected function getAccessToken()
    {
        return Cache::remember('spotify_token', 3500, function () {
            $response = Http::asForm()->withBasicAuth($this->clientId, $this->clientSecret)
                ->post('https://accounts.spotify.com/api/token', [
                    'grant_type' => 'client_credentials',
                ]);

            if ($response->successful()) {
                return $response->json()['access_token'];
            }

            return null;
        });
    }

    /**
     * Search for tracks on Spotify
     */
    public function searchTracks($query, $limit = 10)
    {
        $token = $this->getAccessToken();
        if (!$token) return [];

        $response = Http::withToken($token)
            ->get('https://api.spotify.com/v1/search', [
                'q' => $query,
                'type' => 'track',
                'limit' => $limit,
            ]);

        if ($response->successful()) {
            return collect($response->json()['tracks']['items'])->map(function ($track) {
                return [
                    'id' => 'sp_' . $track['id'],
                    'title' => $track['name'],
                    'duration' => floor($track['duration_ms'] / 1000),
                    'audio_url' => $track['preview_url'], // 30s preview
                    'artist' => [
                        'name' => $track['artists'][0]['name'],
                    ],
                    'album' => [
                        'cover_url' => $track['album']['images'][0]['url'] ?? null,
                        'title' => $track['album']['name'],
                    ],
                    'is_spotify' => true,
                    'spotify_url' => $track['external_urls']['spotify'],
                ];
            });
        }

        return [];
    }
}
