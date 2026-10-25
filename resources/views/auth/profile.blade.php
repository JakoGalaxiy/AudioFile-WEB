<!DOCTYPE html>
    <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Mi Perfil - AudioFile</title>
            
            <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}?v=2.0">
            <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=2.0">

            <style>
                * { box-sizing: border-box; }
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
                    max-width: 420px;
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
                    margin-bottom: 25px;
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
                .input-group:focus-within { border-color: #2CE4F5; }
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
                .input-group input::placeholder { color: #6A7B92; 
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
                    margin-bottom: 15px;
                    transition: opacity 0.2s;
                }
                .register-btn:hover { opacity: 0.9; 
                }
                .logout-btn {
                    background-color: transparent;
                    color: #FF4B4B;
                    border: 1px solid rgba(255, 75, 75, 0.3);
                    width: 100%;
                    padding: 12px;
                    border-radius: 8px;
                    font-size: 14px;
                    font-weight: 600;
                    cursor: pointer;
                    transition: background-color 0.2s;
                }
                .logout-btn:hover {
                    background-color: rgba(255, 75, 75, 0.1);
                }
                .alert {
                    padding: 10px;
                    border-radius: 8px;
                    font-size: 13px;
                    text-align: center;
                    margin-bottom: 20px;
                    display: none;
                }
                .error-alert {
                    background-color: rgba(255, 75, 75, 0.1);
                    border: 1px solid rgba(255, 75, 75, 0.3);
                    color: #FF4B4B;
                }
                .success-alert {
                    background-color: rgba(44, 228, 245, 0.1);
                    border: 1px solid rgba(44, 228, 245, 0.3);
                    color: #2CE4F5;
                }
                .section-label {
                    font-size: 12px;
                    color: #6A7B92;
                    text-transform: uppercase;
                    letter-spacing: 0.5px;
                    margin: 15px 0 8px 2px;
                    font-weight: bold;
                }
            </style>
        </head>
        <body>

            <!-- Barra de Navegación Global -->
            <nav class="navbar">
                <a href="{{ route('home') }}" class="nav-brand">AudioFile</a>
                <div class="nav-links" id="nav-links-container">
                    <!-- El contenido dinámico de la navbar se inyectará aquí mediante JavaScript -->
                </div>
            </nav>

            <!-- Contenedor Principal que centra el formulario de perfil -->
            <div class="main-content">
                <div class="register-card">
                    <h2>Perfil de Usuario</h2>
                    <div class="subtitle">Gestiona tu información</div>
                    
                    <div id="error-alert" class="alert error-alert"></div>
                    <div id="success-alert" class="alert success-alert"></div>

                    <form id="profile-form">
                        <!-- Campo Nombre -->
                        <div class="section-label">Información personal</div>
                        <div class="input-group">
                            <svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                            <input type="text" id="name" placeholder="Nombre de usuario" required>
                        </div>

                        <!-- Campo Email -->
                        <div class="input-group">
                            <svg viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                            <input type="email" id="email" placeholder="Correo electrónico" required>
                        </div>
                        
                        <!-- Sección Contraseña -->
                        <div class="section-label">Change Password (Optional)</div>
                        <div class="input-group">
                            <svg viewBox="0 0 24 24"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
                            <input type="password" id="password" placeholder="Nueva contraseña">
                        </div>

                        <div class="input-group">
                            <svg viewBox="0 0 24 24"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
                            <input type="password" id="password_confirmation" placeholder="Confirma nueva contraseña">
                        </div>
                        
                        <button type="submit" id="update-btn" class="register-btn">Guardar cambios</button>
                    </form>

                    <button type="button" id="logout-btn" class="logout-btn">Cerrar sesión</button>
                </div>
            </div>

            <script>
                const API_BASE_URL = "{{ env('VITE_API_BASE_URL', 'http://127.0.0.1:8000') }}";
                const token = localStorage.getItem('auth_token'); 

                // Redirigir al login si no hay token activo
                if (!token) {
                    window.location.href = "{{ route('login') }}";
                }

                

                // Renderizado dinámico de la Barra de Navegación
                document.addEventListener("DOMContentLoaded", () => {
                    const userDataNav = JSON.parse(localStorage.getItem('user_data') || '{}');
                    const navContainer = document.getElementById('nav-links-container');

                    if (navContainer) {
                        const currentPath = window.location.pathname;
                        let htmlLinks = '';

                        if (token) {
                            const profileName = userDataNav.username || 'Mi Perfil';
                            htmlLinks += `<a href="{{ route('profile') }}" class="profile-badge ${currentPath.includes('profile') ? 'active' : ''}">${profileName}</a>`;
                        } else {
                            htmlLinks += `<a href="{{ route('login') }}" class="${currentPath.includes('login') ? 'active' : ''}">Iniciar sesión</a>`;
                            htmlLinks += `<a href="{{ route('register') }}" class="nav-btn-action ${currentPath.includes('register') ? 'active' : ''}">Regístrate</a>`;
                        }
                        navContainer.innerHTML = htmlLinks;
                    }
                });

                // Cargar datos del usuario almacenados al iniciar sesión en el formulario
                const userData = JSON.parse(localStorage.getItem('user_data') || '{}');
                if (userData.username) document.getElementById('name').value = userData.username;
                if (userData.email) document.getElementById('email').value = userData.email;

                const profileForm = document.getElementById('profile-form');
                const errorAlert = document.getElementById('error-alert');
                const successAlert = document.getElementById('success-alert');
                const updateBtn = document.getElementById('update-btn');
                const logoutBtn = document.getElementById('logout-btn');

                // Manejar actualización de perfil
                profileForm.addEventListener('submit', async (e) => {
                    e.preventDefault();
                    errorAlert.style.display = 'none';
                    successAlert.style.display = 'none';
                    updateBtn.disabled = true;
                    updateBtn.textContent = 'Updating...';

                    const username = document.getElementById('name').value;
                    const email = document.getElementById('email').value;
                    const password = document.getElementById('password').value;
                    const password_confirmation = document.getElementById('password_confirmation').value;

                    const bodyData = { username, email };
                    if (password) {
                        bodyData.password = password;
                        bodyData.password_confirmation = password_confirmation;
                    }

                    try {
                        const response = await fetch(`${API_BASE_URL}/api/user`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'Authorization': `Bearer ${token}`
                            },
                            body: JSON.stringify(bodyData)
                        });

                        const data = await response.json();
                        if (!response.ok) throw new Error(data.message || 'No se pudieron actualizar los datos.');

                        // Actualizar datos locales y refrescar el nombre en la navbar instantáneamente
                        localStorage.setItem('user_data', JSON.stringify(data.user || bodyData));
                        
                        successAlert.textContent = '¡Perfil actualizado exitosamente!';
                        successAlert.style.display = 'block';
                        document.getElementById('password').value = '';
                        document.getElementById('password_confirmation').value = '';

                        // Actualizar el texto del badge de perfil en la navbar si existe
                        const badge = document.querySelector('.profile-badge');
                        if(badge && bodyData.username) badge.textContent = `${bodyData.username}`;

                    } catch (error) {
                        errorAlert.textContent = error.message;
                        errorAlert.style.display = 'block';
                    } finally {
                        updateBtn.disabled = false;
                        updateBtn.textContent = 'Save Changes';
                    }
                });

                // Manejar cierre de sesión
                logoutBtn.addEventListener('click', async () => {
                    if (confirm("¿Seguro que quieres cerrar sesión?")) {
                        try {
                            await fetch(`${API_BASE_URL}/api/logout`, {
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
            </script>
        </body>
    </html>