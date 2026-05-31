@extends('layouts.app')
@section('title', __('All Songs'))
@section('content')

{{-- Header --}}
<div style="background:linear-gradient(135deg,rgba(124,77,255,0.1),rgba(83,109,254,0.1));backdrop-filter:var(--glass);border:1px solid var(--border);border-radius:24px;padding:40px;margin-bottom:32px">
    <div style="font-size:12px;font-weight:700;color:var(--accent);text-transform:uppercase;letter-spacing:2px;margin-bottom:8px">🎵 {{ __('Melodix Library') }}</div>
    <h1 style="font-size:42px;font-weight:800;letter-spacing:-1px;margin-bottom:12px">{{ __('All Songs') }}</h1>
    <p style="color:var(--text-muted);font-size:15px;max-width:600px;line-height:1.6">
        {{ __('Explore all tracks uploaded to Melodix. Click play to start, or add them to your playlists and favorites.') }}
    </p>
</div>

{{-- Songs Grid/List --}}
<div style="background:var(--bg-card);backdrop-filter:var(--glass);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden">
    <div style="display:grid;grid-template-columns:50px 1.5fr 1fr 1fr 100px;gap:12px;padding:16px 24px;border-bottom:1px solid var(--border);background:rgba(255,255,255,0.03)">
        <div style="font-size:12px;color:var(--text-faint);text-align:center;font-weight:700">#</div>
        <div style="font-size:12px;color:var(--text-faint);font-weight:700">{{ __('Title') }}</div>
        <div style="font-size:12px;color:var(--text-faint);font-weight:700">{{ __('Artist') }}</div>
        <div style="font-size:12px;color:var(--text-faint);font-weight:700">{{ __('Album') }}</div>
        <div style="font-size:12px;color:var(--text-faint);text-align:right;font-weight:700">{{ __('Actions') }}</div>
    </div>
    
    <div class="song-list">
        @forelse($songs as $i => $song)
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
                    <div class="song-name" style="font-weight:600;font-size:14px">{{ $song->title }}</div>
                </div>
            </div>
            
            <div style="color:var(--text-muted);font-size:13px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $song->artist->name }}</div>
            <div style="color:var(--text-muted);font-size:13px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $song->album->title }}</div>
            
            <div style="display:flex;align-items:center;justify-content:flex-end;gap:16px">
                <button class="ctrl-btn" onclick="event.stopPropagation();toggleLike({{ $song->id }},this)" title="{{ __('Like') }}">
                    <i class="far fa-heart" id="like-icon-{{ $song->id }}"></i>
                </button>
                <button class="ctrl-btn btn-more" onclick="event.stopPropagation();showPlaylistMenu(event,{{ $song->id }})" title="{{ __('More') }}">
                    <i class="fas fa-ellipsis-h"></i>
                </button>
                <div style="font-size:12px;color:var(--text-faint);width:40px;text-align:right">{{ $song->formatted_duration }}</div>
            </div>
        </div>
        
        @empty
        <div style="padding:60px 24px;text-align:center;color:var(--text-faint)">
            <i class="fas fa-music" style="font-size:48px;margin-bottom:16px;display:block"></i>
            <p>{{ __('No songs available on the platform yet.') }}</p>
        </div>
        @endforelse
    </div>
</div>

{{-- Pagination Links --}}
<div style="margin-top:24px;display:flex;justify-content:center">
    {{ $songs->links() }}
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Proactively check liked status for songs listed
    @foreach($songs as $song)
    fetch(`/api/songs/{{ $song->id }}/like`)
        .then(res => res.json())
        .then(data => {
            if (data.liked) {
                const el = document.getElementById('like-icon-{{ $song->id }}');
                if (el) {
                    el.className = 'fas fa-heart';
                    el.style.color = 'var(--accent)';
                }
            }
        }).catch(()=>{});
    @endforeach
});
</script>
@endpush

@endsection
