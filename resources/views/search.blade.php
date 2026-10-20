<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Búsqueda: {{ $query ?? '' }} - AudioFile</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}?v=2.0">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=2.0">

    <link href="https://vjs.zencdn.net/8.10.0/video-js.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * { box-sizing: border-box; }
        body {
            background-color: #13161F;
            color: #FFFFFF;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding-bottom: 50px;
        }
        /* Navbar */
        .navbar {
            background-color: #1E2433;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
            position: sticky;
            top: 0;
            z-index: 100;
            width: 100%;
        }
        .nav-brand { font-size: 20px; font-weight: bold; color: #2CE4F5; text-decoration: none; }
        .nav-links { display: flex; gap: 20px; align-items: center; }
        .nav-links a { color: #6A7B92; text-decoration: none; font-size: 14px; font-weight: 600; transition: color 0.2s; }
        .nav-links a:hover, .nav-links a.active { color: #FFFFFF; scale: 1.05;}
        .nav-btn-action {
            background: linear-gradient(to right, #2CE4F5, #67F4CE);
            color: #13161F !important;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: bold !important;
        }
        .nav-btn-action:hover {
            opacity: 0.9;
            scale: 1.1;
        }
        /* Contenedor para el menú desplegable de autocompletar/sugerencias */
        .nav-search-container { position: relative; }
        .nav-search {
            display: flex;
            align-items: center;
            background-color: #151924;
            border: 1px solid rgba(44, 228, 245, 0.2);
            border-radius: 20px;
            padding: 6px 15px;
            width: 320px;
            transition: border-color 0.2s;
        }
        .nav-search:focus-within { border-color: #2CE4F5; }
        .nav-search input {
            background: transparent; border: none; color: #FFFFFF; font-size: 13px; width: 100%; outline: none;
        }
        .nav-search input::placeholder { color: #6A7B92; }
        .nav-search button { background: transparent; border: none; color: #6A7B92; cursor: pointer; font-size: 14px; }
        .nav-search button:hover { color: #2CE4F5; }
        /* Estilos del Dropdown del Buscador */
        .search-suggestions-dropdown {
            display: none;
            position: absolute;
            top: calc(100% + 8px);
            left: 0;
            width: 100%;
            min-width: 320px;
            background-color: #181C27;
            border: 1px solid rgba(44, 228, 245, 0.25);
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.8);
            z-index: 1000;
            max-height: 420px;
            overflow-y: auto;
            padding: 8px 0;
        }
        .search-suggestions-dropdown.show { 
            display: block;
        }
        .suggestion-item {
            padding: 8px 14px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: #FFFFFF;
            text-decoration: none;
            font-size: 13px;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .suggestion-item:hover { background-color: #252D42; }
        /* Formatos de los distintos tipos de sugerencias */
        .suggestion-icon {
            color: #6A7B92;
            font-size: 14px;
            width: 20px;
            text-align: center;
        }
        .suggestion-thumb {
            width: 38px;
            height: 38px;
            border-radius: 4px;
            object-fit: cover;
            background-color: #252D42;
            flex-shrink: 0;
        }
        .suggestion-thumb.circle { 
            border-radius: 50%; 
        }
        
        .suggestion-info {
            display: flex;
            flex-direction: column;
            overflow: hidden;
            flex: 1;
        }
        .suggestion-title {
            font-size: 13px;
            font-weight: 600;
            color: #FFFFFF;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .suggestion-title strong { color: #2CE4F5; }
        .suggestion-subtitle {
            font-size: 11px;
            color: #6A7B92;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-top: 2px;
        }
        /* Estilos del Avatar y Menú Desplegable */
        .profile-menu-container { position: relative; display: inline-block; }
        .profile-avatar-btn {
            background: transparent;
            border: 2px solid rgba(44, 228, 245, 0.4);
            border-radius: 50%;
            padding: 0;
            cursor: pointer;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            transition: border-color 0.2s, transform 0.2s;
        }
        .profile-avatar-btn:hover { border-color: #2CE4F5; transform: scale(1.05); }
        .profile-avatar-img, .profile-avatar-placeholder {
            width: 100%; height: 100%; object-fit: cover; display: flex;
            align-items: center; justify-content: center; background-color: #2CE4F5;
            color: #13161F; font-weight: bold; font-size: 15px;
        }
        .profile-dropdown {
            display: none; position: absolute; right: 0; top: 120%;
            background-color: #1E2433; border: 1px solid rgba(44, 228, 245, 0.2);
            border-radius: 10px; box-shadow: 0 8px 24px rgba(0,0,0,0.4);
            min-width: 240px; z-index: 101; padding: 12px 0;
        }
        .profile-dropdown.show { display: block; }
        .profile-dropdown-header { padding: 8px 16px 12px 16px; display: flex; align-items: center; gap: 12px; }
        .dropdown-avatar {
            width: 40px; height: 40px; border-radius: 50%; object-fit: cover;
            background-color: #2CE4F5; color: #13161F; display: flex;
            align-items: center; justify-content: center; font-weight: bold;
        }
        .dropdown-user-info { display: flex; flex-direction: column; overflow: hidden; }
        .dropdown-name { font-size: 14px; font-weight: bold; color: #FFFFFF; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .dropdown-email { font-size: 12px; color: #6A7B92; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .profile-dropdown hr { border: none; border-top: 1px solid rgba(255, 255, 255, 0.1); margin: 4px 0; }
        .profile-dropdown a, .profile-dropdown button {
            display: block; width: 100%; padding: 8px 16px; color: #6A7B92; text-decoration: none;
            font-size: 13px; background: none; border: none; text-align: left; cursor: pointer; transition: background-color 0.2s, color 0.2s;
        }
        .profile-dropdown a:hover, .profile-dropdown button:hover { background-color: #252D42; color: #FFFFFF; }
        .logout-btn { color: #ff5c5c !important; }
        .logout-btn:hover { background-color: rgba(255, 92, 92, 0.1) !important; }
        /* Layout */
        .app-body { display: flex; flex: 1; overflow: hidden; height: calc(100vh - 65px); background-color: rgba(19, 22, 31, 0.6); }
        .sidebar {
            width: 240px; background-color: rgba(23, 28, 40, 0.9); backdrop-filter: blur(5px);
            border-right: 1px solid rgba(44, 228, 245, 0.1); display: flex; flex-direction: column;
            padding: 20px 15px; gap: 25px; overflow-y: auto; flex-shrink: 0;
        }
        .sidebar-group-title { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #6A7B92; margin-bottom: 10px; padding-left: 10px; }
        .sidebar-menu { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 4px; }
        .sidebar-item a { display: flex; align-items: center; gap: 12px; padding: 10px 12px; color: #A0AEC0; text-decoration: none; font-size: 13px; font-weight: 600; border-radius: 8px; transition: all 0.2s; }
        .sidebar-item a:hover { color: #FFFFFF; background-color: rgba(30, 36, 51, 0.8); }
        .btn-create-playlist { width: 100%; background-color: rgba(30, 36, 51, 0.7); border: 1px dashed rgba(44, 228, 245, 0.3); color: #2CE4F5; padding: 10px; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; }

        .main-content { flex: 1; overflow-y: auto; padding: 30px 40px 100px 40px; }
        h2.section-title { font-size: 22px; margin-bottom: 15px; font-weight: 700; border-left: 4px solid #2CE4F5; padding-left: 10px; }
        
        .card-grid { display: flex; gap: 20px; flex-wrap: wrap; padding-bottom: 15px; }
        .music-card {
            background-color: #1E2433; border-radius: 12px; width: 180px; padding: 15px;
            flex-shrink: 0; box-shadow: 0 6px 20px rgba(0,0,0,0.3); transition: transform 0.2s, background-color 0.2s; cursor: pointer;
        }
        .music-card:hover { background-color: #252D42; }
        .card-img-wrapper { position: relative; width: 100%; height: 150px; margin-bottom: 12px; border-radius: 8px; overflow: hidden; background-color: rgba(21, 25, 36, 0.5); }
        .play-overlay { position: absolute; bottom: 8px; right: 8px; background-color: #2CE4F5; color: #13161F; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; opacity: 0; transform: translateY(10px); transition: all 0.2s; }
        .music-card:hover .play-overlay { opacity: 1; transform: translateY(0); }
        .card-title { font-size: 14px; font-weight: bold; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-bottom: 4px; }
        .card-artist { font-size: 12px; color: #6A7B92; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

        .artist-card {
            background-color: #1E2433; border-radius: 12px; width: 180px; padding: 20px 15px; text-align: center;
            box-shadow: 0 6px 20px rgba(0,0,0,0.3); transition: background-color 0.2s;
        }
        .artist-card:hover { background-color: #252D42; }
        .artist-avatar-circle {
            width: 100px; height: 100px; border-radius: 50%; background: #2CE4F5; color: #13161F;
            display: flex; align-items: center; justify-content: center; font-size: 32px; font-weight: bold; margin: 0 auto 12px auto;
        }

        /* Reproductor Video.js */
        #audio-player-container {
            position: fixed; bottom: 0; left: 0; width: 100%; height: 72px;
            background-color: #181C27 !important; border-top: 1px solid rgba(44, 228, 245, 0.15);
            display: none; align-items: center; justify-content: space-between; padding: 0 16px;
            box-shadow: 0 -4px 20px rgba(0,0,0,0.5); z-index: 1000;
        }
        /* Ocultar elementos innecesarios de Video.js */
        .video-js .vjs-big-play-button,
        .video-js .vjs-fullscreen-control,
        .video-js .vjs-picture-in-picture-control,
        .video-js .vjs-modal-dialog,
        .video-js .vjs-text-track-settings,
        .video-js .vjs-time-divider,
        .video-js .vjs-play-control,
        .video-js .vjs-current-time,
        .video-js .vjs-duration,
        .video-js .vjs-volume-panel,
        .video-js .vjs-remaining-time {
            display: none !important;
        }
        
        .video-js { position: absolute !important; top: 0 !important; left: 0 !important; width: 100% !important; height: 4px !important; background-color: transparent !important; }
        .video-js .vjs-control-bar { display: flex !important; background: transparent !important; align-items: center !important; height: 4px !important; width: 100% !important; position: absolute !important; top: 0 !important; padding: 0 !important; }
        .video-js .vjs-progress-control { position: absolute !important; top: -4px !important; left: 0 !important; width: 100% !important; height: 6px !important; cursor: pointer; }
        .video-js .vjs-progress-holder { height: 4px !important; border-radius: 0 !important; background-color: rgba(255, 255, 255, 0.2) !important; margin: 0 !important; }
        .video-js .vjs-play-progress { background-color: #2CE4F5 !important; border-radius: 0 !important; }
        .video-js .vjs-play-progress:before { display: none !important; }

        .player-left-section { display: flex; align-items: center; gap: 12px; width: 30%; min-width: 200px; }
        .player-cover-img { width: 48px; height: 48px; border-radius: 4px; object-fit: cover; background-color: #252D42; }
        .player-meta-info { display: flex; flex-direction: column; overflow: hidden; }
        #player-song-title { font-size: 14px; font-weight: bold; color: #F1F1F1; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        #player-song-details { font-size: 12px; color: #AAAAAA; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

        .player-center-section { display: flex; flex-direction: column; align-items: center; gap: 4px; flex: 1; }
        .player-controls-row { display: flex; align-items: center; gap: 20px; }
        .player-controls-row button { background: transparent; border: none; color: #A0AEC0; font-size: 15px; cursor: pointer; transition: color 0.2s; }
        .player-controls-row button:hover { color: #FFFFFF; }
        .player-controls-row button.active { color: #2CE4F5 !important; }
        .btn-main-play { background: #2CE4F5 !important; color: #13161F !important; width: 34px; height: 34px; border-radius: 50%; display: flex !important; align-items: center; justify-content: center; font-size: 13px !important; }
        .player-time-indicators { font-size: 11px; color: #6A7B92; display: flex; gap: 6px; }

        .player-right-section { display: flex; align-items: center; justify-content: flex-end; gap: 15px; width: 30%; }
        .player-like-buttons { display: flex; align-items: center; gap: 12px; }
        .player-like-buttons button { background: transparent; border: none; color: #6A7B92; font-size: 14px; cursor: pointer; }
        .volume-control-wrapper { display: flex; align-items: center; gap: 8px; color: #6A7B92; }
        .volume-control-wrapper input[type="range"] { width: 80px; accent-color: #2CE4F5; cursor: pointer; }
    </style>
</head>

<body>
    <!-- 1. Navbar Global -->
    <nav class="navbar">
        <a href="{{ route('home') }}" class="nav-brand">
            <i class="fa-solid fa-compact-disc"></i> AudioFile
        </a>
        
        <div class="nav-search-container">
            <form action="{{ route('search.view') }}" method="GET" class="nav-search" id="search-form">
                <input type="text" id="search-input" name="query" value="{{ $query ?? '' }}" placeholder="Buscar canciones o artistas..." autocomplete="off" required>
                <button type="submit">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>
            <div class="search-suggestions-dropdown" id="search-suggestions"></div>
        </div>

        <div class="nav-links" id="nav-links-container"></div>
    </nav>

    <!-- 2. Cuerpo Principal -->
    <div class="app-body">
        <aside class="sidebar">
            <div>
                <div class="sidebar-group-title">Menú Principal</div>
                <ul class="sidebar-menu">
                    <li class="sidebar-item">
                        <a href="{{ route('home') }}"><i class="fa-solid fa-house"></i> Inicio</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#"><i class="fa-solid fa-compass"></i> Explorar</a>
                    </li>
                </ul>
            </div>
            <div>
                <div class="sidebar-group-title">Tu Biblioteca</div>
                <ul class="sidebar-menu">
                    <li class="sidebar-item"><a href="#"><i class="fa-solid fa-heart"></i> Favoritos</a></li>
                    <li class="sidebar-item"><a href="#"><i class="fa-solid fa-clock"></i> Recientes</a></li>
                    <li class="sidebar-item"><a href="#"><i class="fa-solid fa-user-gear"></i> Artistas</a></li>
                </ul>
            </div>
            <div>
                <div class="sidebar-group-title">Playlists</div>
                <button type="button" class="btn-create-playlist" id="btn-create-playlist"><i class="fa-solid fa-plus"></i> Crear Playlist</button>
                <ul class="sidebar-menu" style="margin-top: 10px;">
                    <li class="sidebar-item" style="padding: 10px 12px; color: #6A7B92; font-size: 12px; font-style: italic;">Sin playlists guardadas</li>
                </ul>
            </div>
        </aside>

        <!-- Contenido Central de Resultados -->
        <main class="main-content">
            <div style="margin-bottom: 30px;">
                <h1 style="font-size: 26px; font-weight: bold; margin-bottom: 5px;">Resultados de búsqueda</h1>
                <p style="color: #6A7B92; font-size: 14px;">Mostrando coincidencias para: <span style="color: #2CE4F5; font-weight: bold;">"{{ $query ?? '' }}"</span></p>
            </div>

            <!-- Loader / Sin Resultados / Resultados -->
            <div id="search-loading" style="text-align: center; padding: 40px; color: #6A7B92;">
                <i class="fa-solid fa-spinner fa-spin fa-2x"></i>
                <p style="margin-top: 10px;">Buscando coincidencias...</p>
            </div>

            <div id="no-results" style="display: none; text-align: center; padding: 50px; background: #1E2433; border-radius: 12px;">
                <i class="fa-solid fa-magnifying-glass-minus fa-3x" style="color: #6A7B92; margin-bottom: 15px;"></i>
                <h3 style="font-size: 18px; color: #fff;">No se encontraron resultados</h3>
                <p style="color: #6A7B92; font-size: 13px;">Intenta buscar con otro término o el nombre de un artista.</p>
            </div>

            <!-- Sección de Artistas -->
            <div id="artists-result-wrapper" style="display: none; margin-bottom: 40px;">
                <h2 class="section-title"><i class="fa-solid fa-user-astronaut"></i> Artistas</h2>
                <div class="card-grid" id="artists-grid"></div>
            </div>

            <!-- Sección de Canciones -->
            <div id="songs-result-wrapper" style="display: none; margin-bottom: 40px;">
                <h2 class="section-title"><i class="fa-solid fa-music"></i> Canciones</h2>
                <div class="card-grid" id="songs-grid"></div>
            </div>
        </main>
    </div>

    <!-- Reproductor de Audio Inferior -->
    <div id="audio-player-container">
        <audio id="main-audio-player" class="video-js vjs-default-skin" preload="auto"></audio>

        <div class="player-left-section">
            <img id="player-cover-preview" src="" alt="Cover" class="player-cover-img" style="display: none;">
            <div class="player-meta-info">
                <div id="player-song-title">Selecciona una canción</div>
                <div id="player-song-details">Artista • Álbum • Año</div>
            </div>
        </div>

        <div class="player-center-section">
            <div class="player-controls-row">
                <button type="button" id="btn-shuffle" title="Aleatorio"><i class="fa-solid fa-shuffle"></i></button>
                <button type="button" id="btn-prev" title="Anterior"><i class="fa-solid fa-backward-step"></i></button>
                <button type="button" id="btn-toggle-play" class="btn-main-play" title="Reproducir/Pausar"><i class="fa-solid fa-play" id="play-pause-icon"></i></button>
                <button type="button" id="btn-next" title="Siguiente"><i class="fa-solid fa-forward-step"></i></button>
                <button type="button" id="btn-repeat" title="Repetir"><i class="fa-solid fa-repeat"></i></button>
            </div>
            <div class="player-time-indicators">
                <span id="current-time-label">0:00</span> / <span id="duration-time-label">0:00</span>
            </div>
        </div>

        <div class="player-right-section">
            <div class="player-like-buttons">
                <button type="button" title="Me gusta"><i class="fa-regular fa-thumbs-up"></i></button>
                <button type="button" title="No me gusta"><i class="fa-regular fa-thumbs-down"></i></button>
            </div>
            <div class="volume-control-wrapper">
                <button type="button" id="btn-mute" style="background:transparent; border:none; color:#6A7B92; cursor:pointer; padding:0; display:flex; align-items:center;" title="Silenciar/Restaurar">
                    <i class="fa-solid fa-volume-high" id="volume-icon"></i>
                </button>
                <input type="range" id="custom-volume-slider" min="0" max="1" step="0.01" value="1">
            </div>
        </div>
    </div>

    <script src="https://vjs.zencdn.net/8.10.0/video.min.js"></script>

    <script>
        // Corregir portadas locales / relativas
        const resolveImageUrl = (url) => {
            if (!url) return '';
            // Si la URL apunta a localhost sin puerto, le inyectamos el puerto 8000 de la API
            if (url.startsWith('http://localhost/img/') || url.startsWith('http://localhost/storage/')) {
                return url.replace('http://localhost/', 'http://localhost:8000/');
            }
            if (url.startsWith('http://') || url.startsWith('https://')) return url;
            
            // Si es relativa (/img/covers/...), le anteponemos la base de la API
            const cleanBase = API_BASE_URL.replace(/\/api\/?$/, '');
            return `${cleanBase}${url.startsWith('/') ? '' : '/'}${url}`;
        };
        
        document.addEventListener("DOMContentLoaded", () => {
            const API_BASE_URL = "{{ env('API_URL', 'http://localhost:8000/api') }}";
            const searchQuery = "{{ $query ?? '' }}";

            // Lógica del menú de usuario (Navbar)
            const token = localStorage.getItem('auth_token');
            const userData = JSON.parse(localStorage.getItem('user_data') || '{}');

            // --- Lógica del menú de usuario (Navbar) ---
            const navContainer = document.getElementById('nav-links-container');
            if (navContainer) {
                const currentPath = window.location.pathname;
                let htmlLinks = '';

                if (token) {
                    const profileName = userData.name || 'Usuario';
                    const profileEmail = userData.email || '';
                    let avatarContent = userData.avatar ? `<img src="${userData.avatar}" class="profile-avatar-img" alt="Avatar">` : `<div class="profile-avatar-placeholder">${profileName.charAt(0).toUpperCase()}</div>`;
                    let dropdownAvatarContent = userData.avatar ? `<img src="${userData.avatar}" class="dropdown-avatar" alt="Avatar">` : `<div class="dropdown-avatar">${profileName.charAt(0).toUpperCase()}</div>`;

                    htmlLinks += `
                        <div class="profile-menu-container">
                            <button type="button" class="profile-avatar-btn" onclick="toggleProfileMenu(event)" aria-label="Menú de usuario">
                                ${avatarContent}
                            </button>
                            <div class="profile-dropdown" id="profileDropdownMenu">
                                <div class="profile-dropdown-header">
                                    ${dropdownAvatarContent}
                                    <div class="dropdown-user-info">
                                        <span class="dropdown-name">${profileName}</span>
                                        <span class="dropdown-email">${profileEmail}</span>
                                    </div>
                                </div>
                                <hr>
                                <a href="{{ route('profile') }}">Ver Perfil</a>
                                <hr>
                                <button type="button" id="logout-btn" class="logout-btn">Cerrar sesión</button>
                            </div>
                        </div>
                    `;
                } else {
                    htmlLinks += `<a href="{{ route('login') }}" class="${currentPath.includes('login') ? 'active' : ''}">Iniciar sesión</a>`;
                    htmlLinks += `<a href="{{ route('register') }}" class="nav-btn-action ${currentPath.includes('register') ? 'active' : ''}">Regístrate</a>`;
                }

                navContainer.innerHTML = htmlLinks;

                if (token) {
                    const logoutBtn = document.getElementById('logout-btn');
                    if (logoutBtn) {
                        logoutBtn.addEventListener('click', async () => {
                            if (confirm("¿Seguro que quieres cerrar sesión?")) {
                                try {
                                    await fetch(`${API_BASE_URL}/logout`, {
                                        method: 'POST',
                                        headers: {
                                            'Accept': 'application/json',
                                            'Authorization': `Bearer ${token}`
                                        }
                                    });
                                } catch (e) {
                                    console.error('Error al notificar cierre de sesión al servidor', e);
                                } finally {
                                    localStorage.removeItem('auth_token');
                                    localStorage.removeItem('user_data');
                                    window.location.href = "{{ route('login') }}";
                                }
                            }
                        });
                    }
                }
            }

            document.addEventListener('click', (event) => {
                const container = document.querySelector('.profile-menu-container');
                const dropdown = document.getElementById('profileDropdownMenu');
                if (container && dropdown && !container.contains(event.target)) {
                    dropdown.classList.remove('show');
                }
            });

            // Lógica del Autocompletar / Sugerencias
            const searchInput = document.getElementById('search-input');
            const searchSuggestions = document.getElementById('search-suggestions');
            let debounceTimer;

            searchInput.addEventListener('input', function () {
                const query = this.value.trim();
                clearTimeout(debounceTimer);

                if (query.length < 2) {
                    searchSuggestions.classList.remove('show');
                    searchSuggestions.innerHTML = '';
                    return;
                }

                // Debounce de 300ms para no saturar con peticiones al backend
                debounceTimer = setTimeout(() => {
                    const headers = { 'Accept': 'application/json' };
                    if (token && token !== 'undefined' && token !== 'null') {
                        headers['Authorization'] = 'Bearer ' + token;
                    }

                    fetch(`${API_BASE_URL}/search?query=${encodeURIComponent(query)}`, { headers })
                    .then(res => res.json())
                    .then(data => {
                        const songs = data.songs || data[0] || [];
                        const artists = data.artists || data[1] || [];

                        if (songs.length === 0 && artists.length === 0) {
                            searchSuggestions.classList.remove('show');
                            return;
                        }

                        let html = '';

                        // 1. Sugerencias rápidas de texto (Estilo Lupa de YT Music)
                        const textSuggestions = new Set();
                        songs.slice(0, 3).forEach(s => textSuggestions.add(s.title));
                        artists.slice(0, 2).forEach(a => textSuggestions.add(a.stage_name));

                        textSuggestions.forEach(text => {
                            const highlighted = highlightMatch(text, query);
                            html += `
                                <div class="suggestion-item" onclick="selectSearchQuery('${text.replace(/'/g, "\\'")}')">
                                    <i class="fa-solid fa-magnifying-glass suggestion-icon"></i>
                                    <div class="suggestion-info">
                                        <div class="suggestion-title">${highlighted}</div>
                                    </div>
                                </div>
                            `;
                        });

                        // 2. Resultados directos: ARTISTAS
                        artists.slice(0, 2).forEach(artist => {
                            const nameHighlighted = highlightMatch(artist.stage_name, query);
                            const firstLetter = artist.stage_name.charAt(0).toUpperCase();
                            html += `
                                <div class="suggestion-item" onclick="selectSearchQuery('${artist.stage_name.replace(/'/g, "\\'")}')">
                                    <div class="suggestion-thumb circle" style="display:flex; align-items:center; justify-content:center; background:#2CE4F5; color:#13161F; font-weight:bold;">
                                        ${firstLetter}
                                    </div>
                                    <div class="suggestion-info">
                                        <div class="suggestion-title">${nameHighlighted}</div>
                                        <div class="suggestion-subtitle">Artista</div>
                                    </div>
                                </div>
                            `;
                        });

                        // 3. Resultados directos: CANCIONES
                        songs.slice(0, 4).forEach(song => {
                            const titleHighlighted = highlightMatch(song.title, query);
                            const rawCover = song.album?.cover_url || '';
                            const cover = resolveImageUrl(rawCover);
                            const artistName = song.album?.artist?.stage_name || 'Artista';

                            html += `
                                <div class="suggestion-item" onclick="playSongFromSuggestion('${song.audio_url || ''}', '${song.title.replace(/'/g, "\\'")}', '${artistName.replace(/'/g, "\\'")}', '${(song.album?.title || '').replace(/'/g, "\\'")}', '${song.album?.release_year || '2026'}', '${cover}')">
                                    ${cover ? `<img src="${cover}" class="suggestion-thumb" alt="${song.title}" onerror="this.style.display='none'">` : `<div class="suggestion-thumb" style="background:#252D42;"></div>`}
                                    <div class="suggestion-info">
                                        <div class="suggestion-title">${titleHighlighted}</div>
                                        <div class="suggestion-subtitle">Canción • ${artistName}</div>
                                    </div>
                                </div>
                            `;
                        });

                        searchSuggestions.innerHTML = html;
                        searchSuggestions.classList.add('show');
                    })
                    .catch(err => {
                        console.error("Error al obtener sugerencias:", err);
                        searchSuggestions.classList.remove('show');
                    });
                }, 300);
            });

            // Resaltar en negrita la parte coincidente
            function highlightMatch(text, query) {
                const regex = new RegExp(`(${query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')})`, 'gi');
                return text.replace(regex, '<strong>$1</strong>');
            }

            // Ocultar dropdown al hacer clic fuera
            document.addEventListener('click', (e) => {
                if (!searchInput.contains(e.target) && !searchSuggestions.contains(e.target)) {
                    searchSuggestions.classList.remove('show');
                }
            });

            // Función para seleccionar término de búsqueda y enviar
            window.selectSearchQuery = function (term) {
                searchInput.value = term;
                searchSuggestions.classList.remove('show');
                document.getElementById('search-form').submit();
            };

            // Función para reproducir directamente una canción desde la sugerencia
            window.playSongFromSuggestion = function (audioUrl, title, artist, album, year, cover) {
                if (searchSuggestions) searchSuggestions.classList.remove('show');
                if (!audioUrl) return;

                const resolvedCover = resolveImageUrl(cover);

                playerContainer.style.display = 'flex';
                if (resolvedCover) {
                    playerCoverPreview.src = resolvedCover;
                    playerCoverPreview.style.display = 'block';
                } else {
                    playerCoverPreview.style.display = 'none';
                }
                playerSongTitle.textContent = title;
                playerSongDetails.textContent = `${artist} • ${album} • ${year}`;

                player.src({ type: 'audio/mpeg', src: audioUrl });
                player.ready(() => {
                    player.play().then(() => {
                        playPauseIcon.className = "fa-solid fa-pause";
                    }).catch(err => console.error("Error al reproducir:", err));
                });
            };

            // --- Petición a la API para cargar la vista principal de búsqueda ---
            if (searchQuery.trim() !== '') {
                const headers = { 'Accept': 'application/json' };
                if (token && token !== 'undefined' && token !== 'null') {
                    headers['Authorization'] = 'Bearer ' + token;
                }

                fetch(`${API_BASE_URL}/search?query=${encodeURIComponent(searchQuery)}`, { headers })
                .then(res => res.json())
                .then(data => {
                    document.getElementById('search-loading').style.display = 'none';

                    const songs = data.songs || data[0] || [];
                    const artists = data.artists || data[1] || [];

                    if (songs.length === 0 && artists.length === 0) {
                        document.getElementById('no-results').style.display = 'block';
                        return;
                    }

                    // Renderizar Artistas
                    if (artists.length > 0) {
                        const artistsGrid = document.getElementById('artists-grid');
                        document.getElementById('artists-result-wrapper').style.display = 'block';

                        artists.forEach(artist => {
                            artistsGrid.innerHTML += `
                                <div class="artist-card">
                                    <div class="artist-avatar-circle">
                                        ${artist.stage_name.charAt(0).toUpperCase()}
                                    </div>
                                    <div class="card-title">${artist.stage_name}</div>
                                    <div class="card-artist">Artista</div>
                                </div>
                            `;
                        });
                    }

                    // Renderizar Canciones
                    if (songs.length > 0) {
                        const songsGrid = document.getElementById('songs-grid');
                        document.getElementById('songs-result-wrapper').style.display = 'block';
                        
                        songs.forEach(song => {
                            const rawCover = song.album?.cover_url || '';
                            const cover = resolveImageUrl(rawCover);
                            const artistName = song.album?.artist?.stage_name || 'Artista';
                            const albumTitle = song.album?.title || 'Álbum';
                            const year = song.album?.release_year || '2026';

                            songsGrid.innerHTML += `
                                <div class="music-card" 
                                    data-audio="${song.audio_url || ''}"
                                    data-title="${song.title}"
                                    data-artist="${artistName}"
                                    data-album="${albumTitle}"
                                    data-year="${year}"
                                    data-cover="${cover}">
                                    <div class="card-img-wrapper">
                                        <div class="play-overlay"><i class="fa-solid fa-play"></i></div>
                                        <img src="${cover}" alt="${song.title}" style="width:100%; height:100%; object-fit:cover;" onerror="this.src='https://via.placeholder.com/150/1E2433/FFFFFF?text=Sin+Cover'">
                                    </div>
                                    <div class="card-title">${song.title}</div>
                                    <div class="card-artist">${artistName}</div>
                                </div>
                            `;
                        });
                        attachCardEvents();
                    }
                })
                .catch(err => {
                    console.error("Error al obtener resultados de búsqueda:", err);
                    document.getElementById('search-loading').style.display = 'none';
                    document.getElementById('no-results').style.display = 'block';
                });
            }

            // --- Reproductor de Audio (Video.js) ---
            const player = videojs('main-audio-player', {
                responsive: true,
                controls: true,
                controlBar: {
                    playToggle: false, currentTimeDisplay: false, progressControl: true,
                    durationDisplay: false, volumePanel: false, timeDivider: false, fullscreenToggle: false
                }
            });

            const playerContainer = document.getElementById('audio-player-container');
            const playerCoverPreview = document.getElementById('player-cover-preview');
            const playerSongTitle = document.getElementById('player-song-title');
            const playerSongDetails = document.getElementById('player-song-details');
            const btnTogglePlay = document.getElementById('btn-toggle-play');
            const playPauseIcon = document.getElementById('play-pause-icon');
            const currentTimeLabel = document.getElementById('current-time-label');
            const durationTimeLabel = document.getElementById('duration-time-label');
            const customVolumeSlider = document.getElementById('custom-volume-slider');
            const volumeIcon = document.getElementById('volume-icon');
            const btnPrev = document.getElementById('btn-prev');
            const btnRepeat = document.getElementById('btn-repeat');
            const btnMute = document.getElementById('btn-mute');

            let savedVolume = localStorage.getItem('audio_player_volume');
            let initialVol = savedVolume !== null ? parseFloat(savedVolume) : 1;

            player.ready(() => {
                player.volume(initialVol);
                customVolumeSlider.value = initialVol;
                updateVolumeIcon(initialVol);
            });

            let lastVolume = initialVol > 0 ? initialVol : 1;
            let isRepeating = false;

            function formatTime(seconds) {
                if (isNaN(seconds)) return "0:00";
                const minutes = Math.floor(seconds / 60);
                const secs = Math.floor(seconds % 60);
                return `${minutes}:${secs < 10 ? '0' : ''}${secs}`;
            }

            function updateVolumeIcon(vol) {
                if (vol == 0) volumeIcon.className = "fa-solid fa-volume-xmark";
                else volumeIcon.className = "fa-solid fa-volume-high";
            }

            function attachCardEvents() {
                document.querySelectorAll('.music-card').forEach(card => {
                    card.addEventListener('click', () => {
                        const audioUrl = card.getAttribute('data-audio');
                        const title = card.getAttribute('data-title');
                        const artist = card.getAttribute('data-artist');
                        const album = card.getAttribute('data-album');
                        const year = card.getAttribute('data-year');
                        const cover = card.getAttribute('data-cover');

                        if (!audioUrl) return;

                        playerContainer.style.display = 'flex';

                        if (cover) {
                            playerCoverPreview.src = cover;
                            playerCoverPreview.style.display = 'block';
                        }
                        if (title) playerSongTitle.textContent = title;
                        if (artist || album || year) {
                            playerSongDetails.textContent = `${artist} • ${album} • ${year}`;
                        }

                        player.src({ type: 'audio/mpeg', src: audioUrl });
                        player.ready(() => {
                            player.play().then(() => {
                                playPauseIcon.className = "fa-solid fa-pause";
                            }).catch(err => console.error("Error al reproducir:", err));
                        });
                    });
                });
            }

            btnTogglePlay.addEventListener('click', () => {
                if (player.paused()) {
                    player.play();
                    playPauseIcon.className = "fa-solid fa-pause";
                } else {
                    player.pause();
                    playPauseIcon.className = "fa-play";
                }
            });

            btnPrev.addEventListener('click', () => player.currentTime(0));

            btnRepeat.addEventListener('click', () => {
                isRepeating = !isRepeating;
                btnRepeat.classList.toggle('active', isRepeating);
            });

            player.on('ended', () => {
                if (isRepeating) {
                    player.currentTime(0);
                    player.play();
                } else {
                    playPauseIcon.className = "fa-solid fa-play";
                }
            });

            btnMute.addEventListener('click', () => {
                if (player.volume() > 0) {
                    lastVolume = player.volume();
                    player.volume(0);
                    customVolumeSlider.value = 0;
                    updateVolumeIcon(0);
                    localStorage.setItem('audio_player_volume', 0);
                } else {
                    const restoreVol = lastVolume > 0 ? lastVolume : 0.5;
                    player.volume(restoreVol);
                    customVolumeSlider.value = restoreVol;
                    updateVolumeIcon(restoreVol);
                    localStorage.setItem('audio_player_volume', restoreVol);
                }
            });

            player.on('timeupdate', () => {
                currentTimeLabel.textContent = formatTime(player.currentTime());
                durationTimeLabel.textContent = formatTime(player.duration());
            });

            customVolumeSlider.addEventListener('input', (e) => {
                const vol = parseFloat(e.target.value);
                player.volume(vol);
                if (vol > 0) lastVolume = vol;
                updateVolumeIcon(vol);
                localStorage.setItem('audio_player_volume', vol);
            });
        });

        function toggleProfileMenu(event) {
            event.stopPropagation();
            const dropdown = document.getElementById('profileDropdownMenu');
            if (dropdown) {
                dropdown.classList.toggle('show');
            }
        }
    </script>
</body>
</html>