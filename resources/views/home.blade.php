<!DOCTYPE html>
    <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Inicio - AudioFile</title>
            
            <!-- Favicon -->
            <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}?v=2.0">
            <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=2.0">

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
                }
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
                .card-title {
                    font-size: 14px;
                    font-weight: bold;
                    white-space: nowrap;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    margin-bottom: 4px;
                }
                .card-subtitle {
                    font-size: 12px;
                    color: #6A7B92;
                    white-space: nowrap;
                    overflow: hidden;
                    text-overflow: ellipsis;
                }
                .section-wrapper {
                    margin-bottom: 40px;
                }
            </style>
        </head>
        <body>

            <!-- Barra de Navegación Global -->
            <nav class="navbar">
                <a href="{{ route('home') }}" class="nav-brand">AudioFile</a>
                
                <form action="#" method="GET" class="nav-search">
                    <input type="text" name="query" placeholder="Buscar canciones o artistas" required>
                    <button type="submit">
                        <img src="{{ asset('images/nav-search.svg') }}" alt="Buscar" width="20" height="20">
                    </button>
                </form>

                <div class="nav-links" id="nav-links-container">
                    <a href="{{ route('home') }}" class="nav-link-home">Inicio</a>
                </div>
            </nav>

            <div class="container">
                <div class="section-wrapper">
                    <h2 class="section-title">Accesos Directos & Recientes</h2>
                    <div class="card-grid">
                        <div class="music-card">
                            <div class="card-img">Sin conexión</div>
                            <div class="card-title">Cargando...</div>
                            <div class="card-subtitle">Favoritos / Recientes</div>
                        </div>
                    </div>
                </div>

                <!-- 2. Sección de Más Escuchados -->
                <div class="section-wrapper">
                    <h2 class="section-title">Lo más escuchado en la aplicación</h2>
                    <div class="card-grid" id="trending-grid">
                        <div class="music-card">
                            <div class="card-img">Trending</div>
                            <div class="card-title">Popular Track</div>
                            <div class="card-subtitle">Global Hits</div>
                        </div>
                    </div>
                </div>

                <!-- 3. Sección Para Ti -->
                <div class="section-wrapper" id="for-you-section">
                    <h2 class="section-title">Para Ti (Basado en tus gustos)</h2>
                    <div class="card-grid" id="foryou-grid">
                        <div class="music-card">
                            <div class="card-img">Recomendado</div>
                            <div class="card-title">Mix Personal</div>
                            <div class="card-subtitle">Basado en historial</div>
                        </div>
                    </div>
                </div>

                <!-- 4. Canciones en General por Género o Artistas -->
                <div class="section-wrapper">
                    <h2 class="section-title">Explorar por Género: Lo-Fi</h2>
                    <div class="card-grid" id="genre-lofi-grid">
                        <div class="music-card">
                            <div class="card-img">Lo-Fi</div>
                            <div class="card-title">Chill Beats</div>
                            <div class="card-subtitle">Lo-Fi Artist</div>
                        </div>
                    </div>
                </div>

                <div class="section-wrapper">
                    <h2 class="section-title">Explorar por Artista: Poerter Robinson</h2>
                    <div class="card-grid" id="artist-moeshop-grid">
                        <div class="music-card">
                            <div class="card-img">Porter Robinson</div>
                            <div class="card-title">Shelter</div>
                            <div class="card-subtitle">Porter Robinson</div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener("DOMContentLoaded", () => {
                    const token = localStorage.getItem('auth_token');
                    const userData = JSON.parse(localStorage.getItem('user_data') || '{}');
                    const navContainer = document.getElementById('nav-links-container');

                    if (!navContainer) return;

                    const currentPath = window.location.pathname;
                    let htmlLinks = `<a href="{{ route('home') }}" class="${currentPath === '/' ? 'active' : ''}">Inicio</a>`;

                    if (token) {
                        const profileName = userData.name || 'Usuario';
                        const profileEmail = userData.email || 'usuario@audiofile.com';
                        
                        // Generar avatar local o inicial si no existe imagen subida
                        let avatarContent = '';
                        let dropdownAvatarContent = '';

                        if (userData.avatar) {
                            // Si el avatar es una ruta de archivo local almacenada en el servidor o app
                            avatarContent = `<img src="${userData.avatar}" class="profile-avatar-img" alt="Avatar">`;
                            dropdownAvatarContent = `<img src="${userData.avatar}" class="dropdown-avatar" alt="Avatar">`;
                        } else {
                            // Fallback con la inicial del nombre si no hay foto de perfil subida
                            const initial = profileName.charAt(0).toUpperCase();
                            avatarContent = `<div class="profile-avatar-placeholder">${initial}</div>`;
                            dropdownAvatarContent = `<div class="dropdown-avatar">${initial}</div>`;
                        }

                        // Renderizar únicamente el avatar como botón interactivo
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
                                    <button type="button" class="logout-btn" onclick="confirmLogout()">Cerrar sesión</button>
                                </div>
                            </div>
                        `;
                    } else {
                        htmlLinks += `<a href="{{ route('login') }}" class="${currentPath.includes('login') ? 'active' : ''}">Iniciar sesión</a>`;
                        htmlLinks += `<a href="{{ route('register') }}" class="nav-btn-action ${currentPath.includes('register') ? 'active' : ''}">Regístrate</a>`;
                    }

                    navContainer.innerHTML = htmlLinks;

                    // Cerrar el menú si se hace clic fuera de él
                    document.addEventListener('click', (event) => {
                        const container = document.querySelector('.profile-menu-container');
                        const dropdown = document.getElementById('profileDropdownMenu');
                        if (container && dropdown && !container.contains(event.target)) {
                            dropdown.classList.remove('show');
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

                function confirmLogout() {
                    if (confirm("¿Seguro que quieres cerrar sesión?")) {
                        localStorage.removeItem('auth_token');
                        localStorage.removeItem('user_data');
                        window.location.href = "{{ route('login') }}";
                    }
                }
            </script>
        </body>
    </html>