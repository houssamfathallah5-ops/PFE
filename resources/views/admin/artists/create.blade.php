@extends('layouts.admin')
@section('title','Nouvel Artiste')
@section('page-title','Créer un artiste')
@section('content')
<div style="max-width:900px">
    <div style="margin-bottom:20px"><a href="{{ route('admin.artists.index') }}" style="color:var(--muted);font-size:14px"><i class="fas fa-arrow-left"></i> Retour</a></div>
    <form action="{{ route('admin.artists.store') }}" method="POST">
        @csrf
        <div class="grid-2">
            <div class="form-card">
                <h3 style="font-size:16px;font-weight:700;margin-bottom:24px">Informations</h3>
                <div style="display:flex;flex-direction:column;gap:16px">
                    <div class="form-group">
                        <label>Nom *</label>
                        <input type="text" name="name" required placeholder="Ex: Dua Lipa" value="{{ old('name') }}">
                    </div>
                    <div class="form-group">
                        <label>Genre musical</label>
                        <input type="text" name="genre" placeholder="Ex: Pop, Hip-Hop, R&B" value="{{ old('genre') }}">
                    </div>
                    <div class="form-group">
                        <label>Pays</label>
                        <input type="text" name="country" placeholder="Ex: France" value="{{ old('country') }}">
                    </div>
                    <div class="form-group">
                        <label>Biographie</label>
                        <textarea name="bio" rows="4" placeholder="Décrivez l'artiste...">{{ old('bio') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Auditeurs mensuels</label>
                        <input type="number" name="monthly_listeners" min="0" placeholder="Ex: 5000000" value="{{ old('monthly_listeners',0) }}">
                    </div>
                    <div style="display:flex;align-items:center;gap:10px">
                        <input type="hidden" name="is_verified" value="0">
                        <input type="checkbox" name="is_verified" value="1" id="verified" {{ old('is_verified') ? 'checked' : '' }} style="width:16px;height:16px;accent-color:var(--accent)">
                        <label for="verified" style="cursor:pointer">Artiste vérifié</label>
                    </div>
                </div>
            </div>
            <div>
                <div class="form-card" style="margin-bottom:20px">
                    <h3 style="font-size:16px;font-weight:700;margin-bottom:16px">Photo de profil</h3>
                    <div class="form-group">
                        <label>URL de l'image</label>
                        <input type="url" name="image_url" id="imageUrlInput" placeholder="https://..." value="{{ old('image_url') }}" oninput="previewImg('imageUrlInput','imgPreview')">
                    </div>
                    <div style="margin-top:12px">
                        @if(old('image_url'))
                        <img id="imgPreview" class="img-preview" src="{{ old('image_url') }}" onerror="this.style.display='none'">
                        @else
                        <div id="imgPreview" class="img-preview"><i class="fas fa-user"></i></div>
                        @endif
                    </div>
                </div>
                <div class="form-card">
                    <h3 style="font-size:16px;font-weight:700;margin-bottom:16px">Image de couverture</h3>
                    <div class="form-group">
                        <label>URL de la couverture</label>
                        <input type="url" name="cover_url" placeholder="https://...">
                    </div>
                </div>
            </div>
        </div>
        <div style="margin-top:24px;display:flex;gap:12px">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Créer l'artiste</button>
            <a href="{{ route('admin.artists.index') }}" class="btn" style="background:var(--elevated);color:var(--muted)">Annuler</a>
        </div>
    </form>
</div>
@push('scripts')
<script>
function previewImg(inputId, previewId) {
    const url = document.getElementById(inputId).value;
    const prev = document.getElementById(previewId);
    if (url) {
        prev.outerHTML = `<img id="${previewId}" class="img-preview" src="${url}" onerror="this.style.opacity='.3'" style="margin-top:12px">`;
    }
}
</script>
@endpush
@endsection
