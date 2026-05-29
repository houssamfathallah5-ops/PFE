<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — Melodix Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        :root{--bg:#0a0a0f;--surface:#111118;--elevated:#1a1a24;--card:#1e1e2a;--accent:#1db954;--accent-hover:#1ed760;--text:#fff;--muted:#a0a0b0;--faint:#606070;--border:rgba(255,255,255,.06);--r:12px;--sidebar:260px}
        body{font-family:'Inter',sans-serif;background:var(--bg);color:var(--text);display:flex;min-height:100vh}
        a{color:inherit;text-decoration:none}
        ::-webkit-scrollbar{width:5px}
        ::-webkit-scrollbar-thumb{background:rgba(255,255,255,.12);border-radius:3px}
        .sidebar{width:var(--sidebar);background:var(--surface);border-right:1px solid var(--border);display:flex;flex-direction:column;position:fixed;top:0;left:0;height:100vh;z-index:100}
        .sidebar-logo{padding:24px 20px 16px;display:flex;align-items:center;gap:10px;border-bottom:1px solid var(--border)}
        .logo-icon{width:36px;height:36px;background:var(--accent);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:18px;color:#000;font-weight:800}
        .logo-text{font-size:18px;font-weight:800}.logo-text span{color:var(--accent)}
        .admin-badge{font-size:10px;background:rgba(255,165,0,.15);color:orange;border-radius:4px;padding:2px 6px;font-weight:700;margin-top:2px}
        .nav{padding:16px 12px;flex:1;overflow-y:auto}
        .nav-section{margin-bottom:24px}
        .nav-lbl{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;color:var(--faint);padding:0 8px;margin-bottom:8px}
        .nav-item{display:flex;align-items:center;gap:12px;padding:10px 12px;border-radius:8px;color:var(--muted);font-size:13px;font-weight:500;transition:all .2s;cursor:pointer}
        .nav-item:hover,.nav-item.active{background:var(--card);color:var(--text)}
        .nav-item.active i{color:var(--accent)}
        .nav-item i{width:18px;text-align:center}
        .main{margin-left:var(--sidebar);flex:1;min-height:100vh;display:flex;flex-direction:column}
        .topbar{background:var(--surface);border-bottom:1px solid var(--border);padding:16px 32px;display:flex;align-items:center;justify-content:space-between}
        .topbar h1{font-size:20px;font-weight:700}
        .content{padding:32px;flex:1}
        /* Stats */
        .stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:20px;margin-bottom:32px}
        .stat-card{background:var(--card);border-radius:var(--r);padding:24px;border:1px solid var(--border);transition:transform .2s}
        .stat-card:hover{transform:translateY(-3px)}
        .stat-icon{width:44px;height:44px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;margin-bottom:16px}
        .stat-val{font-size:32px;font-weight:800;margin-bottom:4px}
        .stat-label{font-size:13px;color:var(--muted)}
        /* Table */
        .table-card{background:var(--card);border-radius:var(--r);overflow:hidden;border:1px solid var(--border)}
        .table-header{padding:20px 24px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between}
        .table-header h3{font-size:16px;font-weight:700}
        table{width:100%;border-collapse:collapse}
        th{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:var(--faint);padding:12px 24px;text-align:left;border-bottom:1px solid var(--border)}
        td{padding:14px 24px;font-size:14px;border-bottom:1px solid var(--border)}
        tr:last-child td{border-bottom:none}
        tr:hover td{background:rgba(255,255,255,.02)}
        .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;border:none;font-family:inherit;transition:all .2s}
        .btn-primary{background:var(--accent);color:#000}
        .btn-primary:hover{background:var(--accent-hover)}
        .btn-sm{padding:5px 10px;font-size:12px;border-radius:6px}
        .btn-danger{background:rgba(239,68,68,.15);color:#ef4444}
        .btn-danger:hover{background:rgba(239,68,68,.25)}
        .btn-edit{background:rgba(59,130,246,.15);color:#60a5fa}
        .btn-edit:hover{background:rgba(59,130,246,.25)}
        .badge{display:inline-flex;align-items:center;gap:4px;font-size:11px;font-weight:600;padding:3px 8px;border-radius:4px}
        .badge-green{background:rgba(29,185,84,.15);color:var(--accent)}
        .badge-gray{background:rgba(255,255,255,.08);color:var(--muted)}
        .flash{position:fixed;top:20px;right:20px;z-index:999;padding:14px 20px;border-radius:10px;background:var(--accent);color:#000;font-weight:600;font-size:14px;animation:slideIn .3s ease;box-shadow:0 8px 32px rgba(0,0,0,.4)}
        @keyframes slideIn{from{opacity:0;transform:translateX(40px)}to{opacity:1;transform:translateX(0)}}
        /* Form */
        .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:20px}
        .form-group{display:flex;flex-direction:column;gap:6px}
        .form-group.full{grid-column:1/3}
        label{font-size:13px;font-weight:600;color:var(--muted)}
        input,select,textarea{background:var(--elevated);border:1px solid var(--border);border-radius:8px;padding:10px 14px;color:var(--text);font-family:inherit;font-size:14px;outline:none;transition:border-color .2s}
        input:focus,select:focus,textarea:focus{border-color:var(--accent)}
        input::placeholder,textarea::placeholder{color:var(--faint)}
        select option{background:var(--elevated)}
        .form-card{background:var(--card);border-radius:var(--r);padding:32px;border:1px solid var(--border)}
        .grid-2{display:grid;grid-template-columns:1fr 1fr;gap:32px}
        .img-preview{width:100%;aspect-ratio:1;border-radius:12px;object-fit:cover;border:1px solid var(--border);background:var(--elevated);display:flex;align-items:center;justify-content:center;color:var(--faint);font-size:40px}
        img.img-preview{display:block}
        .pagination a{display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;border-radius:6px;background:var(--card);border:1px solid var(--border);font-size:13px;margin:0 2px;transition:all .2s}
        .pagination a:hover{background:var(--elevated);border-color:var(--accent)}
        .pagination .active a{background:var(--accent);color:#000;border-color:var(--accent)}
    </style>
    @stack('styles')
</head>
<body>
<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-icon">🎵</div>
        <div>
            <div class="logo-text">Melo<span>dix</span></div>
            <div class="admin-badge">ADMIN</div>
        </div>
    </div>
    <nav class="nav">
        <div class="nav-section">
            <div class="nav-lbl">Dashboard</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i> Tableau de bord
            </a>
        </div>
        <div class="nav-section">
            <div class="nav-lbl">Catalogue</div>
            <a href="{{ route('admin.artists.index') }}" class="nav-item {{ request()->routeIs('admin.artists.*') ? 'active' : '' }}">
                <i class="fas fa-microphone"></i> Artistes
            </a>
            <a href="{{ route('admin.albums.index') }}" class="nav-item {{ request()->routeIs('admin.albums.*') ? 'active' : '' }}">
                <i class="fas fa-compact-disc"></i> Albums
            </a>
            <a href="{{ route('admin.songs.index') }}" class="nav-item {{ request()->routeIs('admin.songs.*') ? 'active' : '' }}">
                <i class="fas fa-music"></i> Chansons
            </a>
        </div>
        <div class="nav-section">
            <div class="nav-lbl">Site</div>
            <a href="{{ route('home') }}" class="nav-item" target="_blank">
                <i class="fas fa-external-link-alt"></i> Voir le site
            </a>
        </div>
    </nav>
</aside>

<div class="main">
    <div class="topbar">
        <h1>@yield('page-title', 'Dashboard')</h1>
        <div style="display:flex;align-items:center;gap:12px">
            <span style="font-size:13px;color:var(--muted)">Admin</span>
            <div style="width:34px;height:34px;border-radius:50%;background:var(--accent);display:flex;align-items:center;justify-content:center;color:#000;font-weight:700">A</div>
        </div>
    </div>
    <div class="content">
        @if(session('success'))
        <div class="flash" id="flash">{{ session('success') }}</div>
        <script>setTimeout(()=>{let f=document.getElementById('flash');if(f){f.style.animation='slideIn .3s ease reverse';setTimeout(()=>f.remove(),300)}},3000)</script>
        @endif
        @yield('content')
    </div>
</div>
@stack('scripts')
</body>
</html>
