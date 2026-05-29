@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Tableau de bord')
@section('content')

{{-- Stats --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(29,185,84,.15);color:var(--accent)"><i class="fas fa-microphone"></i></div>
        <div class="stat-val">{{ number_format($stats['artists']) }}</div>
        <div class="stat-label">Artistes</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(99,102,241,.15);color:#818cf8"><i class="fas fa-compact-disc"></i></div>
        <div class="stat-val">{{ number_format($stats['albums']) }}</div>
        <div class="stat-label">Albums</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(245,158,11,.15);color:#fbbf24"><i class="fas fa-music"></i></div>
        <div class="stat-val">{{ number_format($stats['songs']) }}</div>
        <div class="stat-label">Chansons</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(239,68,68,.15);color:#f87171"><i class="fas fa-play-circle"></i></div>
        <div class="stat-val">{{ $stats['total_streams'] >= 1_000_000_000 ? round($stats['total_streams']/1_000_000_000,1).'B' : round($stats['total_streams']/1_000_000,1).'M' }}</div>
        <div class="stat-label">Total Streams</div>
    </div>
</div>

<div class="grid-2" style="margin-bottom:32px">
    {{-- Chart --}}
    <div class="table-card">
        <div class="table-header"><h3>📊 Streams par genre</h3></div>
        <div style="padding:24px"><canvas id="genreChart" height="220"></canvas></div>
    </div>
    {{-- Top Artists --}}
    <div class="table-card">
        <div class="table-header">
            <h3>⭐ Top Artistes</h3>
            <a href="{{ route('admin.artists.index') }}" class="btn btn-sm" style="background:var(--elevated);color:var(--muted)">Voir tout</a>
        </div>
        <table>
            <thead><tr><th>Artiste</th><th>Auditeurs</th><th>Streams</th></tr></thead>
            <tbody>
                @foreach($stats['top_artists'] as $artist)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px">
                            <img src="{{ $artist->image_url }}" style="width:36px;height:36px;border-radius:50%;object-fit:cover" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($artist->name) }}&size=72&background=1db954&color=000'">
                            <div>
                                <div style="font-weight:600;font-size:13px">{{ $artist->name }}</div>
                                <div style="font-size:11px;color:var(--muted)">{{ $artist->genre }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="color:var(--muted);font-size:13px">{{ $artist->formatted_listeners }}</td>
                    <td><span class="badge badge-green">{{ $artist->formatted_listeners }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="grid-2">
    {{-- Top Songs --}}
    <div class="table-card">
        <div class="table-header"><h3>🔥 Chansons les plus écoutées</h3></div>
        <table>
            <thead><tr><th>#</th><th>Chanson</th><th>Écoutes</th></tr></thead>
            <tbody>
                @foreach($stats['top_songs'] as $i => $song)
                <tr>
                    <td style="color:var(--faint);font-size:13px">{{ $i+1 }}</td>
                    <td>
                        <div style="font-weight:600;font-size:13px">{{ $song->title }}</div>
                        <div style="font-size:11px;color:var(--muted)">{{ $song->artist->name }}</div>
                    </td>
                    <td style="font-size:13px;color:var(--muted)">{{ $song->formatted_play_count }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{-- Recent Albums --}}
    <div class="table-card">
        <div class="table-header"><h3>💿 Albums récents</h3></div>
        <table>
            <thead><tr><th>Album</th><th>Artiste</th><th>Date</th></tr></thead>
            <tbody>
                @foreach($stats['recent_albums'] as $album)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px">
                            <img src="{{ $album->cover_url }}" style="width:36px;height:36px;border-radius:6px;object-fit:cover" onerror="this.style.display='none'">
                            <span style="font-weight:600;font-size:13px">{{ $album->title }}</span>
                        </div>
                    </td>
                    <td style="font-size:13px;color:var(--muted)">{{ $album->artist->name }}</td>
                    <td style="font-size:13px;color:var(--muted)">{{ $album->release_date?->format('d/m/Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
const genreData = @json($stats['streams_by_genre']);
new Chart(document.getElementById('genreChart'), {
    type: 'doughnut',
    data: {
        labels: genreData.map(d => d.genre || 'Autre'),
        datasets: [{
            data: genreData.map(d => d.total),
            backgroundColor: ['#1db954','#818cf8','#fbbf24','#f87171','#34d399','#60a5fa'],
            borderWidth: 0,
            hoverOffset: 8
        }]
    },
    options: {
        responsive: true, maintainAspectRatio: false,
        plugins: {
            legend: { position: 'right', labels: { color: '#a0a0b0', padding: 16, font: { size: 12 } } },
            tooltip: { callbacks: { label: c => ` ${(c.parsed/1e9).toFixed(1)}B streams` } }
        },
        cutout: '65%'
    }
});
</script>
@endpush
@endsection
