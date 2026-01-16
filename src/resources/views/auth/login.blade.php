<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CardFactory</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #111827;
            --accent: #6366f1;
            --accent-dark: #4338ca;
            --white: #ffffff;
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
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 400px;
        }

        .logo {
            font-size: 2rem;
            font-weight: 800;
            color: var(--primary);
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: 600; margin-bottom: 5px; color: #374151; }
        
        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            outline-color: var(--accent);
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background: var(--accent);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
        }

        .btn-login:hover { background: var(--accent-dark); }

        .links {
            text-align: center;
            margin-top: 15px;
            font-size: 0.9rem;
        }

        .links a { color: var(--accent); text-decoration: none; font-weight: 600; }
        .error-list { color: #dc2626; font-size: 0.85rem; margin-bottom: 15px; }
    </style>
</head>
<body>

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

</body>
</html>