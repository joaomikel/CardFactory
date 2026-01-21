<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - CardFactory</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary: #816EB2; --dark: #111827; --bg: #f3f4f6; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        
        body { background-color: var(--bg); color: var(--dark); padding-bottom: 40px; }

        /* Botón superior de volver (opcional, para navegación) */
        .top-nav {
            padding: 20px 5%;
            display: flex;
            justify-content: flex-start;
        }
        .btn-back { text-decoration: none; color: var(--primary); font-weight: 700; }

        .profile-container { max-width: 450px; margin: 0 auto; padding: 20px; }
        
        /* Encabezado: Avatar y Nombre */
        .profile-header { text-align: center; margin: 2rem 0 3rem; }
        .avatar-circle { 
            width: 110px; height: 110px; background: #e5e7eb; border-radius: 50%; 
            margin: 0 auto 1.2rem; display: flex; align-items: center; justify-content: center;
            font-size: 3.5rem; color: #9ca3af; border: 4px solid white; box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }
        .user-name { font-size: 1.8rem; font-weight: 800; letter-spacing: -0.5px; }

        /* Botones de Menú */
        .menu-link { 
            display: flex; align-items: center; justify-content: space-between;
            width: 100%; padding: 18px 20px; background: white; border-radius: 16px;
            margin-bottom: 12px; border: 1px solid #e5e7eb; font-weight: 700; 
            color: var(--dark); text-decoration: none; transition: 0.2s;
        }
        .menu-link:hover { transform: translateY(-2px); border-color: var(--primary); }
        .menu-link i.icon-main { color: var(--primary); width: 30px; }
        .menu-link i.chevron { color: #cbd5e1; font-size: 0.8rem; }

        /* Tarjeta de Información (Parte baja del wireframe) */
        .info-card { 
            background: white; border-radius: 20px; padding: 10px 20px; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.03); margin-top: 2rem;
        }
        .info-item { display: flex; justify-content: space-between; padding: 15px 0; border-bottom: 1px solid #f3f4f6; }
        .info-item:last-child { border-bottom: none; }
        .info-label { color: #6b7280; font-weight: 600; font-size: 0.9rem; }
        .info-value { font-weight: 700; }

        /* Botón Logout */
        .btn-logout { 
            margin-top: 20px; color: #ef4444; border: 1px solid #fee2e2; 
        }
        .btn-logout:hover { background: #fef2f2; border-color: #fca5a5; }
    </style>
</head>
<body>

    <div class="top-nav">
        <a href="/" class="btn-back"><i class="fas fa-chevron-left"></i> Inicio</a>
    </div>

    <div class="profile-container">
        
        <div class="profile-header">
            <div class="avatar-circle">
                <i class="fas fa-user"></i>
            </div>
            <h1 class="user-name">{{ Auth::user()->name }}</h1>
        </div>

        <a href="{{ route('profile.edit') }}" class="menu-link">
            <span><i class="fas fa-cog icon-main"></i> Configuración</span>
            <i class="fas fa-chevron-right chevron"></i>
        </a>

        <a href="/mis-productos" class="menu-link">
            <span><i class="fas fa-box icon-main"></i> Mis Productos</span>
            <i class="fas fa-chevron-right chevron"></i>
        </a>

        <div class="info-card">
            <div class="info-item">
                <span class="info-label">Creación de cuenta</span>
                <span class="info-value">{{ Auth::user()->created_at->format('d/m/Y') }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Id Usuario</span>
                <span class="info-value">{{ Auth::user()->id }}</span>
            </div>
        </div>

        <form method="POST" action="{{ route('logout') }}" id="logoutForm">
            @csrf
            <button type="submit" class="menu-link btn-logout">
                <span><i class="fas fa-sign-out-alt icon-main" style="color:#ef4444"></i> Cerrar sesión</span>
                <i class="fas fa-chevron-right chevron"></i>
            </button>
        </form>

    </div>

    <script>
        // Escuchamos cuando el usuario envía el formulario de cerrar sesión
        document.getElementById('logoutForm').addEventListener('submit', function() {
            // BORRAMOS EL TOKEN DEL NAVEGADOR
            // Esto hace que el carrito sepa que ya no hay nadie logueado
            localStorage.removeItem('auth_token');
            localStorage.removeItem('user_data');
            
            console.log("Sesión local eliminada. El carrito ahora está bloqueado.");
        });
    </script>
</body>
</html>