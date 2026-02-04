<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Ayuda - CardFactory</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="http://localhost:8000/css/catalogo.css">

    <style>
        /* Estilos específicos para la página de ayuda */
        .help-header {
            text-align: center;
            margin-bottom: 40px;
        }
        .help-header h1 {
            color: var(--primary-dark);
            font-size: 2rem;
            margin-bottom: 10px;
        }
        .help-header p {
            color: #666;
            max-width: 600px;
            margin: 0 auto;
        }

        .video-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 30px;
            max-width: 1000px;
            margin: 0 auto;
        }

        @media (min-width: 768px) {
            .video-grid {
                grid-template-columns: 1fr 1fr; /* Dos columnas en PC */
            }
        }

        /* Reutilizamos el estilo de tarjeta pero adaptado a video */
        .help-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            transition: transform 0.3s;
            display: flex;
            flex-direction: column;
        }
        .help-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .video-wrapper {
            position: relative;
            padding-bottom: 56.25%; /* Ratio 16:9 */
            height: 0;
            background: #000;
        }
        
        .video-wrapper iframe, 
        .video-wrapper video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }

        .help-content {
            padding: 20px;
        }
        .help-content h2 {
            color: var(--primary);
            margin-bottom: 10px;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .help-content p {
            font-size: 0.95rem;
            color: #555;
            line-height: 1.5;
        }
        
        /* Iconos decorativos */
        .icon-step {
            width: 30px;
            height: 30px;
            background: rgba(129, 110, 178, 0.1);
            color: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

    <div class="modal-overlay" id="acc-modal" aria-modal="true" role="dialog" aria-labelledby="acc-title">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="acc-title">Declaración de Accesibilidad</h2>
                <button class="modal-close" onclick="closeAccModal()" aria-label="Cerrar declaración">&times;</button>
            </div>
            <div style="font-size: 1rem; line-height: 1.6;">
                <p style="margin-bottom: 15px;">CardFactory está optimizando la accesibilidad del Catálogo.</p>
                <div style="background: #fff3cd; color: #856404; padding: 10px; border-radius: 8px; border: 1px solid #ffeeba; margin-bottom: 15px; font-size: 0.9rem;">
                    <strong>Estado:</strong> En proceso de mejora (WCAG 2.1).
                </div>
                <button onclick="closeAccModal()" style="margin-top: 15px; width: 100%; padding: 12px; background: var(--secondary); color: white; border: none; border-radius: 8px; font-weight: bold; cursor: pointer;">Entendido</button>
            </div>
        </div>
    </div>

    <div class="sidebar-overlay" id="overlay" onclick="toggleMenu()"></div>
    <div class="sidebar" id="sidebar">
        <button class="close-sidebar" id="closeSidebarBtn" onclick="toggleMenu()" aria-label="Cerrar menú">&times;</button>
        <h3 style="color: var(--primary); margin-bottom: 1rem;">Menú</h3>
        <a href="/">Inicio</a> 
        <a href="/dashboard">Login</a>
        <a href="/colecciones">Colecciones</a>
        <a href="/catalogo">Catálogo</a>
        <a href="/carrito">Carrito</a>
        <a href="/ayuda" style="color: var(--primary); font-weight: 700; border-left: 4px solid var(--primary); padding-left: 6px;">Ayuda</a>
    </div>

    <header>
        <button class="menu-trigger" id="menuBtn" onclick="toggleMenu()" aria-label="Abrir Menú">
            <i class="fas fa-bars"></i>
        </button>
        <div class="header-title">Centro de Ayuda</div>
        
        <div class="auth-actions" id="auth-container">
            @auth
                <a href="/dashboard" class="user-profile-widget">
                    <div class="profile-avatar">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <span class="profile-name">{{ Auth::user()->name }}</span>
                </a>
            @else
                <a href="/login" class="btn-header btn-login" style="color: var(--primary); border-color: var(--primary);">Login</a>
                <a href="/register" class="btn-header btn-register">Registro</a>
            @endauth
        </div>
    </header>

    <main class="container">
        
        <div class="help-header">
            <h1>¿Cómo funciona CardFactory?</h1>
            <p>Aprende a comprar y vender tus cartas de Magic de forma segura y rápida con nuestros tutoriales.</p>
        </div>

        <div class="video-grid">
            
            <article class="help-card">
                <div class="video-wrapper">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/dQw4w9WgXcQ?si=placeholder" title="YouTube video player" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                <div class="help-content">
                    <h2><div class="icon-step"><i class="fas fa-shopping-cart"></i></div> Cómo Comprar</h2>
                    <p>Descubre cómo buscar cartas en el catálogo, usar los filtros avanzados, añadir al carrito y finalizar tu pedido con seguridad.</p>
                </div>
            </article>

            <article class="help-card">
                <div class="video-wrapper">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/dQw4w9WgXcQ?si=placeholder" title="YouTube video player" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                <div class="help-content">
                    <h2><div class="icon-step"><i class="fas fa-tag"></i></div> Cómo Vender</h2>
                    <p>Aprende a registrarte como vendedor, subir tus cartas desde tu colección, establecer precios y gestionar tus envíos.</p>
                </div>
            </article>

        </div>

    </main>

    <footer role="contentinfo">
        <div class="footer-content">
            <div class="footer-section">
                <img src="/img/logo.jpg" alt="CardFactory Logo" class="footer-logo">
                <p>Tu mercado de confianza para comprar y vender cartas de Magic.</p>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <div class="footer-section">
                <h3>Enlaces Rápidos</h3>
                <ul class="footer-links">
                    <li><a href="/catalogo">Catálogo Completo</a></li>
                    <li><a href="/colecciones">Ver Colecciones</a></li>
                    <li><a href="/login" id="footer-login-link">Acceso Login</a></li> 
                    <li><a href="/ayuda">Ayuda</a></li>
                    <li><a href="javascript:void(0)" onclick="openAccModal()" style="color: #ffbf00;">Accesibilidad</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 CardFactory. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script>
        function toggleMenu() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        }
        // Sustituye tu función checkLoginStatus antigua por esta:
            function checkLoginStatus() {
                // 1. Buscamos el token
                const token = sessionStorage.getItem('auth_token') || localStorage.getItem('auth_token');
                
                // 2. Buscamos los datos "viejos" (caché) para mostrar algo rápido
                let storedUser = sessionStorage.getItem('user_data') || localStorage.getItem('user_data');
                let userData = { name: 'Usuario' };

                try {
                    if (storedUser) userData = JSON.parse(storedUser);
                } catch (e) {
                    console.error("Error parseando usuario", e);
                }

                if (token) {
                    // --- A. MOSTRAR DATOS DE LA CACHÉ (Inmediato) ---
                    updateUserUI(userData);

                    // --- B. PEDIR DATOS FRESCOS AL SERVIDOR (Segundo plano) ---
                    // Esto arregla tu problema: actualiza el nombre si cambió en la DB
                    fetch('/api/user', {
                        method: 'GET',
                        headers: {
                            'Authorization': `Bearer ${token}`,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (response.ok) return response.json();
                        throw new Error('Sesión expirada o inválida');
                    })
                    .then(freshUser => {
                        // Si el nombre ha cambiado, actualizamos todo
                        if (JSON.stringify(freshUser) !== storedUser) {
                            console.log("Datos actualizados desde el servidor");
                            
                            // 1. Guardar en memoria nueva
                            localStorage.setItem('user_data', JSON.stringify(freshUser));
                            sessionStorage.setItem('user_data', JSON.stringify(freshUser));
                            
                            // 2. Actualizar el Header otra vez con el nombre nuevo
                            updateUserUI(freshUser);
                        }
                    })
                    .catch(error => {
                        console.error("Error verificando sesión:", error);
                        // Opcional: Si el token no vale, cerrar sesión
                        // logout(); 
                    });

                } else {
                    // --- USUARIO NO LOGUEADO ---
                    showGuestUI();
                }
            }

            // --- FUNCIONES AUXILIARES PARA LIMPIAR EL CÓDIGO ---

            function updateUserUI(user) {
                const userName = user.name ? user.name.split(' ')[0] : 'Mi Cuenta';
                const authContainer = document.getElementById('auth-container');
                const linkSidebar = document.getElementById('link-perfil-sidebar');
                const footerLoginLink = document.getElementById('footer-login-link');

                // 1. Header
                if (authContainer) {
                    authContainer.innerHTML = `
                        <a href="/dashboard" class="user-profile-widget" title="Ir a mi perfil">
                            <div class="profile-avatar"><i class="fas fa-user"></i></div>
                            <span class="profile-name">${userName}</span>
                        </a>`;
                }
                // 2. Sidebar
                if (linkSidebar) {
                    linkSidebar.innerHTML = `Hola, ${userName}`;
                    linkSidebar.href = "/dashboard";
                    linkSidebar.style.color = "var(--primary)";
                    linkSidebar.style.fontWeight = "bold";
                }
                // 3. Footer
                if (footerLoginLink) {
                    footerLoginLink.textContent = "Mi Perfil";
                    footerLoginLink.href = "/dashboard";
                }
            }

            function showGuestUI() {
                const authContainer = document.getElementById('auth-container');
                const linkSidebar = document.getElementById('link-perfil-sidebar');
                const footerLoginLink = document.getElementById('footer-login-link');

                if (authContainer) {
                    authContainer.innerHTML = `
                        <a href="/login" class="btn-header btn-login">Login</a>
                        <a href="/register" class="btn-header btn-register">Registro</a>`;
                }
                if (linkSidebar) {
                    linkSidebar.textContent = "Login";
                    linkSidebar.href = "/login";
                    linkSidebar.style.color = "";
                }
                if (footerLoginLink) {
                    footerLoginLink.textContent = "Acceso Login";
                    footerLoginLink.href = "/login";
                }
            }
        function openAccModal() {
            document.getElementById('acc-modal').classList.add('active');
        }

        function closeAccModal() {
            document.getElementById('acc-modal').classList.remove('active');
        }

        // Cerrar modal al hacer clic fuera
        document.getElementById('acc-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeAccModal();
            }
        });
    </script>
</body>
</html>