<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Artista - AudioFile</title>
    
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}?v=2.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * { box-sizing: border-box; }
        body {
            background-color: #13161F; color: #FFFFFF;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0; display: flex; height: 100vh; overflow: hidden;
        }
        
        /* Sidebar (Replicado del Admin) */
        .admin-sidebar {
            width: 260px; background-color: #1A1F2C;
            border-right: 1px solid rgba(44, 228, 245, 0.1);
            display: flex; flex-direction: column; padding: 20px 15px; flex-shrink: 0;
        }
        .admin-brand {
            font-size: 20px; font-weight: bold; color: #2CE4F5;
            text-decoration: none; display: flex; align-items: center;
            gap: 10px; margin-bottom: 30px; padding-left: 10px;
        }
        .sidebar-section-title {
            font-size: 11px; font-weight: 700; text-transform: uppercase;
            letter-spacing: 1px; color: #6A7B92; margin: 15px 0 10px 10px;
        }
        .admin-menu { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 5px; }
        .admin-menu-item a {
            display: flex; align-items: center; gap: 12px; padding: 12px 15px;
            color: #A0AEC0; text-decoration: none; font-size: 14px; font-weight: 600;
            border-radius: 8px; transition: all 0.2s; cursor: pointer;
        }
        .admin-menu-item a:hover { color: #FFFFFF; background-color: rgba(30, 36, 51, 0.8); }
        .admin-menu-item.active a { color: #13161F; background: linear-gradient(to right, #2CE4F5, #67F4CE); font-weight: bold; }
        
        /* Área Principal y Header */
        .admin-main { flex: 1; display: flex; flex-direction: column; overflow-y: auto; }
        .admin-header {
            background-color: #1E2433; padding: 15px 30px; display: flex;
            justify-content: space-between; align-items: center;
            border-bottom: 1px solid rgba(44, 228, 245, 0.1);
        }
        .admin-header-title { font-size: 20px; font-weight: 700; }
        .admin-user-profile { display: flex; align-items: center; gap: 12px; }
        .admin-avatar {
            width: 38px; height: 38px; border-radius: 50%; background-color: #67F4CE;
            color: #13161F; display: flex; align-items: center; justify-content: center; font-weight: bold;
        }

        /* Secciones y Tablas */
        .content-section { padding: 30px 40px; display: none; }
        .content-section.active { display: block; }
        .section-toolbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; gap: 15px; }
        
        .btn-action-primary {
            background: linear-gradient(to right, #2CE4F5, #67F4CE); color: #13161F;
            border: none; padding: 10px 20px; border-radius: 8px; font-weight: bold;
            font-size: 13px; cursor: pointer; display: flex; align-items: center; gap: 8px; transition: opacity 0.2s;
        }
        .btn-action-primary:hover { opacity: 0.9; }

        .data-table-wrapper { background-color: #1E2433; border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.3); overflow: hidden; }
        table.data-table { width: 100%; border-collapse: collapse; text-align: left; font-size: 14px; }
        table.data-table th { background-color: #151924; color: #6A7B92; padding: 16px 20px; font-weight: 600; font-size: 12px; text-transform: uppercase; border-bottom: 1px solid rgba(255, 255, 255, 0.05); }
        table.data-table td { padding: 16px 20px; border-bottom: 1px solid rgba(255, 255, 255, 0.05); color: #E2E8F0; }
        table.data-table tr:hover { background-color: rgba(37, 45, 66, 0.5); }

        /* Modales adaptados para Formularios */
        .modal-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background-color: rgba(0, 0, 0, 0.75); display: none;
            justify-content: center; align-items: center; z-index: 2000;
        }
        .modal-card {
            background-color: #1E2433; border-radius: 12px; width: 100%;
            max-width: 500px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            border: 1px solid rgba(44, 228, 245, 0.2); max-height: 90vh; overflow-y: auto;
        }
        .modal-card h3 { margin-top: 0; font-size: 20px; color: #FFF; margin-bottom: 20px; }
        
        /* Controles de Formulario Oscuros */
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 8px; font-size: 12px; color: #A0AEC0; font-weight: 600; text-transform: uppercase; }
        .form-control {
            width: 100%; background-color: #151924; border: 1px solid rgba(44, 228, 245, 0.2);
            border-radius: 8px; color: #FFF; padding: 12px 15px; font-family: inherit; font-size: 14px; outline: none; box-sizing: border-box;
        }
        .form-control:focus { border-color: #2CE4F5; }
        select.form-control { appearance: none; background-image: url('data:image/svg+xml;utf8,<svg fill="%236A7B92" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/></svg>'); background-repeat: no-repeat; background-position: right 10px center; background-size: 20px; }
        
        .radio-group { display: flex; gap: 15px; margin-bottom: 10px; }
        .radio-label { display: flex; align-items: center; gap: 5px; font-size: 13px; color: #E2E8F0; cursor: pointer; }

        .modal-actions { display: flex; justify-content: flex-end; gap: 12px; margin-top: 25px; }
        .btn-secondary { background-color: transparent; color: #A0AEC0; border: 1px solid #A0AEC0; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 13px; }
        
        /* Reproductor HTML5 Simple */
        audio {
            width: 100%; height: 40px; margin-top: 10px; outline: none; border-radius: 8px;
        }
        audio::-webkit-media-controls-panel { background-color: #151924; }
        audio::-webkit-media-controls-play-button,
        audio::-webkit-media-controls-mute-button { filter: invert(1); }
        audio::-webkit-media-controls-current-time-display,
        audio::-webkit-media-controls-time-remaining-display { color: #FFF; }
    </style>
</head>
<body>

    <!-- Menú Lateral -->
    <aside class="admin-sidebar">
        <a href="{{ route('home') }}" class="admin-brand">
            <i class="fa-solid fa-compact-disc"></i>AudioFile <span style="font-size:11px; background:rgba(103, 244, 206, 0.2); color:#67F4CE; padding:2px 6px; border-radius:4px;">ARTISTA</span>
        </a>

        <div class="sidebar-section-title">Mi Contenido</div>
        <ul class="admin-menu">
            <li class="admin-menu-item active" onclick="switchSection('albums-section', this)">
                <a><i class="fa-solid fa-record-vinyl"></i> Mis Álbumes</a>
            </li>
            <li class="admin-menu-item" onclick="switchSection('songs-section', this)">
                <a><i class="fa-solid fa-music"></i> Mis Canciones</a>
            </li>
        </ul>
    </aside>

    <!-- Área Principal -->
    <main class="admin-main">
        <header class="admin-header">
            <div class="admin-header-title" id="page-title">Mis Álbumes</div>
            <div class="admin-user-profile">
                <div class="admin-avatar" id="artist-avatar-char">U</div>
                <div style="display:flex; flex-direction:column;">
                    <span id="artist-username-display" style="font-size:14px; font-weight:bold;">Usuario</span>
                    <span id="artist-stagename-display" style="font-size:11px; color:#2CE4F5;">Nombre Artístico</span>
                </div>
            </div>
        </header>

        <!-- Seccion: Álbumes -->
        <section id="albums-section" class="content-section active">
            <div class="section-toolbar">
                <p style="color: #A0AEC0; font-size: 14px;">Gestiona tus EPs, Singles y Álbumes. Recuerda crear un álbum primero para poder asignarle canciones.</p>
                <button class="btn-action-primary" onclick="openModal('album-modal')"><i class="fa-solid fa-plus"></i> Crear Álbum</button>
            </div>
            <div class="data-table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Portada</th>
                            <th>Título</th>
                            <th>Tipo</th>
                            <th>Género</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody id="albums-table-body">
                        <!-- Llenado dinámico -->
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Seccion: Canciones -->
        <section id="songs-section" class="content-section">
            <div class="section-toolbar">
                <p style="color: #A0AEC0; font-size: 14px;">Sube tus archivos de audio MPEG o enlaza una URL.</p>
                <button class="btn-action-primary" onclick="openModal('song-modal')"><i class="fa-solid fa-cloud-arrow-up"></i> Subir Canción</button>
            </div>
            <div class="data-table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Álbum</th>
                            <th>Género</th>
                            <th>Reproducciones</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="songs-table-body">
                        <!-- Llenado dinámico -->
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <!-- MODAL: CREAR ÁLBUM -->
    <div class="modal-overlay" id="album-modal">
        <div class="modal-card">
            <h3><i class="fa-solid fa-record-vinyl"></i> Crear Nuevo Álbum</h3>
            <form id="album-form" onsubmit="submitAlbum(event)">
                <div class="form-group">
                    <label>Título del Álbum / Single</label>
                    <input type="text" class="form-control" required placeholder="Ej: Midnight Vibes">
                </div>
                <div class="form-group">
                    <label>Tipo de Lanzamiento</label>
                    <select class="form-control" required>
                        <option value="Single">Single (1 Canción)</option>
                        <option value="EP">EP (2-6 Canciones)</option>
                        <option value="Album">Álbum (Más de 6 Canciones)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Género Principal</label>
                    <input type="text" class="form-control" required placeholder="Ej: Synthpop, Reggaeton, Rock...">
                </div>
                <div class="form-group">
                    <label>Portada (Imagen)</label>
                    <input type="file" class="form-control" accept="image/*" required style="padding: 9px 15px;">
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn-secondary" onclick="closeModal('album-modal')">Cancelar</button>
                    <button type="submit" class="btn-action-primary">Guardar Álbum</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL: SUBIR CANCIÓN -->
    <div class="modal-overlay" id="song-modal">
        <div class="modal-card">
            <h3><i class="fa-solid fa-music"></i> Subir Nueva Canción</h3>
            <form id="song-form" onsubmit="submitSong(event)">
                
                <div class="form-group">
                    <label>Título de la Canción</label>
                    <input type="text" class="form-control" id="song-title" required placeholder="Ej: Luces de Neón">
                </div>

                <div class="form-group">
                    <label>Seleccionar Álbum Destino</label>
                    <select class="form-control" id="song-album" required>
                        <option value="">Selecciona un álbum previamente creado...</option>
                        <!-- Se llenará con JS -->
                        <option value="1">Midnight Vibes (EP)</option>
                    </select>
                </div>

                <div style="display:flex; gap: 15px;">
                    <div class="form-group" style="flex: 1;">
                        <label>Género</label>
                        <input type="text" class="form-control" id="song-genre" placeholder="Ej: Pop">
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label>Fecha de Publicación</label>
                        <input type="date" class="form-control" id="song-date">
                    </div>
                </div>

                <div class="form-group">
                    <label>Fuente del Audio (MPEG)</label>
                    <div class="radio-group">
                        <label class="radio-label">
                            <input type="radio" name="audio_source" value="file" checked onchange="toggleAudioSource()"> Subir Archivo Local
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="audio_source" value="url" onchange="toggleAudioSource()"> Enlace URL Externo
                        </label>
                    </div>

                    <!-- Input Archivo -->
                    <div id="file-input-container">
                        <input type="file" id="audio-file" class="form-control" accept="audio/mpeg, audio/mp3" style="padding: 9px 15px;" onchange="previewAudioFile(this)">
                    </div>

                    <!-- Input URL -->
                    <div id="url-input-container" style="display:none;">
                        <input type="url" id="audio-url" class="form-control" placeholder="https://ejemplo.com/audio.mp3" onchange="previewAudioUrl(this.value)">
                    </div>
                </div>

                <!-- Reproductor de Prueba Simple -->
                <div class="form-group" id="audio-preview-container" style="display: none;">
                    <label style="color:#67F4CE;">Vista Previa del Audio</label>
                    <audio id="audio-player" controls>
                        <source id="audio-source" src="" type="audio/mpeg">
                        Tu navegador no soporta el reproductor de audio.
                    </audio>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn-secondary" onclick="closeModal('song-modal')">Cancelar</button>
                    <button type="submit" class="btn-action-primary">Subir y Publicar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const token = localStorage.getItem('auth_token');
            const userData = JSON.parse(localStorage.getItem('user_data') || '{}');

            // Validar que sea Artista (role_id == 2)
            if (!token || userData.role_id !== 2) {
                window.location.href = "/perfil"; // O donde prefieras redirigir a no autorizados
                return;
            }

            // Datos del Header
            document.getElementById('artist-username-display').textContent = userData.username || 'Artista';
            document.getElementById('artist-stagename-display').textContent = userData.stage_name || 'Artista Verificado';
            document.getElementById('artist-avatar-char').textContent = (userData.username || 'A').charAt(0).toUpperCase();
        });

        // Alternar vistas Sidebar
        function switchSection(sectionId, element) {
            document.querySelectorAll('.content-section').forEach(sec => sec.classList.remove('active'));
            document.querySelectorAll('.admin-menu-item').forEach(item => item.classList.remove('active'));

            document.getElementById(sectionId).classList.add('active');
            if (element) element.classList.add('active');

            const titles = {
                'albums-section': 'Mis Álbumes',
                'songs-section': 'Mis Canciones'
            };
            document.getElementById('page-title').textContent = titles[sectionId];
        }

        // Manejo de Modales
        function openModal(id) { document.getElementById(id).style.display = 'flex'; }
        function closeModal(id) { 
            document.getElementById(id).style.display = 'none'; 
            // Pausar audio si se cierra
            const audioPlayer = document.getElementById('audio-player');
            if(audioPlayer) audioPlayer.pause();
        }

        // Alternar entre Archivo y URL
        function toggleAudioSource() {
            const isFile = document.querySelector('input[name="audio_source"]:checked').value === 'file';
            document.getElementById('file-input-container').style.display = isFile ? 'block' : 'none';
            document.getElementById('url-input-container').style.display = isFile ? 'none' : 'block';
            
            // Limpiar preview
            document.getElementById('audio-preview-container').style.display = 'none';
            document.getElementById('audio-player').pause();
        }

        // Previsualizar Archivo Local
        function previewAudioFile(input) {
            if (input.files && input.files[0]) {
                const url = URL.createObjectURL(input.files[0]);
                setupAudioPreview(url);
            }
        }

        // Previsualizar URL
        function previewAudioUrl(url) {
            if (url) setupAudioPreview(url);
        }

        // Cargar audio en el reproductor simple
        function setupAudioPreview(srcUrl) {
            const container = document.getElementById('audio-preview-container');
            const player = document.getElementById('audio-player');
            const source = document.getElementById('audio-source');
            
            source.src = srcUrl;
            player.load(); // Recargar con la nueva fuente
            container.style.display = 'block';
        }

        // Simular Envío de Álbum (Aquí meterás tu Fetch API)
        function submitAlbum(e) {
            e.preventDefault();
            alert("Lógica para enviar Álbum al backend...");
            closeModal('album-modal');
        }

        // Simular Envío de Canción (Aquí meterás tu Fetch API)
        function submitSong(e) {
            e.preventDefault();
            alert("Lógica para subir el archivo/URL de la canción al backend...");
            closeModal('song-modal');
        }
    </script>
</body>
</html>