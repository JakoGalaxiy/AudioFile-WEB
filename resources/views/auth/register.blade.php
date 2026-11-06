<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regístrate - AudioFile</title>

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}?v=2.0">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=2.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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
        /* Estilo para el Logo AudioFile */
        .login-logo {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 50%;
            margin: 0 auto 16px auto;
            display: block;
            box-shadow: 0 4px 15px rgba(44, 228, 245, 0.2);
        }
        .subtitle {
            text-align: center;
            color: #6A7B92;
            font-size: 14px;
            margin-bottom: 24px;
        }
        .error-alert {
            background-color: rgba(255, 75, 75, 0.1);
            border: 1px solid rgba(255, 75, 75, 0.3);
            color: #FF4B4B;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 13px;
            text-align: center;
            margin-bottom: 20px;
            display: none;
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
        .register-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
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
        /* Botones de selección de tipo de cuenta (Oyente / Artista) */
        .role-toggle-container {
            display: flex;
            background-color: #151924;
            border-radius: 8px;
            padding: 4px;
            margin-bottom: 20px;
        }
        .role-toggle-btn {
            flex: 1;
            background: transparent;
            border: none;
            color: #6A7B92;
            padding: 10px;
            font-size: 13px;
            font-weight: 700;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.25s ease;
        }
        .role-toggle-btn.active {
            background: linear-gradient(to right, #2CE4F5, #67F4CE);
            color: #13161F;
            box-shadow: 0 2px 8px rgba(44, 228, 245, 0.3);
        }
        /* Contenedor relativo para la sugerencia de nombres artísticos existentes */
        .artist-input-wrapper {
            position: relative;
            width: 100%;
        }
        .artist-suggestions-dropdown {
            display: none;
            position: absolute;
            top: calc(100% + 4px);
            left: 0;
            width: 100%;
            background-color: #181C27;
            border: 1px solid rgba(44, 228, 245, 0.3);
            border-radius: 8px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.6);
            z-index: 50;
            max-height: 180px;
            overflow-y: auto;
        }
        .artist-suggestions-dropdown.show {
            display: block;
        }
        .artist-suggestion-item {
            padding: 10px 14px;
            font-size: 13px;
            color: #FFFFFF;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: background-color 0.2s;
        }
        .artist-suggestion-item:hover {
            background-color: #252D42;
        }
        .claim-tag {
            font-size: 10px;
            background-color: rgba(44, 228, 245, 0.15);
            color: #2CE4F5;
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: bold;
        }
        .stage-status-msg {
            font-size: 12px;
            margin-top: 4px;
            margin-bottom: 8px;
            display: none;
            padding-left: 5px;
        }
        .stage-status-msg.available {
            color: #67F4CE;
        }
        .stage-status-msg.exists {
            color: #FFC107;
        }
        .stage-status-msg.error {
            color: #FF4B4B;
        }
    </style>
</head>
<body>

    <!-- Barra de Navegación Global -->
    <nav class="navbar">
        <a href="{{ route('home') }}" class="nav-brand">
            <i class="fa-solid fa-compact-disc"></i> AudioFile
        </a>
    </nav>

    <!-- Contenedor principal que centra la tarjeta -->
    <div class="main-content">
        <div class="register-card">
            <img src="{{ asset('images/AudioFile.jpeg') }}" alt="AudioFile Logo" class="login-logo">
            <h2>Crear cuenta</h2>
            <div class="subtitle">Regístrate para empezar a escuchar contenido</div>

            <div id="alertMessage" class="error-alert"></div>

            <!-- Botones de Conmutación (Oyente / Artista) -->
            <div class="role-toggle-container">
                <button type="button" class="role-toggle-btn active" id="btnRoleOyente" onclick="setRegisterRole('oyente')">
                    <i class="fa-solid fa-headphones"></i> Oyente
                </button>
                <button type="button" class="role-toggle-btn" id="btnRoleArtista" onclick="setRegisterRole('artista')">
                    <i class="fa-solid fa-microphone-lines"></i> Artista
                </button>
            </div>

            <form id="registerForm">
                <!-- Campo oculto para definir el tipo de cuenta enviada -->
                <input type="hidden" name="account_type" id="accountTypeInput" value="oyente">

                <!-- Campo adicional para el Nombre Artístico (Se muestra dinámicamente) -->
                <div id="artistFieldGroup" class="artist-input-wrapper" style="display: none; margin-bottom: 16px;">
                    <div class="input-group">
                        <svg viewBox="0 0 24 24"><path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/></svg>
                        <input type="text" name="stage_name" id="stageNameInput" placeholder="Nombre artístico" autocomplete="off">
                    </div>
                    
                    <!-- Mensaje de disponibilidad / sugerencias -->
                    <div id="stageStatusMsg" class="stage-status-msg"></div>
                    <div id="artistSuggestions" class="artist-suggestions-dropdown"></div>
                </div>

                <div class="input-group">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                    <input type="text" name="username" placeholder="Nombre de usuario" required>
                </div>

                <div class="input-group">
                    <svg viewBox="0 0 24 24">
                        <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                    </svg>
                    <input type="email" name="email" placeholder="Correo electrónico" required>
                </div>
                
                <div class="input-group">
                    <svg viewBox="0 0 24 24">
                        <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
                    </svg>
                    <input type="password" name="password" placeholder="Contraseña" required>
                </div>

                <div class="input-group">
                    <svg viewBox="0 0 24 24">
                        <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
                    </svg>
                    <input type="password" name="password_confirmation" placeholder="Confirma contraseña" required>
                </div>
                
                <button type="submit" class="register-btn" id="submitBtn">Regístrate</button>
                
                <div class="footer-links">
                    ¿Ya tienes una cuenta? <a href="{{ route('login') }}" class="login-link">Iniciar sesión</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        const apiUrl = "{{ env('API_URL', 'http://localhost:8000/api') }}";
        let isArtistAvailable = true;
        let debounceTimer;

        // Cambiar entre tipo Oyente y Artista
        function setRegisterRole(role) {
            const btnOyente = document.getElementById('btnRoleOyente');
            const btnArtista = document.getElementById('btnRoleArtista');
            const artistFieldGroup = document.getElementById('artistFieldGroup');
            const stageNameInput = document.getElementById('stageNameInput');
            const accountTypeInput = document.getElementById('accountTypeInput');

            accountTypeInput.value = role;

            if (role === 'artista') {
                btnArtista.classList.add('active');
                btnOyente.classList.remove('active');
                artistFieldGroup.style.display = 'block';
                stageNameInput.required = true;
                stageNameInput.focus();
            } else {
                btnOyente.classList.add('active');
                btnArtista.classList.remove('active');
                artistFieldGroup.style.display = 'none';
                stageNameInput.required = false;
                stageNameInput.value = '';
                document.getElementById('stageStatusMsg').style.display = 'none';
                document.getElementById('artistSuggestions').classList.remove('show');
                isArtistAvailable = true;
            }
        }

        // Búsqueda interactiva en tiempo real para verificar el nombre artístico (stage_name)
        document.addEventListener('DOMContentLoaded', () => {
            const stageNameInput = document.getElementById('stageNameInput');
            const stageStatusMsg = document.getElementById('stageStatusMsg');
            const artistSuggestions = document.getElementById('artistSuggestions');

            stageNameInput.addEventListener('input', function() {
                const query = this.value.trim();
                clearTimeout(debounceTimer);

                if (query.length < 2) {
                    stageStatusMsg.style.display = 'none';
                    artistSuggestions.classList.remove('show');
                    isArtistAvailable = true;
                    return;
                }

                debounceTimer = setTimeout(async () => {
                    try {
                        const res = await fetch(`${apiUrl}/search?query=${encodeURIComponent(query)}`);
                        const data = await res.json();
                        const artists = data.artists || [];

                        // Verificar si existe una coincidencia exacta
                        const exactMatch = artists.find(a => (a.stage_name || '').toLowerCase() === query.toLowerCase());

                        if (exactMatch) {
                            if (!exactMatch.user_id) {
                                stageStatusMsg.className = 'stage-status-msg exists';
                                stageStatusMsg.innerHTML = '<i class="fa-solid fa-circle-info"></i> El nombre existe sin usuario asociado. Podrás reclamarlo al enviar tu solicitud.';
                                stageStatusMsg.style.display = 'block';
                                isArtistAvailable = true;
                            } else {
                                stageStatusMsg.className = 'stage-status-msg error';
                                stageStatusMsg.innerHTML = '<i class="fa-solid fa-circle-xmark"></i> Este nombre artístico ya está registrado por otro usuario.';
                                stageStatusMsg.style.display = 'block';
                                isArtistAvailable = false;
                            }
                        } else {
                            stageStatusMsg.className = 'stage-status-msg available';
                            stageStatusMsg.innerHTML = '<i class="fa-solid fa-circle-check"></i> Nombre artístico disponible.';
                            stageStatusMsg.style.display = 'block';
                            isArtistAvailable = true;
                        }

                        // Desplegar sugerencias de coincidencia parcial
                        if (artists.length > 0) {
                            let html = '';
                            artists.forEach(a => {
                                const tag = !a.user_id ? '<span class="claim-tag">Disponible para reclamar</span>' : '<span style="font-size:10px; color:#6A7B92;">Registrado</span>';
                                html += `
                                    <div class="artist-suggestion-item" onclick="selectArtistSuggestion('${(a.stage_name || '').replace(/'/g, "\\'")}')">
                                        <span>${a.stage_name}</span>
                                        ${tag}
                                    </div>
                                `;
                            });
                            artistSuggestions.innerHTML = html;
                            artistSuggestions.classList.add('show');
                        } else {
                            artistSuggestions.classList.remove('show');
                        }

                    } catch (e) {
                        console.error("Error al verificar nombre artístico", e);
                    }
                }, 300);
            });

            document.addEventListener('click', (e) => {
                if (!stageNameInput.contains(e.target) && !artistSuggestions.contains(e.target)) {
                    artistSuggestions.classList.remove('show');
                }
            });
        });

        function selectArtistSuggestion(name) {
            const stageNameInput = document.getElementById('stageNameInput');
            stageNameInput.value = name;
            document.getElementById('artistSuggestions').classList.remove('show');
            stageNameInput.dispatchEvent(new Event('input'));
        }

        // Envío del Formulario
        document.getElementById('registerForm').addEventListener('submit', async function(e) {
            e.preventDefault(); 

            const alertBox = document.getElementById('alertMessage');
            const submitBtn = document.getElementById('submitBtn');
            alertBox.style.display = 'none';

            const accountType = document.getElementById('accountTypeInput').value;

            if (accountType === 'artista' && !isArtistAvailable) {
                alertBox.style.display = 'block';
                alertBox.innerText = 'El nombre artístico ingresado ya pertenece a otro usuario registrado.';
                return;
            }

            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());

            if (accountType === 'artista' && (!data.stage_name || !data.stage_name.trim())) {
                alertBox.style.display = 'block';
                alertBox.innerText = 'Por favor ingresa un nombre artístico.';
                return;
            }

            if (data.password !== data.password_confirmation) {
                alertBox.style.display = 'block';
                alertBox.innerText = 'Las contraseñas no coinciden.';
                return;
            }

            const originalBtnText = submitBtn.innerText;
            submitBtn.innerText = 'Cargando...';
            submitBtn.disabled = true;

            try {
                const response = await fetch(`${apiUrl}/register`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json' 
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (response.ok) {
                    const token = result.token || result.access_token;
                    if (token) {
                        localStorage.setItem('auth_token', token);
                    }
                    if (result.user) {
                        localStorage.setItem('user_data', JSON.stringify(result.user));
                    }

                    // Redirección directa al inicio con sesión activa
                    window.location.href = "/";
                } else {
                    let errorMessage = result.message || 'Verifica los datos ingresados.';
                    if (result.errors) {
                        const firstKey = Object.keys(result.errors)[0];
                        if (firstKey && result.errors[firstKey].length > 0) {
                            errorMessage = result.errors[firstKey][0];
                        }
                    }
                    alertBox.style.display = 'block';
                    alertBox.innerText = errorMessage;
                }
            } catch (error) {
                console.error('Error:', error);
                alertBox.style.display = 'block';
                alertBox.innerText = 'No se pudo conectar con la API.';
            } finally {
                submitBtn.innerText = originalBtnText;
                submitBtn.disabled = false;
            }
        });
    </script>
</body>
</html>
