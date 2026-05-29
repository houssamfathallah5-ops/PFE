@extends('layouts.app')
@section('title', 'Playlists')
@section('content')
<h1 style="font-size:28px;font-weight:800;margin-bottom:24px">🎧 Playlists publiques</h1>
@if($playlists->count())
<div class="cards-grid">
    @foreach($playlists as $playlist)
    <a href="{{ route('playlists.show', $playlist->slug) }}" class="card">
        <div class="card-img-wrap" style="background:linear-gradient(135deg,#1db954,#191414);display:flex;align-items:center;justify-content:center;font-size:48px">
            {{ $playlist->cover_url ? '' : '🎵' }}
            @if($playlist->cover_url)<img src="{{ $playlist->cover_url }}" alt="{{ $playlist->name }}">@endif
        </div>
        <div class="card-title">{{ $playlist->name }}</div>
        <div class="card-sub">Par {{ $playlist->user->name }}</div>
    </a>
    @endforeach
</div>
<div style="margin-top:32px">{{ $playlists->links() }}</div>
@else
<div style="text-align:center;padding:80px;color:var(--text-muted)">
    <div style="font-size:48px;margin-bottom:16px">🎵</div>
    <div style="font-size:18px;font-weight:600">Aucune playlist pour l'instant</div>
</div>
@endif
@endsection
