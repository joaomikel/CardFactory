<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CardFactory</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #111827;
            --accent: #6366f1;
            --accent-dark: #4338ca;
            --white: #ffffff;
            --sidebar-primary: #816EB2;
            /* Variable de foco amarillo del index.html */
            --focus-ring: #ffbf00; 
        }

        /* --- ACCESIBILIDAD: FOCO VISIBLE --- */
        /* Solo se activa al usar el teclado (tabulador) */
        :focus-visible {
            outline: 3px solid var(--focus-ring) !important;
            outline-offset: 2px;
        }

        /* Quitamos el foco por defecto para que no se duplique */
        button:focus, input:focus, a:focus {
            outline: none;
        }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, rgba(67, 56, 202, 0.85), rgba(124, 58, 237, 0.7)),
                        url('https://cards.scryfall.io/art_crop/front/b/d/bd8fa327-dd41-4737-8f19-2cf5eb1f7cdd.jpg?1614638838');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            overflow-x: hidden;
        }

        /* --- HEADER Y MENU TRIGGER --- */
        header {
            position: absolute; top: 0; left: 0; width: 100%; height: 70px;
            display: flex; align-items: center; padding: 0 20px; z-index: 100;
        }
        .menu-trigger { 
            font-size: 1.8rem; background: none; border: none; 
            color: var(--white); cursor: pointer; padding: 10px;
            border-radius: 8px;
        }

        /* --- SIDEBAR CORREGIDO --- */
        .sidebar-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.6); z-index: 101; opacity: 0; pointer-events: none; transition: 0.3s; backdrop-filter: blur(2px);
        }
        .sidebar-overlay.active { opacity: 1; pointer-events: all; }

        .sidebar {
            position: fixed; top: 0; left: -100%; width: 85%; max-width: 320px; height: 100%;
            background: var(--white); z-index: 102; padding: 2rem; transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex; flex-direction: column; gap: 1rem; box-shadow: 5px 0 15px rgba(0,0,0,0.2);
            /* Importante: oculta los elementos del foco cuando el menú está cerrado */
            visibility: hidden; 
        }
        .sidebar.active { 
            left: 0; 
            visibility: visible;
        }

        .close-sidebar { position: absolute; top: 20px; right: 20px; font-size: 2rem; background: none; border: none; cursor: pointer; color: #666; border-radius: 4px; }
        .sidebar a { padding: 15px 10px; font-weight: 500; color: #958EA0; border-bottom: 1px solid #eee; text-decoration: none; font-size: 1.1rem; border-radius: 4px; }
        .sidebar h3 { color: var(--sidebar-primary); margin-bottom: 1rem; }

        /* --- LOGIN CARD --- */
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 400px;
            position: relative;
            z-index: 1;
        }

        .logo { font-size: 1.8rem; font-weight: 800; color: var(--primary); text-align: center; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: 600; margin-bottom: 4px; color: #374151; font-size: 0.9rem; }
        input[type="email"], input[type="password"] { 
            width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px;
        }
        .btn-login {
            width: 100%; padding: 12px; background: var(--accent); color: white; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; transition: 0.3s; margin-top: 15px;
        }
        .btn-login:hover { background: var(--accent-dark); }
        .btn-login:disabled { background: #9ca3af; cursor: not-allowed; }
        
        .links { text-align: center; margin-top: 15px; font-size: 0.9rem; }
        .links a { color: var(--accent); text-decoration: none; font-weight: 600; border-radius: 4px; }
        .error-list { color: #dc2626; font-size: 0.85rem; margin-bottom: 10px; }
    </style>
</head>
<body>

    <div class="sidebar-overlay" id="overlay" onclick="toggleMenu()"></div>
    
    <div class="sidebar" id="sidebar">
        <button class="close-sidebar" id="closeSidebar" onclick="toggleMenu()" aria-label="Cerrar menú">&times;</button>
        <h3>Menú</h3>
        <a href="/">Inicio</a>
        <a href="{{ url('/dashboard') }}">Perfil</a>
        <a href="{{ url('/colecciones') }}">Colecciones</a>
        <a href="{{ url('/catalogo') }}">Catálogo</a>
        <a href="carrito.html">Carrito</a> 
    </div>

    <header>
        <button class="menu-trigger" id="menuBtn" onclick="toggleMenu()" aria-label="Abrir Menú">&#9776;</button>
    </header>

    <div class="login-card">
        <div class="logo">CardFactory</div>
        
        @if ($errors->any())
            <div class="error-list">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" id="loginForm">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input id="password" type="password" name="password" required autocomplete="current-password">
            </div>

            <div style="margin-bottom: 15px; font-size: 0.85rem;">
                <label style="display: inline; font-weight: 400; cursor:pointer;">
                    <input type="checkbox" name="remember"> Recordarme
                </label>
            </div>

            <button type="submit" class="btn-login">Entrar</button>

            <div class="links">
                ¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate aquí</a>
            </div>
        </form>
    </div>

    <script>
        function toggleMenu() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            const menuBtn = document.getElementById('menuBtn');
            const closeBtn = document.getElementById('closeSidebar');
            
            const isActive = sidebar.classList.toggle('active');
            overlay.classList.toggle('active');

            if (isActive) {
                // Al abrir, esperamos a la transición y ponemos el foco en el botón de cerrar
                setTimeout(() => {
                    closeBtn.focus();
                }, 300);
            } else {
                // Al cerrar, devolvemos el foco al botón que lo abrió
                menuBtn.focus();
            }
        }

        // Lógica de validación de formulario (se mantiene la tuya)
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault(); 
            const form = this;
            const btn = form.querySelector('.btn-login');
            const originalText = btn.innerText;

            btn.innerText = 'Entrando...';
            btn.disabled = true;

            fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            })
            .then(response => response.ok ? response.json() : response.json().then(err => { throw err; }))
            .then(data => {
                if (data.token) {
                    sessionStorage.setItem('auth_token', data.token);
                    sessionStorage.setItem('user_data', JSON.stringify(data.user));
                }
                window.location.href = "{{ route('dashboard') }}";
            })
            .catch(error => {
                btn.innerText = originalText;
                btn.disabled = false;
                alert("❌ " + (error.message || "Credenciales incorrectas"));
            });
        });
    </script>
</body> 
</html>