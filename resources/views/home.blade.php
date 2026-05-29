@extends('layouts.app')
@section('title', 'Accueil')
@section('content')

{{-- Hero --}}
<div style="background:linear-gradient(135deg,rgba(124,77,255,0.2),rgba(83,109,254,0.2));backdrop-filter:var(--glass);border:1px solid var(--border);border-radius:24px;padding:60px 48px;margin-bottom:48px;position:relative;overflow:hidden">
    <div style="position:absolute;top:-100px;right:-100px;width:400px;height:400px;background:radial-gradient(circle,rgba(124,77,255,0.4),transparent 70%);border-radius:50%"></div>
    <div style="position:relative;z-index:1">
        <div style="font-size:14px;font-weight:700;color:var(--accent);text-transform:uppercase;letter-spacing:3px;margin-bottom:16px">🎵 {{ __('Welcome to Melodix') }}</div>
        <h1 style="font-size:56px;font-weight:800;line-height:1;margin-bottom:20px;letter-spacing:-2px">{{ __('Music without') }}<br><span style="background:linear-gradient(to right, #fff, var(--accent));-webkit-background-clip:text;-webkit-text-fill-color:transparent">{{ __('limits') }}</span></h1>
        <p style="color:var(--text-muted);font-size:16px;max-width:520px;margin-bottom:32px;line-height:1.6">Découvrez les artistes les plus populaires, les albums tendance et créez vos playlists personnalisées.</p>
        <a href="{{ route('artists.index') }}" style="display:inline-flex;align-items:center;gap:12px;background:var(--accent);color:#000;font-weight:700;padding:16px 36px;border-radius:40px;font-size:16px;transition:all .3s;box-shadow:0 10px 20px var(--accent-dim)" onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 15px 30px var(--accent-dim)'" onmouseout="this.style.transform='none';this.style.boxShadow='0 10px 20px var(--accent-dim)'">
            <i class="fas fa-play"></i> {{ __('Explore now') }}
        </a>
    </div>
</div>

{{-- Popular Songs --}}
<div style="margin-bottom:48px">
    <div class="section-header">
        <h2 class="section-title">🔥 {{ __('Popular Songs') }}</h2>
    </div>
    <div style="background:var(--bg-card);backdrop-filter:var(--glass);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden">
        <div style="display:grid;grid-template-columns:40px 1fr 120px 140px;gap:12px;padding:12px 20px;border-bottom:1px solid var(--border);background:rgba(255,255,255,0.03)">
            <div style="font-size:12px;color:var(--text-faint);text-align:center">#</div>
            <div style="font-size:12px;color:var(--text-faint)">{{ __('Title') }}</div>
            <div style="font-size:12px;color:var(--text-faint)">{{ __('Album') }}</div>
            <div style="font-size:12px;color:var(--text-faint);text-align:right">{{ __('Actions') }}</div>
        </div>
        <div class="song-list">
            @foreach($popularSongs as $i => $song)
            <div class="song-row" data-id="{{ $song->id }}"
                 onclick="playSong({{ $song->id }},'{{ addslashes($song->title) }}','{{ addslashes($song->artist->name) }}','{{ $song->album->cover_url ?? '' }}',{{ $song->duration }}, null, '{{ $song->audio_url }}')">
                <div style="text-align:center;position:relative">
                    <span class="song-num">{{ $i+1 }}</span>
                    <i class="fas fa-play song-play-icon" style="font-size:13px"></i>
                </div>
                <div class="song-info">
                    <div class="song-name">{{ $song->title }}</div>
                    <div class="song-artist">{{ $song->artist->name }}</div>
                </div>
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

{{-- Featured Artists --}}
<div style="margin-bottom:48px">
    <div class="section-header">
        <h2 class="section-title">⭐ {{ __('Popular Artists') }}</h2>
        <a href="{{ route('artists.index') }}" class="section-link">{{ __('Read more') }}</a>
    </div>
    <div class="cards-grid">
        @foreach($featuredArtists as $artist)
        <a href="{{ route('artists.show', $artist->slug) }}" class="card artist-card" style="text-align:center">
            <div class="card-img-wrap">
                <img src="{{ $artist->image_url }}" alt="{{ $artist->name }}" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($artist->name) }}&size=300&background=7c4dff&color=fff&bold=true'">
                <button class="card-play-btn" onclick="event.preventDefault();playSong(null,'','{{ addslashes($artist->name) }}','{{ $artist->image_url }}',180)"><i class="fas fa-play"></i></button>
            </div>
            <div class="card-title">{{ $artist->name }}</div>
            <div class="card-sub">{{ $artist->formatted_listeners }} {{ __('listeners/month') }}</div>
            @if($artist->is_verified)<div style="margin-top:8px"><span class="badge"><i class="fas fa-check-circle"></i> {{ __('Verified') }}</span></div>@endif
        </a>
        @endforeach
    </div>
</div>

{{-- Recent Albums --}}
<div style="margin-bottom:48px">
    <div class="section-header">
        <h2 class="section-title">💿 {{ __('Recent Albums') }}</h2>
    </div>
    <div class="cards-grid">
        @foreach($recentAlbums as $album)
        <a href="{{ route('albums.show', $album->slug) }}" class="card">
            <div class="card-img-wrap">
                <img src="{{ $album->cover_url }}" alt="{{ $album->title }}" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($album->title) }}&size=300&background=1a1a2e&color=fff'">
                <button class="card-play-btn" onclick="event.preventDefault();loadAndPlayAlbum({{ $album->id }})"><i class="fas fa-play"></i></button>
            </div>
            <div class="card-title">{{ $album->title }}</div>
            <div class="card-sub">{{ $album->artist->name }} • {{ $album->release_date?->year }}</div>
        </a>
        @endforeach
    </div>
</div>

{{-- Trending --}}
<div>
    <div class="section-header">
        <h2 class="section-title">📈 {{ __('Trending Albums') }}</h2>
    </div>
    <div class="cards-grid">
        @foreach($trendingAlbums as $album)
        <a href="{{ route('albums.show', $album->slug) }}" class="card">
            <div class="card-img-wrap">
                <img src="{{ $album->cover_url }}" alt="{{ $album->title }}" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($album->title) }}&size=300&background=1a1a2e&color=fff'">
                <button class="card-play-btn" onclick="event.preventDefault();loadAndPlayAlbum({{ $album->id }})"><i class="fas fa-play"></i></button>
            </div>
            <div class="card-title">{{ $album->title }}</div>
            <div class="card-sub">{{ $album->formatted_streams }} {{ __('streams') }}</div>
        </a>
        @endforeach
    </div>
</div>

@push('scripts')
<script>
async function loadAndPlayAlbum(albumId) {
    const res = await fetch(`/api/albums/${albumId}/songs`);
    const songs = await res.json();
    if (!songs.length) return;
    const queue = songs.map(s => ({
        id: s.id, title: s.title,
        artist: s.artist?.name || '',
        cover: s.album?.cover_url || '',
        duration: s.duration
    }));
    window.playQueue(queue, 0);
}
</script>
@endpush
@endsection
