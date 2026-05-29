<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Melodix') — Musique sans limites</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        :root{
            --bg-base:#050508;--bg-surface:rgba(10,10,18,0.7);--bg-elevated:rgba(30,30,45,0.8);--bg-card:rgba(25,25,35,0.6);
            --accent:#7c4dff;--accent-hover:#9575cd;--accent-dim:rgba(124,77,255,0.15);
            --text:#ffffff;--text-muted:#b0b0cc;--text-faint:#707085;
            --border:rgba(255,255,255,0.08);--radius:16px;--sidebar:260px;--player:100px;
            --glass:blur(12px) saturate(180%);
        }
        html,body{height:100%;font-family:'Inter',sans-serif;background:radial-gradient(circle at top right, #1a1033 0%, #050508 60%);color:var(--text);overflow:hidden}
        a{color:inherit;text-decoration:none}
        img{display:block;max-width:100%}
        ::-webkit-scrollbar{width:6px;height:6px}
        ::-webkit-scrollbar-track{background:transparent}
        ::-webkit-scrollbar-thumb{background:rgba(255,255,255,.15);border-radius:3px}
        /* Layout */
        .app{display:grid;grid-template-columns:var(--sidebar) 1fr;grid-template-rows:1fr var(--player);height:100vh}
        /* Sidebar */
        .sidebar{grid-row:1/2;background:var(--bg-surface);backdrop-filter:var(--glass);border-right:1px solid var(--border);display:flex;flex-direction:column;overflow:hidden;z-index:10}
        [dir="rtl"] .sidebar{border-right:none;border-left:1px solid var(--border)}
        .sidebar-logo{padding:32px 24px 24px;display:flex;align-items:center;gap:12px}
        .sidebar-logo .logo-icon{width:40px;height:40px;background:linear-gradient(135deg, var(--accent), #536dfe);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:20px;box-shadow:0 8px 16px var(--accent-dim)}
        .sidebar-logo .logo-text{font-size:24px;font-weight:800;letter-spacing:-1px}
        .sidebar-logo .logo-text span{background:linear-gradient(to right, #fff, var(--accent));-webkit-background-clip:text;-webkit-text-fill-color:transparent}
        .sidebar-nav{padding:8px 12px;flex:1;overflow-y:auto}
        .nav-section{margin-bottom:24px}
        .nav-label{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;color:var(--text-faint);padding:0 8px;margin-bottom:8px}
        .nav-link{display:flex;align-items:center;gap:12px;padding:10px 12px;border-radius:8px;color:var(--text-muted);font-size:13px;font-weight:500;transition:all .2s;cursor:pointer}
        .nav-link:hover,.nav-link.active{background:var(--bg-card);color:var(--text)}
        .nav-link.active .nav-icon{color:var(--accent)}
        .nav-icon{width:18px;text-align:center;font-size:16px}
        /* Main content */
        .main{grid-column:2;grid-row:1;overflow-y:auto;background:var(--bg-base)}
        .main-inner{min-height:100%;padding:28px;padding-bottom:40px}
        /* Top bar */
        .topbar{display:flex;align-items:center;justify-content:space-between;margin-bottom:32px}
        .search-bar{display:flex;align-items:center;gap:10px;background:var(--bg-elevated);border:1px solid var(--border);border-radius:30px;padding:10px 18px;width:320px;transition:border-color .2s}
        .search-bar:focus-within{border-color:var(--accent)}
        .search-bar input{background:none;border:none;outline:none;color:var(--text);font-family:inherit;font-size:14px;width:100%}
        .search-bar input::placeholder{color:var(--text-faint)}
        .search-bar i{color:var(--text-faint)}
        /* Section headings */
        .section-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px}
        .section-title{font-size:22px;font-weight:700}
        .section-link{font-size:12px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:1px;transition:color .2s}
        .section-link:hover{color:var(--accent)}
        /* Cards grid */
        .cards-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(170px,1fr));gap:18px}
        .card{background:var(--bg-card);backdrop-filter:var(--glass);border:1px solid var(--border);padding:20px;border-radius:20px;transition:all .3s ease;cursor:pointer;position:relative}
        .card:hover{background:rgba(255,255,255,0.05);transform:translateY(-8px);box-shadow:0 12px 24px rgba(0,0,0,0.3)}
        .card-img-wrap{position:relative;aspect-ratio:1;border-radius:12px;overflow:hidden;margin-bottom:16px;box-shadow:0 8px 16px rgba(0,0,0,0.4)}
        .card img{width:100%;height:100%;object-fit:cover;transition:transform .5s}
        .card:hover img{transform:scale(1.1)}
        .card-play-btn{position:absolute;bottom:8px;right:8px;width:42px;height:42px;background:var(--accent);border-radius:50%;display:flex;align-items:center;justify-content:center;opacity:0;transform:translateY(8px);transition:all .25s;box-shadow:0 8px 24px rgba(0,0,0,.5);border:none;cursor:pointer;font-size:14px;color:#000}
        .card:hover .card-play-btn{opacity:1;transform:translateY(0)}
        .card-play-btn:hover{background:var(--accent-hover);transform:scale(1.08)!important}
        .card-title{font-weight:700;font-size:16px;margin-bottom:4px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
        .card-sub{font-size:13px;color:var(--text-muted)}
        .badge{display:inline-flex;align-items:center;gap:4px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;padding:3px 8px;border-radius:4px;background:var(--accent-dim);color:var(--accent)}
        /* Artist circle card */
        .artist-card .card-img-wrap{border-radius:50%}
        /* Song list */
        .song-list{display:flex;flex-direction:column;gap:2px}
        .song-row{display:grid;grid-template-columns:40px 1fr 120px 140px;align-items:center;gap:12px;padding:8px 16px;border-radius:8px;transition:background .2s;cursor:pointer}
        .song-row:hover{background:var(--bg-card)}
        .song-row.playing{background:var(--accent-dim)}
        .song-row:hover .song-num,.song-row.playing .song-num{display:none}
        .song-play-icon{display:none;color:var(--accent)}
        .song-row:hover .song-play-icon,.song-row.playing .song-play-icon{display:block}
        .song-num{color:var(--text-muted);font-size:14px;text-align:center}
        .song-info{display:flex;flex-direction:column;gap:2px;overflow:hidden}
        .song-name{font-size:14px;font-weight:500;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
        .song-row.playing .song-name{color:var(--accent)}
        .song-artist{font-size:12px;color:var(--text-muted)}
        .song-album-name{font-size:13px;color:var(--text-muted);white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
        .song-plays{font-size:13px;color:var(--text-muted);text-align:right}
        .song-duration{font-size:13px;color:var(--text-muted);text-align:right}
        /* Player */
        .player{grid-column:1/3;grid-row:2;background:var(--bg-surface);border-top:1px solid var(--border);display:grid;grid-template-columns:1fr 2fr 1fr;align-items:center;padding:0 24px;gap:16px}
        .player-info{display:flex;align-items:center;gap:14px;overflow:hidden}
        .player-thumb{width:56px;height:56px;border-radius:8px;object-fit:cover;flex-shrink:0}
        .player-thumb-placeholder{width:56px;height:56px;border-radius:8px;background:var(--bg-elevated);flex-shrink:0;display:flex;align-items:center;justify-content:center;color:var(--text-faint)}
        .player-meta{overflow:hidden}
        .player-title{font-size:13px;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
        .player-artist{font-size:11px;color:var(--text-muted)}
        .player-controls{display:flex;flex-direction:column;align-items:center;gap:8px}
        .player-btns{display:flex;align-items:center;gap:20px}
        .ctrl-btn{background:none;border:none;color:var(--text-muted);cursor:pointer;font-size:16px;transition:color .2s;padding:4px}
        .ctrl-btn:hover{color:var(--text)}
        .ctrl-btn.active{color:var(--accent)}
        .play-btn{width:40px;height:40px;background:var(--text);border-radius:50%;display:flex;align-items:center;justify-content:center;border:none;cursor:pointer;font-size:15px;color:#000;transition:transform .15s}
        .play-btn:hover{transform:scale(1.08)}
        .progress-wrap{display:flex;align-items:center;gap:10px;width:100%}
        .progress-time{font-size:11px;color:var(--text-faint);min-width:34px}
        .progress-time:last-child{text-align:right}
        .progress-bar{flex:1;height:4px;background:rgba(255,255,255,.15);border-radius:2px;cursor:pointer;position:relative}
        .progress-fill{height:100%;background:var(--text);border-radius:2px;transition:width .1s linear;position:relative}
        .progress-fill::after{content:'';position:absolute;right:-5px;top:50%;transform:translateY(-50%);width:10px;height:10px;background:var(--text);border-radius:50%;opacity:0;transition:opacity .2s}
        .progress-bar:hover .progress-fill::after{opacity:1}
        .progress-bar:hover .progress-fill{background:var(--accent)}
        .player-right{display:flex;align-items:center;justify-content:flex-end;gap:14px}
        .volume-wrap{display:flex;align-items:center;gap:8px;width:140px}
        .volume-slider{flex:1;-webkit-appearance:none;appearance:none;height:4px;background:rgba(255,255,255,.15);border-radius:2px;outline:none;cursor:pointer}
        .volume-slider::-webkit-slider-thumb{-webkit-appearance:none;width:12px;height:12px;background:var(--text);border-radius:50%;cursor:pointer}
        /* Notification */
        .flash{position:fixed;top:20px;right:20px;z-index:999;padding:14px 20px;border-radius:10px;background:var(--accent);color:#000;font-weight:600;font-size:14px;animation:slideIn .3s ease;box-shadow:0 8px 32px rgba(0,0,0,.4)}
        @keyframes slideIn{from{opacity:0;transform:translateX(40px)}to{opacity:1;transform:translateX(0)}}
        @keyframes eq{from{height:4px}to{height:14px}}
        /* Search results dropdown */
        .search-results{position:absolute;top:100%;left:0;right:0;background:var(--bg-elevated);border:1px solid var(--border);border-top:none;border-radius:0 0 12px 12px;z-index:100;max-height:400px;overflow-y:auto;display:none;box-shadow:0 10px 30px rgba(0,0,0,.5)}
        .search-result-item{display:flex;align-items:center;gap:12px;padding:10px 16px;cursor:pointer;transition:background .2s}
        .search-result-item:hover{background:var(--bg-card)}
        .search-result-thumb{width:32px;height:32px;border-radius:4px;object-fit:cover}
        .search-result-info{flex:1;overflow:hidden}
        .search-result-title{font-size:13px;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
        .search-result-sub{font-size:11px;color:var(--text-muted)}
        /* Context Menu */
        .context-menu{position:fixed;background:var(--bg-elevated);border:1px solid var(--border);border-radius:8px;box-shadow:0 10px 40px rgba(0,0,0,.5);z-index:1000;min-width:180px;padding:6px;display:none}
        .menu-item{padding:8px 12px;border-radius:4px;font-size:13px;cursor:pointer;display:flex;align-items:center;gap:10px;transition:all .2s}
        .menu-item:hover{background:var(--accent);color:#000}
        .menu-divider{height:1px;background:var(--border);margin:6px 0}
        /* Volume icons */
        .vol-icon{width:20px;text-align:center}
    </style>
    @stack('styles')
</head>
<body>
<div class="app" id="app">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-logo">
            <div class="logo-icon">🎵</div>
            <div class="logo-text">Melo<span>dix</span></div>
        </div>
        <nav class="sidebar-nav">
            <div class="nav-section">
                <div class="nav-label">{{ __('Menu') }}</div>
                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                    <i class="fas fa-home nav-icon"></i> {{ __('Home') }}
                </a>
                <a href="{{ route('search') }}" class="nav-link {{ request()->routeIs('search') ? 'active' : '' }}">
                    <i class="fas fa-search nav-icon"></i> {{ __('Search') }}
                </a>
                <a href="{{ route('artists.index') }}" class="nav-link {{ request()->routeIs('artists.*') ? 'active' : '' }}">
                    <i class="fas fa-microphone nav-icon"></i> {{ __('Artists') }}
                </a>
            </div>
            <div class="nav-section">
                <div class="nav-label">{{ __('Library') }}</div>
                <a href="{{ route('playlists.index') }}" class="nav-link {{ request()->routeIs('playlists.*') ? 'active' : '' }}">
                    <i class="fas fa-list nav-icon"></i> {{ __('Playlists') }}
                </a>
                <div class="nav-link" onclick="alert('Connectez-vous pour voir vos titres aimés')">
                    <i class="fas fa-heart nav-icon"></i> {{ __('Liked Songs') }}
                </div>
            </div>
            <div class="nav-section">
                <div class="nav-label">{{ __('Account') }}</div>
                @guest
                <a href="{{ route('login') }}" class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}">
                    <i class="fas fa-sign-in-alt nav-icon"></i> {{ __('Login') }}
                </a>
                <a href="{{ route('register') }}" class="nav-link {{ request()->routeIs('register') ? 'active' : '' }}">
                    <i class="fas fa-user-plus nav-icon"></i> {{ __('Register') }}
                </a>
                @else
                <div class="nav-link">
                    <i class="fas fa-user nav-icon"></i> {{ Auth::user()->name }}
                </div>
                <form action="{{ route('logout') }}" method="POST" id="logout-form">
                    @csrf
                    <a href="#" class="nav-link" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt nav-icon"></i> {{ __('Logout') }}
                    </a>
                </form>
                @endguest
            </div>
            <div class="nav-section">
                <div class="nav-label">{{ __('Administration') }}</div>
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}">
                    <i class="fas fa-chart-line nav-icon"></i> {{ __('Dashboard') }}
                </a>
                <a href="{{ route('admin.artists.index') }}" class="nav-link">
                    <i class="fas fa-user-music nav-icon"></i> {{ __('Manage Artists') }}
                </a>
                <a href="{{ route('admin.albums.index') }}" class="nav-link">
                    <i class="fas fa-compact-disc nav-icon"></i> {{ __('Manage Albums') }}
                </a>
            </div>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main" id="mainContent">
        <div class="main-inner">
            <div class="topbar">
                <div style="display:flex;gap:8px">
                    <button onclick="history.back()" style="width:32px;height:32px;border-radius:50%;background:rgba(0,0,0,.5);border:none;color:var(--text);cursor:pointer;font-size:14px"><i class="fas fa-chevron-left"></i></button>
                    <button onclick="history.forward()" style="width:32px;height:32px;border-radius:50%;background:rgba(0,0,0,.5);border:none;color:var(--text);cursor:pointer;font-size:14px"><i class="fas fa-chevron-right"></i></button>
                </div>
                <form action="{{ route('search') }}" method="GET" style="position:relative" id="searchForm">
                    <div class="search-bar">
                        <i class="fas fa-search"></i>
                        <input type="text" name="q" id="searchInput" placeholder="Artistes, chansons, albums..." value="{{ request('q') }}" autocomplete="off">
                    </div>
                    <div class="search-results" id="searchResults"></div>
                </form>
                <div style="display:flex;align-items:center;gap:12px">
                    <div style="display:flex;gap:4px;background:var(--bg-elevated);padding:4px;border-radius:20px;margin-right:12px">
                        <a href="{{ route('locale.switch', 'en') }}" style="width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:700;{{ app()->getLocale()=='en'?'background:var(--accent);color:#000':'' }}">EN</a>
                        <a href="{{ route('locale.switch', 'fr') }}" style="width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:700;{{ app()->getLocale()=='fr'?'background:var(--accent);color:#000':'' }}">FR</a>
                        <a href="{{ route('locale.switch', 'ar') }}" style="width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:700;{{ app()->getLocale()=='ar'?'background:var(--accent);color:#000':'' }}">AR</a>
                    </div>
                    <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg, var(--accent), #536dfe);display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:700;color:#fff;box-shadow:0 4px 12px var(--accent-dim)">
                        @auth {{ substr(Auth::user()->name, 0, 1) }} @else A @endauth
                    </div>
                </div>
            </div>
            @if(session('success'))
            <div class="flash" id="flash">{{ session('success') }}</div>
            <script>setTimeout(()=>{let f=document.getElementById('flash');if(f)f.style.animation='slideIn .3s ease reverse';setTimeout(()=>{if(f)f.remove()},300)},3000)</script>
            @endif
            @yield('content')
        </div>
    </main>

    <!-- Player -->
    <footer class="player" id="player">
        <div style="position:absolute;inset:0;background:var(--bg-surface);backdrop-filter:var(--glass);z-index:-1"></div>
        <div class="player-info" id="playerInfo">
            <div class="player-thumb-placeholder" id="playerThumbWrap">
                <i class="fas fa-music"></i>
            </div>
            <div class="player-meta">
                <div class="player-title" id="playerTitle">{{ __('Select a song') }}</div>
                <div class="player-artist" id="playerArtist">—</div>
            </div>
        </div>
        <div class="player-controls">
            <div class="player-btns">
                <button class="ctrl-btn" id="shuffleBtn" title="Aléatoire"><i class="fas fa-random"></i></button>
                <button class="ctrl-btn" id="prevBtn" title="Précédent"><i class="fas fa-step-backward"></i></button>
                <button class="play-btn" id="playBtn"><i class="fas fa-play" id="playIcon"></i></button>
                <button class="ctrl-btn" id="nextBtn" title="Suivant"><i class="fas fa-step-forward"></i></button>
                <button class="ctrl-btn" id="repeatBtn" title="Répéter"><i class="fas fa-redo"></i></button>
            </div>
            <div class="progress-wrap">
                <span class="progress-time" id="currentTime">0:00</span>
                <div class="progress-bar" id="progressBar">
                    <div class="progress-fill" id="progressFill" style="width:0%"></div>
                </div>
                <span class="progress-time" id="totalTime">0:00</span>
            </div>
        </div>
        <div class="player-right">
            <button class="ctrl-btn"><i class="fas fa-list-ul"></i></button>
            <div class="volume-wrap">
                <button class="ctrl-btn" id="muteBtn"><i class="fas fa-volume-up"></i></button>
                <input type="range" class="volume-slider" id="volumeSlider" min="0" max="100" value="80">
            </div>
        </div>
    </footer>
</div>

<audio id="audioEl" preload="none"></audio>

<script>
// =================== MELODIX PLAYER ===================
const audio = document.getElementById('audioEl');
const playBtn = document.getElementById('playBtn');
const playIcon = document.getElementById('playIcon');
const prevBtn = document.getElementById('prevBtn');
const nextBtn = document.getElementById('nextBtn');
const shuffleBtn = document.getElementById('shuffleBtn');
const repeatBtn = document.getElementById('repeatBtn');
const muteBtn = document.getElementById('muteBtn');
const progressBar = document.getElementById('progressBar');
const progressFill = document.getElementById('progressFill');
const currentTimeEl = document.getElementById('currentTime');
const totalTimeEl = document.getElementById('totalTime');
const volumeSlider = document.getElementById('volumeSlider');
const playerTitle = document.getElementById('playerTitle');
const playerArtist = document.getElementById('playerArtist');
const playerThumbWrap = document.getElementById('playerThumbWrap');

let queue = [], currentIndex = 0, isShuffling = false, isRepeating = false;

function fmt(s) {
    const m = Math.floor(s / 60), sec = Math.floor(s % 60);
    return `${m}:${sec.toString().padStart(2,'0')}`;
}

window.playQueue = function(songs, startIndex = 0) {
    queue = songs;
    currentIndex = startIndex;
    loadSong(queue[currentIndex]);
    audio.play();
};

window.playSong = function(id, title, artist, cover, duration, albumSongs, audioUrl) {
    if (albumSongs) {
        queue = albumSongs;
        currentIndex = albumSongs.findIndex(s => s.id == id) || 0;
    } else {
        queue = [{id, title, artist, cover, duration, audio_url: audioUrl}];
        currentIndex = 0;
    }
    loadSong(queue[currentIndex]);
    audio.play();
    fetch(`/api/songs/${id}/play`).catch(()=>{});
};

function loadSong(song) {
    playerTitle.textContent = song.title || '{{ __('Inconnue') }}';
    playerArtist.textContent = song.artist || '—';
    playerThumbWrap.innerHTML = (song.cover || song.album?.cover_url)
        ? `<img class="player-thumb" src="${song.cover || song.album?.cover_url}" alt="${song.title}" onerror="this.style.display='none'">`
        : `<i class="fas fa-music" style="color:var(--text-faint)"></i>`;
    totalTimeEl.textContent = fmt(song.duration || 0);
    document.querySelectorAll('.song-row').forEach(r => r.classList.remove('playing'));
    const row = document.querySelector(`.song-row[data-id="${song.id}"]`);
    if (row) row.classList.add('playing');
    
    if (song.audio_url) {
        audio.src = song.audio_url;
        audio.load();
    }
}

function togglePlay() {
    if (audio.src && audio.src !== window.location.href) {
        audio.paused ? audio.play() : audio.pause();
    }
}

function setIcon(s) { playIcon.className = `fas fa-${s}`; }

audio.addEventListener('play', () => setIcon('pause'));
audio.addEventListener('pause', () => setIcon('play'));
audio.addEventListener('ended', () => nextSong());
audio.addEventListener('timeupdate', () => {
    if (!audio.duration) return;
    progressFill.style.width = (audio.currentTime / audio.duration * 100) + '%';
    currentTimeEl.textContent = fmt(audio.currentTime);
    totalTimeEl.textContent = fmt(audio.duration);
});

playBtn.addEventListener('click', togglePlay);

function nextSong() {
    if (!queue.length) return;
    if (isRepeating) { loadSong(queue[currentIndex]); audio.play(); return; }
    if (isShuffling) currentIndex = Math.floor(Math.random() * queue.length);
    else currentIndex = (currentIndex + 1) % queue.length;
    loadSong(queue[currentIndex]);
    audio.play();
}

function prevSong() {
    if (!queue.length) return;
    currentIndex = (currentIndex - 1 + queue.length) % queue.length;
    loadSong(queue[currentIndex]);
    audio.play();
}

nextBtn.addEventListener('click', nextSong);
prevBtn.addEventListener('click', prevSong);
shuffleBtn.addEventListener('click', () => { isShuffling = !isShuffling; shuffleBtn.classList.toggle('active', isShuffling); });
repeatBtn.addEventListener('click', () => { isRepeating = !isRepeating; repeatBtn.classList.toggle('active', isRepeating); });

progressBar.addEventListener('click', e => {
    const pct = e.offsetX / progressBar.offsetWidth;
    if (audio.duration) { audio.currentTime = pct * audio.duration; }
    progressFill.style.width = (pct * 100) + '%';
});

volumeSlider.addEventListener('input', () => {
    audio.volume = volumeSlider.value / 100;
    muteBtn.querySelector('i').className = volumeSlider.value == 0 ? 'fas fa-volume-mute' : 'fas fa-volume-up';
});

muteBtn.addEventListener('click', () => {
    audio.muted = !audio.muted;
    muteBtn.querySelector('i').className = audio.muted ? 'fas fa-volume-mute' : 'fas fa-volume-up';
});

audio.volume = 0.8;

// =================== INTERACTIVE FEATURES ===================

// Real-time Search
const searchInput = document.getElementById('searchInput');
const searchResults = document.getElementById('searchResults');
let searchTimeout;

searchInput.addEventListener('input', () => {
    clearTimeout(searchTimeout);
    const q = searchInput.value.trim();
    if (q.length < 2) { searchResults.style.display = 'none'; return; }
    
    searchTimeout = setTimeout(async () => {
        const res = await fetch(`/api/search?q=${encodeURIComponent(q)}`);
        const data = await res.json();
        renderSearchResults(data);
    }, 300);
});

function renderSearchResults(data) {
    let html = '';
    if (data.artists.length) {
        html += `<div style="padding:8px 16px;font-size:10px;font-weight:700;color:var(--text-faint);text-transform:uppercase">${"{{ __('Artists') }}"}</div>`;
        data.artists.forEach(a => {
            html += `<a href="/artists/${a.slug}" class="search-result-item">
                <img src="${a.image_url}" class="search-result-thumb" style="border-radius:50%">
                <div class="search-result-info"><div class="search-result-title">${a.name}</div><div class="search-result-sub">${"{{ __('Artist') }}"}</div></div>
            </a>`;
        });
    }
    if (data.songs.length) {
        html += `<div style="padding:8px 16px;font-size:10px;font-weight:700;color:var(--text-faint);text-transform:uppercase">${"{{ __('Songs') }}"}</div>`;
        data.songs.forEach(s => {
            const isSp = s.id && s.id.toString().startsWith('sp_');
            html += `<div class="search-result-item" onclick="playSong(${isSp ? 'null' : s.id},'${s.title.replace(/'/g,"\\'")}','${s.artist.name.replace(/'/g,"\\'")}','${s.album?.cover_url||''}',${s.duration}, null, '${s.audio_url||''}')">
                <img src="${s.album?.cover_url||''}" class="search-result-thumb">
                <div class="search-result-info">
                    <div class="search-result-title">${s.title} ${isSp ? '<i class="fab fa-spotify" style="color:#1DB954;font-size:10px"></i>' : ''}</div>
                    <div class="search-result-sub">${s.artist.name}</div>
                </div>
            </div>`;
        });
    }
    if (!html) html = `<div style="padding:20px;text-align:center;color:var(--text-faint);font-size:13px">${"{{ __('No results found') }}"}</div>`;
    searchResults.innerHTML = html;
    searchResults.style.display = 'block';
}

document.addEventListener('click', e => {
    if (!e.target.closest('#searchForm')) searchResults.style.display = 'none';
    if (!e.target.closest('.context-menu') && !e.target.closest('.btn-more')) hideContextMenu();
});

// Like Functionality
window.toggleLike = async function(songId, btn) {
    const res = await fetch(`/api/songs/${songId}/like`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
    });
    const data = await res.json();
    if (data.success) {
        const icon = btn.querySelector('i');
        icon.className = data.liked ? 'fas fa-heart' : 'far fa-heart';
        icon.style.color = data.liked ? 'var(--accent)' : '';
        if (data.liked) btn.classList.add('heart-pop');
        setTimeout(() => btn.classList.remove('heart-pop'), 300);
    }
};

// Playlist Menu
let currentSongId = null;
const contextMenu = document.createElement('div');
contextMenu.className = 'context-menu';
document.body.appendChild(contextMenu);

window.showPlaylistMenu = async function(e, songId) {
    e.preventDefault();
    e.stopPropagation();
    currentSongId = songId;
    
    const res = await fetch('/api/user/playlists');
    const playlists = await res.json();
    
    let html = '<div style="padding:4px 12px;font-size:11px;color:var(--text-faint);font-weight:700;text-transform:uppercase">Ajouter à la playlist</div>';
    if (playlists.length) {
        playlists.forEach(p => {
            html += `<div class="menu-item" onclick="addToPlaylist(${p.id})"><i class="fas fa-plus"></i> ${p.name}</div>`;
        });
    } else {
        html += '<div class="menu-item" style="color:var(--text-faint);cursor:default">Aucune playlist</div>';
    }
    html += '<div class="menu-divider"></div>';
    html += `<div class="menu-item" onclick="window.open('/playlists','_self')"><i class="fas fa-external-link-alt"></i> Gérer mes playlists</div>`;
    
    contextMenu.innerHTML = html;
    contextMenu.style.display = 'block';
    
    const rect = e.target.getBoundingClientRect();
    contextMenu.style.top = (rect.bottom + window.scrollY) + 'px';
    contextMenu.style.left = (rect.left - 150 + window.scrollX) + 'px';
};

window.addToPlaylist = async function(playlistId) {
    const res = await fetch('/api/playlists/add-song', {
        method: 'POST',
        headers: { 
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content 
        },
        body: JSON.stringify({ playlist_id: playlistId, song_id: currentSongId })
    });
    const data = await res.json();
    if (data.success) {
        showNotification('Ajouté à la playlist !');
        hideContextMenu();
    }
};

function hideContextMenu() { contextMenu.style.display = 'none'; }

function showNotification(msg) {
    const div = document.createElement('div');
    div.className = 'flash';
    div.textContent = msg;
    document.body.appendChild(div);
    setTimeout(() => {
        div.style.animation = 'slideIn .3s ease reverse';
        setTimeout(() => div.remove(), 300);
    }, 3000);
}

// Player Volume enhancements
function updateVolumeIcon(v) {
    const icon = muteBtn.querySelector('i');
    if (v == 0) icon.className = 'fas fa-volume-mute';
    else if (v < 30) icon.className = 'fas fa-volume-off';
    else if (v < 70) icon.className = 'fas fa-volume-down';
    else icon.className = 'fas fa-volume-up';
}

volumeSlider.addEventListener('input', () => {
    const v = volumeSlider.value;
    audio.volume = v / 100;
    updateVolumeIcon(v);
});

updateVolumeIcon(80);
</script>
@stack('scripts')
</body>
</html>
