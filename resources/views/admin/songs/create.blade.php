@extends('layouts.admin')
@section('title','Nouvelle Chanson')
@section('page-title','Créer une chanson')
@section('content')
<div style="max-width:700px">
    <div style="margin-bottom:20px"><a href="{{ route('admin.songs.index') }}" style="color:var(--muted);font-size:14px"><i class="fas fa-arrow-left"></i> Retour</a></div>
    <div class="form-card">
        <form action="{{ route('admin.songs.store') }}" method="POST">
            @csrf
            <div style="display:flex;flex-direction:column;gap:16px">
                <div class="form-group"><label>Artiste *</label>
                    <select name="artist_id" required>
                        <option value="">Sélectionner...</option>
                        @foreach($artists as $a)<option value="{{ $a->id }}">{{ $a->name }}</option>@endforeach
                    </select>
                </div>
                <div class="form-group"><label>Album *</label>
                    <select name="album_id" required>
                        <option value="">Sélectionner...</option>
                        @foreach($albums as $al)<option value="{{ $al->id }}">{{ $al->artist->name }} — {{ $al->title }}</option>@endforeach
                    </select>
                </div>
                <div class="form-group"><label>Titre *</label><input type="text" name="title" required placeholder="Titre de la chanson"></div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
                    <div class="form-group"><label>Numéro de piste</label><input type="number" name="track_number" min="1" value="1"></div>
                    <div class="form-group"><label>Durée (en secondes) *</label><input type="number" name="duration" required min="1" placeholder="Ex: 210"></div>
                </div>
                <div class="form-group"><label>Genre</label><input type="text" name="genre" placeholder="Ex: Pop"></div>
                <div style="display:flex;gap:20px">
                    <div style="display:flex;align-items:center;gap:8px">
                        <input type="hidden" name="is_explicit" value="0">
                        <input type="checkbox" name="is_explicit" value="1" id="explicit" style="accent-color:var(--accent);width:16px;height:16px">
                        <label for="explicit" style="cursor:pointer;font-size:13px">Contenu explicite</label>
                    </div>
                    <div style="display:flex;align-items:center;gap:8px">
                        <input type="hidden" name="is_published" value="0">
                        <input type="checkbox" name="is_published" value="1" id="pub" checked style="accent-color:var(--accent);width:16px;height:16px">
                        <label for="pub" style="cursor:pointer;font-size:13px">Publié</label>
                    </div>
                </div>
                <div style="display:flex;gap:12px;margin-top:8px">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Créer</button>
                    <a href="{{ route('admin.songs.index') }}" class="btn" style="background:var(--elevated);color:var(--muted)">Annuler</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
