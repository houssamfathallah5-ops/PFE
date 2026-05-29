@extends('layouts.app')
@section('title', 'Recherche')
@section('content')
<h1 style="font-size:28px;font-weight:800;margin-bottom:24px">Recherche</h1>

@if(!$query)
<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px">
    @foreach(['Pop','Hip-Hop','R&B','Electronic','Rock','Latin','Jazz','Classical'] as $genre)
    <a href="{{ route('search') }}?q={{ $genre }}" style="border-radius:var(--radius);padding:20px;font-size:16px;font-weight:700;cursor:pointer;background:linear-gradient(135deg,{{ ['#e91e63','#9c27b0','#3f51b5','#00bcd4','#f44336','#ff9800','#795548','#607d8b'][array_search($genre,['Pop','Hip-Hop','R&B','Electronic','Rock','Latin','Jazz','Classical'])] }},rgba(0,0,0,.3));transition:transform .2s;display:block" onmouseover="this.style.transform='scale(1.04)'" onmouseout="this.style.transform='scale(1)'">{{ $genre }}</a>
    @endforeach
</div>
@else
<p style="color:var(--text-muted);margin-bottom:28px">Résultats pour "<strong style="color:var(--text)">{{ $query }}</strong>"</p>

@if($artists->count())
<div style="margin-bottom:36px">
    <div class="section-header"><h2 class="section-title">⭐ {{ __('Artists') }}</h2></div>
    <div class="cards-grid">
        @foreach($artists as $artist)
        <a href="{{ route('artists.show', $artist->slug) }}" class="card artist-card" style="text-align:center">
            <div class="card-img-wrap">
                <img src="{{ $artist->image_url }}" alt="{{ $artist->name }}" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($artist->name) }}&size=300&background=7c4dff&color=fff&bold=true'">
            </div>
            <div class="card-title">{{ $artist->name }}</div>
            <div class="card-sub">{{ $artist->formatted_listeners }} {{ __('listeners/month') }}</div>
        </a>
        @endforeach
    </div>
</div>
@endif

@if($songs->count())
<div style="margin-bottom:36px">
    <div class="section-header"><h2 class="section-title">🎵 {{ __('Songs') }}</h2></div>
    <div style="background:var(--bg-card);backdrop-filter:var(--glass);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden">
        <div style="display:grid;grid-template-columns:40px 1fr 120px 140px;gap:12px;padding:12px 20px;border-bottom:1px solid var(--border);background:rgba(255,255,255,0.03)">
            <div style="font-size:12px;color:var(--text-faint);text-align:center">#</div>
            <div style="font-size:12px;color:var(--text-faint)">{{ __('Title') }}</div>
            <div style="font-size:12px;color:var(--text-faint)">{{ __('Album') }}</div>
            <div style="font-size:12px;color:var(--text-faint);text-align:right">{{ __('Actions') }}</div>
        </div>
        <div class="song-list">
            @foreach($songs as $i => $song)
            <div class="song-row" data-id="{{ $song->id }}"
             onclick="playSong({{ $song->id }},'{{ addslashes($song->title) }}','{{ addslashes($song->artist->name) }}','{{ $song->album->cover_url ?? '' }}',{{ $song->duration }}, null, '{{ $song->audio_url }}')">
            <div style="text-align:center"><span class="song-num">{{ $i+1 }}</span><i class="fas fa-play song-play-icon" style="font-size:13px"></i></div>
            <div class="song-info"><div class="song-name">{{ $song->title }}</div><div class="song-artist">{{ $song->artist->name }}</div></div>
            <div class="song-album-name">{{ $song->album->title }}</div>
            <div style="display:flex;align-items:center;justify-content:flex-end;gap:16px">
                <button class="ctrl-btn" onclick="event.stopPropagation();toggleLike({{ $song->id }},this)" title="{{ __('Like') }}"><i class="far fa-heart"></i></button>
                <div class="song-duration">{{ $song->formatted_duration }}</div>
                <button class="ctrl-btn btn-more" onclick="event.stopPropagation();showPlaylistMenu(event,{{ $song->id }})" title="{{ __('More') }}"><i class="fas fa-ellipsis-h"></i></button>
            </div>
        </div>
            @endforeach
        </div>
    </div>
</div>
@endif

@if(isset($spotifySongs) && $spotifySongs->count())
<div style="margin-bottom:36px">
    <div class="section-header">
        <h2 class="section-title">🌍 {{ __('Worldwide (Spotify)') }}</h2>
        <span style="font-size:12px;color:var(--text-faint)">{{ __('30s previews') }}</span>
    </div>
    <div style="background:var(--bg-card);backdrop-filter:var(--glass);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden">
        <div class="song-list">
            @foreach($spotifySongs as $i => $track)
            <div class="song-row" data-id="{{ $track['id'] }}"
                 onclick="playSong(null,'{{ addslashes($track['title']) }}','{{ addslashes($track['artist']['name']) }}','{{ $track['album']['cover_url'] }}',{{ $track['duration'] }}, null, '{{ $track['audio_url'] }}')">
                <div style="text-align:center"><i class="fab fa-spotify" style="color:#1DB954"></i></div>
                <div class="song-info">
                    <div class="song-name">{{ $track['title'] }}</div>
                    <div class="song-artist">{{ $track['artist']['name'] }}</div>
                </div>
                <div class="song-album-name">{{ $track['album']['title'] }}</div>
                <div style="display:flex;align-items:center;justify-content:flex-end;gap:16px">
                    <a href="{{ $track['spotify_url'] }}" target="_blank" class="ctrl-btn" onclick="event.stopPropagation()" title="{{ __('Open in Spotify') }}"><i class="fas fa-external-link-alt"></i></a>
                    <div class="song-duration">{{ floor($track['duration']/60) }}:{{ str_pad($track['duration']%60,2,'0',STR_PAD_LEFT) }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif


@if($albums->count())
<div>
    <div class="section-header"><h2 class="section-title">Albums</h2></div>
    <div class="cards-grid">
        @foreach($albums as $album)
        <a href="{{ route('albums.show', $album->slug) }}" class="card">
            <div class="card-img-wrap"><img src="{{ $album->cover_url }}" alt="{{ $album->title }}" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($album->title) }}&size=300&background=1a1a2e&color=fff'"></div>
            <div class="card-title">{{ $album->title }}</div>
            <div class="card-sub">{{ $album->artist->name }}</div>
        </a>
        @endforeach
    </div>
</div>
@endif

@if(!$artists->count() && !$songs->count() && !$albums->count())
<div style="text-align:center;padding:100px 20px;color:var(--text-muted)">
    <div style="font-size:48px;margin-bottom:24px;opacity:0.3"><i class="fas fa-search"></i></div>
    <div style="font-size:18px;font-weight:600">{{ __('No results found for') }} "{{ request('q') }}"</div>
    <div style="font-size:14px;margin-top:8px">{{ __('Try another search or check the spelling') }}</div>
</div>
@endif
@endif
@endsection
