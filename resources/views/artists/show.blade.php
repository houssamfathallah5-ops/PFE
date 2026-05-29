@extends('layouts.app')
@section('title', $artist->name)
@section('content')

{{-- Hero --}}
<div style="position:relative;border-radius:20px;overflow:hidden;margin-bottom:32px;min-height:280px;background:linear-gradient(135deg,#111,#1a1a2e)">
    @if($artist->cover_url)
    <img src="{{ $artist->cover_url }}" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;opacity:.35" alt="">
    @endif
    <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(10,10,15,1) 0%,rgba(10,10,15,.3) 100%)"></div>
    <div style="position:relative;z-index:1;padding:40px;display:flex;align-items:flex-end;gap:28px;min-height:280px">
        <img src="{{ $artist->image_url }}" alt="{{ $artist->name }}"
             style="width:140px;height:140px;border-radius:50%;object-fit:cover;border:4px solid rgba(255,255,255,.15);flex-shrink:0;box-shadow:0 20px 60px rgba(0,0,0,.6)"
             onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($artist->name) }}&size=280&background=1db954&color=000&bold=true'">
        <div style="flex:1">
        <div style="display:flex;align-items:center;gap:8px;margin-bottom:12px">
            @if($artist->is_verified)<span style="background:var(--accent);color:#000;font-size:10px;font-weight:900;padding:4px 8px;border-radius:20px;text-transform:uppercase;letter-spacing:1px"><i class="fas fa-check-circle"></i> {{ __('Verified Artist') }}</span>@endif
        </div>
        <h1 style="font-size:96px;font-weight:800;line-height:0.9;margin-bottom:24px;letter-spacing:-4px">{{ $artist->name }}</h1>
        <div style="font-size:16px;font-weight:600;color:#fff">{{ $artist->formatted_listeners }} {{ __('listeners/month') }}</div>
        <div style="color:var(--text-muted);font-size:14px">{{ $artist->country }} • {{ $artist->genre }}</div>
    </div>
    </div>
</div>

{{-- Actions --}}
<div style="display:flex;align-items:center;gap:14px;margin-bottom:36px">
    <button onclick="loadAndPlayArtist()" style="display:flex;align-items:center;gap:10px;background:var(--accent);color:#000;font-weight:700;padding:14px 32px;border-radius:30px;border:none;cursor:pointer;font-size:15px;font-family:inherit;transition:all .2s" onmouseover="this.style.transform='scale(1.04)'" onmouseout="this.style.transform='scale(1)'">
        <i class="fas fa-play"></i> Lecture
    </button>
    <button style="width:48px;height:48px;border-radius:50%;border:2px solid rgba(255,255,255,.2);background:none;color:var(--text-muted);cursor:pointer;font-size:18px;transition:all .2s" onmouseover="this.style.borderColor='var(--text)';this.style.color='var(--text)'" onmouseout="this.style.borderColor='rgba(255,255,255,.2)';this.style.color='var(--text-muted)'">
        <i class="fas fa-heart"></i>
    </button>
    <button style="width:48px;height:48px;border-radius:50%;border:2px solid rgba(255,255,255,.2);background:none;color:var(--text-muted);cursor:pointer;font-size:18px" title="Plus">
        <i class="fas fa-ellipsis-h"></i>
    </button>
</div>

{{-- Bio --}}
@if($artist->bio)
<div style="background:var(--bg-card);border-radius:var(--radius);padding:24px;margin-bottom:32px">
    <h3 style="font-size:16px;font-weight:700;margin-bottom:10px">À propos</h3>
    <p style="color:var(--text-muted);font-size:14px;line-height:1.7">{{ $artist->bio }}</p>
</div>
@endif

{{-- Popular Songs --}}
<div style="margin-bottom:40px">
    <div style="display:grid;grid-template-columns:40px 1fr 120px 140px;gap:12px;padding:12px 20px;border-bottom:1px solid var(--border);background:rgba(255,255,255,0.03)">
        <div style="font-size:12px;color:var(--text-faint);text-align:center">#</div>
        <div style="font-size:12px;color:var(--text-faint)">{{ __('Title') }}</div>
        <div style="font-size:12px;color:var(--text-faint)">{{ __('Album') }}</div>
        <div style="font-size:12px;color:var(--text-faint);text-align:right">{{ __('Actions') }}</div>
    </div>
    <div style="background:var(--bg-card);border-radius:var(--radius);overflow:hidden">
        <div class="song-list">
            @foreach($popularSongs as $i => $song)
            <div class="song-row" data-id="{{ $song->id }}"
                 onclick="playSong({{ $song->id }},'{{ addslashes($song->title) }}','{{ addslashes($artist->name) }}','{{ $song->album->cover_url ?? '' }}',{{ $song->duration }}, null, '{{ $song->audio_url }}')">
                <div style="text-align:center">
                    <span class="song-num">{{ $i+1 }}</span>
                    <i class="fas fa-play song-play-icon" style="font-size:13px"></i>
                </div>
                <div class="song-info">
                    <div class="song-name">{{ $song->title }}</div>
                    <div class="song-artist">{{ $song->album->title }}</div>
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

{{-- Albums --}}
<div>
    <div class="section-header"><h2 class="section-title">Discographie</h2></div>
    <div class="cards-grid">
        @foreach($albums as $album)
        <a href="{{ route('albums.show', $album->slug) }}" class="card">
            <div class="card-img-wrap">
                <img src="{{ $album->cover_url }}" alt="{{ $album->title }}" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($album->title) }}&size=300&background=1a1a2e&color=fff'">
                <button class="card-play-btn" onclick="event.preventDefault();loadAndPlayAlbum({{ $album->id }})"><i class="fas fa-play"></i></button>
            </div>
            <div class="card-title">{{ $album->title }}</div>
            <div class="card-sub">{{ $album->release_date?->year }} • {{ ucfirst($album->type) }} • {{ $album->songs_count }} titres</div>
        </a>
        @endforeach
    </div>
</div>

@push('scripts')
<script>
const artistSongs = {!! $popularSongs->map(fn($s) => ['id'=>$s->id,'title'=>$s->title,'artist'=>$artist->name,'cover'=>$s->album->cover_url??'','duration'=>$s->duration,'audio_url'=>$s->audio_url])->toJson() !!};
function loadAndPlayArtist() { window.playQueue(artistSongs, 0); }
async function loadAndPlayAlbum(albumId) {
    const res = await fetch(`/api/albums/${albumId}/songs`);
    const songs = await res.json();
    if (!songs.length) return;
    window.playQueue(songs.map(s=>({id:s.id,title:s.title,artist:s.artist?.name||'',cover:s.album?.cover_url||'',duration:s.duration})),0);
}
</script>
@endpush
@endsection
