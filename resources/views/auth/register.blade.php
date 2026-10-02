<!DOCTYPE html>
    <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Registrarse - AudioFile</title>

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
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    min-height: 100vh;
                    margin: 0;
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
                /* Contenedor principal para centrar la tarjeta debajo de la barra */
                .main-content {
                    flex: 1;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    width: 100%;
                    padding: 20px;
                }
                .register-card {
                    background-color: #1E2433;
                    padding: 40px 35px;
                    border-radius: 16px;
                    width: 100%;
                    max-width: 400px;
                    box-shadow: 0 10px 30px rgba(0,0,0,0.4);
                }
                .register-card h2 {
                    text-align: center;
                    margin: 0 0 10px 0;
                    font-size: 26px;
                    font-weight: 700;
                }
                .subtitle {
                    text-align: center;
                    color: #6A7B92;
                    font-size: 14px;
                    margin-bottom: 30px;
                }
                .input-group {
                    background-color: #151924;
                    border-radius: 8px;
                    display: flex;
                    align-items: center;
                    padding: 0 15px;
                    margin-bottom: 16px;
                    border: 1px solid transparent;
                    transition: border-color 0.3s ease;
                }
                .input-group:focus-within {
                    border-color: #2CE4F5;
                }
                .input-group svg {
                    width: 20px;
                    height: 20px;
                    fill: #6A7B92;
                    margin-right: 12px;
                    flex-shrink: 0;
                }
                .input-group input {
                    background: transparent;
                    border: none;
                    color: #FFFFFF;
                    padding: 16px 0;
                    width: 100%;
                    font-size: 14px;
                    outline: none;
                }
                .input-group input::placeholder {
                    color: #6A7B92;
                }
                input:-webkit-autofill,
                input:-webkit-autofill:hover, 
                input:-webkit-autofill:focus, 
                input:-webkit-autofill:active {
                    -webkit-box-shadow: 0 0 0 30px #151924 inset !important;
                    -webkit-text-fill-color: #FFFFFF !important;
                    transition: background-color 5000s ease-in-out 0s;
                }
                .register-btn {
                    background: linear-gradient(to right, #2CE4F5, #67F4CE);
                    color: #13161F;
                    border: none;
                    width: 100%;
                    padding: 14px;
                    border-radius: 8px;
                    font-size: 15px;
                    font-weight: bold;
                    cursor: pointer;
                    margin-top: 10px;
                    margin-bottom: 25px;
                    transition: opacity 0.2s;
                }
                .register-btn:hover {
                    opacity: 0.9;
                }
                .footer-links {
                    text-align: center;
                    font-size: 13px;
                    color: #6A7B92;
                }
                .login-link {
                    color: #13B4E3;
                    text-decoration: none;
                    font-weight: 600;
                    margin-left: 5px;
                }
                .login-link:hover {
                    text-decoration: underline;
                }
            </style>
        </head>
        <body>

            <!-- Barra de Navegación Global (Añadida) -->
            <nav class="navbar">
                <a href="{{ route('home') }}" class="nav-brand">AudioFile</a>
                <div class="nav-links" id="nav-links-container">
                    <a href="{{ route('home') }}" class="nav-link-home">Inicio</a>
                </div>
            </nav>

            <!-- Contenedor principal que centra la tarjeta -->
            <div class="main-content">
                <div class="register-card">
                    <h2>Create Account</h2>
                    <div class="subtitle">Join us to start listening</div>
                    
                    <form action="#" method="POST">
                        
                        <!-- Campo Nombre -->
                        <div class="input-group">
                            <svg viewBox="0 0 24 24">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                            <input type="text" name="name" placeholder="Full Name" required>
                        </div>

                        <!-- Campo Email -->
                        <div class="input-group">
                            <svg viewBox="0 0 24 24">
                                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                            </svg>
                            <input type="email" name="email" placeholder="Email Address" required>
                        </div>
                        
                        <!-- Campo Contraseña -->
                        <div class="input-group">
                            <svg viewBox="0 0 24 24">
                                <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
                            </svg>
                            <input type="password" name="password" placeholder="Password" required>
                        </div>

                        <!-- Confirmar Contraseña -->
                        <div class="input-group">
                            <svg viewBox="0 0 24 24">
                                <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
                            </svg>
                            <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
                        </div>
                        
                        <button type="submit" class="register-btn">Sign Up</button>
                        
                        <div class="footer-links">
                            Already have an account? <a href="{{ route('login') }}" class="login-link">Log In</a>
                        </div>
                    </form>
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
                        const profileName = userData.name || 'Mi Perfil';
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