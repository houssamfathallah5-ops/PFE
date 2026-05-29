<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Artist;
use App\Models\Album;
use App\Models\Song;
use App\Models\User;
use App\Models\Playlist;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@melodix.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $artists = [
            [
                'name' => 'The Weeknd',
                'genre' => 'R&B / Pop',
                'country' => 'Canada',
                'bio' => 'Abel Makkonen Tesfaye, known professionally as The Weeknd, is a Canadian singer, songwriter, and record producer.',
                'image_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/e/e3/The_Weeknd_2017_cropped.jpg/800px-The_Weeknd_2017_cropped.jpg',
                'cover_url' => 'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=1200',
                'monthly_listeners' => 88_000_000,
                'total_streams' => 40_000_000_000,
                'is_verified' => true,
                'albums' => [
                    [
                        'title' => 'After Hours',
                        'type' => 'album',
                        'release_date' => '2020-03-20',
                        'genre' => 'R&B',
                        'label' => 'Republic Records',
                        'cover_url' => 'https://upload.wikimedia.org/wikipedia/en/c/c0/The_Weeknd_-_After_Hours.png',
                        'total_streams' => 15_000_000_000,
                        'songs' => [
                            ['title' => 'Alone Again', 'duration' => 236, 'play_count' => 800_000_000, 'track_number' => 1],
                            ['title' => 'Too Late', 'duration' => 232, 'play_count' => 750_000_000, 'track_number' => 2],
                            ['title' => 'Hardest to Love', 'duration' => 224, 'play_count' => 720_000_000, 'track_number' => 3],
                            ['title' => 'Scared to Live', 'duration' => 200, 'play_count' => 690_000_000, 'track_number' => 4],
                            ['title' => 'Snowchild', 'duration' => 259, 'play_count' => 680_000_000, 'track_number' => 5],
                            ['title' => 'Escape from LA', 'duration' => 366, 'play_count' => 660_000_000, 'track_number' => 6],
                            ['title' => 'Heartless', 'duration' => 202, 'play_count' => 2_100_000_000, 'track_number' => 7],
                            ['title' => 'Faith', 'duration' => 371, 'play_count' => 640_000_000, 'track_number' => 8],
                            ['title' => 'Blinding Lights', 'duration' => 200, 'play_count' => 4_000_000_000, 'track_number' => 9],
                            ['title' => 'In Your Eyes', 'duration' => 238, 'play_count' => 1_800_000_000, 'track_number' => 10],
                            ['title' => 'Save Your Tears', 'duration' => 215, 'play_count' => 2_500_000_000, 'track_number' => 11],
                            ['title' => 'Repeat After Me', 'duration' => 192, 'play_count' => 600_000_000, 'track_number' => 12],
                            ['title' => 'After Hours', 'duration' => 361, 'play_count' => 900_000_000, 'track_number' => 13],
                        ],
                    ],
                    [
                        'title' => 'Starboy',
                        'type' => 'album',
                        'release_date' => '2016-11-25',
                        'genre' => 'R&B',
                        'label' => 'Republic Records',
                        'cover_url' => 'https://upload.wikimedia.org/wikipedia/en/3/39/The_Weeknd_-_Starboy.png',
                        'total_streams' => 12_000_000_000,
                        'songs' => [
                            ['title' => 'Starboy', 'duration' => 230, 'play_count' => 2_800_000_000, 'track_number' => 1],
                            ['title' => 'Party Monster', 'duration' => 248, 'play_count' => 900_000_000, 'track_number' => 2],
                            ['title' => 'False Alarm', 'duration' => 221, 'play_count' => 850_000_000, 'track_number' => 3],
                            ['title' => 'Reminder', 'duration' => 228, 'play_count' => 800_000_000, 'track_number' => 4],
                            ['title' => 'Rockin\'', 'duration' => 216, 'play_count' => 750_000_000, 'track_number' => 5],
                            ['title' => 'Secrets', 'duration' => 244, 'play_count' => 820_000_000, 'track_number' => 6],
                            ['title' => 'True Colors', 'duration' => 211, 'play_count' => 700_000_000, 'track_number' => 7],
                            ['title' => 'Sidewalks', 'duration' => 215, 'play_count' => 680_000_000, 'track_number' => 8],
                            ['title' => 'Six Feet Under', 'duration' => 231, 'play_count' => 720_000_000, 'track_number' => 9],
                            ['title' => 'Love to Lay', 'duration' => 198, 'play_count' => 660_000_000, 'track_number' => 10],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Drake',
                'genre' => 'Hip-Hop / Rap',
                'country' => 'Canada',
                'bio' => 'Aubrey Drake Graham is a Canadian rapper, singer, songwriter, actor, and entrepreneur. Drake is credited for popularizing the Toronto sound.',
                'image_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/2/28/Drake_July_2016.jpg/800px-Drake_July_2016.jpg',
                'cover_url' => 'https://images.unsplash.com/photo-1501386761578-eac5c94b800a?w=1200',
                'monthly_listeners' => 78_000_000,
                'total_streams' => 50_000_000_000,
                'is_verified' => true,
                'albums' => [
                    [
                        'title' => 'Certified Lover Boy',
                        'type' => 'album',
                        'release_date' => '2021-09-03',
                        'genre' => 'Hip-Hop',
                        'label' => 'OVO Sound',
                        'cover_url' => 'https://upload.wikimedia.org/wikipedia/en/e/e7/Drake_-_Certified_Lover_Boy.png',
                        'total_streams' => 10_000_000_000,
                        'songs' => [
                            ['title' => 'Champagne Poetry', 'duration' => 342, 'play_count' => 850_000_000, 'track_number' => 1],
                            ['title' => 'TSU', 'duration' => 196, 'play_count' => 600_000_000, 'track_number' => 2],
                            ['title' => 'Way 2 Sexy', 'duration' => 246, 'play_count' => 1_200_000_000, 'track_number' => 3],
                            ['title' => 'Pipe Down', 'duration' => 224, 'play_count' => 750_000_000, 'track_number' => 4],
                            ['title' => 'Yebba\'s Heartbreak', 'duration' => 226, 'play_count' => 580_000_000, 'track_number' => 5],
                            ['title' => 'Girls Want Girls', 'duration' => 230, 'play_count' => 900_000_000, 'track_number' => 6],
                            ['title' => 'In the Bible', 'duration' => 285, 'play_count' => 720_000_000, 'track_number' => 7],
                            ['title' => 'Love All', 'duration' => 210, 'play_count' => 800_000_000, 'track_number' => 8],
                            ['title' => 'Fair Trade', 'duration' => 296, 'play_count' => 780_000_000, 'track_number' => 9],
                            ['title' => 'Knife Talk', 'duration' => 181, 'play_count' => 1_100_000_000, 'track_number' => 10],
                        ],
                    ],
                    [
                        'title' => 'Scorpion',
                        'type' => 'album',
                        'release_date' => '2018-06-29',
                        'genre' => 'Hip-Hop / R&B',
                        'label' => 'Young Money',
                        'cover_url' => 'https://upload.wikimedia.org/wikipedia/en/9/90/Scorpion_by_Drake.jpg',
                        'total_streams' => 14_000_000_000,
                        'songs' => [
                            ['title' => 'Survival', 'duration' => 175, 'play_count' => 700_000_000, 'track_number' => 1],
                            ['title' => 'Nonstop', 'duration' => 205, 'play_count' => 1_800_000_000, 'track_number' => 2],
                            ['title' => 'Elevate', 'duration' => 183, 'play_count' => 650_000_000, 'track_number' => 3],
                            ['title' => 'Emotionless', 'duration' => 261, 'play_count' => 680_000_000, 'track_number' => 4],
                            ['title' => 'God\'s Plan', 'duration' => 198, 'play_count' => 3_500_000_000, 'track_number' => 5],
                            ['title' => 'I\'m Upset', 'duration' => 216, 'play_count' => 780_000_000, 'track_number' => 6],
                            ['title' => 'Blue Tint', 'duration' => 229, 'play_count' => 620_000_000, 'track_number' => 7],
                            ['title' => 'In My Feelings', 'duration' => 217, 'play_count' => 2_800_000_000, 'track_number' => 8],
                            ['title' => 'Nice for What', 'duration' => 213, 'play_count' => 1_900_000_000, 'track_number' => 9],
                            ['title' => 'Finesse', 'duration' => 201, 'play_count' => 750_000_000, 'track_number' => 10],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Taylor Swift',
                'genre' => 'Pop / Country',
                'country' => 'USA',
                'bio' => 'Taylor Alison Swift is an American singer-songwriter. Recognized for her songwriting, musical versatility, and artistic reinventions.',
                'image_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/b5/191125_Taylor_Swift_at_the_2019_American_Music_Awards_%28cropped%29.png/800px-191125_Taylor_Swift_at_the_2019_American_Music_Awards_%28cropped%29.png',
                'cover_url' => 'https://images.unsplash.com/photo-1470229722913-7c0e2dbbafd3?w=1200',
                'monthly_listeners' => 95_000_000,
                'total_streams' => 60_000_000_000,
                'is_verified' => true,
                'albums' => [
                    [
                        'title' => 'Midnights',
                        'type' => 'album',
                        'release_date' => '2022-10-21',
                        'genre' => 'Synth-Pop',
                        'label' => 'Republic Records',
                        'cover_url' => 'https://upload.wikimedia.org/wikipedia/en/9/9f/Midnights_-_Taylor_Swift.png',
                        'total_streams' => 20_000_000_000,
                        'songs' => [
                            ['title' => 'Lavender Haze', 'duration' => 202, 'play_count' => 2_000_000_000, 'track_number' => 1],
                            ['title' => 'Maroon', 'duration' => 218, 'play_count' => 1_500_000_000, 'track_number' => 2],
                            ['title' => 'Anti-Hero', 'duration' => 200, 'play_count' => 4_500_000_000, 'track_number' => 3],
                            ['title' => 'Snow on the Beach', 'duration' => 253, 'play_count' => 1_200_000_000, 'track_number' => 4],
                            ['title' => 'Midnight Rain', 'duration' => 174, 'play_count' => 1_100_000_000, 'track_number' => 5],
                            ['title' => 'Question...?', 'duration' => 215, 'play_count' => 1_000_000_000, 'track_number' => 6],
                            ['title' => 'Vigilante Shit', 'duration' => 164, 'play_count' => 980_000_000, 'track_number' => 7],
                            ['title' => 'Bejeweled', 'duration' => 194, 'play_count' => 1_300_000_000, 'track_number' => 8],
                            ['title' => 'Labyrinth', 'duration' => 250, 'play_count' => 850_000_000, 'track_number' => 9],
                            ['title' => 'Karma', 'duration' => 196, 'play_count' => 1_600_000_000, 'track_number' => 10],
                            ['title' => 'Sweet Nothing', 'duration' => 183, 'play_count' => 900_000_000, 'track_number' => 11],
                            ['title' => 'Mastermind', 'duration' => 197, 'play_count' => 1_100_000_000, 'track_number' => 12],
                        ],
                    ],
                    [
                        'title' => '1989 (Taylor\'s Version)',
                        'type' => 'album',
                        'release_date' => '2023-10-27',
                        'genre' => 'Pop',
                        'label' => 'Republic Records',
                        'cover_url' => 'https://upload.wikimedia.org/wikipedia/en/thumb/a/a3/Taylor_Swift_-_1989_%28Taylor%27s_Version%29.png/220px-Taylor_Swift_-_1989_%28Taylor%27s_Version%29.png',
                        'total_streams' => 18_000_000_000,
                        'songs' => [
                            ['title' => 'Welcome to New York', 'duration' => 212, 'play_count' => 800_000_000, 'track_number' => 1],
                            ['title' => 'Blank Space', 'duration' => 231, 'play_count' => 3_200_000_000, 'track_number' => 2],
                            ['title' => 'Style', 'duration' => 231, 'play_count' => 2_900_000_000, 'track_number' => 3],
                            ['title' => 'Out of the Woods', 'duration' => 235, 'play_count' => 1_400_000_000, 'track_number' => 4],
                            ['title' => 'Bad Blood', 'duration' => 211, 'play_count' => 1_100_000_000, 'track_number' => 5],
                            ['title' => 'Shake It Off', 'duration' => 219, 'play_count' => 4_000_000_000, 'track_number' => 6],
                            ['title' => 'Wildest Dreams', 'duration' => 220, 'play_count' => 2_000_000_000, 'track_number' => 7],
                            ['title' => 'How You Get the Girl', 'duration' => 244, 'play_count' => 900_000_000, 'track_number' => 8],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Dua Lipa',
                'genre' => 'Pop / Dance',
                'country' => 'UK',
                'bio' => 'Dua Lipa is an English singer and songwriter. After working as a model, she signed with a management company in 2012 and began her music career.',
                'image_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/c7/Dua_Lipa_2023.jpg/800px-Dua_Lipa_2023.jpg',
                'cover_url' => 'https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?w=1200',
                'monthly_listeners' => 80_000_000,
                'total_streams' => 35_000_000_000,
                'is_verified' => true,
                'albums' => [
                    [
                        'title' => 'Future Nostalgia',
                        'type' => 'album',
                        'release_date' => '2020-03-27',
                        'genre' => 'Nu-Disco / Pop',
                        'label' => 'Warner Records',
                        'cover_url' => 'https://upload.wikimedia.org/wikipedia/en/f/f5/Dua_Lipa_-_Future_Nostalgia_%28Official_Album_Cover%29.png',
                        'total_streams' => 16_000_000_000,
                        'songs' => [
                            ['title' => 'Future Nostalgia', 'duration' => 208, 'play_count' => 1_400_000_000, 'track_number' => 1],
                            ['title' => "Don't Start Now", 'duration' => 183, 'play_count' => 3_000_000_000, 'track_number' => 2],
                            ['title' => 'Cool', 'duration' => 215, 'play_count' => 1_000_000_000, 'track_number' => 3],
                            ['title' => 'Physical', 'duration' => 194, 'play_count' => 1_600_000_000, 'track_number' => 4],
                            ['title' => 'Levitating', 'duration' => 203, 'play_count' => 3_500_000_000, 'track_number' => 5],
                            ['title' => 'Pretty Please', 'duration' => 205, 'play_count' => 820_000_000, 'track_number' => 6],
                            ['title' => 'Hallucinate', 'duration' => 203, 'play_count' => 950_000_000, 'track_number' => 7],
                            ['title' => 'Love Again', 'duration' => 219, 'play_count' => 1_200_000_000, 'track_number' => 8],
                            ['title' => 'Break My Heart', 'duration' => 220, 'play_count' => 1_100_000_000, 'track_number' => 9],
                            ['title' => 'Good in Bed', 'duration' => 203, 'play_count' => 850_000_000, 'track_number' => 10],
                            ['title' => 'Boys Will Be Boys', 'duration' => 212, 'play_count' => 900_000_000, 'track_number' => 11],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Bad Bunny',
                'genre' => 'Reggaeton / Latin Trap',
                'country' => 'Puerto Rico',
                'bio' => 'Benito Antonio Martínez Ocasio, known professionally as Bad Bunny, is a Puerto Rican rapper, singer, and songwriter.',
                'image_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/16/Bad_Bunny_2019_cropped.jpg/800px-Bad_Bunny_2019_cropped.jpg',
                'cover_url' => 'https://images.unsplash.com/photo-1571330735066-03aaa9429d89?w=1200',
                'monthly_listeners' => 92_000_000,
                'total_streams' => 45_000_000_000,
                'is_verified' => true,
                'albums' => [
                    [
                        'title' => 'Un Verano Sin Ti',
                        'type' => 'album',
                        'release_date' => '2022-05-06',
                        'genre' => 'Reggaeton',
                        'label' => 'Rimas Entertainment',
                        'cover_url' => 'https://upload.wikimedia.org/wikipedia/en/4/4e/Bad_Bunny_-_Un_Verano_Sin_Ti.png',
                        'total_streams' => 22_000_000_000,
                        'songs' => [
                            ['title' => 'El Apagón', 'duration' => 407, 'play_count' => 1_200_000_000, 'track_number' => 1],
                            ['title' => 'Titi Me Preguntó', 'duration' => 253, 'play_count' => 2_800_000_000, 'track_number' => 2],
                            ['title' => 'Después de la Playa', 'duration' => 186, 'play_count' => 950_000_000, 'track_number' => 3],
                            ['title' => 'Me Porto Bonito', 'duration' => 178, 'play_count' => 2_200_000_000, 'track_number' => 4],
                            ['title' => 'Efecto', 'duration' => 209, 'play_count' => 1_400_000_000, 'track_number' => 5],
                            ['title' => 'Party', 'duration' => 196, 'play_count' => 1_100_000_000, 'track_number' => 6],
                            ['title' => 'Neverita', 'duration' => 147, 'play_count' => 1_600_000_000, 'track_number' => 7],
                            ['title' => 'Moscow Mule', 'duration' => 191, 'play_count' => 1_300_000_000, 'track_number' => 8],
                            ['title' => 'Ojitos Lindos', 'duration' => 263, 'play_count' => 1_500_000_000, 'track_number' => 9],
                            ['title' => 'Un Coco', 'duration' => 200, 'play_count' => 1_000_000_000, 'track_number' => 10],
                        ],
                    ],
                ],
            ],
        ];

        // Use DB Transaction for data integrity
        DB::transaction(function () use ($artists) {
            foreach ($artists as $artistData) {
                $albumsData = $artistData['albums'];
                unset($artistData['albums']);

                $artist = Artist::create(array_merge($artistData, [
                    'slug' => Str::slug($artistData['name']),
                ]));

                foreach ($albumsData as $albumData) {
                    $songsData = $albumData['songs'];
                    unset($albumData['songs']);

                    $album = Album::create(array_merge($albumData, [
                        'artist_id' => $artist->id,
                        'slug' => Str::slug($albumData['title'] . '-' . $artist->id),
                    ]));

                    foreach ($songsData as $songData) {
                        Song::create(array_merge($songData, [
                            'album_id' => $album->id,
                            'artist_id' => $artist->id,
                            'slug' => Str::slug($songData['title'] . '-' . $album->id . '-' . $songData['track_number']),
                            'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-' . (rand(1, 10)) . '.mp3',
                            'genre' => $albumData['genre'],
                            'like_count' => (int)($songData['play_count'] * 0.15),
                            'is_published' => true,
                            'is_explicit' => false,
                        ]));
                    }
                }
            }
        });

        // Create some playlists for the admin user
        $admin = User::first();
        if ($admin) {
            $playlists = ['Ma Playlist #1', 'Favoris R&B', 'Découvertes du soir'];
            foreach ($playlists as $name) {
                Playlist::create([
                    'user_id' => $admin->id,
                    'name' => $name,
                    'slug' => Str::slug($name),
                    'is_public' => true
                ]);
            }
        }
    }
}
