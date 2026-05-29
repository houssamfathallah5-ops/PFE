@extends('layouts.admin')
@section('title','Albums')
@section('page-title','Gestion des Albums')
@section('content')
<div style="display:flex;justify-content:flex-end;margin-bottom:24px">
    <a href="{{ route('admin.albums.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Nouvel album</a>
</div>
<div class="table-card">
    <div class="table-header"><h3>{{ $albums->total() }} albums</h3></div>
    <table>
        <thead><tr><th>Album</th><th>Artiste</th><th>Type</th><th>Titres</th><th>Streams</th><th>Publié</th><th>Actions</th></tr></thead>
        <tbody>
            @foreach($albums as $album)
            <tr>
                <td>
                    <div style="display:flex;align-items:center;gap:10px">
                        <img src="{{ $album->cover_url }}" style="width:42px;height:42px;border-radius:8px;object-fit:cover" onerror="this.style.display='none'">
                        <div>
                            <div style="font-weight:600;font-size:13px">{{ $album->title }}</div>
                            <div style="font-size:11px;color:var(--muted)">{{ $album->release_date?->year }}</div>
                        </div>
                    </div>
                </td>
                <td style="font-size:13px;color:var(--muted)">{{ $album->artist->name }}</td>
                <td><span class="badge badge-gray">{{ ucfirst($album->type) }}</span></td>
                <td style="font-size:13px;color:var(--muted)">{{ $album->songs_count }}</td>
                <td style="font-size:13px">{{ $album->formatted_streams }}</td>
                <td>@if($album->is_published)<span class="badge badge-green">Publié</span>@else<span class="badge badge-gray">Masqué</span>@endif</td>
                <td>
                    <div style="display:flex;gap:6px">
                        <a href="{{ route('admin.albums.edit', $album) }}" class="btn btn-sm btn-edit"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.albums.destroy', $album) }}" method="POST" onsubmit="return confirm('Supprimer cet album ?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div style="padding:20px 24px">{{ $albums->links() }}</div>
</div>
@endsection
