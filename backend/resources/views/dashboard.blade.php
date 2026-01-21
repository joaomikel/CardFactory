<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - CardFactory</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

    <style>
        :root { --primary: #816EB2; --dark: #111827; --bg: #f3f4f6; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        
        body { background-color: var(--bg); color: var(--dark); padding-bottom: 40px; }

        .top-nav { padding: 20px 5%; display: flex; justify-content: flex-start; }
        .btn-back { text-decoration: none; color: var(--primary); font-weight: 700; }

        .profile-container { max-width: 450px; margin: 0 auto; padding: 20px; }
        
        /* Encabezado */
        .profile-header { text-align: center; margin: 1rem 0 2rem; }
        .avatar-circle { 
            width: 100px; height: 100px; background: #e5e7eb; border-radius: 50%; 
            margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center;
            font-size: 3rem; color: #9ca3af; border: 4px solid white; box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }
        .user-name { font-size: 1.5rem; font-weight: 800; letter-spacing: -0.5px; }

        /* --- PERSONALIZACIÓN DE JQUERY UI TABS --- */
        
        /* Quitamos bordes y fondos por defecto de jQuery UI */
        .ui-widget.ui-widget-content { border: none; background: transparent; }
        .ui-widget-header { border: none; background: transparent; font-weight: normal; }
        .ui-tabs { padding: 0; }

        /* Estilo del contenedor de navegación (la barra gris) */
        .ui-tabs .ui-tabs-nav {
            display: flex;
            background: #e5e7eb; /* Fondo gris */
            padding: 4px;
            border-radius: 12px;
            margin-bottom: 25px;
            border: none;
        }

        /* Estilo de cada pestaña (LI) */
        .ui-tabs .ui-tabs-nav li {
            flex: 1;
            margin: 0;
            border: none;
            background: transparent;
            list-style: none;
            text-align: center;
            border-radius: 8px;
            cursor: pointer;
            outline: none;
        }

        /* Estilo del enlace dentro de la pestaña (El texto) */
        .ui-tabs .ui-tabs-nav li a {
            display: block;
            width: 100%;
            padding: 10px;
            text-decoration: none;
            font-weight: 600;
            color: #6b7280; /* Texto gris */
            font-size: 0.95rem;
            outline: none;
        }

        /* ESTADO ACTIVO (Cuando la pestaña está seleccionada) */
        .ui-tabs .ui-tabs-nav li.ui-tabs-active {
            background: white; /* Fondo blanco */
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        .ui-tabs .ui-tabs-nav li.ui-tabs-active a {
            color: var(--primary); /* Texto morado */
        }
        
        /* Eliminamos estados de hover/focus feos de jQuery UI */
        .ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default {
            border: none; background: transparent;
        }

        /* --- ESTILOS DEL FORMULARIO Y TARJETAS --- */
        .form-group { margin-bottom: 15px; }
        .form-label { display: block; margin-bottom: 6px; font-size: 0.9rem; font-weight: 600; color: #374151; }
        .form-input { 
            width: 100%; padding: 12px 15px; border-radius: 10px; border: 1px solid #d1d5db; 
            font-size: 1rem; outline: none; transition: 0.2s;
        }
        .form-input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(129, 110, 178, 0.1); }
        
        .btn-save {
            width: 100%; padding: 14px; background: var(--primary); color: white; border: none;
            border-radius: 12px; font-weight: 700; font-size: 1rem; cursor: pointer; margin-top: 10px;
        }
        
        .sales-card {
            background: white; border-radius: 20px; padding: 30px 20px; text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03); margin-bottom: 20px;
        }
        .sales-number { font-size: 3rem; font-weight: 800; color: var(--primary); line-height: 1; margin-bottom: 5px; }
        .sales-text { color: #6b7280; font-weight: 600; }

        .btn-products {
            display: block; width: 100%; text-align: center; padding: 14px; 
            background: var(--dark); color: white; border-radius: 12px; 
            text-decoration: none; font-weight: 700; transition: 0.2s;
        }

        .info-card { 
            background: white; border-radius: 20px; padding: 10px 20px; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.03); margin-top: 2rem;
        }
        .info-item { display: flex; justify-content: space-between; padding: 15px 0; border-bottom: 1px solid #f3f4f6; }
        .info-item:last-child { border-bottom: none; }
        .info-label { color: #6b7280; font-weight: 600; font-size: 0.9rem; }
        .info-value { font-weight: 700; }

        .btn-logout { 
            display: flex; align-items: center; justify-content: space-between;
            width: 100%; padding: 18px 20px; background: white; border-radius: 16px;
            margin-top: 20px; color: #ef4444; border: 1px solid #fee2e2; cursor: pointer; font-weight: 700;
        }
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

        <div id="tabs">
            <ul>
                <li><a href="#tabs-config">Configuración</a></li>
                <li><a href="#tabs-sales">Ventas</a></li>
            </ul>

            <div id="tabs-config">
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('patch')

                    <div class="form-group">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="name" class="form-input" value="{{ Auth::user()->name }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Apellidos</label>
                        <input type="text" name="lastname" class="form-input" value="{{ Auth::user()->lastname ?? '' }}" placeholder="Tus apellidos">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Número de teléfono</label>
                        <input type="tel" name="phone" class="form-input" value="{{ Auth::user()->phone ?? '' }}" placeholder="600 000 000">
                    </div>

                    <button type="submit" class="btn-save">Guardar Cambios</button>
                </form>
            </div>

            <div id="tabs-sales">
                <div class="sales-card">
                    <div class="sales-number">{{ $salesCount ?? 0 }}</div>
                    <div class="sales-text">Productos disponibles</div>
                </div>

                <a href="/mis-productos" class="btn-products">
                    <i class="fas fa-box-open" style="margin-right: 8px;"></i> Gestionar Productos
                </a>
            </div>
        </div>
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
            <button type="submit" class="btn-logout">
                <span><i class="fas fa-sign-out-alt" style="margin-right: 10px;"></i> Cerrar sesión</span>
                <i class="fas fa-chevron-right" style="color: #cbd5e1; font-size: 0.8rem;"></i>
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

        $( function() {
            $( "#tabs" ).tabs({
                show: { effect: "fade", duration: 300 },
                hide: { effect: "fade", duration: 300 }
            });
        } );

    </script>

</body>
</html>