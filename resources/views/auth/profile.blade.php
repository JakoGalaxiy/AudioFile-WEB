<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - AudioFile</title>

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
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
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
        .nav-links a:hover,
        .nav-links a.active {
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
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
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
        .register-btn:hover {
            opacity: 0.9;
        }
        .logout-btn {
            background-color: transparent;
            color: #FF4B4B;
            border: 1px solid #FF4B4B;
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }
        .logout-btn:hover {
            background-color: rgba(255, 75, 75, 0.1);
        }
        .alert {
            padding: 12px;
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
    </style>
</head>
<body>
    <!-- Barra de Navegación Global -->
    <nav class="navbar">
        <a href="{{ route('home') }}" class="nav-brand">AudioFile</a>
        <div class="nav-links" id="nav-auth-links">
            <!-- Renderizado dinámico vía JavaScript -->
        </div>
    </nav>

    <!-- Contenedor principal que centra la tarjeta -->
    <div class="main-content">
        <div class="register-card">
            <h2>Perfil de Usuario</h2>
            <div class="subtitle">Gestiona tu información</div>

            <div id="error-alert" class="alert error-alert"></div>
            <div id="success-alert" class="alert success-alert"></div>

            <div id="artist-request-status-card" style="display: none; margin-bottom: 20px; padding: 15px; border-radius: 10px; font-size: 13px; line-height: 1.4;"></div>

            <form id="profile-form">
                <div class="input-group">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                    <input type="text" id="name" placeholder="Nombre de usuario" required>
                </div>

                <div class="input-group">
                    <svg viewBox="0 0 24 24">
                        <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                    </svg>
                    <input type="email" id="email" placeholder="Correo electrónico" required>
                </div>

                <div class="input-group">
                    <svg viewBox="0 0 24 24">
                        <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
                    </svg>
                    <input type="password" id="password" placeholder="Nueva contraseña (opcional)">
                </div>

                <div class="input-group">
                    <svg viewBox="0 0 24 24">
                        <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
                    </svg>
                    <input type="password" id="password_confirmation" placeholder="Confirmar nueva contraseña">
                </div>

                <button type="submit" id="update-btn" class="register-btn">Actualizar Perfil</button>
                <button type="button" id="logout-btn" class="logout-btn">Cerrar Sesión</button>
            </form>
        </div>
    </div>

    <script>
        const API_BASE_URL = "{{ env('API_URL', 'http://localhost:8000') }}";
        const token = localStorage.getItem('auth_token');

        // Redirigir a inicio de sesión si no hay sesión activa
        if (!token) {
            window.location.href = "{{ route('login') }}";
        }

        // Configurar Barra de Navegación según el estado de la sesión
        document.addEventListener("DOMContentLoaded", () => {
            const navContainer = document.getElementById('nav-auth-links');
            const userDataNav = JSON.parse(localStorage.getItem('user_data') || '{}');

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

            // Función para consultar el estado de las peticiones de artista
            (async () => {
                const token = localStorage.getItem('auth_token');
                if (!token) return;

                try {
                    const res = await fetch(`${API_BASE_URL}/user`, {
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': `Bearer ${token}`
                        }
                    });

                    if (res.ok) {
                        const result = await res.json();
                        // Extrae el usuario de forma segura sin sobreescribir el formulario de edición
                        const user = result.user || result.data || result;

                        if (user) {
                            // Actualiza solo la tarjeta de estado de artista
                            renderArtistRequestStatus(user.artist);
                        }
                    }
                } catch (err) {
                    console.error("Error al obtener estado de artista:", err);
                }
            })();
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
                if (badge && bodyData.username) badge.textContent = `${bodyData.username}`;

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

        function renderArtistRequestStatus(artistData) {
            const statusCard = document.getElementById('artist-request-status-card');
            if (!statusCard) return;

            if (!artistData) {
                statusCard.style.display = 'none';
                return;
            }

            const status = artistData.verification_status;
            const stageName = artistData.stage_name || '';
            const reason = artistData.rejection_reason ? `<br><strong>Motivo:</strong> ${artistData.rejection_reason}` : '';

            statusCard.style.display = 'block';

            if (status === 'pending') {
                statusCard.style.backgroundColor = 'rgba(44, 228, 245, 0.15)';
                statusCard.style.border = '1px solid rgba(44, 228, 245, 0.4)';
                statusCard.style.color = '#2CE4F5';
                statusCard.innerHTML = `
                    <div style="font-weight: bold; margin-bottom: 4px;"><i class="fa-solid fa-clock"></i> Estado: Pendiente</div>
                    Tu solicitud está bajo revisión por un Administrador. Por favor, espera mientras verificamos tus datos.
                `;
            } else if (status === 'verified') {
                statusCard.style.backgroundColor = 'rgba(103, 244, 206, 0.15)';
                statusCard.style.border = '1px solid rgba(103, 244, 206, 0.4)';
                statusCard.style.color = '#67F4CE';
                statusCard.innerHTML = `
                    <div style="font-weight: bold; margin-bottom: 4px;"><i class="fa-solid fa-circle-check"></i> Estado: Verificado</div>
                    Tu solicitud ha sido aceptada por un Administrador. ¡Bienvenido <strong>${stageName}</strong> como Artista!
                `;
            } else if (status === 'rejected') {
                statusCard.style.backgroundColor = 'rgba(255, 75, 75, 0.15)';
                statusCard.style.border = '1px solid rgba(255, 75, 75, 0.4)';
                statusCard.style.color = '#FF4B4B';
                statusCard.innerHTML = `
                    <div style="font-weight: bold; margin-bottom: 4px;"><i class="fa-solid fa-circle-xmark"></i> Estado: Rechazado</div>
                    Tu solicitud ha sido rechazada por un Administrador. ${reason}
                `;
            }
        }

document.addEventListener("DOMContentLoaded", () => {
    // Consultar el estado del usuario/artista al cargar la página
    fetchArtistStatus();
});

async function fetchArtistStatus() {
    const token = localStorage.getItem('auth_token');
    if (!token) return;

    const API_BASE_URL = "{{ env('API_URL', 'http://localhost:8000/api') }}";

    try {
        const response = await fetch(`${API_BASE_URL}/user`, {
            headers: {
                'Accept': 'application/json',
                'Authorization': `Bearer ${token}`
            }
        });

        if (response.ok) {
            const result = await response.json();
            const user = result.user || result.data || result;

            if (user) {
                // Dibujar el estado en la tarjeta
                renderArtistRequestStatus(user.artist);
            }
        }
    } catch (error) {
        console.error("Error al consultar estado de artista:", error);
    }
}

function renderArtistRequestStatus(artistData) {
    const statusCard = document.getElementById('artist-request-status-card');
    if (!statusCard) return;

    // Si no ha hecho solicitud de artista, se mantiene oculto
    if (!artistData) {
        statusCard.style.display = 'none';
        return;
    }

    const status = artistData.verification_status;
    const stageName = artistData.stage_name || '';

    statusCard.style.display = 'block';

    if (status === 'pending') {
        statusCard.style.backgroundColor = 'rgba(44, 228, 245, 0.15)';
        statusCard.style.border = '1px solid rgba(44, 228, 245, 0.4)';
        statusCard.style.color = '#2CE4F5';
        statusCard.innerHTML = `
            <div style="font-weight: bold; margin-bottom: 4px;"><i class="fa-solid fa-clock"></i> Estado: Pendiente de revisión</div>
            Tu solicitud para el nombre artístico <strong>${stageName}</strong> está bajo revisión por un Administrador.
        `;
    } else if (status === 'verified') {
        statusCard.style.backgroundColor = 'rgba(103, 244, 206, 0.15)';
        statusCard.style.border = '1px solid rgba(103, 244, 206, 0.4)';
        statusCard.style.color = '#67F4CE';
        statusCard.innerHTML = `
            <div style="font-weight: bold; margin-bottom: 4px;"><i class="fa-solid fa-circle-check"></i> Estado: Verificado</div>
            ¡Felicidades! Tu solicitud ha sido aprobada. Ahora eres formalmente el artista <strong>${stageName}</strong>.
        `;
    } else if (status === 'rejected' || status === 'rejected') {
        statusCard.style.backgroundColor = 'rgba(255, 75, 75, 0.15)';
        statusCard.style.border = '1px solid rgba(255, 75, 75, 0.4)';
        statusCard.style.color = '#FF4B4B';
        statusCard.innerHTML = `
            <div style="font-weight: bold; margin-bottom: 4px;"><i class="fa-solid fa-circle-xmark"></i> Estado: Rechazado</div>
            Tu solicitud para ser artista fue rechazada. El nombre artístico ha sido liberado.
        `;
    }
}
    </script>
</body>
</html>
