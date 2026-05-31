@extends('layouts.app')
@section('title', __('Liked Songs'))
@section('content')

{{-- Header --}}
<div style="background:linear-gradient(135deg,rgba(255,82,82,0.15),rgba(255,23,68,0.05));backdrop-filter:var(--glass);border:1px solid var(--border);border-radius:24px;padding:48px;margin-bottom:32px;display:flex;align-items:center;gap:24px">
    <div style="width:120px;height:120px;background:linear-gradient(135deg, #ff5252, #ff1744);border-radius:20px;display:flex;align-items:center;justify-content:center;font-size:48px;box-shadow:0 12px 24px rgba(255,23,68,0.3)">
        <i class="fas fa-heart" style="color:#fff"></i>
    </div>
    <div>
        <div style="font-size:12px;font-weight:700;color:#ff5252;text-transform:uppercase;letter-spacing:2px;margin-bottom:8px">{{ __('Playlist') }}</div>
        <h1 style="font-size:42px;font-weight:800;letter-spacing:-1px;margin-bottom:12px">{{ __('Liked Songs') }}</h1>
        <p style="color:var(--text-muted);font-size:15px">
            {{ Auth::user()->name }} • {{ $songs->total() }} {{ __('songs') }}
        </p>
    </div>
</div>

{{-- Songs List --}}
<div style="background:var(--bg-card);backdrop-filter:var(--glass);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden">
    @if($songs->count())
    <div style="display:grid;grid-template-columns:50px 1.5fr 1fr 1fr 100px;gap:12px;padding:16px 24px;border-bottom:1px solid var(--border);background:rgba(255,255,255,0.03)">
        <div style="font-size:12px;color:var(--text-faint);text-align:center;font-weight:700">#</div>
        <div style="font-size:12px;color:var(--text-faint);font-weight:700">{{ __('Title') }}</div>
        <div style="font-size:12px;color:var(--text-faint);font-weight:700">{{ __('Artist') }}</div>
        <div style="font-size:12px;color:var(--text-faint);font-weight:700">{{ __('Album') }}</div>
        <div style="font-size:12px;color:var(--text-faint);text-align:right;font-weight:700">{{ __('Actions') }}</div>
    </div>
    
    <div class="song-list">
        @foreach($songs as $i => $song)
        <div class="song-row" data-id="{{ $song->id }}" 
             style="display:grid;grid-template-columns:50px 1.5fr 1fr 1fr 100px;gap:12px;padding:14px 24px;align-items:center"
             onclick="playSong({{ $song->id }},'{{ addslashes($song->title) }}','{{ addslashes($song->artist->name) }}','{{ $song->album->cover_url ?? '' }}',{{ $song->duration }}, null, '{{ $song->audio_url }}')">
            <div style="text-align:center;position:relative">
                <span class="song-num">{{ ($songs->currentPage() - 1) * $songs->perPage() + $i + 1 }}</span>
                <i class="fas fa-play song-play-icon" style="font-size:13px;margin:0 auto"></i>
            </div>
            
            <div style="display:flex;align-items:center;gap:12px;overflow:hidden">
                <img src="{{ $song->album->cover_url ?? '' }}" alt="{{ $song->title }}" 
                     onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($song->title) }}&size=100&background=1a1a2e&color=fff'"
                     style="width:40px;height:40px;border-radius:6px;object-fit:cover;box-shadow:0 4px 8px rgba(0,0,0,0.3)">
                <div style="overflow:hidden">
                    <div class="song-name" style="font-weight:600;font-size:14px;color:var(--accent)">{{ $song->title }}</div>
                </div>
            </div>
            
            <div style="color:var(--text-muted);font-size:13px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $song->artist->name }}</div>
            <div style="color:var(--text-muted);font-size:13px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $song->album->title }}</div>
            
            <div style="display:flex;align-items:center;justify-content:flex-end;gap:16px">
                <button class="ctrl-btn" onclick="event.stopPropagation();toggleLike({{ $song->id }},this)" title="{{ __('Like') }}">
                    <i class="fas fa-heart" style="color:var(--accent)"></i>
                </button>
                <button class="ctrl-btn btn-more" onclick="event.stopPropagation();showPlaylistMenu(event,{{ $song->id }})" title="{{ __('More') }}">
                    <i class="fas fa-ellipsis-h"></i>
                </button>
                <div style="font-size:12px;color:var(--text-faint);width:40px;text-align:right">{{ $song->formatted_duration }}</div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div style="padding:80px 24px;text-align:center;color:var(--text-faint)">
        <i class="fas fa-heart" style="font-size:48px;color:#ff5252;margin-bottom:16px;display:block;opacity:0.3"></i>
        <p style="font-size:16px;margin-bottom:20px">{{ __('You haven\'t liked any songs yet.') }}</p>
        <a href="{{ route('songs.index') }}" style="display:inline-block;background:var(--accent);color:#000;font-weight:700;padding:12px 28px;border-radius:30px;font-size:14px;transition:all 0.2s">
            {{ __('Find songs to like') }}
        </a>
    </div>
    @endif
</div>

{{-- Pagination Links --}}
<div style="margin-top:24px;display:flex;justify-content:center">
    {{ $songs->links() }}
</div>

@endsection
