<!DOCTYPE html>
    <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Inicio - AudioFile</title>
            
            <!-- Favicon -->
            <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}?v=2.0">
            <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=2.0">

            <link href="https://vjs.zencdn.net/8.10.0/video-js.css" rel="stylesheet" />
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

            <style>
                * { 
                    box-sizing: border-box; 
                }
                body {
                    background-color: #13161F;
                    color: #FFFFFF;
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                    margin: 0;
                    padding-bottom: 50px;
                }
                /* Estilos de la Navbar */
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
                .nav-brand {
                    font-size: 20px;
                    font-weight: bold;
                    color: #2CE4F5;
                    text-decoration: none;
                }
                .nav-links {
                    display: flex;
                    gap: 20px;
                    align-items: center;
                }
                .nav-links a {
                    color: #6A7B92;
                    text-decoration: none;
                    font-size: 14px;
                    font-weight: 600;
                    transition: color 0.2s;
                }
                .nav-links a:hover, .nav-links a.active {
                    color: #FFFFFF;
                    scale: 1.05;
                }
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
                /* Estilos de la barra de búsqueda */
                .nav-search {
                    display: flex;
                    align-items: center;
                    background-color: #151924;
                    border: 1px solid rgba(44, 228, 245, 0.2);
                    border-radius: 20px;
                    padding: 6px 15px;
                    width: 300px;
                    transition: border-color 0.2s;
                }
                .nav-search:focus-within {
                    border-color: #2CE4F5;
                }
                .nav-search input {
                    background: transparent;
                    border: none;
                    color: #FFFFFF;
                    font-size: 13px;
                    width: 100%;
                    outline: none;
                }
                .nav-search input::placeholder {
                    color: #6A7B92;
                }
                .nav-search button {
                    background: transparent;
                    border: none;
                    color: #6A7B92;
                    cursor: pointer;
                    font-size: 14px;
                }
                .nav-search button:hover {
                    color: #2CE4F5;
                }
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
                /* Estilos del Avatar y Menú Desplegable */
                .profile-menu-container {
                    position: relative;
                    display: inline-block;
                }
                /* Botón exclusivo del Avatar */
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
                .profile-avatar-btn:hover {
                    border-color: #2CE4F5;
                    transform: scale(1.05);
                }
                .profile-avatar-img, .profile-avatar-placeholder {
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    background-color: #2CE4F5;
                    color: #13161F;
                    font-weight: bold;
                    font-size: 15px;
                }
                /* Menú Desplegable */
                .profile-dropdown {
                    display: none;
                    position: absolute;
                    right: 0;
                    top: 120%;
                    background-color: #1E2433;
                    border: 1px solid rgba(44, 228, 245, 0.2);
                    border-radius: 10px;
                    box-shadow: 0 8px 24px rgba(0,0,0,0.4);
                    min-width: 240px;
                    z-index: 101;
                    padding: 12px 0;
                }
                .profile-dropdown.show {
                    display: block;
                }
                .profile-dropdown-header {
                    padding: 8px 16px 12px 16px;
                    display: flex;
                    align-items: center;
                    gap: 12px;
                }
                .dropdown-avatar {
                    width: 40px;
                    height: 40px;
                    border-radius: 50%;
                    object-fit: cover;
                    background-color: #2CE4F5;
                    color: #13161F;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-weight: bold;
                }
                .dropdown-user-info {
                    display: flex;
                    flex-direction: column;
                    overflow: hidden;
                }
                .dropdown-name {
                    font-size: 14px;
                    font-weight: bold;
                    color: #FFFFFF;
                    white-space: nowrap;
                    overflow: hidden;
                    text-overflow: ellipsis;
                }
                .dropdown-email {
                    font-size: 12px;
                    color: #6A7B92;
                    white-space: nowrap;
                    overflow: hidden;
                    text-overflow: ellipsis;
                }
                .profile-dropdown hr {
                    border: none;
                    border-top: 1px solid rgba(255, 255, 255, 0.1);
                    margin: 4px 0;
                }
                .profile-dropdown a, .profile-dropdown button {
                    display: block;
                    width: 100%;
                    padding: 8px 16px;
                    color: #6A7B92;
                    text-decoration: none;
                    font-size: 13px;
                    background: none;
                    border: none;
                    text-align: left;
                    cursor: pointer;
                    transition: background-color 0.2s, color 0.2s;
                }
                .profile-dropdown a:hover, .profile-dropdown button:hover {
                    background-color: #252D42;
                    color: #FFFFFF;
                }
                .logout-btn {
                    color: #ff5c5c !important;
                }
                .logout-btn:hover {
                    background-color: rgba(255, 92, 92, 0.1) !important;
                }
                /* 2. Layout Principal de 2 Columnas */
                .app-body {
                    display: flex;
                    flex: 1;
                    overflow: hidden;
                    height: calc(100vh - 65px);
                    background-color: rgba(19, 22, 31, 0.6);
                }
                /* Sidebar Lateral Izquierda */
                .sidebar {
                    width: 240px;
                    background-color: rgba(23, 28, 40, 0.9);
                    backdrop-filter: blur(5px);
                    border-right: 1px solid rgba(44, 228, 245, 0.1);
                    display: flex;
                    flex-direction: column;
                    padding: 20px 15px;
                    gap: 25px;
                    overflow-y: auto;
                    flex-shrink: 0;
                }
                .sidebar::-webkit-scrollbar {
                    width: 4px;
                }
                .sidebar::-webkit-scrollbar-thumb {
                    background-color: #1E2433;
                    border-radius: 2px;
                }
                .sidebar-group-title {
                    font-size: 11px;
                    font-weight: 700;
                    text-transform: uppercase;
                    letter-spacing: 1px;
                    color: #6A7B92;
                    margin-bottom: 10px;
                    padding-left: 10px;
                }
                .sidebar-menu {
                    list-style: none;
                    padding: 0;
                    margin: 0;
                    display: flex;
                    flex-direction: column;
                    gap: 4px;
                }
                .sidebar-item a {
                    display: flex;
                    align-items: center;
                    gap: 12px;
                    padding: 10px 12px;
                    color: #A0AEC0;
                    text-decoration: none;
                    font-size: 13px;
                    font-weight: 600;
                    border-radius: 8px;
                    transition: all 0.2s;
                }
                .sidebar-item a:hover {
                    color: #FFFFFF;
                    background-color: rgba(30, 36, 51, 0.8);
                }
                .sidebar-item.active a {
                    color: #2CE4F5;
                    background-color: rgba(44, 228, 245, 0.1);
                    border-left: 3px solid #2CE4F5;
                }
                .btn-create-playlist {
                    width: 100%;
                    background-color: rgba(30, 36, 51, 0.7);
                    border: 1px dashed rgba(44, 228, 245, 0.3);
                    color: #2CE4F5;
                    padding: 10px;
                    border-radius: 8px;
                    font-size: 13px;
                    font-weight: 600;
                    cursor: pointer;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    gap: 8px;
                    transition: all 0.2s;
                }
                .btn-create-playlist:hover {
                    background-color: rgba(44, 228, 245, 0.15);
                    border-color: #2CE4F5;
                }

                /* Área de Contenido Central */
                .main-content {
                    flex: 1;
                    overflow-y: auto;
                    padding: 30px 40px 100px 40px;
                }
                .main-content::-webkit-scrollbar {
                    width: 6px;
                }
                .main-content::-webkit-scrollbar-thumb {
                    background-color: #1E2433;
                    border-radius: 3px;
                }
                /* Contenedor Principal */
                .container {
                    max-width: 1200px;
                    margin: 30px auto;
                    padding: 0 20px;
                }
                h2.section-title {
                    font-size: 22px;
                    margin-bottom: 15px;
                    font-weight: 700;
                    border-left: 4px solid #2CE4F5;
                    padding-left: 10px;
                }
                /* Carruseles y Grillas horizontales */
                .card-grid {
                    display: flex;
                    gap: 20px;
                    overflow-x: auto;
                    padding-bottom: 15px;
                    scroll-behavior: smooth;
                }
                .card-grid::-webkit-scrollbar {
                    height: 6px;
                }
                .card-grid::-webkit-scrollbar-thumb {
                    background-color: #1E2433;
                    border-radius: 3px;
                }
                .music-card {
                    background-color: #1E2433;
                    border-radius: 12px;
                    min-width: 180px;
                    max-width: 180px;
                    padding: 15px;
                    flex-shrink: 0;
                    box-shadow: 0 6px 20px rgba(0,0,0,0.3);
                    transition: transform 0.2s, background-color 0.2s;
                    cursor: pointer;
                }
                .music-card:hover {
                    background-color: #252D42;
                }
                .card-img-wrapper {
                    position: relative;
                    width: 100%;
                    height: 156px;
                    margin-bottom: 12px;
                    border-radius: 8px;
                    overflow: hidden;
                    background-color: rgba(21, 25, 36, 0.5);
                }
                .card-img {
                    width: 100%;
                    height: 150px;
                    background-color: #151924;
                    border-radius: 8px;
                    object-fit: cover;
                    margin-bottom: 12px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    color: #6A7B92;
                    font-size: 12px;
                }
                .play-overlay {
                    position: absolute;
                    bottom: 8px;
                    right: 8px;
                    background-color: #2CE4F5;
                    color: #13161F;
                    width: 36px;
                    height: 36px;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    opacity: 0;
                    transform: translateY(10px);
                    transition: all 0.2s ease-in-out;
                    box-shadow: 0 4px 10px rgba(0,0,0,0.4);
                }
                .music-card:hover .play-overlay {
                    opacity: 1;
                    transform: translateY(0);
                }
                .card-title {
                    font-size: 14px;
                    font-weight: bold;
                    white-space: nowrap;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    margin-bottom: 4px;
                }
                .card-artist {
                    font-size: 12px;
                    color: #6A7B92;
                    white-space: nowrap;
                    overflow: hidden;
                    text-overflow: ellipsis;
                }
                .section-wrapper {
                    margin-bottom: 40px;
                }
                /* Customización de Video.js */
                #audio-player-container {
                    position: fixed;
                    bottom: 0;
                    left: 0;
                    width: 100%;
                    height: 72px;
                    background-color: #181C27 !important;
                    border-top: 1px solid rgba(44, 228, 245, 0.15);
                    display: none; 
                    align-items: center;
                    justify-content: space-between;
                    padding: 0 16px;
                    box-shadow: 0 -4px 20px rgba(0,0,0,0.5);
                    z-index: 1000;
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
                /* Forzar que Video.js actúe como una barra de progreso superior discreta */
                .video-js {
                    position: absolute !important;
                    top: 0 !important;
                    left: 0 !important;
                    width: 100% !important;
                    height: 4px !important;
                    background-color: transparent !important;
                    font-family: inherit !important;
                }
                .video-js .vjs-control-bar {
                    display: flex !important;
                    background: transparent !important;
                    align-items: center !important;
                    height: 4px !important;
                    width: 100% !important;
                    position: absolute !important;
                    top: 0 !important;
                    padding: 0 !important;
                }
                /* Barra de progreso superior estilo línea de YouTube Music */
                .video-js .vjs-progress-control {
                    position: absolute !important;
                    top: -4px !important;
                    left: 0 !important;
                    width: 100% !important;
                    height: 6px !important;
                    cursor: pointer;
                }
                .video-js .vjs-progress-holder {
                    height: 4px !important;
                    border-radius: 0 !important;
                    background-color: rgba(255, 255, 255, 0.2) !important;
                    margin: 0 !important;
                }
                .video-js .vjs-play-progress {
                    background-color: #2CE4F5 !important;
                    border-radius: 0 !important;
                }
                .video-js .vjs-play-progress:before {
                    display: none !important;
                }
                /* Sección Izquierda: Cover y Metadatos (Artista • Álbum • Año) */
                .player-left-section {
                    display: flex;
                    align-items: center;
                    gap: 12px;
                    width: 30%;
                    min-width: 200px;
                }
                .player-cover-img {
                    width: 48px;
                    height: 48px;
                    border-radius: 4px;
                    object-fit: cover;
                    background-color: #252D42;
                }
                .player-meta-info {
                    display: flex;
                    flex-direction: column;
                    overflow: hidden;
                }
                #player-song-title {
                    font-size: 14px;
                    font-weight: bold;
                    color: #F1F1F1;
                    white-space: nowrap;
                    overflow: hidden;
                    text-overflow: ellipsis;
                }
                #player-song-details {
                    font-size: 12px;
                    color: #AAAAAA;
                    white-space: nowrap;
                    overflow: hidden;
                    text-overflow: ellipsis;
                }
                /* Sección Central: Controles de Reproducción y Tiempos */
                .player-center-section {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    gap: 4px;
                    flex: 1;
                }
                .player-controls-row {
                    display: flex;
                    align-items: center;
                    gap: 20px;
                }
                .player-controls-row button {
                    background: transparent;
                    border: none;
                    color: #A0AEC0;
                    font-size: 15px;
                    cursor: pointer;
                    transition: color 0.2s;
                }
                .player-controls-row button.active {
                    color: #2CE4F5 !important;
                }
                .player-controls-row button:hover {
                    color: #FFFFFF;
                }
                .btn-main-play {
                    background: #2CE4F5 !important;
                    color: #13161F !important;
                    width: 34px;
                    height: 34px;
                    border-radius: 50%;
                    display: flex !important;
                    align-items: center;
                    justify-content: center;
                    font-size: 13px !important;
                    transition: transform 0.1s;
                }
                .btn-main-play:hover {
                    transform: scale(1.05);
                }
                .player-time-indicators {
                    font-size: 11px;
                    color: #6A7B92;
                    display: flex;
                    gap: 6px;
                }
                /* Sección Derecha: Like/Dislike estáticos, Volumen y Tiempos */
                .player-right-section {
                    display: flex;
                    align-items: center;
                    justify-content: flex-end;
                    gap: 15px;
                    width: 30%;
                }
                .player-like-buttons {
                    display: flex;
                    align-items: center;
                    gap: 12px;
                }
                .player-like-buttons button {
                    background: transparent;
                    border: none;
                    color: #6A7B92;
                    font-size: 14px;
                    cursor: pointer;
                    transition: color 0.2s;
                }
                .player-like-buttons button:hover {
                    color: #FFFFFF;
                }
                .volume-control-wrapper {
                    display: flex;
                    align-items: center;
                    gap: 8px;
                    color: #6A7B92;
                }
                .volume-control-wrapper input[type="range"] {
                    width: 80px;
                    accent-color: #2CE4F5;
                    cursor: pointer;
                }
            </style>
        </head>

        <body>
            <!-- 1. Barra de Navegación Global -->
            <nav class="navbar">
                <a href="{{ route('home') }}" class="nav-brand">
                    <i class="fa-solid fa-compact-disc"></i> AudioFile
                </a>
                
                <div class="nav-search-container" style="position: relative;">
                    <form action="{{ route('search.view') }}" method="GET" class="nav-search" id="search-form">
                        <input type="text" id="search-input" name="query" placeholder="Buscar canciones o artistas..." autocomplete="off" required>
                        <button type="submit">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </form>
                    <!-- Menú desplegable para autocompletado en vivo -->
                    <div class="search-suggestions-dropdown" id="search-suggestions"></div>
                </div>

                <div class="nav-links" id="nav-links-container"></div>
            </nav>

            <!-- 2. Cuerpo Principal de 2 Columnas -->
            <div class="app-body">

            <!-- Sidebar Lateral -->
            <aside class="sidebar">
                <div>
                    <div class="sidebar-group-title">Menú Principal</div>
                    <ul class="sidebar-menu">
                        <li class="sidebar-item active">
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
                        <li class="sidebar-item">
                            <a href="#"><i class="fa-solid fa-heart"></i> Favoritos</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#"><i class="fa-solid fa-clock"></i> Recientes</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#"><i class="fa-solid fa-user-gear"></i> Artistas</a>
                        </li>
                    </ul>
                </div>

                <div>
                    <div class="sidebar-group-title">Playlists</div>
                    <button type="button" class="btn-create-playlist" id="btn-create-playlist">
                        <i class="fa-solid fa-plus"></i> Crear Playlist
                    </button>
                    
                    <!-- Lista limpia sin elementos de prueba estáticos -->
                    <ul class="sidebar-menu" id="user-playlists-list" style="margin-top: 10px;">
                        <li class="sidebar-item" style="padding: 10px 12px; color: #6A7B92; font-size: 12px; font-style: italic;">
                            Sin playlists guardadas
                        </li>
                    </ul>
                </div>
            </aside>

            <!-- Contenido Central -->
            <main class="main-content">
                
                <!-- 1. Accesos Directos & Recientes -->
                <div class="section-wrapper">
                    <h2 class="section-title"><i class="fa-solid fa-clock-rotate-left"></i> Accesos Directos & Recientes</h2>
                    <div class="card-grid" id="shortcut-grid">
                        @foreach($recentSongs as $song)
                            <div class="music-card" 
                                 data-audio="{{ $song->audio_url ?? '' }}"
                                 data-title="{{ $song->title }}"
                                 data-artist="{{ $song->album->artist->stage_name ?? 'Artista' }}"
                                 data-album="{{ $song->album->title ?? 'Álbum' }}"
                                 data-year="{{ $song->album->release_year ?? '2026' }}"
                                 data-cover="{{ $song->album->cover_url ?? '' }}">
                                <div class="card-img-wrapper" style="position: relative;">
                                    <div class="card-img" style="display: none;"><i class="fa-solid fa-bolt text-2xl"></i></div>
                                    <div class="play-overlay"><i class="fa-solid fa-play"></i></div>
                                    <img src="{{ $song->album->cover_url ?? '' }}" alt="{{ $song->title }}" style="width:100%; height:100%; object-fit:cover;">
                                </div>
                                <div class="card-title">{{ $song->title }}</div>
                                <div class="card-artist">{{ $song->album->artist->stage_name ?? 'Artista' }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- 2. Sección de Más Escuchados -->
                <div class="section-wrapper">
                    <h2 class="section-title"><i class="fa-solid fa-fire"></i> Lo más escuchado en la aplicación</h2>
                    <div class="card-grid" id="trending-grid">
                        @foreach($trendingSongs as $song)
                            <div class="music-card"
                                 data-audio="{{ $song->audio_url ?? '' }}"
                                 data-title="{{ $song->title }}"
                                 data-artist="{{ $song->album->artist->stage_name ?? 'Artista' }}"
                                 data-album="{{ $song->album->title ?? 'Álbum' }}"
                                 data-year="{{ $song->album->release_year ?? '2026' }}"
                                 data-cover="{{ $song->album->cover_url ?? '' }}">
                                <div class="card-img-wrapper" style="position: relative;">
                                    <div class="card-img" style="display: none;"><i class="fa-solid fa-bolt text-2xl"></i></div>
                                    <div class="play-overlay"><i class="fa-solid fa-play"></i></div>
                                    <img src="{{ $song->album->cover_url ?? '' }}" alt="{{ $song->title }}" style="width:100%; height:100%; object-fit:cover;">
                                </div>
                                <div class="card-title">{{ $song->title }}</div>
                                <div class="card-artist">{{ $song->album->artist->stage_name ?? 'Artista' }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- 3. Sección Para Ti -->
                <div class="section-wrapper" id="for-you-section">
                    <h2 class="section-title"><i class="fa-solid fa-wand-magic-sparkles"></i> Para Ti</h2>
                    <div class="card-grid" id="foryou-grid">
                        @foreach($forYouSongs as $song)
                            <div class="music-card"
                                 data-audio="{{ $song->audio_url ?? '' }}"
                                 data-title="{{ $song->title }}"
                                 data-artist="{{ $song->album->artist->stage_name ?? 'Artista' }}"
                                 data-album="{{ $song->album->title ?? 'Álbum' }}"
                                 data-year="{{ $song->album->release_year ?? '2026' }}"
                                 data-cover="{{ $song->album->cover_url ?? '' }}">
                                <div class="card-img-wrapper" style="position: relative;">
                                    <div class="card-img" style="display: none;"><i class="fa-solid fa-bolt text-2xl"></i></div>
                                    <div class="play-overlay"><i class="fa-solid fa-play"></i></div>
                                    <img src="{{ $song->album->cover_url ?? '' }}" alt="{{ $song->title }}" style="width:100%; height:100%; object-fit:cover;">
                                </div>
                                <div class="card-title">{{ $song->title }}</div>
                                <div class="card-artist">{{ $song->album->artist->stage_name ?? 'Artista' }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- 4. Canciones por Género -->
                <div class="section-wrapper">
                    <h2 class="section-title"><i class="fa-solid fa-headphones"></i> Explorar por Género: {{ $discoveryGenre->first()->album->genres->name ?? 'Género' }}</h2>
                    <div class="card-grid" id="genre-grid">
                        @foreach($discoveryGenre as $song)
                            <div class="music-card"
                                 data-audio="{{ $song->audio_url ?? '' }}"
                                 data-title="{{ $song->title }}"
                                 data-artist="{{ $song->album->artist->stage_name ?? 'Artista' }}"
                                 data-album="{{ $song->album->title ?? 'Álbum' }}"
                                 data-year="{{ $song->album->release_year ?? '2026' }}"
                                 data-cover="{{ $song->album->cover_url ?? '' }}">
                                <div class="card-img-wrapper" style="position: relative;">
                                    <div class="card-img" style="display: none;"><i class="fa-solid fa-bolt text-2xl"></i></div>
                                    <div class="play-overlay"><i class="fa-solid fa-play"></i></div>
                                    <img src="{{ $song->album->cover_url ?? asset('img/default-cover.jpg') }}" alt="{{ $song->title }}" style="width:100%; height:100%; object-fit:cover;">
                                </div>
                                <div class="card-title">{{ $song->title }}</div>
                                <div class="card-artist">{{ $song->album->artist->stage_name ?? 'Artista' }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- 4. Canciones por Artista -->
                <div class="section-wrapper">
                    <h2 class="section-title"><i class="fa-solid fa-user-ninja"></i> Explorar por Artista: {{ $discoveryArtist->first()->album->artist->stage_name ?? 'Artista' }}</h2>
                    <div class="card-grid" id="artist-grid">
                        @foreach($discoveryArtist as $song)
                            <div class="music-card"
                                 data-audio="{{ $song->audio_url ?? '' }}"
                                 data-title="{{ $song->title }}"
                                 data-artist="{{ $song->album->artist->stage_name ?? 'Artista' }}"
                                 data-album="{{ $song->album->title ?? 'Álbum' }}"
                                 data-year="{{ $song->album->release_year ?? '2026' }}"
                                 data-cover="{{ $song->album->cover_url ?? '' }}">
                                <div class="card-img-wrapper" style="position: relative;">
                                    <div class="card-img" style="display: none;"><i class="fa-solid fa-bolt text-2xl"></i></div>
                                    <div class="play-overlay"><i class="fa-solid fa-play"></i></div>
                                    <img src="{{ $song->album->cover_url ?? asset('img/default-cover.jpg') }}" alt="{{ $song->title }}" style="width:100%; height:100%; object-fit:cover;">
                                </div>
                                <div class="card-title">{{ $song->title }}</div>
                                <div class="card-artist">{{ $song->album->artist->stage_name ?? 'Artista' }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </main>

            </div>
            <!-- Reproductor de audio global en el Home con Video.js -->
            <div id="audio-player-container">
                <!-- Etiqueta de Video.js para el audio y barra superior -->
                <audio id="main-audio-player" class="video-js vjs-default-skin" preload="auto"></audio>

                <!-- 1. Izquierda: Cover y Detalles (Artista • Álbum • Año) -->
                <div class="player-left-section">
                    <img id="player-cover-preview" src="" alt="Cover" class="player-cover-img" style="display: none;">
                    <div class="player-meta-info">
                        <div id="player-song-title">Selecciona una canción</div>
                        <div id="player-song-details">Artista • Álbum • Año</div>
                    </div>
                </div>

                <!-- 2. Centro: Botones de control y tiempos -->
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

                <!-- 3. Derecha: Botones estáticos de Like/Dislike y Volumen -->
                <div class="player-right-section">
                    <div class="player-like-buttons">
                        <button type="button" title="Me gusta"><i class="fa-regular fa-thumbs-up"></i></button>
                        <button type="button" title="No me gusta"><i class="fa-regular fa-thumbs-down"></i></button>
                    </div>
                    <div class="volume-control-wrapper">
                        <button type="button" id="btn-mute" style="background:transparent; border:none; color:#6A7B92; cursor:pointer; padding:0;"><i class="fa-solid fa-volume-high" id="volume-icon"></i></button>
                        <input type="range" id="custom-volume-slider" min="0" max="1" step="0.01" value="1">
                    </div>
                </div>
            </div>

            <script src="https://vjs.zencdn.net/8.10.0/video.min.js"></script>

            <script>
                // Corregir portadas locales / relativas
                const resolveImageUrl = (url) => {
                    if (!url) return '';
                    if (url.startsWith('http://localhost/img/') || url.startsWith('http://localhost/storage/')) {
                        return url.replace('http://localhost/', 'http://localhost:8000/');
                    }
                    if (url.startsWith('http://') || url.startsWith('https://')) return url;
                    
                    const cleanBase = API_BASE_URL.replace(/\/api\/?$/, '');
                    return `${cleanBase}${url.startsWith('/') ? '' : '/'}${url}`;
                };

                // Lógica del menú de usuario (Navbar)
                document.addEventListener("DOMContentLoaded", () => {
                    const token = localStorage.getItem('auth_token');
                    const isValidToken = token && token !== 'undefined' && token !== 'null';
                    const API_BASE_URL = "{{ env('API_URL', 'http://localhost:8000/api') }}";
                    const userData = JSON.parse(localStorage.getItem('user_data') || '{}');
                    const navContainer = document.getElementById('nav-links-container');

                    if (navContainer) {
                        const currentPath = window.location.pathname;
                        let htmlLinks = '';

                        if (isValidToken) {
                            const profileName = userData.username || 'Usuario';
                            const profileEmail = userData.email || '';
                            const avatarUrl = userData.avatar_url || userData.avatar;
                            // Renderizar la imagen de avatar_url
                            let avatarContent = avatarUrl 
                                ? `<img src="${avatarUrl}" class="profile-avatar-img" alt="Avatar">` 
                                : `<div class="profile-avatar-placeholder">${profileName.charAt(0).toUpperCase()}</div>`;
                            let dropdownAvatarContent = avatarUrl 
                                ? `<img src="${avatarUrl}" class="dropdown-avatar" alt="Avatar">` 
                                : `<div class="dropdown-avatar">${profileName.charAt(0).toUpperCase()}</div>`;

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

                        if (isValidToken) {
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
                
                    // Lógica del Autocompletar / Sugerencias (Sincronizado estilo YouTube Music)
                    const searchInput = document.getElementById('search-input');
                    const searchSuggestions = document.getElementById('search-suggestions');
                    let debounceTimer;

                    if (searchInput && searchSuggestions) {
                        searchInput.addEventListener('input', function () {
                            const query = this.value.trim();
                            clearTimeout(debounceTimer);

                            if (query.length < 2) {
                                searchSuggestions.classList.remove('show');
                                searchSuggestions.innerHTML = '';
                                return;
                            }

                            debounceTimer = setTimeout(() => {
                                const headers = { 'Accept': 'application/json' };
                                if (isValidToken) {
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

                                    // 1. Sugerencias rápidas de texto
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

                        document.addEventListener('click', (e) => {
                            if (!searchInput.contains(e.target) && !searchSuggestions.contains(e.target)) {
                                searchSuggestions.classList.remove('show');
                            }
                        });
                    }

                    function highlightMatch(text, query) {
                        const regex = new RegExp(`(${query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')})`, 'gi');
                        return text.replace(regex, '<strong>$1</strong>');
                    }

                    window.selectSearchQuery = function (term) {
                        if (searchInput) searchInput.value = term;
                        if (searchSuggestions) searchSuggestions.classList.remove('show');
                        document.getElementById('search-form').submit();
                    };

                    window.playSongFromSuggestion = function (audioUrl, title, artist, album, year, cover) {
                        if (searchSuggestions) searchSuggestions.classList.remove('show');
                        if (!audioUrl) return;

                        playerContainer.style.display = 'flex';
                        if (cover) {
                            playerCoverPreview.src = cover;
                            playerCoverPreview.style.display = 'block';
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

                    // Lógica del Reproductor de Audio (Video.js)
                    const player = videojs('main-audio-player', {
                        responsive: true,
                        controls: true,
                        controlBar: {
                            playToggle: false,
                            currentTimeDisplay: false,
                            progressControl: true,
                            durationDisplay: true,
                            volumePanel: false,
                            timeDivider: false,
                            fullscreenToggle: false
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

                    // Cargar volumen guardado en localStorage o por defecto a 1
                    let savedVolume = localStorage.getItem('audio_player_volume');
                    if (savedVolume !== null) {
                        const volNum = parseFloat(savedVolume);
                        player.volume(volNum);
                        customVolumeSlider.value = volNum;
                        updateVolumeIcon(volNum);
                    } else {
                        player.volume(1);
                    }

                    let lastVolume = player.volume() || 1;
                    let isRepeating = false;

                    function formatTime(seconds) {
                        if (isNaN(seconds)) return "0:00";
                        const minutes = Math.floor(seconds / 60);
                        const secs = Math.floor(seconds % 60);
                        return `${minutes}:${secs < 10 ? '0' : ''}${secs}`;
                    }

                    function updateVolumeIcon(vol) {
                        if (vol == 0) {
                            volumeIcon.className = "fa-solid fa-volume-xmark";
                        } else {
                            volumeIcon.className = "fa-solid fa-volume-high";
                        }
                    }

                    function formatTime(seconds) {
                        if (isNaN(seconds)) return "0:00";
                        const minutes = Math.floor(seconds / 60);
                        const secs = Math.floor(seconds % 60);
                        return `${minutes}:${secs < 10 ? '0' : ''}${secs}`;
                    }

                    // Escuchar clics en las tarjetas
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

                    // Control manual del botón Play/Pause central
                    btnTogglePlay.addEventListener('click', () => {
                        if (player.paused()) {
                            player.play();
                            playPauseIcon.className = "fa-solid fa-pause";
                        } else {
                            player.pause();
                            playPauseIcon.className = "fa-solid fa-play";
                        }
                    });

                    // Botón Anterior (reinicia la canción al inicio)
                    btnPrev.addEventListener('click', () => {
                        player.currentTime(0);
                    });

                    // Botón Repetir (alternar modo bucle)
                    btnRepeat.addEventListener('click', () => {
                        isRepeating = !isRepeating;
                        if (isRepeating) {
                            btnRepeat.classList.add('active');
                        } else {
                            btnRepeat.classList.remove('active');
                        }
                    });

                    // Manejar fin de la canción (Bucle si está activo)
                    player.on('ended', () => {
                        if (isRepeating) {
                            player.currentTime(0);
                            player.play();
                        } else {
                            playPauseIcon.className = "fa-solid fa-play";
                        }
                    });

                    // Botón Silenciar / Desmutear al hacer clic en la bocina
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

                    // Actualizar tiempos dinámicamente desde Video.js
                    player.on('timeupdate', () => {
                        currentTimeLabel.textContent = formatTime(player.currentTime());
                        durationTimeLabel.textContent = formatTime(player.duration());
                    });

                    // Control de Volumen sincronizado con Video.js
                    customVolumeSlider.addEventListener('input', (e) => {
                        const vol = e.target.value;
                        player.volume(vol);
                        if (vol == 0) {
                            volumeIcon.className = "fa-solid fa-volume-xmark";
                        } else {
                            volumeIcon.className = "fa-solid fa-volume-high";
                        }
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