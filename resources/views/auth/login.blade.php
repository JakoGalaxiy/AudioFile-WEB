<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Music App</title>
    <!-- Tailwind CSS por CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Estilo para corregir el fondo blanco al autocompletar en navegadores -->
    <style>
        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus, 
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px #121620 inset !important;
            -webkit-text-fill-color: #f3f4f6 !important;
            transition: background-color 5000s ease-in-out 0s;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 bg-[#121620] font-sans">

    <!-- Tarjeta Principal con estilo de la plantilla -->
    <div class="w-full max-w-md bg-[#191f2d] p-8 sm:p-10 rounded-[2rem] shadow-2xl border border-gray-800/80 relative overflow-hidden">
        
        <!-- Encabezado -->
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-white tracking-tight">Welcome Back!</h1>
            <p class="text-sm text-gray-400 mt-2">Login to continue to our app</p>
        </div>

        <!-- Alerta de Error -->
        <div id="error-alert" class="hidden mb-6 p-3 bg-red-500/10 border border-red-500/30 text-red-400 text-sm rounded-xl text-center"></div>

        <!-- Formulario -->
        <form id="login-form" class="space-y-5">
            <!-- Input Email con Icono -->
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </span>
                <input type="email" id="email" required autocomplete="email"
                    class="w-full pl-12 pr-4 py-4 bg-[#121620] border border-gray-800 rounded-2xl text-gray-100 placeholder-gray-500 focus:outline-none focus:border-cyan-400 transition"
                    placeholder="Email Address">
            </div>

            <!-- Input Password con Icono -->
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </span>
                <input type="password" id="password" required autocomplete="current-password"
                    class="w-full pl-12 pr-4 py-4 bg-[#121620] border border-gray-800 rounded-2xl text-gray-100 placeholder-gray-500 focus:outline-none focus:border-cyan-400 transition"
                    placeholder="Password">
            </div>

            <!-- Botón de Log In -->
            <button type="submit" id="submit-btn"
                class="w-full mt-4 py-4 bg-gradient-to-r from-cyan-400 to-teal-300 hover:from-cyan-300 hover:to-teal-200 text-[#121620] font-bold rounded-2xl shadow-lg shadow-cyan-500/10 transition duration-200">
                Log In
            </button>
        </form>

        <!-- Enlaces inferiores -->
        <div class="flex justify-between items-center mt-6 text-sm">
            <a href="#" class="text-gray-400 hover:text-gray-200 transition">Remember Me</a>
            <a href="#" class="text-cyan-400 hover:text-cyan-300 transition font-medium">Forgot Password?</a>
        </div>
    </div>

    <!-- Script JavaScript -->
    <script>
        const API_BASE_URL = "{{ env('VITE_API_BASE_URL', 'http://127.0.0.1:8000') }}";

        const loginForm = document.getElementById('login-form');
        const errorAlert = document.getElementById('error-alert');
        const submitBtn = document.getElementById('submit-btn');

        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            errorAlert.classList.add('hidden');
            submitBtn.disabled = true;
            submitBtn.textContent = 'Processing...';

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            try {
                const response = await fetch(`${API_BASE_URL}/api/login`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ email, password })
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || 'Credenciales incorrectas.');
                }

                localStorage.setItem('auth_token', data.access_token);
                localStorage.setItem('user_data', JSON.stringify(data.user));

                window.location.href = '/dashboard';

            } catch (error) {
                errorAlert.textContent = error.message;
                errorAlert.classList.remove('hidden');
                submitBtn.disabled = false;
                submitBtn.textContent = 'Log In';
            }
        });
    </script>
</body>
</html>