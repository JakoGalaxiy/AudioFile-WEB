<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Music App</title>
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            background-color: #121620;
            color: #FFFFFF;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }
        .login-card {
            background-color: #191f2d;
            padding: 40px 35px;
            border-radius: 32px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.6);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        .login-card h1 {
            text-align: center;
            margin: 0 0 8px 0;
            font-size: 30px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        .subtitle {
            text-align: center;
            color: #9ca3af;
            font-size: 14px;
            margin-bottom: 35px;
        }
        .input-group {
            background-color: #121620;
            border-radius: 16px;
            display: flex;
            align-items: center;
            padding: 0 16px;
            margin-bottom: 20px;
            border: 1px solid #1f2937;
            transition: border-color 0.2s;
        }
        .input-group:focus-within {
            border-color: #22d3ee;
        }
        .input-group svg {
            width: 20px;
            height: 20px;
            fill: none;
            stroke: #6b7280;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
            flex-shrink: 0;
        }
        .input-group input {
            background: transparent;
            border: none;
            color: #f3f4f6;
            padding: 16px 12px;
            width: 100%;
            outline: none;
            font-size: 15px;
        }
        .input-group input::placeholder {
            color: #6b7280;
        }
        /* Corrección para el autocompletado en navegadores */
        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus, 
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px #121620 inset !important;
            -webkit-text-fill-color: #f3f4f6 !important;
            transition: background-color 5000s ease-in-out 0s;
        }
        .btn-submit {
            background: linear-gradient(135deg, #22d3ee, #5eead4);
            color: #121620;
            border: none;
            border-radius: 16px;
            padding: 16px;
            width: 100%;
            font-weight: 700;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
            box-shadow: 0 10px 20px rgba(34, 211, 238, 0.1);
            transition: opacity 0.2s;
        }
        .btn-submit:hover {
            opacity: 0.9;
        }
        .footer-links {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 24px;
            font-size: 14px;
        }
        .footer-links a {
            color: #9ca3af;
            text-decoration: none;
            transition: color 0.2s;
        }
        .footer-links a:hover {
            color: #f3f4f6;
        }
        .footer-links a.highlight {
            color: #22d3ee;
            font-weight: 500;
        }
        .footer-links a.highlight:hover {
            color: #67e8f9;
        }
        .error-alert {
            background-color: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #f87171;
            padding: 12px;
            border-radius: 12px;
            font-size: 13px;
            text-align: center;
            margin-bottom: 20px;
            display: none;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <h1>Welcome Back!</h1>
        <div class="subtitle">Login to continue to our app</div>

        <div id="error-alert" class="error-alert"></div>

        <form id="login-form">
            <!-- Campo Email -->
            <div class="input-group">
                <svg viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                <input type="email" id="email" placeholder="Email Address" required autocomplete="email">
            </div>

            <!-- Campo Contraseña -->
            <div class="input-group">
                <svg viewBox="0 0 24 24"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                <input type="password" id="password" placeholder="Password" required autocomplete="current-password">
            </div>

            <button type="submit" id="submit-btn" class="btn-submit">Log In</button>
        </form>

        <div class="footer-links">
            <a href="#">Remember Me</a>
            <a href="#" class="highlight">Forgot Password?</a>
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
            errorAlert.style.display = 'none';
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
                errorAlert.style.display = 'block';
                submitBtn.disabled = false;
                submitBtn.textContent = 'Log In';
            }
        });
    </script>
</body>
</html>