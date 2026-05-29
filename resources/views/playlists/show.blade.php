@extends('layouts.app')
@section('title', $playlist->name)
@section('content')
<div style="display:flex;gap:32px;align-items:flex-end;margin-bottom:32px;padding:40px;background:linear-gradient(135deg,#1a1a2e,#1db954);border-radius:20px">
    <div style="width:180px;height:180px;border-radius:12px;background:linear-gradient(135deg,#1db954,#191414);display:flex;align-items:center;justify-content:center;font-size:72px;flex-shrink:0;box-shadow:0 24px 60px rgba(0,0,0,.5)">🎵</div>
    <div>
        <div style="font-size:12px;text-transform:uppercase;letter-spacing:1px;color:rgba(255,255,255,.7);margin-bottom:8px">Playlist</div>
        <h1 style="font-size:40px;font-weight:800;margin-bottom:8px">{{ $playlist->name }}</h1>
        @if($playlist->description)<p style="color:rgba(255,255,255,.7);font-size:14px;margin-bottom:8px">{{ $playlist->description }}</p>@endif
        <div style="color:rgba(255,255,255,.7);font-size:13px">{{ $playlist->user->name }} • {{ $playlist->songs->count() }} titres</div>
    </div>
</div>

@if($playlist->songs->count())
<button onclick="window.playQueue(playlistQueue,0)" style="display:flex;align-items:center;gap:10px;background:var(--accent);color:#000;font-weight:700;padding:14px 32px;border-radius:30px;border:none;cursor:pointer;font-size:15px;margin-bottom:28px">
    <i class="fas fa-play"></i> Lecture
</button>
<div style="background:var(--bg-card);backdrop-filter:var(--glass);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-top:24px">
    <div style="display:grid;grid-template-columns:40px 1fr 120px 140px;gap:12px;padding:12px 20px;border-bottom:1px solid var(--border);background:rgba(255,255,255,0.03)">
        <div style="font-size:12px;color:var(--text-faint);text-align:center">#</div>
        <div style="font-size:12px;color:var(--text-faint)">{{ __('Title') }}</div>
        <div style="font-size:12px;color:var(--text-faint)">{{ __('Album') }}</div>
        <div style="font-size:12px;color:var(--text-faint);text-align:right">{{ __('Actions') }}</div>
    </div>
    <div class="song-list">
        @foreach($playlist->songs as $i => $song)
        <div class="song-row" data-id="{{ $song->id }}"
             onclick="playSong({{ $song->id }},'{{ addslashes($song->title) }}','{{ addslashes($song->artist->name) }}','{{ $song->album->cover_url ?? '' }}',{{ $song->duration }},playlistQueue, '{{ $song->audio_url }}')">
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
@else
<div style="text-align:center;padding:60px;color:var(--text-muted)">Cette playlist est vide.</div>
@endif

@push('scripts')
<script>
const playlistQueue = {!! $playlist->songs->map(fn($s)=>['id'=>$s->id,'title'=>$s->title,'artist'=>$s->artist->name,'cover'=>$s->album->cover_url??'','duration'=>$s->duration,'audio_url'=>$s->audio_url])->toJson() !!};
</script>
@endpush
@endsection
