<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - AudioFile</title>

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
            margin: 0;
            display: flex;
            height: 100vh;
            overflow: hidden;
        }
        /* Sidebar Administrador */
        .admin-sidebar {
            width: 260px;
            background-color: #1A1F2C;
            border-right: 1px solid rgba(44, 228, 245, 0.1);
            display: flex;
            flex-direction: column;
            padding: 20px 15px;
            flex-shrink: 0;
        }
        .admin-brand {
            font-size: 20px;
            font-weight: bold;
            color: #2CE4F5;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 30px;
            padding-left: 10px;
        }
        .sidebar-section-title {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #6A7B92;
            margin: 15px 0 10px 10px;
        }
        .admin-menu {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        .admin-menu-item a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            color: #A0AEC0;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.2s;
            cursor: pointer;
        }
        .admin-menu-item a:hover {
            color: #FFFFFF;
            background-color: rgba(30, 36, 51, 0.8);
        }
        .admin-menu-item.active a {
            color: #13161F;
            background: linear-gradient(to right, #2CE4F5, #67F4CE);
            font-weight: bold;
        }
        /* Área de Contenido Principal */
        .admin-main {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }
        /* Header Superior Admin */
        .admin-header {
            background-color: #1E2433;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(44, 228, 245, 0.1);
        }
        .admin-header-title {
            font-size: 20px;
            font-weight: 700;
        }
        .admin-user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .admin-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background-color: #2CE4F5;
            color: #13161F;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        /* Vistas / Secciones */
        .content-section {
            padding: 30px 40px;
            display: none;
        }
        .content-section.active {
            display: block;
        }
        /* Barra de Herramientas y Tablas */
        .section-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            gap: 15px;
        }
        .search-box {
            background-color: #151924;
            border: 1px solid rgba(44, 228, 245, 0.2);
            border-radius: 8px;
            padding: 8px 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            width: 300px;
        }
        .search-box input {
            background: transparent;
            border: none;
            color: #FFF;
            outline: none;
            width: 100%;
            font-size: 13px;
        }
        .btn-action-primary {
            background: linear-gradient(to right, #2CE4F5, #67F4CE);
            color: #13161F;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: bold;
            font-size: 13px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: opacity 0.2s;
        }
        .btn-action-primary:hover {
            opacity: 0.9;
        }
        /* Estilos de Tabla */
        .data-table-wrapper {
            background-color: #1E2433;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.3);
            overflow: hidden;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 14px;
        }
        table.data-table th {
            background-color: #151924;
            color: #6A7B92;
            padding: 16px 20px;
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        table.data-table td {
            padding: 16px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            color: #E2E8F0;
        }
        table.data-table tr:hover {
            background-color: rgba(37, 45, 66, 0.5);
        }
        /* Badges de Estado */
        .badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            display: inline-block;
        }
        .badge-pending {
            background-color: rgba(255, 193, 7, 0.15);
            color: #FFC107;
            border: 1px solid rgba(255, 193, 7, 0.3);
        }
        .badge-approved {
            background-color: rgba(44, 228, 245, 0.15);
            color: #2CE4F5;
            border: 1px solid rgba(44, 228, 245, 0.3);
        }
        .badge-rejected {
            background-color: rgba(255, 75, 75, 0.15);
            color: #FF4B4B;
            border: 1px solid rgba(255, 75, 75, 0.3);
        }
        /* Botones de Acción de Fila */
        .btn-table-action {
            background: transparent;
            border: none;
            cursor: pointer;
            font-size: 14px;
            padding: 6px;
            border-radius: 4px;
            transition: background-color 0.2s;
        }
        .btn-approve {
            color: #67F4CE;
        }
        .btn-approve:hover {
            background-color: rgba(103, 244, 206, 0.1);
        }
        .btn-reject {
            color: #FF4B4B;
        }
        .btn-reject:hover {
            background-color: rgba(255, 75, 75, 0.1);
        }
        /* Modal Overlay */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 2000;
        }
        .modal-card {
            background-color: #1E2433;
            border-radius: 12px;
            width: 100%;
            max-width: 480px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            border: 1px solid rgba(44, 228, 245, 0.2);
        }
        .modal-card h3 {
            margin-top: 0;
            font-size: 20px;
            color: #FFF;
        }
        .modal-card textarea {
            width: 100%;
            background-color: #151924;
            border: 1px solid rgba(44, 228, 245, 0.2);
            border-radius: 8px;
            color: #FFF;
            padding: 12px;
            font-family: inherit;
            resize: vertical;
            min-height: 100px;
            outline: none;
            margin: 15px 0;
        }
        .modal-card textarea:focus {
            border-color: #2CE4F5;
        }
        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }
        .btn-secondary {
            background-color: transparent;
            color: #A0AEC0;
            border: 1px solid #A0AEC0;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <!-- 1. Menú Lateral (Sidebar) -->
    <aside class="admin-sidebar">
        <a href="{{ route('home') }}" class="admin-brand">
            <i class="fa-solid fa-compact-disc"></i> AudioFile <span style="font-size:11px; background:rgba(44,228,245,0.2); padding:2px 6px; border-radius:4px;">ADMIN</span>
        </a>

        <div class="sidebar-section-title">Gestión de Contenido</div>
        <ul class="admin-menu">
            <li class="admin-menu-item active" onclick="switchSection('songs-section', this)">
                <a><i class="fa-solid fa-music"></i> Canciones</a>
            </li>
            <li class="admin-menu-item" onclick="switchSection('albums-section', this)">
                <a><i class="fa-solid fa-record-vinyl"></i> Álbumes</a>
            </li>
            <li class="admin-menu-item" onclick="switchSection('artists-section', this)">
                <a><i class="fa-solid fa-user-astronaut"></i> Artistas</a>
            </li>
        </ul>

        <div class="sidebar-section-title">Usuarios & Solicitudes</div>
        <ul class="admin-menu">
            <li class="admin-menu-item" onclick="switchSection('requests-section', this)">
                <a><i class="fa-solid fa-user-clock"></i> Solicitudes Artista</a>
            </li>
            <li class="admin-menu-item" onclick="switchSection('users-section', this)">
                <a><i class="fa-solid fa-users"></i> Oyentes</a>
            </li>
        </ul>
    </aside>

    <!-- 2. Área Principal de Trabajo -->
    <main class="admin-main">
        <header class="admin-header">
            <div class="admin-header-title" id="page-title">Gestión de Canciones</div>
            <div class="admin-user-profile">
                <div class="admin-avatar" id="admin-avatar-char">A</div>
                <div style="display:flex; flex-direction:column;">
                    <span id="admin-username-display" style="font-size:14px; font-weight:bold;">Admin</span>
                    <span style="font-size:11px; color:#6A7B92;">Administrador</span>
                </div>
            </div>
        </header>

        <!-- Seccion: Canciones -->
        <section id="songs-section" class="content-section active">
            <div class="section-toolbar">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass" style="color:#6A7B92;"></i>
                    <input type="text" placeholder="Buscar canción por título...">
                </div>
                <button class="btn-action-primary"><i class="fa-solid fa-plus"></i> Nueva Canción</button>
            </div>

            <div class="data-table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Álbum</th>
                            <th>Duración</th>
                            <th>Reproducciones</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="songs-table-body">
                        <!-- Carga dinámica vía JS -->
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Seccion: Solicitudes de Artista -->
        <section id="requests-section" class="content-section">
            <div class="section-toolbar">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass" style="color:#6A7B92;"></i>
                    <input type="text" placeholder="Buscar solicitud...">
                </div>
            </div>

            <div class="data-table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Correo</th>
                            <th>Nombre Artístico Solicitado</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="requests-table-body">
                        <!-- Carga dinámica vía JS -->
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Seccion: Álbumes -->
        <section id="albums-section" class="content-section">
            <div class="section-toolbar">
                <button class="btn-action-primary"><i class="fa-solid fa-plus"></i> Crear Álbum</button>
            </div>
            <div class="data-table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Título Álbum</th>
                            <th>Artista</th>
                            <th>Año</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="albums-table-body"></tbody>
                </table>
            </div>
        </section>

        <!-- Seccion: Artistas -->
        <section id="artists-section" class="content-section">
            <div class="data-table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Nombre Artístico</th>
                            <th>Estado Verificación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="artists-table-body"></tbody>
                </table>
            </div>
        </section>

        <!-- Seccion: Usuarios -->
        <section id="users-section" class="content-section">
            <div class="data-table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Email</th>
                            <th>Fecha Registro</th>
                        </tr>
                    </thead>
                    <tbody id="users-table-body"></tbody>
                </table>
            </div>
        </section>
    </main>

    <!-- Modal de Justificación de Rechazo -->
    <div class="modal-overlay" id="reject-modal">
        <div class="modal-card">
            <h3>Motivo de Rechazo de Solicitud</h3>
            <p style="font-size:13px; color:#6A7B92;">Indica el motivo por el cual se rechaza la solicitud del usuario. Esta respuesta será visible en su perfil.</p>
            <textarea id="reject-reason-input" placeholder="Ej: El nombre artístico infringe derechos de autor o los datos están incompletos..."></textarea>
            <div class="modal-actions">
                <button class="btn-secondary" onclick="closeRejectModal()">Cancelar</button>
                <button class="btn-action-primary" style="background:#FF4B4B; color:#FFF;" onclick="confirmRejection()">Confirmar Rechazo</button>
            </div>
        </div>
    </div>

    <script>
        const API_BASE_URL = "{{ env('API_URL', 'http://localhost:8000/api') }}";
        let selectedRequestId = null;

        // Verificación de Acceso de Administrador
        document.addEventListener("DOMContentLoaded", () => {
            const token = localStorage.getItem('auth_token');
            const userData = JSON.parse(localStorage.getItem('user_data') || '{}');

            if (!token || userData.role_id !== 3) {
                window.location.href = "{{ route('login') }}";
                return;
            }

            // Mostrar nombre del Admin en Header
            const adminName = userData.username || 'Admin';
            document.getElementById('admin-username-display').textContent = adminName;
            document.getElementById('admin-avatar-char').textContent = adminName.charAt(0).toUpperCase();

            // Cargar datos iniciales
            loadRequestsData();
        });

        // Alternar Secciones del Sidebar
        function switchSection(sectionId, element) {
            document.querySelectorAll('.content-section').forEach(sec => sec.classList.remove('active'));
            document.querySelectorAll('.admin-menu-item').forEach(item => item.classList.remove('active'));

            document.getElementById(sectionId).classList.add('active');
            element.classList.add('active');

            // Actualizar Título
            const titles = {
                'songs-section': 'Gestión de Canciones',
                'albums-section': 'Gestión de Álbumes',
                'artists-section': 'Perfiles de Artistas',
                'requests-section': 'Solicitudes de Artistas Pendientes',
                'users-section': 'Gestión de Usuarios (Oyentes)'
            };
            document.getElementById('page-title').textContent = titles[sectionId] || 'Panel de Administración';
        }

        // Cargar Solicitudes Pendientes desde la API
        async function loadRequestsData() {
            const token = localStorage.getItem('auth_token');
            try {
                const response = await fetch(`${API_BASE_URL}/admin/artist-requests`, {
                    headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }
                });
                if (!response.ok) return;

                const requests = await response.json();
                const tbody = document.getElementById('requests-table-body');
                tbody.innerHTML = '';

                requests.forEach(req => {
                    tbody.innerHTML += `
                        <tr>
                            <td>${req.user?.username || 'N/A'}</td>
                            <td>${req.user?.email || 'N/A'}</td>
                            <td><strong>${req.stage_name}</strong></td>
                            <td><span class="badge badge-pending">Pendiente de revisión</span></td>
                            <td>
                                <button class="btn-table-action btn-approve" onclick="approveRequest('${req.id}')" title="Aprobar"><i class="fa-solid fa-check"></i></button>
                                <button class="btn-table-action btn-reject" onclick="openRejectModal('${req.id}')" title="Rechazar"><i class="fa-solid fa-xmark"></i></button>
                            </td>
                        </tr>
                    `;
                });
            } catch (err) {
                console.error("Error al cargar solicitudes:", err);
            }
        }

        // Aprobar Solicitud
        async function approveRequest(artistId) {
            if (!confirm("¿Deseas aprobar a este usuario como artista oficial?")) return;
            const token = localStorage.getItem('auth_token');

            try {
                const res = await fetch(`${API_BASE_URL}/admin/artist-requests/${artistId}/status`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ status: 'approved' })
                });

                if (res.ok) {
                    alert("Solicitud aprobada con éxito.");
                    loadRequestsData();
                }
            } catch (e) {
                console.error(e);
            }
        }

        // Manejo del Modal de Rechazo
        function openRejectModal(requestId) {
            selectedRequestId = requestId;
            document.getElementById('reject-modal').style.display = 'flex';
        }

        function closeRejectModal() {
            selectedRequestId = null;
            document.getElementById('reject-reason-input').value = '';
            document.getElementById('reject-modal').style.display = 'none';
        }

        // Confirmar Rechazo con Justificación
        async function confirmRejection() {
            const reason = document.getElementById('reject-reason-input').value.trim();
            if (!reason) {
                alert("Por favor ingresa un motivo para el rechazo.");
                return;
            }

            const token = localStorage.getItem('auth_token');
            try {
                const res = await fetch(`${API_BASE_URL}/admin/artist-requests/${selectedRequestId}/status`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        status: 'rejected',
                        rejection_reason: reason
                    })
                });

                if (res.ok) {
                    alert("La solicitud ha sido rechazada.");
                    closeRejectModal();
                    loadRequestsData();
                }
            } catch (e) {
                console.error(e);
            }
        }
    </script>
</body>
</html>
