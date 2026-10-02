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
                .profile-badge {
                    background-color: #151924;
                    padding: 8px 15px;
                    border-radius: 20px;
                    border: 1px solid rgba(44, 228, 245, 0.3);
                    color: #2CE4F5 !important;
                    font-weight: 600;
                    font-size: 13px;
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
                    transform: translateY(-5px);
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
                <div class="nav-links" id="nav-links-container">
                    <a href="{{ route('home') }}" class="nav-link-home">Inicio</a>
                </div>
            </nav>

            <div class="container">
                
                <!-- 1. Sección de Accesos Directos -->
                <div class="section-wrapper" id="shortcuts-section">
                    <h2 class="section-title">Accesos Directos & Recientes</h2>
                    <div class="card-grid" id="shortcuts-grid">
                        <!-- Se llenará dinámicamente vía JS -->
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

                    // Detectar en qué página estamos para marcar la clase .active
                    const currentPath = window.location.pathname;

                    let htmlLinks = `<a href="{{ route('home') }}" class="${currentPath === '/' ? 'active' : ''}">Inicio</a>`;

                    if (token) {
                        // Si hay sesión iniciada, mostrar botón de perfil
                        const profileName = userData.name || 'Mi Perfil';
                        htmlLinks += `<a href="{{ route('profile') }}" class="profile-badge ${currentPath.includes('profile') ? 'active' : ''}">👤 ${profileName}</a>`;
                    } else {
                        // Si NO hay sesión iniciada, mostrar botones de Login y Register
                        htmlLinks += `<a href="{{ route('login') }}" class="${currentPath.includes('login') ? 'active' : ''}">Log In</a>`;
                        htmlLinks += `<a href="{{ route('register') }}" class="nav-btn-action ${currentPath.includes('register') ? 'active' : ''}">Sign Up</a>`;
                    }

                    navContainer.innerHTML = htmlLinks;
                });
            </script>
            
            <!-- Prueba para el botón "Mi Perfil" - simula un token de usuario -->
            <script>
                document.addEventListener("DOMContentLoaded", () => {
                    const token = localStorage.getItem('auth_token');
                    const userData = JSON.parse(localStorage.getItem('user_data') || '{}');
                    const navContainer = document.getElementById('nav-links-container');

                    if (!navContainer) return;

                    const currentPath = window.location.pathname;

                    // Enlace de Inicio
                    let htmlLinks = `<a href="{{ route('home') }}" class="${currentPath === '/' ? 'active' : ''}">Inicio</a>`;

                    // FORZAR LA PRUEBA: Para que aparezca el boton "Mi Perfil" en la interfaz, cambiar temporalmente la condición a: if (true || token), una vez hecha la prueba, simplemente hay que quitar el "true"
                    if (token || true) { 
                        const profileName = userData.name || 'Mi Perfil';
                        
                        // Usamos la ruta de Laravel directamente para el botón de perfil
                        htmlLinks += `<a href="{{ route('profile') }}" class="profile-badge ${currentPath.includes('profile') ? 'active' : ''}">👤 ${profileName}</a>`;
                    } else {
                        htmlLinks += `<a href="{{ route('login') }}" class="${currentPath.includes('login') ? 'active' : ''}">Log In</a>`;
                        htmlLinks += `<a href="{{ route('register') }}" class="nav-btn-action ${currentPath.includes('register') ? 'active' : ''}">Sign Up</a>`;
                    }

                    navContainer.innerHTML = htmlLinks;
                });
            </script>

        </body>
    </html>