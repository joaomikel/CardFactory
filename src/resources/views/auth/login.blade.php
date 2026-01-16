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
            --sidebar-primary: #816EB2; /* Color de tu welcome.blade.php */
        }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, rgba(67, 56, 202, 0.85), rgba(124, 58, 237, 0.7)),
                        url('https://cards.scryfall.io/art_crop/front/b/d/bd8fa327-dd41-4737-8f19-2cf5eb1f7cdd.jpg?1614638838');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
        }

        /* --- ESTILOS DEL SIDEBAR Y HEADER --- */
        header {
            position: absolute; top: 0; left: 0; width: 100%; height: 70px;
            display: flex; align-items: center; padding: 0 20px; z-index: 100;
        }
        .menu-trigger { 
            font-size: 1.8rem; background: none; border: none; 
            color: var(--white); cursor: pointer; padding: 10px;
        }
        .sidebar-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.6); z-index: 101; opacity: 0; pointer-events: none; transition: 0.3s; backdrop-filter: blur(2px);
        }
        .sidebar-overlay.active { opacity: 1; pointer-events: all; }
        .sidebar {
            position: fixed; top: 0; left: -100%; width: 85%; max-width: 320px; height: 100%;
            background: var(--white); z-index: 102; padding: 2rem; transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex; flex-direction: column; gap: 1rem; box-shadow: 5px 0 15px rgba(0,0,0,0.2);
        }
        .sidebar.active { left: 0; }
        .close-sidebar { position: absolute; top: 20px; right: 20px; font-size: 2rem; background: none; border: none; cursor: pointer; color: #666; }
        .sidebar a { padding: 15px 10px; font-weight: 500; color: #958EA0; border-bottom: 1px solid #eee; text-decoration: none; font-size: 1.1rem; }
        .sidebar h3 { color: var(--sidebar-primary); margin-bottom: 1rem; }

        /* --- ESTILOS LOGIN CARD --- */
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 400px;
            position: relative;
            z-index: 1;
        }

        .logo { font-size: 2rem; font-weight: 800; color: var(--primary); text-align: center; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: 600; margin-bottom: 5px; color: #374151; }
        input[type="email"], input[type="password"] {
            width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 8px; outline-color: var(--accent);
        }
        .btn-login {
            width: 100%; padding: 12px; background: var(--accent); color: white; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; transition: 0.3s; margin-top: 10px;
        }
        .btn-login:hover { background: var(--accent-dark); }
        .links { text-align: center; margin-top: 15px; font-size: 0.9rem; }
        .links a { color: var(--accent); text-decoration: none; font-weight: 600; }
        .error-list { color: #dc2626; font-size: 0.85rem; margin-bottom: 15px; }
    </style>
</head>
<body>

    <div class="sidebar-overlay" id="overlay" onclick="toggleMenu()"></div>
    <div class="sidebar" id="sidebar">
        <button class="close-sidebar" onclick="toggleMenu()">&times;</button>
        <h3>Menú</h3>
        <a href="#">Perfil</a>
        <a href="{{ url('/colecciones') }}">Colecciones</a>
        <a href="{{ url('/catalogo') }}">Catálogo</a>
        <a href="#">Carrito</a>
    </div>

    <header>
        <button class="menu-trigger" onclick="toggleMenu()" aria-label="Menú">&#9776;</button>
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

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input id="password" type="password" name="password" required>
            </div>

            <div style="margin-bottom: 15px; font-size: 0.85rem;">
                <label style="display: inline; font-weight: 400;">
                    <input type="checkbox" name="remember"> Recordarme
                </label>
            </div>

            <button type="submit" class="btn-login">Entrar</button>

            <div class="links">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
                @endif
                <br><br>
                ¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate aquí</a>
            </div>
        </form>
    </div>

    <script>
        function toggleMenu() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('overlay').classList.toggle('active');
        }
    </script>
</body>
</html>