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

        /* ── Sidebar ── */
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

        /* ── Secciones ── */
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

        /* ── Tablas ── */
        .data-table-wrapper { background-color: #1E2433; border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.3); overflow: hidden; }
        table.data-table { width: 100%; border-collapse: collapse; text-align: left; font-size: 14px; }
        table.data-table th { background-color: #151924; color: #6A7B92; padding: 16px 20px; font-weight: 600; font-size: 12px; text-transform: uppercase; border-bottom: 1px solid rgba(255,255,255,0.05); }
        table.data-table td { padding: 14px 20px; border-bottom: 1px solid rgba(255,255,255,0.05); color: #E2E8F0; vertical-align: middle; }
        table.data-table tr:hover { background-color: rgba(37, 45, 66, 0.5); }
        .cover-thumb { width: 42px; height: 42px; border-radius: 6px; object-fit: cover; background: #151924; }

        /* ── Modales ── */
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

        /* ── Formularios ── */
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

        /* ── Alert inline ── */
        .form-alert { padding: 10px 14px; border-radius: 8px; font-size: 13px; margin-bottom: 16px; display: none; }
        .form-alert.error { background: rgba(255,75,75,0.12); border: 1px solid rgba(255,75,75,0.35); color: #FF4B4B; }
        .form-alert.success { background: rgba(103,244,206,0.12); border: 1px solid rgba(103,244,206,0.35); color: #67F4CE; }

        /* ── Reproductor de prueba ── */
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
                <button class="btn-action-primary" onclick="openModal('album-modal')">
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
                        </tr>
                    </thead>
                    <tbody id="albums-table-body">
                        <tr><td colspan="5" style="text-align:center; color:#6A7B92; padding:30px;"><i class="fa-solid fa-spinner fa-spin"></i> Cargando álbumes...</td></tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Sección: Canciones -->
        <section id="songs-section" class="content-section">
            <div class="section-toolbar">
                <p style="color:#A0AEC0; font-size:14px; margin:0;">Sube archivos MPEG o enlaza una URL de audio a tus álbumes.</p>
                <button class="btn-action-primary" onclick="openSongModal()">
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
                        </tr>
                    </thead>
                    <tbody id="songs-table-body">
                        <tr><td colspan="4" style="text-align:center; color:#6A7B92; padding:30px;"><i class="fa-solid fa-spinner fa-spin"></i> Cargando canciones...</td></tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <!-- ═══════════════════════════════════════════════
         MODAL: CREAR ÁLBUM
    ═══════════════════════════════════════════════ -->
    <div class="modal-overlay" id="album-modal">
        <div class="modal-card">
            <h3><i class="fa-solid fa-record-vinyl" style="color:#2CE4F5;"></i> Crear Nuevo Álbum</h3>

            <div id="album-form-alert" class="form-alert error"></div>

            <form id="album-form" onsubmit="submitAlbum(event)">
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
                    <label>Portada (Imagen) *</label>
                    <div class="radio-group">
                        <label class="radio-label">
                            <input type="radio" name="cover_source" value="file" onchange="toggleCoverSource()"> Subir Archivo Local
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="cover_source" value="url" checked onchange="toggleCoverSource()"> Enlace URL Externo
                        </label>
                    </div>

                    <div id="cover-url-container">
                        <input type="url" class="form-control" id="album-cover" placeholder="https://ejemplo.com/portada.jpg">
                    </div>
                    <div id="cover-file-container" style="display:none;">
                        <input type="file" id="album-cover-file" class="form-control" accept="image/*" style="padding:9px 15px;">
                    </div>
                </div>

                <div class="form-group">
                    <label>Fecha de Lanzamiento <span style="color:#6A7B92; font-weight:400;">(opcional)</span></label>
                    <input type="date" class="form-control" id="album-release-date">
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn-secondary" onclick="closeModal('album-modal')">Cancelar</button>
                    <button type="submit" class="btn-action-primary" id="album-submit-btn">
                        <i class="fa-solid fa-floppy-disk"></i> Guardar Álbum
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ═══════════════════════════════════════════════
         MODAL: SUBIR CANCIÓN
    ═══════════════════════════════════════════════ -->
    <div class="modal-overlay" id="song-modal">
        <div class="modal-card">
            <h3><i class="fa-solid fa-music" style="color:#67F4CE;"></i> Subir Nueva Canción</h3>

            <div id="song-form-alert" class="form-alert error"></div>

            <form id="song-form" onsubmit="submitSong(event)">
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
                    <label>Fuente de Audio (MPEG) *</label>
                    <div class="radio-group">
                        <label class="radio-label">
                            <input type="radio" name="audio_source" value="file" checked onchange="toggleAudioSource()"> Archivo local
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="audio_source" value="url" onchange="toggleAudioSource()"> Enlace URL externo
                        </label>
                    </div>

                    <div id="file-input-container">
                        <input type="file" id="audio-file" class="form-control" accept="audio/mpeg,audio/mp3"
                               style="padding:9px 15px;" onchange="previewAudioFile(this)">
                    </div>
                    <div id="url-input-container" style="display:none;">
                        <input type="url" id="audio-url" class="form-control"
                               placeholder="https://ejemplo.com/audio.mp3" oninput="previewAudioUrl(this.value)">
                    </div>
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
                        <i class="fa-solid fa-cloud-arrow-up"></i> Subir y Publicar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const API_BASE_URL = "{{ env('API_URL', 'http://localhost:8000/api') }}";
        let artistId = null;
        let myAlbums  = [];

        // ── Inicio ──────────────────────────────────────────────────────
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

            // Si por alguna razón no se obtuvo aún, intentar obtenerlo de la tabla de artistas
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

            loadAlbums();
            loadSongs();

            // Cerrar modales al hacer clic fuera
            document.querySelectorAll('.modal-overlay').forEach(overlay => {
                overlay.addEventListener('click', e => {
                    if (e.target === overlay) closeModal(overlay.id);
                });
            });
        });

        // ── Navegación Sidebar ───────────────────────────────────────────
        function switchSection(sectionId, element) {
            document.querySelectorAll('.content-section').forEach(s => s.classList.remove('active'));
            document.querySelectorAll('.admin-menu-item').forEach(i => i.classList.remove('active'));
            document.getElementById(sectionId).classList.add('active');
            if (element) element.classList.add('active');
            const titles = { 'albums-section': 'Mis Álbumes', 'songs-section': 'Mis Canciones' };
            document.getElementById('page-title').textContent = titles[sectionId] || '';
        }

        // ── Modales ──────────────────────────────────────────────────────
        function openModal(id) {
            document.getElementById(id).style.display = 'flex';
        }
        function closeModal(id) {
            document.getElementById(id).style.display = 'none';
            const player = document.getElementById('audio-player');
            if (player) player.pause();
        }

        // ── Cargar Álbumes ───────────────────────────────────────────────
        async function loadAlbums() {
            const token = localStorage.getItem('auth_token');
            const tbody = document.getElementById('albums-table-body');

            try {
                const res = await fetch(`${API_BASE_URL}/songs`, {
                    headers: { 'Accept': 'application/json', 'Authorization': `Bearer ${token}` }
                });

                // Usamos el endpoint de songs para inferir álbumes del artista.
                // Mejor: obtener los álbumes filtrando por artist_id.
                // Si hay un endpoint GET /albums, usarlo aquí.
                // Por ahora se consulta con un truco: la API devuelve albums embebidos en songs.
                // Usaremos fetch directo al recurso de álbumes si existe:
                const resA = await fetch(`${API_BASE_URL}/albums?artist_id=${artistId}`, {
                    headers: { 'Accept': 'application/json', 'Authorization': `Bearer ${token}` }
                });

                if (resA.ok) {
                    const result = await resA.json();
                    myAlbums = result.data || result || [];
                    renderAlbumsTable(myAlbums);
                } else {
                    // Fallback: tabla vacía con mensaje
                    myAlbums = [];
                    tbody.innerHTML = `<tr><td colspan="5" style="text-align:center; color:#6A7B92; padding:30px;"><i class="fa-regular fa-folder-open" style="display:block; font-size:24px; margin-bottom:8px;"></i>Aún no tienes álbumes. ¡Crea el primero!</td></tr>`;
                }
            } catch (err) {
                console.error('Error al cargar álbumes:', err);
                tbody.innerHTML = `<tr><td colspan="5" style="text-align:center; color:#FF4B4B; padding:30px;"><i class="fa-solid fa-triangle-exclamation"></i> Error al conectar con el servidor.</td></tr>`;
            }
        }

        function renderAlbumsTable(albums) {
            const tbody = document.getElementById('albums-table-body');
            if (!Array.isArray(albums) || albums.length === 0) {
                tbody.innerHTML = `<tr><td colspan="5" style="text-align:center; color:#6A7B92; padding:30px;"><i class="fa-regular fa-folder-open" style="display:block; font-size:24px; margin-bottom:8px;"></i>Aún no tienes álbumes. ¡Crea el primero!</td></tr>`;
                return;
            }
            tbody.innerHTML = albums.map(a => `
                <tr>
                    <td>${a.cover_url ? `<img src="${escHtml(a.cover_url)}" class="cover-thumb" onerror="this.style.background='#2E3545'; this.src='';">` : `<div class="cover-thumb" style="background:#2E3545;"></div>`}</td>
                    <td><strong>${escHtml(a.title)}</strong></td>
                    <td><span style="color:#6A7B92;">${escHtml(a.album_type || '—')}</span></td>
                    <td>${escHtml(a.genre?.name || '—')}</td>
                    <td>${a.release_date ? escHtml(a.release_date) : '<span style="color:#6A7B92;">Sin fecha</span>'}</td>
                </tr>
            `).join('');
        }

        // ── Cargar Canciones ─────────────────────────────────────────────
        async function loadSongs() {
            const token = localStorage.getItem('auth_token');
            const tbody = document.getElementById('songs-table-body');

            try {
                const res = await fetch(`${API_BASE_URL}/songs`, {
                    headers: { 'Accept': 'application/json', 'Authorization': `Bearer ${token}` }
                });
                if (res.ok) {
                    const result = await res.json();
                    const songs  = (result.data || result || []).filter(s =>
                        s.album?.artist?.id === artistId || !artistId
                    );
                    renderSongsTable(songs);
                } else {
                    tbody.innerHTML = `<tr><td colspan="4" style="text-align:center; color:#6A7B92; padding:30px;">Sin canciones aún.</td></tr>`;
                }
            } catch (err) {
                console.error('Error al cargar canciones:', err);
                tbody.innerHTML = `<tr><td colspan="4" style="text-align:center; color:#FF4B4B; padding:30px;"><i class="fa-solid fa-triangle-exclamation"></i> Error al conectar.</td></tr>`;
            }
        }

        function renderSongsTable(songs) {
            const tbody = document.getElementById('songs-table-body');
            if (!Array.isArray(songs) || songs.length === 0) {
                tbody.innerHTML = `<tr><td colspan="4" style="text-align:center; color:#6A7B92; padding:30px;"><i class="fa-regular fa-folder-open" style="display:block; font-size:24px; margin-bottom:8px;"></i>Aún no tienes canciones subidas.</td></tr>`;
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
                </tr>`;
            }).join('');
        }

        // ── Abrir Modal Canción (con álbumes cargados) ───────────────────
        function openSongModal() {
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
                    sel.appendChild(opt);
                });
            }
            // Reset audio preview
            document.getElementById('audio-preview-container').style.display = 'none';
            document.getElementById('audio-player').pause();
            document.getElementById('song-form').reset();
            document.getElementById('song-form-alert').style.display = 'none';
            document.getElementById('file-input-container').style.display = 'block';
            document.getElementById('url-input-container').style.display = 'none';

            openModal('song-modal');
        }

        let songDurationSeconds = 0;

        // ── Audio Source Toggle ──────────────────────────────────────────
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

        // ── Submit Álbum ─────────────────────────────────────────────────
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

            const isUrl = document.querySelector('input[name="cover_source"]:checked').value === 'url';
            const coverUrlInput = document.getElementById('album-cover');
            const coverFileInput = document.getElementById('album-cover-file');

            if (isUrl && !coverUrlInput.value.trim()) {
                showAlert(alertEl, 'Ingresa una URL de portada válida.', 'error');
                return;
            }

            if (!isUrl && (!coverFileInput.files || !coverFileInput.files[0])) {
                showAlert(alertEl, 'Selecciona una imagen de portada.', 'error');
                return;
            }

            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Guardando...';

            try {
                let res;
                if (!isUrl) {
                    const formData = new FormData();
                    formData.append('artist_id', artistId);
                    formData.append('title', document.getElementById('album-title').value.trim());
                    formData.append('album_type', (document.getElementById('album-type').value || '').toLowerCase());
                    formData.append('genre_id', parseInt(document.getElementById('album-genre').value));
                    formData.append('cover_file', coverFileInput.files[0]);
                    if (document.getElementById('album-release-date').value) {
                        formData.append('release_date', document.getElementById('album-release-date').value);
                    }

                    res = await fetch(`${API_BASE_URL}/albums`, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': `Bearer ${token}`
                        },
                        body: formData
                    });
                } else {
                    const payload = {
                        artist_id:    artistId,
                        title:        document.getElementById('album-title').value.trim(),
                        album_type:   (document.getElementById('album-type').value || '').toLowerCase(),
                        genre_id:     parseInt(document.getElementById('album-genre').value),
                        cover_url:    coverUrlInput.value.trim(),
                        release_date: document.getElementById('album-release-date').value || null,
                    };

                    res = await fetch(`${API_BASE_URL}/albums`, {
                        method: 'POST',
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
                } else {
                    const msg = data.message || (data.errors ? Object.values(data.errors).flat().join(' ') : 'Error al crear el álbum.');
                    showAlert(alertEl, msg, 'error');
                }
            } catch (err) {
                console.error('Error al crear álbum:', err);
                showAlert(alertEl, 'No se pudo conectar con el servidor.', 'error');
            } finally {
                btn.disabled = false;
                btn.innerHTML = '<i class="fa-solid fa-floppy-disk"></i> Guardar Álbum';
            }
        }

        // ── Submit Canción ───────────────────────────────────────────────
        async function submitSong(e) {
            e.preventDefault();
            const token   = localStorage.getItem('auth_token');
            const alertEl = document.getElementById('song-form-alert');
            const btn     = document.getElementById('song-submit-btn');
            alertEl.style.display = 'none';

            const isFile    = document.querySelector('input[name="audio_source"]:checked').value === 'file';
            const fileInput = document.getElementById('audio-file');
            const urlInput  = document.getElementById('audio-url');

            // Validar fuente de audio
            if (isFile && (!fileInput.files || !fileInput.files[0])) {
                showAlert(alertEl, 'Selecciona un archivo de audio MPEG.', 'error');
                return;
            }
            if (!isFile && !urlInput.value.trim()) {
                showAlert(alertEl, 'Ingresa una URL de audio válida.', 'error');
                return;
            }

            const albumId = document.getElementById('song-album').value;
            if (!albumId) {
                showAlert(alertEl, 'Selecciona un álbum destino.', 'error');
                return;
            }

            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Subiendo...';

            try {
                let audioUrl = '';

                if (isFile) {
                    // Subir archivo: usar FormData
                    const formData = new FormData();
                    formData.append('album_id',   albumId);
                    formData.append('title',       document.getElementById('song-title').value.trim());
                    formData.append('audio_file',  fileInput.files[0]);
                    formData.append('duration_seconds', songDurationSeconds || 0);

                    if (document.getElementById('song-track').value) {
                        formData.append('track_number', document.getElementById('song-track').value);
                    }

                    const res = await fetch(`${API_BASE_URL}/songs`, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': `Bearer ${token}`
                        },
                        body: formData
                    });

                    const data = await res.json();
                    if (!res.ok) {
                        const msg = data.message || (data.errors ? Object.values(data.errors).flat().join(' ') : 'Error al subir la canción.');
                        showAlert(alertEl, msg, 'error');
                        return;
                    }
                } else {
                    // Enviar URL como JSON
                    const payload = {
                        album_id:         albumId,
                        title:            document.getElementById('song-title').value.trim(),
                        audio_url:        urlInput.value.trim(),
                        duration_seconds: songDurationSeconds || 0,
                        track_number:     document.getElementById('song-track').value || null,
                    };

                    const res = await fetch(`${API_BASE_URL}/songs`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'Authorization': `Bearer ${token}`
                        },
                        body: JSON.stringify(payload)
                    });

                    const data = await res.json();
                    if (!res.ok) {
                        const msg = data.message || (data.errors ? Object.values(data.errors).flat().join(' ') : 'Error al publicar la canción.');
                        showAlert(alertEl, msg, 'error');
                        return;
                    }
                }

                closeModal('song-modal');
                await loadSongs();

            } catch (err) {
                console.error('Error al subir canción:', err);
                showAlert(alertEl, 'No se pudo conectar con el servidor.', 'error');
            } finally {
                btn.disabled = false;
                btn.innerHTML = '<i class="fa-solid fa-cloud-arrow-up"></i> Subir y Publicar';
            }
        }

        // ── Utilidades ───────────────────────────────────────────────────
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

        function formatDuration(seconds) {
            const m = Math.floor(seconds / 60);
            const s = seconds % 60;
            return `${m}:${String(s).padStart(2, '0')}`;
        }
    </script>
</body>
</html>