@extends('layouts.admin')
@section('title','Modifier Album')
@section('page-title','Modifier : '.$album->title)
@section('content')
<div style="max-width:900px">
    <div style="margin-bottom:20px"><a href="{{ route('admin.albums.index') }}" style="color:var(--muted);font-size:14px"><i class="fas fa-arrow-left"></i> Retour</a></div>
    <form action="{{ route('admin.albums.update', $album) }}" method="POST">
        @csrf @method('PUT')
        <div class="grid-2">
            <div class="form-card">
                <h3 style="font-size:16px;font-weight:700;margin-bottom:20px">Informations</h3>
                <div style="display:flex;flex-direction:column;gap:16px">
                    <div class="form-group"><label>Artiste *</label>
                        <select name="artist_id" required>
                            @foreach($artists as $a)<option value="{{ $a->id }}" {{ $album->artist_id==$a->id?'selected':'' }}>{{ $a->name }}</option>@endforeach
                        </select>
                    </div>
                    <div class="form-group"><label>Titre *</label><input type="text" name="title" required value="{{ old('title',$album->title) }}"></div>
                    <div class="form-group"><label>Type</label>
                        <select name="type">
                            <option value="album" {{ $album->type=='album'?'selected':'' }}>Album</option>
                            <option value="ep" {{ $album->type=='ep'?'selected':'' }}>EP</option>
                            <option value="single" {{ $album->type=='single'?'selected':'' }}>Single</option>
                        </select>
                    </div>
                    <div class="form-group"><label>Genre</label><input type="text" name="genre" value="{{ old('genre',$album->genre) }}"></div>
                    <div class="form-group"><label>Label</label><input type="text" name="label" value="{{ old('label',$album->label) }}"></div>
                    <div class="form-group"><label>Date de sortie</label><input type="date" name="release_date" value="{{ old('release_date',$album->release_date?->format('Y-m-d')) }}"></div>
                    <div class="form-group"><label>URL Couverture</label><input type="url" name="cover_url" value="{{ old('cover_url',$album->cover_url) }}" oninput="document.getElementById('coverPreview').src=this.value"></div>
                    <div style="display:flex;align-items:center;gap:10px">
                        <input type="hidden" name="is_published" value="0">
                        <input type="checkbox" name="is_published" value="1" id="pub" {{ $album->is_published?'checked':'' }} style="accent-color:var(--accent);width:16px;height:16px">
                        <label for="pub" style="cursor:pointer">Publié</label>
                    </div>
                </div>
            </div>
            <div class="form-card">
                <h3 style="font-size:16px;font-weight:700;margin-bottom:12px">Aperçu</h3>
                <img id="coverPreview" src="{{ $album->cover_url }}" style="width:100%;aspect-ratio:1;object-fit:cover;border-radius:12px;border:1px solid var(--border)">
                <div style="margin-top:16px">
                    <div style="font-size:13px;color:var(--muted)">{{ $album->songs->count() }} chansons dans cet album</div>
                </div>
            </div>
        </div>
        <div style="margin-top:24px;display:flex;gap:12px">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Enregistrer</button>
            <a href="{{ route('admin.albums.index') }}" class="btn" style="background:var(--elevated);color:var(--muted)">Annuler</a>
        </div>
    </form>
</div>
@endsection
