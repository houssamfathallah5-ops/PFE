@extends('layouts.admin')
@section('title','Chansons')
@section('page-title','Gestion des Chansons')
@section('content')
<div style="display:flex;justify-content:flex-end;margin-bottom:24px">
    <a href="{{ route('admin.songs.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Nouvelle chanson</a>
</div>
<div class="table-card">
    <div class="table-header"><h3>{{ $songs->total() }} chansons</h3></div>
    <table>
        <thead><tr><th>#</th><th>Chanson</th><th>Artiste</th><th>Album</th><th>Durée</th><th>Écoutes</th><th>Actions</th></tr></thead>
        <tbody>
            @foreach($songs as $song)
            <tr>
                <td style="color:var(--faint);font-size:13px">{{ $song->track_number }}</td>
                <td>
                    <div style="font-weight:600;font-size:13px">{{ $song->title }}</div>
                    @if($song->is_explicit)<span style="font-size:10px;background:rgba(255,255,255,.1);padding:1px 5px;border-radius:3px">E</span>@endif
                </td>
                <td style="font-size:13px;color:var(--muted)">{{ $song->artist->name }}</td>
                <td style="font-size:13px;color:var(--muted)">{{ $song->album->title }}</td>
                <td style="font-size:13px;color:var(--muted)">{{ $song->formatted_duration }}</td>
                <td style="font-size:13px">{{ $song->formatted_play_count }}</td>
                <td>
                    <div style="display:flex;gap:6px">
                        <a href="{{ route('admin.songs.edit', $song) }}" class="btn btn-sm btn-edit"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.songs.destroy', $song) }}" method="POST" onsubmit="return confirm('Supprimer cette chanson ?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div style="padding:20px 24px">{{ $songs->links() }}</div>
</div>
@endsection
