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

        /* Sidebar */
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

        /* Área Principal */
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

        /* Secciones */
        .content-section { padding: 30px 40px; display: none; }
        .content-section.active { display: block; }
        .section-toolbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; gap: 15px; flex-wrap: wrap; }

        .btn-action-primary {
            background: linear-gradient(to right, #2CE4F5, #67F4CE); color: #13161F;
            border: none; padding: 10px 20px; border-radius: 8px; font-weight: bold;
            font-size: 13px; cursor: pointer; display: flex; align-items: center; gap: 8px; transition: opacity 0.2s;
        }
        .btn-action-primary:hover { opacity: 0.9; }
        .btn-action-primary:disabled { opacity: 0.6; cursor: not-allowed; }

        /* Tablas */
        .data-table-wrapper { background-color: #1E2433; border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.3); overflow: hidden; }
        table.data-table { width: 100%; border-collapse: collapse; text-align: left; font-size: 14px; }
        table.data-table th { background-color: #151924; color: #6A7B92; padding: 16px 20px; font-weight: 600; font-size: 12px; text-transform: uppercase; border-bottom: 1px solid rgba(255,255,255,0.05); }
        table.data-table td { padding: 14px 20px; border-bottom: 1px solid rgba(255,255,255,0.05); color: #E2E8F0; vertical-align: middle; }
        table.data-table tr:hover { background-color: rgba(37, 45, 66, 0.5); }
        .cover-thumb { width: 42px; height: 42px; border-radius: 6px; object-fit: cover; background: #151924; }

        /* Botones de Acción de Fila */
        .btn-table-action {
            background: transparent;
            border: 1px solid transparent;
            cursor: pointer;
            font-size: 12px;
            padding: 6px 10px;
            border-radius: 6px;
            transition: all 0.2s;
            margin-right: 6px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-weight: 600;
        }
        .btn-table-edit {
            color: #2CE4F5;
            border-color: rgba(44, 228, 245, 0.3);
            background-color: rgba(44, 228, 245, 0.08);
        }
        .btn-table-edit:hover {
            background-color: rgba(44, 228, 245, 0.2);
        }
        .btn-table-delete {
            color: #FF4B4B;
            border-color: rgba(255, 75, 75, 0.3);
            background-color: rgba(255, 75, 75, 0.08);
        }
        .btn-table-delete:hover {
            background-color: rgba(255, 75, 75, 0.2);
        }

        /* Modales */
        .modal-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background-color: rgba(0,0,0,0.78); display: none;
            justify-content: center; align-items: center; z-index: 2000;
        }
        .modal-card {
            background-color: #1E2433; border-radius: 14px; width: 100%;
            max-width: 520px; padding: 32px; box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            border: 1px solid rgba(44, 228, 245, 0.2); max-height: 92vh; overflow-y: auto;
        }
        .modal-card h3 { margin-top: 0; font-size: 20px; color: #FFF; margin-bottom: 22px; display: flex; align-items: center; gap: 10px; }

        /* Formularios */
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; margin-bottom: 7px; font-size: 11px; color: #A0AEC0; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
        .form-control {
            width: 100%; background-color: #151924; border: 1px solid rgba(44, 228, 245, 0.2);
            border-radius: 8px; color: #FFF; padding: 12px 15px; font-family: inherit;
            font-size: 14px; outline: none;
        }
        .form-control:focus { border-color: #2CE4F5; }
        select.form-control {
            appearance: none;
            background-image: url('data:image/svg+xml;utf8,<svg fill="%236A7B92" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/></svg>');
            background-repeat: no-repeat; background-position: right 10px center; background-size: 20px;
        }
        .form-row { display: flex; gap: 14px; }
        .form-row .form-group { flex: 1; }

        .radio-group { display: flex; gap: 20px; margin-bottom: 10px; }
        .radio-label { display: flex; align-items: center; gap: 6px; font-size: 13px; color: #E2E8F0; cursor: pointer; }

        .modal-actions { display: flex; justify-content: flex-end; gap: 12px; margin-top: 26px; }
        .btn-secondary { background-color: transparent; color: #A0AEC0; border: 1px solid rgba(160,174,192,0.4); padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 13px; }
        .btn-secondary:hover { border-color: #A0AEC0; }

        /* Alert inline */
        .form-alert { padding: 10px 14px; border-radius: 8px; font-size: 13px; margin-bottom: 16px; display: none; }
        .form-alert.error { background: rgba(255,75,75,0.12); border: 1px solid rgba(255,75,75,0.35); color: #FF4B4B; }
        .form-alert.success { background: rgba(103,244,206,0.12); border: 1px solid rgba(103,244,206,0.35); color: #67F4CE; }

        /* Reproductor de prueba */
        #audio-preview-container { margin-top: 4px; }
        #audio-preview-container label { font-size: 11px; color: #67F4CE; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 7px; }
        #audio-player { width: 100%; height: 42px; border-radius: 8px; outline: none; background: #151924; }
    </style>
</head>
<body>

    <!-- Menú Lateral -->
    <aside class="admin-sidebar">
        <a href="{{ route('home') }}" class="admin-brand">
            <i class="fa-solid fa-compact-disc"></i>AudioFile
            <span style="font-size:11px; background:rgba(103,244,206,0.2); color:#67F4CE; padding:2px 6px; border-radius:4px;">ARTISTA</span>
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
                <div class="admin-avatar" id="artist-avatar-char">A</div>
                <div style="display:flex; flex-direction:column;">
                    <span id="artist-username-display" style="font-size:14px; font-weight:bold;">Artista</span>
                    <span id="artist-stagename-display" style="font-size:11px; color:#2CE4F5;">Nombre Artístico</span>
                </div>
            </div>
        </header>

        <!-- Sección: Álbumes -->
        <section id="albums-section" class="content-section active">
            <div class="section-toolbar">
                <p style="color:#A0AEC0; font-size:14px; margin:0;">Gestiona tus EPs, Singles y Álbumes. Crea un álbum primero para poder asignarle canciones.</p>
                <button class="btn-action-primary" onclick="openCreateAlbumModal()">
                    <i class="fa-solid fa-plus"></i> Crear Álbum
                </button>
            </div>
            <div class="data-table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Portada</th>
                            <th>Título</th>
                            <th>Tipo</th>
                            <th>Género</th>
                            <th>Lanzamiento</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="albums-table-body">
                        <tr><td colspan="6" style="text-align:center; color:#6A7B92; padding:30px;"><i class="fa-solid fa-spinner fa-spin"></i> Cargando álbumes...</td></tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Sección: Canciones -->
        <section id="songs-section" class="content-section">
            <div class="section-toolbar">
                <p style="color:#A0AEC0; font-size:14px; margin:0;">Sube archivos MPEG o enlaza una URL de audio a tus álbumes.</p>
                <button class="btn-action-primary" onclick="openCreateSongModal()">
                    <i class="fa-solid fa-cloud-arrow-up"></i> Subir Canción
                </button>
            </div>
            <div class="data-table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Álbum</th>
                            <th>Track #</th>
                            <th>Duración</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="songs-table-body">
                        <tr><td colspan="5" style="text-align:center; color:#6A7B92; padding:30px;"><i class="fa-solid fa-spinner fa-spin"></i> Cargando canciones...</td></tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <!-- Modal para Crear / Editar un álbum -->
    <div class="modal-overlay" id="album-modal">
        <div class="modal-card">
            <h3 id="album-modal-title"><i class="fa-solid fa-record-vinyl" style="color:#2CE4F5;"></i> <span id="album-modal-title-text">Crear Nuevo Álbum</span></h3>

            <div id="album-form-alert" class="form-alert error"></div>

            <form id="album-form" onsubmit="submitAlbum(event)">
                <input type="hidden" id="album-id-edit" value="">

                <div class="form-group">
                    <label>Título del Álbum / Single *</label>
                    <input type="text" class="form-control" id="album-title" required placeholder="Ej: Midnight Vibes">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Tipo de Lanzamiento *</label>
                        <select class="form-control" id="album-type" required>
                            <option value="single">Single (1 canción)</option>
                            <option value="ep">EP (2–6 canciones)</option>
                            <option value="album">Álbum (más de 6)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Género *</label>
                        <select class="form-control" id="album-genre" required>
                            <option value="">Selecciona...</option>
                            <option value="1">Pop</option>
                            <option value="2">Rock</option>
                            <option value="3">Hip Hop</option>
                            <option value="4">Reggaeton</option>
                            <option value="5">Electrónica</option>
                            <option value="6">Jazz</option>
                            <option value="7">Clásica</option>
                            <option value="8">Regional Mexicano</option>
                            <option value="9">Indie</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Portada (Imagen) <span id="album-cover-required-label">*</span></label>
                    <div class="radio-group">
                        <label class="radio-label">
                            <input type="radio" name="cover_source" value="url" checked onchange="toggleCoverSource()"> Enlace URL Externo
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="cover_source" value="file" onchange="toggleCoverSource()"> Subir Archivo Local
                        </label>
                    </div>

                    <div id="cover-url-container">
                        <input type="url" class="form-control" id="album-cover" placeholder="https://ejemplo.com/portada.jpg">
                    </div>
                    <div id="cover-file-container" style="display:none;">
                        <input type="file" id="album-cover-file" class="form-control" accept="image/*" style="padding:9px 15px;">
                    </div>
                    <small id="album-cover-current-hint" style="display:none; color:#2CE4F5; font-size:11px; margin-top:5px;"></small>
                </div>

                <div class="form-group">
                    <label>Fecha de Lanzamiento <span style="color:#6A7B92; font-weight:400;">(opcional)</span></label>
                    <input type="date" class="form-control" id="album-release-date">
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn-secondary" onclick="closeModal('album-modal')">Cancelar</button>
                    <button type="submit" class="btn-action-primary" id="album-submit-btn">
                        <i class="fa-solid fa-floppy-disk"></i> <span id="album-submit-btn-text">Guardar Álbum</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal para Crear / Editar una canción -->
    <div class="modal-overlay" id="song-modal">
        <div class="modal-card">
            <h3 id="song-modal-title"><i class="fa-solid fa-music" style="color:#67F4CE;"></i> <span id="song-modal-title-text">Subir Nueva Canción</span></h3>

            <div id="song-form-alert" class="form-alert error"></div>

            <form id="song-form" onsubmit="submitSong(event)">
                <input type="hidden" id="song-id-edit" value="">

                <div class="form-group">
                    <label>Título de la Canción *</label>
                    <input type="text" class="form-control" id="song-title" required placeholder="Ej: Luces de Neón">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Álbum Destino *</label>
                        <select class="form-control" id="song-album" required>
                            <option value="">Cargando álbumes...</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Track # <span style="color:#6A7B92; font-weight:400;">(opcional)</span></label>
                        <input type="number" class="form-control" id="song-track" min="1" placeholder="Ej: 1">
                    </div>
                </div>

                <div class="form-group">
                    <label>Fuente de Audio (MPEG) <span id="song-audio-required-label">*</span></label>
                    <div class="radio-group">
                        <label class="radio-label">
                            <input type="radio" name="audio_source" value="file" checked onchange="toggleAudioSource()"> Archivo local
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="audio_source" value="url" onchange="toggleAudioSource()"> URL externa
                        </label>
                    </div>

                    <div id="file-input-container">
                        <input type="file" id="audio-file" class="form-control" accept="audio/mpeg,audio/mp3,audio/wav,audio/ogg"
                               style="padding:9px 15px;" onchange="previewAudioFile(this)">
                    </div>
                    <div id="url-input-container" style="display:none;">
                        <input type="url" id="audio-url" class="form-control"
                               placeholder="https://ejemplo.com/audio.mp3" oninput="previewAudioUrl(this.value)">
                    </div>
                    <small id="song-audio-current-hint" style="display:none; color:#67F4CE; font-size:11px; margin-top:5px;"></small>
                </div>

                <!-- Reproductor de prueba: solo barra de progreso y volumen -->
                <div id="audio-preview-container" style="display:none;">
                    <label>Vista previa — comprueba que es el audio correcto</label>
                    <audio id="audio-player" controls controlsList="nodownload noplaybackrate">
                        <source id="audio-source-el" src="" type="audio/mpeg">
                        Tu navegador no soporta el reproductor de audio.
                    </audio>
                </div>

                <div class="form-group" style="margin-top:16px;">
                    <label>Fecha de Publicación <span style="color:#6A7B92; font-weight:400;">(opcional)</span></label>
                    <input type="date" class="form-control" id="song-date">
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn-secondary" onclick="closeModal('song-modal')">Cancelar</button>
                    <button type="submit" class="btn-action-primary" id="song-submit-btn">
                        <i class="fa-solid fa-cloud-arrow-up"></i> <span id="song-submit-btn-text">Subir y Publicar</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const API_BASE_URL = "{{ env('API_URL', 'http://localhost:8000/api') }}";
        let artistId = null;
        let myAlbums  = [];
        let mySongs   = [];

        // Inicio
        document.addEventListener("DOMContentLoaded", async () => {
            const token    = localStorage.getItem('auth_token');
            const userData = JSON.parse(localStorage.getItem('user_data') || '{}');

            if (!token || userData.role_id !== 2) {
                window.location.href = "{{ route('profile') }}";
                return;
            }

            document.getElementById('artist-username-display').textContent = userData.username || 'Artista';
            document.getElementById('artist-avatar-char').textContent = (userData.username || 'A').charAt(0).toUpperCase();

            // Obtener artist_id real desde el perfil
            try {
                const res = await fetch(`${API_BASE_URL}/user`, {
                    headers: { 'Accept': 'application/json', 'Authorization': `Bearer ${token}` }
                });
                if (res.ok) {
                    const result = await res.json();
                    const user   = result.user || result.data || result;
                    if (user?.artist) {
                        artistId = user.artist.id;
                        document.getElementById('artist-stagename-display').textContent = user.artist.stage_name || 'Artista Verificado';
                    }
                }
            } catch (e) { console.error('Error obteniendo perfil:', e); }

            // Respaldo por si aún no se tiene
            if (!artistId && userData.id) {
                try {
                    const resArt = await fetch(`${API_BASE_URL}/artists`, {
                        headers: { 'Accept': 'application/json', 'Authorization': `Bearer ${token}` }
                    });
                    if (resArt.ok) {
                        const arts = await resArt.json();
                        const list = arts.data || arts || [];
                        const mine = list.find(a => a.user_id === userData.id || a.user?.id === userData.id);
                        if (mine) {
                            artistId = mine.id;
                            document.getElementById('artist-stagename-display').textContent = mine.stage_name || 'Artista Verificado';
                        }
                    }
                } catch(err) { console.error(err); }
            }

            await loadAlbums();
            await loadSongs();

            // Cerrar modales al hacer clic fuera
            document.querySelectorAll('.modal-overlay').forEach(overlay => {
                overlay.addEventListener('click', e => {
                    if (e.target === overlay) closeModal(overlay.id);
                });
            });
        });

        // Navegación Sidebar
        function switchSection(sectionId, element) {
            document.querySelectorAll('.content-section').forEach(s => s.classList.remove('active'));
            document.querySelectorAll('.admin-menu-item').forEach(i => i.classList.remove('active'));
            document.getElementById(sectionId).classList.add('active');
            if (element) element.classList.add('active');
            const titles = { 'albums-section': 'Mis Álbumes', 'songs-section': 'Mis Canciones' };
            document.getElementById('page-title').textContent = titles[sectionId] || '';
        }

        // Modales
        function openModal(id) {
            document.getElementById(id).style.display = 'flex';
        }
        function closeModal(id) {
            document.getElementById(id).style.display = 'none';
            const player = document.getElementById('audio-player');
            if (player) player.pause();
        }

        // Cargar Álbums
        async function loadAlbums() {
            const token = localStorage.getItem('auth_token');
            const tbody = document.getElementById('albums-table-body');

            try {
                const url = artistId ? `${API_BASE_URL}/albums?artist_id=${artistId}` : `${API_BASE_URL}/albums`;
                const resA = await fetch(url, {
                    headers: { 'Accept': 'application/json', 'Authorization': `Bearer ${token}` }
                });

                if (resA.ok) {
                    const result = await resA.json();
                    myAlbums = result.data || result || [];
                    renderAlbumsTable(myAlbums);
                } else {
                    myAlbums = [];
                    tbody.innerHTML = `<tr><td colspan="6" style="text-align:center; color:#6A7B92; padding:30px;"><i class="fa-regular fa-folder-open" style="display:block; font-size:24px; margin-bottom:8px;"></i>Aún no tienes álbumes. ¡Crea el primero!</td></tr>`;
                }
            } catch (err) {
                console.error('Error al cargar álbumes:', err);
                tbody.innerHTML = `<tr><td colspan="6" style="text-align:center; color:#FF4B4B; padding:30px;"><i class="fa-solid fa-triangle-exclamation"></i> Error al conectar con el servidor.</td></tr>`;
            }
        }

        function renderAlbumsTable(albums) {
            const tbody = document.getElementById('albums-table-body');
            if (!Array.isArray(albums) || albums.length === 0) {
                tbody.innerHTML = `<tr><td colspan="6" style="text-align:center; color:#6A7B92; padding:30px;"><i class="fa-regular fa-folder-open" style="display:block; font-size:24px; margin-bottom:8px;"></i>Aún no tienes álbumes. ¡Crea el primero!</td></tr>`;
                return;
            }
            tbody.innerHTML = albums.map(a => `
                <tr>
                    <td>${a.cover_url ? `<img src="${escHtml(a.cover_url)}" class="cover-thumb" onerror="this.style.background='#2E3545'; this.src='';">` : `<div class="cover-thumb" style="background:#2E3545;"></div>`}</td>
                    <td><strong>${escHtml(a.title)}</strong></td>
                    <td><span style="color:#6A7B92;">${escHtml(a.album_type || '—')}</span></td>
                    <td>${escHtml(a.genre?.name || '—')}</td>
                    <td>${a.release_date ? escHtml(a.release_date) : '<span style="color:#6A7B92;">Sin fecha</span>'}</td>
                    <td>
                        <button class="btn-table-action btn-table-edit" onclick="openEditAlbumModal('${a.id}')" title="Editar Álbum">
                            <i class="fa-solid fa-pen-to-square"></i> Editar
                        </button>
                        <button class="btn-table-action btn-table-delete" onclick="confirmDeleteAlbum('${a.id}', '${escapeJs(a.title)}')" title="Eliminar Álbum">
                            <i class="fa-solid fa-trash-can"></i> Eliminar
                        </button>
                    </td>
                </tr>
            `).join('');
        }

        // Cargar Canciones
        async function loadSongs() {
            const token = localStorage.getItem('auth_token');
            const tbody = document.getElementById('songs-table-body');

            try {
                const res = await fetch(`${API_BASE_URL}/songs`, {
                    headers: { 'Accept': 'application/json', 'Authorization': `Bearer ${token}` }
                });
                if (res.ok) {
                    const result = await res.json();
                    const allSongs = result.data || result || [];
                    mySongs = allSongs.filter(s => s.album?.artist?.id === artistId || !artistId);
                    renderSongsTable(mySongs);
                } else {
                    tbody.innerHTML = `<tr><td colspan="5" style="text-align:center; color:#6A7B92; padding:30px;">Sin canciones aún.</td></tr>`;
                }
            } catch (err) {
                console.error('Error al cargar canciones:', err);
                tbody.innerHTML = `<tr><td colspan="5" style="text-align:center; color:#FF4B4B; padding:30px;"><i class="fa-solid fa-triangle-exclamation"></i> Error al conectar.</td></tr>`;
            }
        }

        function renderSongsTable(songs) {
            const tbody = document.getElementById('songs-table-body');
            if (!Array.isArray(songs) || songs.length === 0) {
                tbody.innerHTML = `<tr><td colspan="5" style="text-align:center; color:#6A7B92; padding:30px;"><i class="fa-regular fa-folder-open" style="display:block; font-size:24px; margin-bottom:8px;"></i>Aún no tienes canciones subidas.</td></tr>`;
                return;
            }
            tbody.innerHTML = songs.map(s => {
                const dur = s.duration_seconds ? formatDuration(s.duration_seconds) : '—';
                return `
                <tr>
                    <td><strong>${escHtml(s.title)}</strong></td>
                    <td>${escHtml(s.album?.title || '—')}</td>
                    <td style="color:#6A7B92;">${s.track_number ?? '—'}</td>
                    <td style="color:#6A7B92;">${dur}</td>
                    <td>
                        <button class="btn-table-action btn-table-edit" onclick="openEditSongModal('${s.id}')" title="Editar Canción">
                            <i class="fa-solid fa-pen-to-square"></i> Editar
                        </button>
                        <button class="btn-table-action btn-table-delete" onclick="confirmDeleteSong('${s.id}', '${escapeJs(s.title)}')" title="Eliminar Canción">
                            <i class="fa-solid fa-trash-can"></i> Eliminar
                        </button>
                    </td>
                </tr>`;
            }).join('');
        }

        // Abrir Modal Crear Álbum
        function openCreateAlbumModal() {
            document.getElementById('album-id-edit').value = '';
            document.getElementById('album-form').reset();
            document.getElementById('album-modal-title-text').textContent = 'Crear Nuevo Álbum';
            document.getElementById('album-submit-btn-text').textContent = 'Guardar Álbum';
            document.getElementById('album-cover-required-label').style.display = 'inline';
            document.getElementById('album-cover-current-hint').style.display = 'none';
            document.getElementById('album-form-alert').style.display = 'none';
            toggleCoverSource();
            openModal('album-modal');
        }

        // Abrir Modal Editar Álbum
        function openEditAlbumModal(albumIdToEdit) {
            const album = myAlbums.find(a => String(a.id) === String(albumIdToEdit));
            if (!album) return;

            document.getElementById('album-id-edit').value = album.id;
            document.getElementById('album-modal-title-text').textContent = 'Editar Álbum';
            document.getElementById('album-submit-btn-text').textContent = 'Guardar';
            document.getElementById('album-title').value = album.title || '';
            document.getElementById('album-type').value = (album.album_type || 'album').toLowerCase();
            document.getElementById('album-genre').value = album.genre?.id || '';
            document.getElementById('album-release-date').value = album.release_date || '';

            // Portada
            document.querySelector('input[name="cover_source"][value="url"]').checked = true;
            document.getElementById('album-cover').value = album.cover_url || '';
            document.getElementById('album-cover-file').value = '';
            toggleCoverSource();

            const hint = document.getElementById('album-cover-current-hint');
            if (album.cover_url) {
                hint.textContent = 'Portada actual asignada. Puedes cambiarla por URL o subiendo un nuevo archivo.';
                hint.style.display = 'block';
                document.getElementById('album-cover-required-label').style.display = 'none';
            } else {
                hint.style.display = 'none';
                document.getElementById('album-cover-required-label').style.display = 'inline';
            }

            document.getElementById('album-form-alert').style.display = 'none';
            openModal('album-modal');
        }

        // Eliminar Álbum
        async function confirmDeleteAlbum(albumIdToDelete, albumTitle) {
            const msg = `¿Estás seguro de que deseas eliminar "${albumTitle}"?\n\n¡ATENCIÓN! Al borrar un álbum se borrarán automáticamente todas las canciones que contiene. Esta acción es permanente e irreversible.`;
            if (!confirm(msg)) return;

            const token = localStorage.getItem('auth_token');

            try {
                const res = await fetch(`${API_BASE_URL}/albums/${albumIdToDelete}`, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token}`
                    }
                });

                const data = await res.json();
                if (res.ok) {
                    alert('Álbum eliminado correctamente.');
                    await loadAlbums();
                    await loadSongs();
                } else {
                    alert(data.message || 'Error al eliminar el álbum.');
                }
            } catch (err) {
                console.error('Error al eliminar álbum:', err);
                alert('No se pudo conectar con el servidor.');
            }
        }

        // Abrir Modal Crear Canción
        function openCreateSongModal() {
            document.getElementById('song-id-edit').value = '';
            document.getElementById('song-modal-title-text').textContent = 'Subir Nueva Canción';
            document.getElementById('song-submit-btn-text').textContent = 'Subir y Publicar';
            document.getElementById('song-audio-required-label').style.display = 'inline';
            document.getElementById('song-audio-current-hint').style.display = 'none';

            populateSongAlbumSelect('');

            document.getElementById('audio-preview-container').style.display = 'none';
            document.getElementById('audio-player').pause();
            document.getElementById('song-form').reset();
            document.getElementById('song-form-alert').style.display = 'none';
            toggleAudioSource();

            openModal('song-modal');
        }

        // Abrir Modal Editar Canción
        function openEditSongModal(songIdToEdit) {
            const song = mySongs.find(s => String(s.id) === String(songIdToEdit));
            if (!song) return;

            document.getElementById('song-id-edit').value = song.id;
            document.getElementById('song-modal-title-text').textContent = 'Editar Canción';
            document.getElementById('song-submit-btn-text').textContent = 'Guardar';
            document.getElementById('song-title').value = song.title || '';
            document.getElementById('song-track').value = song.track_number ?? '';

            populateSongAlbumSelect(song.album?.id || '');

            // Audio previo
            document.querySelector('input[name="audio_source"][value="url"]').checked = true;
            document.getElementById('audio-url').value = song.audio_url || '';
            document.getElementById('audio-file').value = '';
            toggleAudioSource();

            const hint = document.getElementById('song-audio-current-hint');
            if (song.audio_url) {
                hint.textContent = 'Audio actual asignado. Puedes reemplazarlo cargando un nuevo archivo o URL.';
                hint.style.display = 'block';
                document.getElementById('song-audio-required-label').style.display = 'none';
                setupAudioPreview(song.audio_url);
            } else {
                hint.style.display = 'none';
                document.getElementById('song-audio-required-label').style.display = 'inline';
            }

            document.getElementById('song-form-alert').style.display = 'none';
            openModal('song-modal');
        }

        function populateSongAlbumSelect(selectedAlbumId) {
            const sel = document.getElementById('song-album');
            sel.innerHTML = '';
            if (myAlbums.length === 0) {
                sel.innerHTML = '<option value="">Primero crea un álbum</option>';
            } else {
                sel.innerHTML = '<option value="">Selecciona un álbum...</option>';
                myAlbums.forEach(a => {
                    const opt = document.createElement('option');
                    opt.value = a.id;
                    opt.textContent = `${a.title} (${a.album_type})`;
                    if (String(a.id) === String(selectedAlbumId)) {
                        opt.selected = true;
                    }
                    sel.appendChild(opt);
                });
            }
        }

        // Eliminar Canción
        async function confirmDeleteSong(songIdToDelete, songTitle) {
            const msg = `¿Estás seguro de que deseas eliminar "${songTitle}"?\n\nEsta acción es permanente e irreversible. El álbum al que pertenece permanecerá intacto.`;
            if (!confirm(msg)) return;

            const token = localStorage.getItem('auth_token');

            try {
                const res = await fetch(`${API_BASE_URL}/songs/${songIdToDelete}`, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token}`
                    }
                });

                const data = await res.json();
                if (res.ok) {
                    alert('Canción eliminada correctamente.');
                    await loadSongs();
                } else {
                    alert(data.message || 'Error al eliminar la canción.');
                }
            } catch (err) {
                console.error('Error al eliminar canción:', err);
                alert('No se pudo conectar con el servidor.');
            }
        }

        let songDurationSeconds = 0;

        // Audio Source Toggle
        function toggleAudioSource() {
            const isFile = document.querySelector('input[name="audio_source"]:checked').value === 'file';
            document.getElementById('file-input-container').style.display = isFile ? 'block' : 'none';
            document.getElementById('url-input-container').style.display  = isFile ? 'none' : 'block';
            document.getElementById('audio-preview-container').style.display = 'none';
            document.getElementById('audio-player').pause();
            songDurationSeconds = 0;
        }

        function previewAudioFile(input) {
            if (input.files && input.files[0]) {
                const file = input.files[0];
                // Autocompletar el título con el nombre del archivo (limpiando la extensión) si está vacío
                const titleInput = document.getElementById('song-title');
                if (!titleInput.value.trim()) {
                    let cleanName = file.name.replace(/\.[^/.]+$/, ""); // quitar extensión
                    cleanName = cleanName.replace(/^[0-9]+[\s._-]+/, ""); // quitar números iniciales de pista si los tiene
                    titleInput.value = cleanName.trim();
                }
                setupAudioPreview(URL.createObjectURL(file));
            }
        }

        function previewAudioUrl(url) {
            if (url && url.startsWith('http')) {
                // Si el título está vacío, intentar extraerlo del final de la URL
                const titleInput = document.getElementById('song-title');
                if (!titleInput.value.trim()) {
                    try {
                        const parsed = new URL(url);
                        let name = parsed.pathname.split('/').pop() || '';
                        name = decodeURIComponent(name).replace(/\.[^/.]+$/, "");
                        if (name) titleInput.value = name;
                    } catch(e) {}
                }
                setupAudioPreview(url);
            }
        }

        function setupAudioPreview(srcUrl) {
            const player = document.getElementById('audio-player');
            const src    = document.getElementById('audio-source-el');
            src.src = srcUrl;
            player.load();
            document.getElementById('audio-preview-container').style.display = 'block';

            // Escuchar cuando el audio cargue los metadatos para extraer la duración exacta en segundos
            player.onloadedmetadata = function() {
                if (player.duration && !isNaN(player.duration)) {
                    songDurationSeconds = Math.round(player.duration);
                }
            };
        }

        // Subir album
        function toggleCoverSource() {
            const isUrl = document.querySelector('input[name="cover_source"]:checked').value === 'url';
            document.getElementById('cover-url-container').style.display = isUrl ? 'block' : 'none';
            document.getElementById('cover-file-container').style.display = isUrl ? 'none' : 'block';
        }

        async function submitAlbum(e) {
            e.preventDefault();
            const token   = localStorage.getItem('auth_token');
            const alertEl = document.getElementById('album-form-alert');
            const btn     = document.getElementById('album-submit-btn');
            alertEl.style.display = 'none';

            if (!artistId) {
                showAlert(alertEl, 'No se pudo determinar tu perfil de artista. Recarga la página.', 'error');
                return;
            }

            const editId = document.getElementById('album-id-edit').value;
            const isEdit = Boolean(editId);

            const isUrl = document.querySelector('input[name="cover_source"]:checked').value === 'url';
            const coverUrlInput = document.getElementById('album-cover');
            const coverFileInput = document.getElementById('album-cover-file');

            if (!isEdit) {
                if (isUrl && !coverUrlInput.value.trim()) {
                    showAlert(alertEl, 'Ingresa una URL de portada válida.', 'error');
                    return;
                }
                if (!isUrl && (!coverFileInput.files || !coverFileInput.files[0])) {
                    showAlert(alertEl, 'Selecciona una imagen de portada.', 'error');
                    return;
                }
            }

            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Guardando...';

            try {
                let res;
                const endpoint = isEdit ? `${API_BASE_URL}/albums/${editId}` : `${API_BASE_URL}/albums`;

                if (!isUrl && coverFileInput.files && coverFileInput.files[0]) {
                    const formData = new FormData();
                    if (!isEdit) formData.append('artist_id', artistId);
                    formData.append('title', document.getElementById('album-title').value.trim());
                    formData.append('album_type', (document.getElementById('album-type').value || '').toLowerCase());
                    formData.append('genre_id', parseInt(document.getElementById('album-genre').value));
                    formData.append('cover_file', coverFileInput.files[0]);
                    if (document.getElementById('album-release-date').value) {
                        formData.append('release_date', document.getElementById('album-release-date').value);
                    }
                    if (isEdit) {
                        formData.append('_method', 'PUT');
                    }

                    res = await fetch(endpoint, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': `Bearer ${token}`
                        },
                        body: formData
                    });
                } else {
                    const payload = {
                        title:        document.getElementById('album-title').value.trim(),
                        album_type:   (document.getElementById('album-type').value || '').toLowerCase(),
                        genre_id:     parseInt(document.getElementById('album-genre').value),
                        release_date: document.getElementById('album-release-date').value || null,
                    };

                    if (!isEdit) {
                        payload.artist_id = artistId;
                    }
                    if (coverUrlInput.value.trim()) {
                        payload.cover_url = coverUrlInput.value.trim();
                    }

                    res = await fetch(endpoint, {
                        method: isEdit ? 'PUT' : 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'Authorization': `Bearer ${token}`
                        },
                        body: JSON.stringify(payload)
                    });
                }

                const data = await res.json();

                if (res.ok) {
                    closeModal('album-modal');
                    document.getElementById('album-form').reset();
                    toggleCoverSource();
                    await loadAlbums();
                    await loadSongs();
                } else {
                    const msg = data.message || (data.errors ? Object.values(data.errors).flat().join(' ') : 'Error al procesar el álbum.');
                    showAlert(alertEl, msg, 'error');
                }
            } catch (err) {
                console.error('Error al guardar álbum:', err);
                showAlert(alertEl, 'No se pudo conectar con el servidor.', 'error');
            } finally {
                btn.disabled = false;
                btn.innerHTML = `<i class="fa-solid fa-floppy-disk"></i> <span>${isEdit ? 'Guardar' : 'Guardar Álbum'}</span>`;
            }
        }

        // Subir Canción (Crear o Editar)
        async function submitSong(e) {
            e.preventDefault();
            const token   = localStorage.getItem('auth_token');
            const alertEl = document.getElementById('song-form-alert');
            const btn     = document.getElementById('song-submit-btn');
            alertEl.style.display = 'none';

            const editId = document.getElementById('song-id-edit').value;
            const isEdit = Boolean(editId);

            const isFile    = document.querySelector('input[name="audio_source"]:checked').value === 'file';
            const fileInput = document.getElementById('audio-file');
            const urlInput  = document.getElementById('audio-url');

            if (!isEdit) {
                if (isFile && (!fileInput.files || !fileInput.files[0])) {
                    showAlert(alertEl, 'Selecciona un archivo de audio MPEG.', 'error');
                    return;
                }
                if (!isFile && !urlInput.value.trim()) {
                    showAlert(alertEl, 'Ingresa una URL de audio válida.', 'error');
                    return;
                }
            }

            const albumId = document.getElementById('song-album').value;
            if (!albumId) {
                showAlert(alertEl, 'Selecciona un álbum destino.', 'error');
                return;
            }

            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Guardando...';

            try {
                let res;
                const endpoint = isEdit ? `${API_BASE_URL}/songs/${editId}` : `${API_BASE_URL}/songs`;

                if (isFile && fileInput.files && fileInput.files[0]) {
                    const formData = new FormData();
                    formData.append('album_id', albumId);
                    formData.append('title', document.getElementById('song-title').value.trim());
                    formData.append('audio_file', fileInput.files[0]);
                    if (songDurationSeconds) {
                        formData.append('duration_seconds', songDurationSeconds);
                    }
                    if (document.getElementById('song-track').value) {
                        formData.append('track_number', document.getElementById('song-track').value);
                    }
                    if (isEdit) {
                        formData.append('_method', 'PUT');
                    }

                    res = await fetch(endpoint, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': `Bearer ${token}`
                        },
                        body: formData
                    });
                } else {
                    const payload = {
                        album_id: albumId,
                        title: document.getElementById('song-title').value.trim(),
                        track_number: document.getElementById('song-track').value || null,
                    };

                    if (urlInput.value.trim()) {
                        payload.audio_url = urlInput.value.trim();
                    }
                    if (songDurationSeconds) {
                        payload.duration_seconds = songDurationSeconds;
                    }

                    res = await fetch(endpoint, {
                        method: isEdit ? 'PUT' : 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'Authorization': `Bearer ${token}`
                        },
                        body: JSON.stringify(payload)
                    });
                }

                const data = await res.json();
                if (res.ok) {
                    closeModal('song-modal');
                    await loadSongs();
                } else {
                    const msg = data.message || (data.errors ? Object.values(data.errors).flat().join(' ') : 'Error al procesar la canción.');
                    showAlert(alertEl, msg, 'error');
                }
            } catch (err) {
                console.error('Error al guardar canción:', err);
                showAlert(alertEl, 'No se pudo conectar con el servidor.', 'error');
            } finally {
                btn.disabled = false;
                btn.innerHTML = `<i class="fa-solid fa-cloud-arrow-up"></i> <span>${isEdit ? 'Guardar' : 'Subir y Publicar'}</span>`;
            }
        }

        // Utilidades
        function showAlert(el, msg, type = 'error') {
            el.className = `form-alert ${type}`;
            el.textContent = msg;
            el.style.display = 'block';
        }

        function escHtml(text) {
            if (!text) return '';
            const d = document.createElement('div');
            d.textContent = String(text);
            return d.innerHTML;
        }

        function escapeJs(text) {
            if (!text) return '';
            return String(text).replace(/\\/g, '\\\\').replace(/'/g, "\\'").replace(/"/g, '&quot;');
        }

        function formatDuration(seconds) {
            const m = Math.floor(seconds / 60);
            const s = seconds % 60;
            return `${m}:${String(s).padStart(2, '0')}`;
        }
    </script>
</body>
</html>