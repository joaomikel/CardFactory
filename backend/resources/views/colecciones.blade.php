<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>CardFactory - Todas las Colecciones</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #816EB2;
            --primary-dark: #5e4c8d; 
            --secondary: #958EA0;
            --text-dark: #222;
            --text-light: #f4f4f4;
            --white: #ffffff;
            --radius: 16px;
            --focus-ring: #ffbf00;
        }

        * { 
            margin: 0; padding: 0; 
            box-sizing: border-box; 
            -webkit-tap-highlight-color: transparent;
            font-family: 'Inter', sans-serif;
        }

        /* --- MEJORA DE FOCO (ÚNICO CAMBIO DE ESTILO) --- */
        :focus-visible {
            outline: 3px solid var(--focus-ring) !important;
            outline-offset: 2px;
        }
        button:focus, input:focus, a:focus { outline: none; }

        html, body {
            width: 100%;
            max-width: 100vw;
            overflow-x: hidden;
            background-color: #f8f9fa; 
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* --- HEADER --- */
        header {
            background: transparent;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            position: absolute;
            top: 0; left: 0; right: 0;
            width: 100%;
            z-index: 100;
        }

        .menu-trigger { 
            font-size: 1.8rem; 
            background: none; 
            border: none; 
            color: var(--white); 
            cursor: pointer; 
            padding: 10px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.5);
            margin-right: auto;
        }

        .auth-actions { 
            display: flex; gap: 10px; align-items: center; margin-left: auto;
        }

        .btn-header {
            padding: 8px 16px; 
            border-radius: 20px; 
            font-weight: 600;
            text-decoration: none; 
            font-size: 0.85rem; 
            transition: 0.3s;
            white-space: nowrap;
        }
        .btn-login { 
            background: rgba(255,255,255,0.25); 
            color: var(--white); 
            border: 1px solid rgba(255,255,255,0.5); 
            backdrop-filter: blur(4px); 
        }
        .btn-login:hover { background: rgba(255,255,255,0.4); }

        .btn-register { 
            background: var(--primary); 
            color: var(--white); 
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        }
        .btn-register:hover { transform: translateY(-2px); }

        /* --- ESTILOS DE PERFIL (LOGUEADO) --- */
        .user-profile-widget {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(255, 255, 255, 0.2);
            padding: 5px 15px 5px 5px;
            border-radius: 30px;
            border: 1px solid rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(5px);
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .user-profile-widget:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }
        .profile-avatar {
            width: 32px; height: 32px;
            background: var(--primary);
            color: white;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem;
            border: 2px solid rgba(255,255,255,0.8);
        }
        .profile-name {
            color: white; font-weight: 600; font-size: 0.9rem;
            max-width: 100px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
            display: none; 
        }
        @media (min-width: 480px) { .profile-name { display: block; } }

        /* --- SIDEBAR --- */
        .sidebar-overlay {
            position: fixed; top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.6); z-index: 101; opacity: 0; pointer-events: none; transition: 0.3s;
            backdrop-filter: blur(3px);
        }
        .sidebar-overlay.active { opacity: 1; pointer-events: all; }

        .sidebar {
            position: fixed; top: 0; left: -100%; width: 280px; height: 100%;
            background: var(--white); z-index: 102; padding: 2rem; 
            transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex; flex-direction: column; gap: 1rem;
            box-shadow: 5px 0 20px rgba(0,0,0,0.1);
            visibility: hidden; /* Evita foco cuando está cerrado */
        }
        .sidebar.active { left: 0; visibility: visible; }
        .close-sidebar { position: absolute; top: 15px; right: 15px; font-size: 1.8rem; background: none; border: none; color: #666; cursor: pointer;}
        .sidebar a { padding: 15px 0; border-bottom: 1px solid #eee; color: var(--secondary); text-decoration: none; font-size: 1.1rem; font-weight: 500;}

        /* --- HERO --- */
        .hero-mini {
            position: relative; width: 100%;
            padding: 110px 20px 60px 20px; 
            display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center;
            background: linear-gradient(180deg, rgba(0,0,0,0.4) 0%, rgba(129, 110, 178, 0.95) 100%), url('https://cards.scryfall.io/art_crop/front/e/3/e37da81e-be12-45a2-9128-376f1ad7b3e8.jpg?1562202585'); 
            background-size: cover; background-position: center top;
            margin-bottom: 20px; color: white;
            border-bottom-left-radius: 25px; border-bottom-right-radius: 25px;
            overflow: hidden;
        }
        .hero-mini h1 { font-size: 1.8rem; margin-bottom: 20px; line-height: 1.2; text-shadow: 0 2px 10px rgba(0,0,0,0.3); }
        .search-wrapper-mini { width: 100%; max-width: 500px; position: relative; }
        .search-wrapper-mini input {
            width: 100%; padding: 14px 45px 14px 20px; font-size: 1rem;
            border: none; border-radius: 50px; outline: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2); 
        }
        .search-icon-mini { position: absolute; right: 20px; top: 50%; transform: translateY(-50%); color: var(--primary); }

        /* --- CONTENIDO --- */
        .container { width: 100%; padding: 0 15px; margin: 0 auto; flex: 1; }
        .sets-grid { display: grid; grid-template-columns: 1fr; gap: 15px; margin-bottom: 30px; width: 100%; }
        .set-item {
            background: var(--white); border-radius: var(--radius);
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            display: flex; align-items: center; padding: 15px; gap: 15px;
            cursor: pointer; border-left: 4px solid var(--primary); width: 100%;
            overflow: hidden; transition: transform 0.2s;
        }
        .set-item:active { transform: scale(0.98); }
        .set-icon {
            width: 40px; height: 40px; flex-shrink: 0;
            filter: invert(53%) sepia(12%) saturate(1469%) hue-rotate(218deg) brightness(88%) contrast(86%);
            opacity: 0.9;
        }
        .set-info { flex: 1; min-width: 0; display: flex; flex-direction: column; justify-content: center; }
        .set-info h3 { font-size: 1rem; color: var(--text-dark); margin-bottom: 4px; font-weight: 700; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .set-info p { font-size: 0.85rem; color: #666; margin: 0; }
        .arrow-indicator { font-size: 1.2rem; color: #ccc; margin-left: auto; }
        .btn-more {
            display: block; width: 100%; max-width: 300px; margin: 20px auto;
            background: white; color: var(--primary); border: 2px solid var(--primary);
            padding: 12px; border-radius: 50px; font-weight: 700; font-size: 1rem;
            cursor: pointer; box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        /* --- FOOTER --- */
        footer { margin-top: auto; background: #2b2440; color: var(--text-light); padding-top: 60px; }
        .footer-content {
            display: grid; grid-template-columns: 1fr; gap: 40px;
            max-width: 1200px; margin: 0 auto; padding: 0 20px 40px;
        }
        .footer-section h3 { font-size: 1.3rem; margin-bottom: 20px; color: var(--white); }
        .footer-section p { font-size: 1rem; line-height: 1.6; opacity: 1; color: #e0e0e0; }
        
        /* ESTILO NUEVO PARA EL LOGO DEL FOOTER */
        .footer-logo {
            width: 150px; /* Tamaño controlado */
            height: auto;
            margin-bottom: 15px;
            display: block;
            border-radius: 8px;
        }

        .footer-links { list-style: none; }
        .footer-links li { margin-bottom: 12px; }
        .footer-links a {
            text-decoration: underline; text-underline-offset: 4px;
            color: #e0e0e0; transition: 0.3s; font-size: 1rem; cursor: pointer;
        }
        .footer-links a:hover, .footer-links a:focus {
            color: var(--white); background-color: rgba(255,255,255,0.1);
        }
        .social-icons { display: flex; gap: 15px; margin-top: 20px; }
        .social-icons a {
            width: 44px; height: 44px; background: rgba(255,255,255,0.1);
            display: flex; align-items: center; justify-content: center;
            border-radius: 50%; color: var(--white); text-decoration: none; transition: 0.3s;
        }
        .social-icons a:hover, .social-icons a:focus { background: var(--primary); transform: translateY(-3px); }
        .footer-bottom { background: #1a1626; padding: 20px; text-align: center; font-size: 0.9rem; color: #ccc; }

        /* --- ACCESSIBILITY MODAL --- */
        .modal-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.8); z-index: 2000;
            display: none; align-items: center; justify-content: center;
            backdrop-filter: blur(4px);
        }
        .modal-overlay.active { display: flex; animation: fadeIn 0.3s; }
        .modal-content {
            background: white; width: 90%; max-width: 600px; max-height: 85vh;
            overflow-y: auto; border-radius: 12px; padding: 30px;
            position: relative; box-shadow: 0 20px 50px rgba(0,0,0,0.5);
            border: 2px solid var(--secondary);
        }
        .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 2px solid #eee; padding-bottom: 10px; }
        .modal-title { color: var(--primary-dark); font-size: 1.5rem; font-weight: 800; }
        .modal-close {
            background: transparent; border: 2px solid var(--secondary); color: var(--secondary);
            width: 40px; height: 40px; border-radius: 50%; font-size: 1.2rem; cursor: pointer;
            transition: 0.3s;
        }
        .modal-close:hover, .modal-close:focus { background: var(--primary); border-color: var(--primary); color: white; }
        
        /* Listas y Etiquetas Accesibilidad */
        .acc-list { margin-left: 20px; margin-bottom: 20px; }
        .acc-list li { margin-bottom: 10px; color: #333; }
        .acc-tag { display: inline-block; padding: 2px 8px; border-radius: 4px; font-weight: bold; font-size: 0.8rem; margin-right: 5px; }
        
        .tag-aa { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        /* NUEVO: Etiquetas para lo que falla */
        .tag-fail { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .acc-subtitle { font-weight: 700; margin-top: 15px; margin-bottom: 5px; display: block; color: var(--text-dark); }
        
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

        @media (min-width: 768px) {
            .container { max-width: 1200px; padding: 0 40px; }
            .sets-grid { grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 25px; }
            .hero-mini { padding: 160px 40px 80px 40px; border-radius: 0; }
            .hero-mini h1 { font-size: 3rem; }
            header { padding: 0 40px; height: 90px; }
            .footer-content { grid-template-columns: repeat(2, 1fr); }
        }
        @media (min-width: 1024px) {
            .footer-content { grid-template-columns: repeat(4, 1fr); }
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
                <p style="margin-bottom: 15px;">
                    CardFactory se encuentra en proceso de auditoría para cumplir con los estándares WCAG 2.1.
                </p>
                
                <div style="background: #fff3cd; color: #856404; padding: 10px; border-radius: 8px; border: 1px solid #ffeeba; margin-bottom: 15px; font-size: 0.9rem;">
                    <strong>Estado:</strong> PARCIALMENTE CONFORME (Nivel AA).
                </div>

                <span class="acc-subtitle">✅ Puntos cumplidos:</span>
                <ul class="acc-list">
                    <li><span class="acc-tag tag-aa">Navegación</span> Foco visible (outline amarillo) en elementos interactivos.</li>
                    <li><span class="acc-tag tag-aa">Semántica</span> Estructura correcta de encabezados (h1, h2, h3).</li>
                </ul>

                <span class="acc-subtitle">❌ Pendiente de corrección:</span>
                <ul class="acc-list">
                    <li>
                        <span class="acc-tag tag-fail">Imágenes</span> 
                        Algunas cartas cargadas dinámicamente no tienen texto alternativo (alt) descriptivo.
                    </li>
                    <li>
                        <span class="acc-tag tag-fail">Formularios</span> 
                        El buscador de sets no tiene una etiqueta &lt;label&gt; visible, solo placeholder.
                    </li>
                    <li>
                        <span class="acc-tag tag-fail">Modal</span> 
                        Al abrir este modal, el foco del teclado no queda atrapado dentro (Focus Trap).
                    </li>
                </ul>

                <button onclick="closeAccModal()" style="margin-top: 15px; width: 100%; padding: 12px; background: var(--secondary); color: white; border: none; border-radius: 8px; font-weight: bold; cursor: pointer;">Entendido</button>
            </div>
        </div>
    </div>

    <div class="sidebar-overlay" id="overlay" onclick="toggleMenu()"></div>
    <div class="sidebar" id="sidebar">
        <button class="close-sidebar" id="closeSidebarBtn" onclick="toggleMenu()" aria-label="Cerrar menú">&times;</button>
        <h3 style="color: var(--primary); margin-bottom: 1.5rem;">Menú</h3>
        <a href="/">Inicio</a>
        <a href="/dashboard" id="link-perfil-sidebar">Login</a> 
        <a href="/colecciones" style="color: var(--primary); font-weight: 700; border-left: 4px solid var(--primary); padding-left: 10px;">Colecciones</a>
        <a href="/catalogo">Catálogo</a>
        <a href="/carrito">Carrito</a>
    </div>

    <header>
        <button class="menu-trigger" id="menuBtn" onclick="toggleMenu()" aria-label="Abrir menú">☰</button>
        <div class="auth-actions" id="auth-container">
            <a href="/login" class="btn-header btn-login">Login</a>
            <a href="/register" class="btn-header btn-register">Registro</a>
        </div>
    </header>

    <section class="hero-mini">
        <h1>Explorar Sets</h1>
        <div class="search-wrapper-mini">
            <input type="text" placeholder="Buscar edición..." id="setSearchInput">
            <i class="fas fa-search search-icon-mini"></i>
        </div>
    </section>

    <main class="container">
        <div class="sets-grid" id="sets-container">
            <p style="text-align:center; padding: 20px; color: #666;">Cargando...</p>
        </div>
        <button class="btn-more" id="loadMoreBtn">Cargar más</button>
    </main>

    <footer role="contentinfo">
        <div class="footer-content">
            <div class="footer-section">
                <img src="http://localhost:8000/logo.jpg" alt="CardFactory Logo" class="footer-logo">                <p>Tu mercado de confianza para comprar y vender cartas de Magic.</p>
                <div class="social-icons">
                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <div class="footer-section">
                <h3>Enlaces Rápidos</h3>
                <ul class="footer-links">
                    <li><a href="{{ url('/catalogo') }}">Catálogo Completo</a></li>
                    <li><a href="{{ url('/colecciones') }}">Ver Colecciones</a></li>
                    <li><a href="{{ url('/login') }}" id="footer-login-link">Acceso Login</a></li> 
                    <li><a href="javascript:void(0)" onclick="openAccModal()" id="acc-trigger" style="color: #ffbf00;">Accesibilidad</a></li>
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
            const menuBtn = document.getElementById('menuBtn');
            const closeBtn = document.getElementById('closeSidebarBtn');

            const isActive = sidebar.classList.toggle('active');
            overlay.classList.toggle('active');

            if (isActive) {
                setTimeout(() => closeBtn.focus(), 300);
            } else {
                menuBtn.focus();
            }
        }

        function checkLoginStatus() {
            const token = localStorage.getItem('auth_token') || sessionStorage.getItem('auth_token');
            const authContainer = document.getElementById('auth-container');
            const footerLoginLink = document.getElementById('footer-login-link');
            const linkSidebar = document.getElementById('link-perfil-sidebar');
            
            let userData = { name: 'Usuario' };
            try {
                const storedUser = localStorage.getItem('user_data') || sessionStorage.getItem('user_data');
                if (storedUser) userData = JSON.parse(storedUser);
            } catch (e) { }

            if (token) {
                const userName = userData.name ? userData.name.split(' ')[0] : 'Perfil';
                if (authContainer) {
                    authContainer.innerHTML = `
                        <a href="/dashboard" class="user-profile-widget" title="Ir a mi perfil">
                            <div class="profile-avatar"><i class="fas fa-user"></i></div>
                            <span class="profile-name">${userName}</span>
                        </a>`;
                }
                if (linkSidebar) {
                    linkSidebar.innerHTML = `Hola, ${userName}`;
                    linkSidebar.href = "/dashboard";
                }
                if (footerLoginLink) {
                    footerLoginLink.textContent = "Mi Perfil";
                    footerLoginLink.href = "/dashboard";
                }
            }
        }

        let allSets = [];
        let currentCount = 20;

        async function loadSets() {
            const container = document.getElementById('sets-container');
            try {
                const res = await fetch('https://api.scryfall.com/sets');
                const data = await res.json();
                const validTypes = ['expansion', 'core', 'masters', 'draft_innovation', 'commander', 'modern'];
                allSets = data.data.filter(set => validTypes.includes(set.set_type));
                allSets.sort((a, b) => new Date(b.released_at) - new Date(a.released_at));
                renderSets(allSets.slice(0, currentCount));
            } catch (error) {
                container.innerHTML = '<p>Error de conexión.</p>';
            }
        }

        function renderSets(setsList) {
            const container = document.getElementById('sets-container');
            if(setsList.length === 0) {
                container.innerHTML = '<p style="text-align:center; padding:20px;">No hay resultados.</p>';
                return;
            }
            container.innerHTML = setsList.map(set => `
                <div class="set-item" tabindex="0" onclick="window.location.href='/catalogo?set=${set.code}'" onkeypress="if(event.key==='Enter')window.location.href='/catalogo?set=${set.code}'">
                    <img src="${set.icon_svg_uri}" class="set-icon" alt="" loading="lazy">
                    <div class="set-info">
                        <h3>${set.name}</h3>
                        <p>${set.card_count} Cartas • ${new Date(set.released_at).getFullYear()}</p>
                    </div>
                    <div class="arrow-indicator">›</div>
                </div>
            `).join('');
        }

        document.getElementById('setSearchInput').addEventListener('keyup', (e) => {
            const term = e.target.value.toLowerCase();
            const filtered = allSets.filter(set => set.name.toLowerCase().includes(term));
            renderSets(filtered.slice(0, 20));
            document.getElementById('loadMoreBtn').style.display = (term !== '' || filtered.length <= 20) ? 'none' : 'block';
        });

        document.getElementById('loadMoreBtn').addEventListener('click', () => {
            currentCount += 20;
            renderSets(allSets.slice(0, currentCount));
            if (currentCount >= allSets.length) document.getElementById('loadMoreBtn').style.display = 'none';
        });

        let lastFocusedElement;
        function openAccModal() {
            lastFocusedElement = document.activeElement;
            const modal = document.getElementById('acc-modal');
            modal.classList.add('active');
            setTimeout(() => { modal.querySelector('.modal-close').focus(); }, 100);
            document.body.style.overflow = 'hidden';
        }

        function closeAccModal() {
            document.getElementById('acc-modal').classList.remove('active');
            document.body.style.overflow = '';
            if (lastFocusedElement) lastFocusedElement.focus();
        }

        document.addEventListener("DOMContentLoaded", () => {
            checkLoginStatus(); 
            loadSets(); 
        });
    </script>
</body>
</html>