@extends('layouts.app')
@section('title', 'Artistes')
@section('content')
<div class="section-header"><h1 class="section-title">🎤 Tous les artistes</h1></div>
<div class="cards-grid" style="grid-template-columns:repeat(auto-fill,minmax(180px,1fr))">
    @foreach($artists as $artist)
    <a href="{{ route('artists.show', $artist->slug) }}" class="card artist-card" style="text-align:center">
        <div class="card-img-wrap">
            <img src="{{ $artist->image_url }}" alt="{{ $artist->name }}" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($artist->name) }}&size=300&background=1db954&color=000&bold=true'">
        </div>
        <div class="card-title">{{ $artist->name }}</div>
        <div class="card-sub">{{ $artist->genre }}</div>
        <div class="card-sub" style="margin-top:4px">{{ $artist->formatted_listeners }} auditeurs</div>
        @if($artist->is_verified)<div style="margin-top:6px"><span class="badge"><i class="fas fa-check-circle"></i> Vérifié</span></div>@endif
    </a>
    @endforeach
</div>
<div style="margin-top:32px">{{ $artists->links() }}</div>
@endsection
