<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - CardFactory</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #111827;
            --accent: #6366f1;
            --accent-dark: #4338ca;
            --white: #ffffff;
            --sidebar-primary: #816EB2;
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

        /* --- ESTILOS REGISTER CARD --- */
        .register-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 450px;
            position: relative;
            z-index: 1;
        }

        .logo { font-size: 1.8rem; font-weight: 800; color: var(--primary); text-align: center; margin-bottom: 15px; }
        .form-group { margin-bottom: 12px; }
        label { display: block; font-weight: 600; margin-bottom: 4px; color: #374151; font-size: 0.9rem; }
        input { width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px; outline-color: var(--accent); }
        .btn-register {
            width: 100%; padding: 12px; background: var(--accent); color: white; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; transition: 0.3s; margin-top: 15px;
        }
        .btn-register:hover { background: var(--accent-dark); }
        .links { text-align: center; margin-top: 15px; font-size: 0.9rem; }
        .links a { color: var(--accent); text-decoration: none; font-weight: 600; }
        .error-list { color: #dc2626; font-size: 0.85rem; margin-bottom: 10px; }
    </style>
</head>
<body>

    <div class="sidebar-overlay" id="overlay" onclick="toggleMenu()"></div>
    <div class="sidebar" id="sidebar">
        <button class="close-sidebar" onclick="toggleMenu()">&times;</button>
        <h3>Menú</h3>
        <a href="/">Inicio</a>
        <a href="{{ url('/dashboard') }}">Perfil</a>
        <a href="{{ url('/colecciones') }}">Colecciones</a>
        <a href="{{ url('/catalogo') }}">Catálogo</a>
        <a href="#">Carrito</a>
    </div>

    <header>
        <button class="menu-trigger" onclick="toggleMenu()" aria-label="Menú">&#9776;</button>
    </header>

    <div class="register-card">
        <div class="logo">Únete a CardFactory</div>
        
        <div id="js-errors" class="error-list" style="display:none;"></div>

        @if ($errors->any())
            <div class="error-list">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" id="registerForm">
            @csrf

            <div class="form-group">
                <label for="name">Nombre</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="given-name">
            </div>

            <div class="form-group">
                <label for="last_name">Apellido</label>
                <input id="last_name" type="text" name="last_name" value="{{ old('last_name') }}" required autocomplete="family-name">
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username">
            </div>

            <div class="form-group">
                <label for="phone">Teléfono</label>
                <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" required autocomplete="tel">
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input id="password" type="password" name="password" required autocomplete="new-password">
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirmar Contraseña</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password">
            </div>

            <button type="submit" class="btn-register">Registrar</button>

            <div class="links">
                ¿Ya tienes una cuenta? <a href="{{ route('login') }}">Inicia sesión</a>
            </div>
        </form>
    </div>

    <script>
        function toggleMenu() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('overlay').classList.toggle('active');
        }

        // --- SCRPT DE REGISTRO AJAX (Igual que el Login) ---
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Evitamos que el formulario recargue la página

            const form = this;
            const formData = new FormData(form);
            const btn = form.querySelector('.btn-register');
            const errorDiv = document.getElementById('js-errors');
            
            // Estado visual "Cargando"
            const originalText = btn.innerText;
            btn.innerText = 'Registrando...';
            btn.disabled = true;
            errorDiv.style.display = 'none';
            errorDiv.innerHTML = '';

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json', // Importante para que el Controller devuelva JSON
                }
            })
            .then(response => {
                return response.json().then(data => {
                    if (!response.ok) {
                        throw data; // Lanzamos error si no es 200 OK
                    }
                    return data;
                });
            })
            .then(data => {
                // AQUÍ ESTÁ LA CLAVE: Guardamos el token igual que en el login
                if (data.token) {
                    localStorage.setItem('auth_token', data.token);
                    localStorage.setItem('user_data', JSON.stringify(data.user));
                }

                // Redirección
                window.location.href = "{{ route('dashboard') }}";
            })
            .catch(error => {
                // Restauramos botón
                btn.innerText = originalText;
                btn.disabled = false;

                // Mostramos errores
                let errorMsg = "Ocurrió un error al registrarse.";
                
                if (error.errors) {
                    // Si Laravel devuelve errores de validación (ej: email duplicado)
                    errorMsg = "<ul>";
                    for (const [key, messages] of Object.entries(error.errors)) {
                        errorMsg += `<li>${messages[0]}</li>`;
                    }
                    errorMsg += "</ul>";
                } else if (error.message) {
                    errorMsg = error.message;
                }

                errorDiv.innerHTML = errorMsg;
                errorDiv.style.display = 'block';
            });
        });
    </script>
</body>
</html>