@extends('layouts.admin')
@section('title','Modifier Chanson')
@section('page-title','Modifier : '.$song->title)
@section('content')
<div style="max-width:700px">
    <div style="margin-bottom:20px"><a href="{{ route('admin.songs.index') }}" style="color:var(--muted);font-size:14px"><i class="fas fa-arrow-left"></i> Retour</a></div>
    <div class="form-card">
        <form action="{{ route('admin.songs.update', $song) }}" method="POST">
            @csrf @method('PUT')
            <div style="display:flex;flex-direction:column;gap:16px">
                <div class="form-group"><label>Titre *</label><input type="text" name="title" required value="{{ old('title',$song->title) }}"></div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
                    <div class="form-group"><label>Numéro de piste</label><input type="number" name="track_number" min="1" value="{{ old('track_number',$song->track_number) }}"></div>
                    <div class="form-group"><label>Durée (secondes) *</label><input type="number" name="duration" required min="1" value="{{ old('duration',$song->duration) }}"></div>
                </div>
                <div class="form-group"><label>Genre</label><input type="text" name="genre" value="{{ old('genre',$song->genre) }}"></div>
                <div style="background:var(--elevated);border-radius:8px;padding:16px">
                    <div style="font-size:12px;color:var(--muted);margin-bottom:8px">Statistiques</div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                        <div><div style="font-size:11px;color:var(--faint)">Écoutes</div><div style="font-weight:700;font-size:18px">{{ $song->formatted_play_count }}</div></div>
                        <div><div style="font-size:11px;color:var(--faint)">Likes</div><div style="font-weight:700;font-size:18px">{{ number_format($song->like_count) }}</div></div>
                    </div>
                </div>
                <div style="display:flex;gap:20px">
                    <div style="display:flex;align-items:center;gap:8px">
                        <input type="hidden" name="is_explicit" value="0">
                        <input type="checkbox" name="is_explicit" value="1" id="explicit" {{ $song->is_explicit?'checked':'' }} style="accent-color:var(--accent);width:16px;height:16px">
                        <label for="explicit" style="cursor:pointer;font-size:13px">Contenu explicite</label>
                    </div>
                    <div style="display:flex;align-items:center;gap:8px">
                        <input type="hidden" name="is_published" value="0">
                        <input type="checkbox" name="is_published" value="1" id="pub" {{ $song->is_published?'checked':'' }} style="accent-color:var(--accent);width:16px;height:16px">
                        <label for="pub" style="cursor:pointer;font-size:13px">Publié</label>
                    </div>
                </div>
                <div style="display:flex;gap:12px;margin-top:8px">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Enregistrer</button>
                    <a href="{{ route('admin.songs.index') }}" class="btn" style="background:var(--elevated);color:var(--muted)">Annuler</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
