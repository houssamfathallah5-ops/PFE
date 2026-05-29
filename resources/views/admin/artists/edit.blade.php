@extends('layouts.admin')
@section('title','Modifier '.$artist->name)
@section('page-title','Modifier : '.$artist->name)
@section('content')
<div style="max-width:900px">
    <div style="margin-bottom:20px"><a href="{{ route('admin.artists.index') }}" style="color:var(--muted);font-size:14px"><i class="fas fa-arrow-left"></i> Retour</a></div>
    <form action="{{ route('admin.artists.update', $artist) }}" method="POST">
        @csrf @method('PUT')
        <div class="grid-2">
            <div class="form-card">
                <h3 style="font-size:16px;font-weight:700;margin-bottom:24px">Informations</h3>
                <div style="display:flex;flex-direction:column;gap:16px">
                    <div class="form-group"><label>Nom *</label><input type="text" name="name" required value="{{ old('name',$artist->name) }}"></div>
                    <div class="form-group"><label>Genre</label><input type="text" name="genre" value="{{ old('genre',$artist->genre) }}"></div>
                    <div class="form-group"><label>Pays</label><input type="text" name="country" value="{{ old('country',$artist->country) }}"></div>
                    <div class="form-group"><label>Biographie</label><textarea name="bio" rows="4">{{ old('bio',$artist->bio) }}</textarea></div>
                    <div class="form-group"><label>Auditeurs mensuels</label><input type="number" name="monthly_listeners" min="0" value="{{ old('monthly_listeners',$artist->monthly_listeners) }}"></div>
                    <div style="display:flex;align-items:center;gap:10px">
                        <input type="hidden" name="is_verified" value="0">
                        <input type="checkbox" name="is_verified" value="1" id="verified" {{ old('is_verified',$artist->is_verified) ? 'checked' : '' }} style="width:16px;height:16px;accent-color:var(--accent)">
                        <label for="verified" style="cursor:pointer">Artiste vérifié</label>
                    </div>
                </div>
            </div>
            <div>
                <div class="form-card" style="margin-bottom:20px">
                    <h3 style="font-size:16px;font-weight:700;margin-bottom:16px">Photo de profil</h3>
                    <div class="form-group"><label>URL de l'image</label><input type="url" name="image_url" id="imageUrlInput" value="{{ old('image_url',$artist->image_url) }}" oninput="previewImg()"></div>
                    <div style="margin-top:12px"><img id="imgPreview" class="img-preview" src="{{ $artist->image_url }}" onerror="this.style.opacity='.3'"></div>
                </div>
                <div class="form-card">
                    <h3 style="font-size:16px;font-weight:700;margin-bottom:16px">Couverture</h3>
                    <div class="form-group"><label>URL couverture</label><input type="url" name="cover_url" value="{{ old('cover_url',$artist->cover_url) }}"></div>
                </div>
            </div>
        </div>
        <div style="margin-top:24px;display:flex;gap:12px">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Enregistrer</button>
            <a href="{{ route('admin.artists.index') }}" class="btn" style="background:var(--elevated);color:var(--muted)">Annuler</a>
        </div>
    </form>
</div>
@push('scripts')
<script>
function previewImg() {
    const url = document.getElementById('imageUrlInput').value;
    document.getElementById('imgPreview').src = url;
}
</script>
@endpush
@endsection
