@extends('layouts.admin')
@section('title','Artistes')
@section('page-title','Gestion des Artistes')
@section('content')
<div style="display:flex;justify-content:flex-end;margin-bottom:24px">
    <a href="{{ route('admin.artists.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Nouvel artiste</a>
</div>
<div class="table-card">
    <div class="table-header"><h3>{{ $artists->total() }} artistes</h3></div>
    <table>
        <thead><tr><th>Artiste</th><th>Genre</th><th>Pays</th><th>Auditeurs</th><th>Vérifié</th><th>Actions</th></tr></thead>
        <tbody>
            @foreach($artists as $artist)
            <tr>
                <td>
                    <div style="display:flex;align-items:center;gap:12px">
                        <img src="{{ $artist->image_url }}" style="width:42px;height:42px;border-radius:50%;object-fit:cover" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($artist->name) }}&size=84&background=1db954&color=000'">
                        <div>
                            <div style="font-weight:600">{{ $artist->name }}</div>
                            <div style="font-size:12px;color:var(--muted)">{{ $artist->albums_count }} albums • {{ $artist->songs_count }} titres</div>
                        </div>
                    </div>
                </td>
                <td style="color:var(--muted);font-size:13px">{{ $artist->genre }}</td>
                <td style="color:var(--muted);font-size:13px">{{ $artist->country }}</td>
                <td style="font-size:13px">{{ $artist->formatted_listeners }}</td>
                <td>
                    @if($artist->is_verified)<span class="badge badge-green"><i class="fas fa-check-circle"></i> Oui</span>
                    @else<span class="badge badge-gray">Non</span>@endif
                </td>
                <td>
                    <div style="display:flex;gap:6px">
                        <a href="{{ route('admin.artists.edit', $artist) }}" class="btn btn-sm btn-edit"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.artists.destroy', $artist) }}" method="POST" onsubmit="return confirm('Supprimer {{ $artist->name }} ?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div style="padding:20px 24px">{{ $artists->links() }}</div>
</div>
@endsection
