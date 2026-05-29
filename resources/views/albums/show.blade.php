@extends('layouts.app')
@section('title', $album->title)
@section('content')

{{-- Album Hero --}}
<div style="display:flex;gap:32px;align-items:flex-end;margin-bottom:32px;padding:40px;background:linear-gradient(135deg,#111827,#1e1b4b);border-radius:20px;position:relative;overflow:hidden">
    <div style="position:absolute;inset:0;background:radial-gradient(ellipse at 70% 50%,rgba(29,185,84,.12),transparent 70%)"></div>
    <img src="{{ $album->cover_url }}" alt="{{ $album->title }}"
         style="width:200px;height:200px;border-radius:12px;object-fit:cover;box-shadow:0 24px 60px rgba(0,0,0,.7);flex-shrink:0;position:relative"
         onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($album->title) }}&size=400&background=1a1a2e&color=fff'">
    <div style="flex:1">
        <div style="font-size:12px;font-weight:700;color:var(--text-faint);text-transform:uppercase;letter-spacing:1px;margin-bottom:8px">{{ ucfirst($album->type) }}</div>
        <h1 style="font-size:72px;font-weight:800;line-height:1;margin-bottom:24px;letter-spacing:-2px">{{ $album->title }}</h1>
        <div style="display:flex;align-items:center;gap:12px;font-size:15px;font-weight:600">
            <a href="{{ route('artists.show', $album->artist->slug) }}" style="display:flex;align-items:center;gap:8px;color:#fff">
                <img src="{{ $album->artist->image_url }}" style="width:24px;height:24px;border-radius:50%">
                {{ $album->artist->name }}
            </a>
            <span style="color:var(--text-faint)">•</span>
            <span style="color:var(--text-muted)">{{ $album->release_date?->year }}</span>
            <span style="color:var(--text-faint)">•</span>
            <span style="color:var(--text-muted)">{{ $album->songs_count }} {{ __('songs') }}</span>
        </div>
    </div>
</div>

{{-- Actions --}}
<div style="display:flex;align-items:center;gap:14px;margin-bottom:32px">
    <button id="playAlbumBtn" style="display:flex;align-items:center;gap:10px;background:var(--accent);color:#000;font-weight:700;padding:14px 32px;border-radius:30px;border:none;cursor:pointer;font-size:15px;font-family:inherit;transition:all .2s" onmouseover="this.style.transform='scale(1.04)'" onmouseout="this.style.transform='scale(1)'">
        <i class="fas fa-play"></i> Lire l'album
    </button>
    <button style="width:48px;height:48px;border-radius:50%;border:2px solid rgba(255,255,255,.2);background:none;color:var(--text-muted);cursor:pointer;font-size:18px"><i class="fas fa-heart"></i></button>
</div>

{{-- Track list --}}
<div style="background:var(--bg-card);backdrop-filter:var(--glass);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-top:32px">
    <div style="display:grid;grid-template-columns:40px 1fr 80px 140px;gap:12px;padding:12px 20px;border-bottom:1px solid var(--border);background:rgba(255,255,255,0.03)">
        <div style="font-size:12px;color:var(--text-faint);text-align:center">#</div>
        <div style="font-size:12px;color:var(--text-faint)">{{ __('Title') }}</div>
        <div style="font-size:12px;color:var(--text-faint);text-align:right">{{ __('Streams') }}</div>
        <div style="font-size:12px;color:var(--text-faint);text-align:right">{{ __('Actions') }}</div>
    </div>
    <div class="song-list">
        @foreach($album->songs as $song)
        <div class="song-row" data-id="{{ $song->id }}" style="grid-template-columns:40px 1fr 80px 140px"
             onclick="playSong({{ $song->id }},'{{ addslashes($song->title) }}','{{ addslashes($album->artist->name) }}','{{ $album->cover_url }}',{{ $song->duration }},albumQueue, '{{ $song->audio_url }}')">
            <div style="text-align:center">
                <span class="song-num">{{ $song->track_number }}</span>
                <i class="fas fa-play song-play-icon" style="font-size:13px"></i>
            </div>
            <div class="song-info">
                <div class="song-name">{{ $song->title }}</div>
                <div class="song-artist">{{ $album->artist->name }}@if($song->is_explicit) <span style="font-size:10px;background:rgba(255,255,255,.2);padding:1px 5px;border-radius:3px;margin-left:4px">E</span>@endif</div>
            </div>
            <div class="song-plays" style="text-align:right">{{ $song->formatted_play_count }}</div>
            <div style="display:flex;align-items:center;justify-content:flex-end;gap:16px">
                <button class="ctrl-btn" onclick="event.stopPropagation();toggleLike({{ $song->id }},this)" title="{{ __('Like') }}"><i class="far fa-heart"></i></button>
                <div class="song-duration">{{ $song->formatted_duration }}</div>
                <button class="ctrl-btn btn-more" onclick="event.stopPropagation();showPlaylistMenu(event,{{ $song->id }})" title="{{ __('More') }}"><i class="fas fa-ellipsis-h"></i></button>
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- Related Albums --}}
@if($relatedAlbums->count())
<div style="margin-top:40px">
    <div class="section-header"><h2 class="section-title">Plus de {{ $album->artist->name }}</h2></div>
    <div class="cards-grid">
        @foreach($relatedAlbums as $rel)
        <a href="{{ route('albums.show', $rel->slug) }}" class="card">
            <div class="card-img-wrap">
                <img src="{{ $rel->cover_url }}" alt="{{ $rel->title }}" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($rel->title) }}&size=300&background=1a1a2e&color=fff'">
            </div>
            <div class="card-title">{{ $rel->title }}</div>
            <div class="card-sub">{{ $rel->release_date?->year }}</div>
        </a>
        @endforeach
    </div>
</div>
@endif

@push('scripts')
<script>
const albumQueue = {!! $album->songs->map(fn($s)=>['id'=>$s->id,'title'=>$s->title,'artist'=>$album->artist->name,'cover'=>$album->cover_url,'duration'=>$s->duration,'audio_url'=>$s->audio_url])->toJson() !!};
document.getElementById('playAlbumBtn').addEventListener('click', () => window.playQueue(albumQueue, 0));
</script>
@endpush
@endsection
