@extends('layouts.admin')
@section('title','Nouvel Album')
@section('page-title','Créer un album')
@section('content')
<div style="max-width:900px">
    <div style="margin-bottom:20px"><a href="{{ route('admin.albums.index') }}" style="color:var(--muted);font-size:14px"><i class="fas fa-arrow-left"></i> Retour</a></div>
    <form action="{{ route('admin.albums.store') }}" method="POST" id="albumForm">
        @csrf
        <div class="grid-2">
            <div class="form-card">
                <h3 style="font-size:16px;font-weight:700;margin-bottom:20px">Informations de l'album</h3>
                <div style="display:flex;flex-direction:column;gap:16px">
                    <div class="form-group"><label>Artiste *</label>
                        <select name="artist_id" required>
                            <option value="">Sélectionner...</option>
                            @foreach($artists as $a)<option value="{{ $a->id }}" {{ old('artist_id')==$a->id?'selected':'' }}>{{ $a->name }}</option>@endforeach
                        </select>
                    </div>
                    <div class="form-group"><label>Titre *</label><input type="text" name="title" required value="{{ old('title') }}" placeholder="Titre de l'album"></div>
                    <div class="form-group"><label>Type</label>
                        <select name="type">
                            <option value="album" {{ old('type')=='album'?'selected':'' }}>Album</option>
                            <option value="ep" {{ old('type')=='ep'?'selected':'' }}>EP</option>
                            <option value="single" {{ old('type')=='single'?'selected':'' }}>Single</option>
                        </select>
                    </div>
                    <div class="form-group"><label>Genre</label><input type="text" name="genre" value="{{ old('genre') }}" placeholder="Ex: R&B, Pop"></div>
                    <div class="form-group"><label>Label</label><input type="text" name="label" value="{{ old('label') }}" placeholder="Ex: Republic Records"></div>
                    <div class="form-group"><label>Date de sortie</label><input type="date" name="release_date" value="{{ old('release_date') }}"></div>
                    <div class="form-group"><label>URL Couverture</label><input type="url" name="cover_url" id="coverInput" value="{{ old('cover_url') }}" placeholder="https://..." oninput="document.getElementById('coverPreview').src=this.value"></div>
                    <div style="display:flex;align-items:center;gap:10px">
                        <input type="hidden" name="is_published" value="0">
                        <input type="checkbox" name="is_published" value="1" id="published" checked style="accent-color:var(--accent);width:16px;height:16px">
                        <label for="published" style="cursor:pointer">Publié</label>
                    </div>
                </div>
            </div>
            <div>
                <div class="form-card" style="margin-bottom:20px">
                    <h3 style="font-size:16px;font-weight:700;margin-bottom:12px">Aperçu couverture</h3>
                    <img id="coverPreview" src="{{ old('cover_url','') }}" class="img-preview" onerror="this.style.opacity='.2'" style="width:100%;aspect-ratio:1;object-fit:cover;border-radius:12px;border:1px solid var(--border)">
                </div>
            </div>
        </div>

        {{-- Songs --}}
        <div class="form-card" style="margin-top:24px">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px">
                <h3 style="font-size:16px;font-weight:700">🎵 Chansons de l'album</h3>
                <button type="button" onclick="addSong()" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Ajouter une chanson</button>
            </div>
            <div id="songsContainer">
                <div class="song-form-row" style="display:grid;grid-template-columns:50px 1fr 120px;gap:12px;align-items:end;padding:12px;background:var(--elevated);border-radius:8px;margin-bottom:8px">
                    <div class="form-group"><label>#</label><input type="number" name="songs[0][track_number]" value="1" min="1" readonly style="text-align:center"></div>
                    <div class="form-group"><label>Titre *</label><input type="text" name="songs[0][title]" required placeholder="Titre de la chanson"></div>
                    <div class="form-group"><label>Durée (sec)</label><input type="number" name="songs[0][duration]" required min="1" placeholder="Ex: 210"></div>
                </div>
            </div>
        </div>

        <div style="margin-top:24px;display:flex;gap:12px">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Créer l'album</button>
            <a href="{{ route('admin.albums.index') }}" class="btn" style="background:var(--elevated);color:var(--muted)">Annuler</a>
        </div>
    </form>
</div>
@push('scripts')
<script>
let songCount = 1;
function addSong() {
    const c = document.getElementById('songsContainer');
    const div = document.createElement('div');
    div.className = 'song-form-row';
    div.style.cssText = 'display:grid;grid-template-columns:50px 1fr 120px 40px;gap:12px;align-items:end;padding:12px;background:var(--elevated);border-radius:8px;margin-bottom:8px';
    div.innerHTML = `
        <div class="form-group"><label>#</label><input type="number" name="songs[${songCount}][track_number]" value="${songCount+1}" min="1" style="text-align:center"></div>
        <div class="form-group"><label>Titre *</label><input type="text" name="songs[${songCount}][title]" required placeholder="Titre"></div>
        <div class="form-group"><label>Durée (sec)</label><input type="number" name="songs[${songCount}][duration]" required min="1" placeholder="Ex: 210"></div>
        <div class="form-group"><label>&nbsp;</label><button type="button" onclick="this.closest('.song-form-row').remove()" style="width:36px;height:38px;background:rgba(239,68,68,.15);color:#ef4444;border:none;border-radius:6px;cursor:pointer;font-size:14px"><i class="fas fa-times"></i></button></div>
    `;
    c.appendChild(div);
    songCount++;
}
</script>
@endpush
@endsection
