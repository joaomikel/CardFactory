<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Catálogo - CardFactory</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root { 
            --primary: #816EB2; 
            --primary-dark: #5e4c8d;
            --secondary: #958EA0;
            --dark: #222; 
            --white: #ffffff; 
            --bg: #f9f9f9;
            --radius: 12px;
            --focus-ring: #ffbf00;
            --text-light: #f4f4f4;
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; -webkit-tap-highlight-color: transparent; }
        
        :focus-visible {
            outline: 3px solid var(--focus-ring) !important;
            outline-offset: 2px;
            z-index: 10;
        }
        button:focus:not(:focus-visible), a:focus:not(:focus-visible) { outline: none; }
        
        body { 
            background-color: var(--bg); 
            color: var(--dark); 
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            width: 100%;
            overflow-x: hidden;
        }

        /* --- MODAL ACCESIBILIDAD --- */
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
        
        .acc-list { margin-left: 20px; margin-bottom: 20px; }
        .acc-list li { margin-bottom: 10px; color: #333; }
        .acc-tag { display: inline-block; padding: 2px 8px; border-radius: 4px; font-weight: bold; font-size: 0.8rem; margin-right: 5px; }
        
        .tag-aa { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .tag-fail { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .acc-subtitle { font-weight: 700; margin-top: 15px; margin-bottom: 5px; display: block; color: var(--dark); }
        
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

        /* --- HEADER --- */
        header {
            background: linear-gradient(135deg, var(--primary), #9ca3af);
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
            width: 100%;
        }

        .menu-trigger {
            font-size: 1.8rem; background: none; border: none;
            color: var(--white); cursor: pointer; padding: 10px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .header-title {
            color: white; font-weight: 800; font-size: 1.2rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
            position: absolute; left: 50%; transform: translateX(-50%);
            white-space: nowrap;
        }

        .auth-actions { display: flex; gap: 10px; align-items: center; }

        .btn-header {
            padding: 8px 16px; border-radius: 20px; font-weight: 600;
            text-decoration: none; font-size: 0.85rem; transition: 0.3s;
            white-space: nowrap;
        }
        .btn-login { 
            background: rgba(255,255,255,0.25); color: var(--white); 
            border: 1px solid rgba(255,255,255,0.5); backdrop-filter: blur(4px); 
        }
        .btn-login:hover { background: rgba(255,255,255,0.4); }

        .btn-register { 
            background: var(--white); color: var(--primary); 
            box-shadow: 0 4px 10px rgba(0,0,0,0.2); 
            display: none; 
        }
        @media (min-width: 480px) { .btn-register { display: inline-block; } }
        .btn-register:hover { transform: translateY(-2px); }

        /* --- PERFIL --- */
        .user-profile-widget {
            display: flex; align-items: center; gap: 10px;
            background: rgba(255, 255, 255, 0.25); padding: 5px 15px 5px 5px;
            border-radius: 30px; border: 1px solid rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(5px); text-decoration: none; transition: 0.3s; cursor: pointer;
        }
        .user-profile-widget:hover { background: rgba(255, 255, 255, 0.4); transform: translateY(-2px); }
        .profile-avatar {
            width: 32px; height: 32px; background: var(--primary); color: white;
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-size: 1rem; border: 2px solid rgba(255,255,255,0.8);
        }
        .profile-name { color: white; font-weight: 600; font-size: 0.9rem; max-width: 100px; overflow: hidden; text-overflow: ellipsis; display: none; }
        @media (min-width: 600px) { .profile-name { display: block; } }

        /* --- SIDEBAR --- */
        .sidebar-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.6); z-index: 101; opacity: 0;
            pointer-events: none; transition: 0.3s; backdrop-filter: blur(2px);
        }
        .sidebar-overlay.active { opacity: 1; pointer-events: all; }

        .sidebar {
            position: fixed; top: 0; left: -100%; width: 280px; height: 100%;
            background: var(--white); z-index: 102; padding: 2rem;
            transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1); display: flex;
            flex-direction: column; gap: 1rem; box-shadow: 5px 0 15px rgba(0,0,0,0.2);
            visibility: hidden;
        }
        .sidebar.active { left: 0; visibility: visible; }
        .close-sidebar { position: absolute; top: 20px; right: 20px; font-size: 2rem; background: none; border: none; cursor: pointer; color: #666; }
        .sidebar a { padding: 15px 10px; font-weight: 500; color: var(--secondary); border-bottom: 1px solid #eee; text-decoration: none; font-size: 1.1rem; }

        /* --- FILTROS --- */
        .filters {
            background: white; padding: 20px; display: flex; flex-direction: column;
            gap: 15px; border-bottom: 1px solid #ddd;
            box-shadow: 0 4px 10px rgba(0,0,0,0.03);
            width: 100%;
        }
        .filter-group { display: flex; flex-direction: column; gap: 8px; flex: 1; }
        .filter-group label { font-size: 0.75rem; font-weight: 800; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; }
        
        .filter-control { 
            padding: 12px; border: 1px solid #d1d5db; border-radius: 10px; 
            font-size: 16px; background: #fafafa; width: 100%; outline: none; transition: 0.3s;
        }
        .filter-control:focus { 
            border-color: var(--focus-ring); background: white; 
        }
        
        .btn-apply { 
            background: var(--primary); color: white; padding: 15px; border: none; 
            border-radius: 10px; font-weight: 700; cursor: pointer;
            box-shadow: 0 4px 12px rgba(129, 110, 178, 0.3); margin-top: 10px; transition: 0.3s;
        }
        .btn-apply:hover { transform: translateY(-2px); box-shadow: 0 6px 15px rgba(129, 110, 178, 0.4); }

        /* --- GRID --- */
        .container { padding: 20px; max-width: 1200px; margin: 0 auto; flex-grow: 1; width: 100%; }
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 15px; width: 100%; }
        .card-catalog {
            background: white; border-radius: 12px; overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06); display: flex; flex-direction: column;
            transition: transform 0.3s, box-shadow 0.3s; border: 1px solid transparent;
        }
        .card-catalog:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .card-catalog img { width: 100%; aspect-ratio: 2.5/3.5; object-fit: cover; border-bottom: 1px solid #f0f0f0; }
        .card-info { padding: 12px; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between; }
        .card-info h3 { font-size: 0.9rem; color: var(--dark); margin-bottom: 8px; line-height: 1.3; font-weight: 600; }
        .card-price { color: var(--primary); font-weight: 800; font-size: 1rem; }

        /* --- FOOTER --- */
        footer { margin-top: auto; background: #2b2440; color: var(--text-light); padding-top: 60px; width: 100%; }
        .footer-content { display: grid; grid-template-columns: 1fr; gap: 40px; max-width: 1200px; margin: 0 auto; padding: 0 20px 40px; }
        
        .footer-logo {
            max-width: 180px;
            height: auto;
            margin-bottom: 15px;
            display: block;
            border-radius: 8px;
        }

        .footer-section h3 { font-size: 1.3rem; margin-bottom: 20px; color: var(--white); }
        .footer-section p { font-size: 1rem; line-height: 1.6; opacity: 1; color: #e0e0e0; }
        .footer-links { list-style: none; }
        .footer-links li { margin-bottom: 12px; }
        .footer-links a { text-decoration: underline; text-underline-offset: 4px; color: #e0e0e0; transition: 0.3s; font-size: 1rem; cursor: pointer; }
        .footer-links a:hover, .footer-links a:focus { color: var(--white); background-color: rgba(255,255,255,0.1); }
        .social-icons { display: flex; gap: 15px; margin-top: 20px; }
        .social-icons a {
            width: 44px; height: 44px; background: rgba(255,255,255,0.1);
            display: flex; align-items: center; justify-content: center;
            border-radius: 50%; color: var(--white); text-decoration: none; transition: 0.3s;
        }
        .social-icons a:hover, .social-icons a:focus { background: var(--primary); transform: translateY(-3px); }
        .footer-bottom { background: #1a1626; padding: 20px; text-align: center; font-size: 0.9rem; color: #ccc; }

        @media (min-width: 768px) {
            header { padding: 0 40px; height: 90px; }
            .filters { flex-direction: row; align-items: flex-end; justify-content: center; padding: 30px; flex-wrap: wrap; }
            .filter-group { min-width: 140px; max-width: 180px; }
            .search-group { flex: 2; min-width: 250px; } 
            .grid { gap: 25px; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); }
            .btn-apply { padding: 12px 30px; margin-top: 0; height: 46px; }
            .footer-content { grid-template-columns: repeat(2, 1fr); }
            .container { padding: 40px; }
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
                    CardFactory está optimizando la accesibilidad del Catálogo.
                </p>
                
                <div style="background: #fff3cd; color: #856404; padding: 10px; border-radius: 8px; border: 1px solid #ffeeba; margin-bottom: 15px; font-size: 0.9rem;">
                    <strong>Estado:</strong> En proceso de mejora (WCAG 2.1).
                </div>

                <span class="acc-subtitle">✅ Funcional:</span>
                <ul class="acc-list">
                    <li><span class="acc-tag tag-aa">Teclado</span> Foco visible amarillo en filtros y cartas.</li>
                    <li><span class="acc-tag tag-aa">Contraste</span> Textos ajustados para lectura clara.</li>
                </ul>

                <span class="acc-subtitle">❌ En revisión:</span>
                <ul class="acc-list">
                    <li><span class="acc-tag tag-fail">Imágenes</span> Textos alternativos (alt) pendientes en carga dinámica.</li>
                    <li><span class="acc-tag tag-fail">Filtros</span> Labels visuales pequeños en móviles.</li>
                </ul>

                <button onclick="closeAccModal()" style="margin-top: 15px; width: 100%; padding: 12px; background: var(--secondary); color: white; border: none; border-radius: 8px; font-weight: bold; cursor: pointer;">Entendido</button>
            </div>
        </div>
    </div>

    <div class="sidebar-overlay" id="overlay" onclick="toggleMenu()"></div>
    <div class="sidebar" id="sidebar">
        <button class="close-sidebar" id="closeSidebarBtn" onclick="toggleMenu()" aria-label="Cerrar menú">&times;</button>
        <h3 style="color: var(--primary); margin-bottom: 1rem;">Menú</h3>
        <a href="/">Inicio</a> 
        <a href="/dashboard" id="link-perfil-sidebar">Login</a>
        <a href="/colecciones">Colecciones</a>
        <a href="/catalogo" style="color: var(--primary); font-weight: 700; border-left: 4px solid var(--primary); padding-left: 6px;">Catálogo</a>
        <a href="/carrito">Carrito</a>
    </div>

    <header>
        <button class="menu-trigger" id="menuBtn" onclick="toggleMenu()" aria-label="Abrir Menú">☰</button>
        <div class="header-title">Catálogo</div>
        <div class="auth-actions" id="auth-container">
            <a href="/login" class="btn-header btn-login">Login</a>
            <a href="/register" class="btn-header btn-register">Registro</a>
        </div>
    </header>

    <section class="filters">
        <div class="filter-group search-group">
            <label for="search-name">Nombre de la carta</label>
            <div style="position: relative;">
                <input type="text" id="search-name" placeholder="Ej: Black Lotus..." class="filter-control">
                <i class="fas fa-search" style="position: absolute; right: 15px; top: 13px; color: #9ca3af; pointer-events: none;" aria-hidden="true"></i>
            </div>
        </div>

        <div class="filter-group">
            <label for="color">Color</label>
            <select id="color" class="filter-control">
                <option value="">Todos</option>
                <option value="w">Blanco</option>
                <option value="u">Azul</option>
                <option value="b">Negro</option>
                <option value="r">Rojo</option>
                <option value="g">Verde</option>
            </select>
        </div>

        <div class="filter-group">
            <label for="rarity">Rareza</label>
            <select id="rarity" class="filter-control">
                <option value="">Todas</option>
                <option value="common">Común</option>
                <option value="uncommon">Infrecuente</option>
                <option value="rare">Rara</option>
                <option value="mythic">Mítica</option>
            </select>
        </div>

        <div class="filter-group">
            <label for="set">Colección</label>
            <select id="set" class="filter-control">
                <option value="">Todas</option>
                <option value="dft">Aetherdrift (DFT)</option>
                <option value="fdn">Foundations (FDN)</option>
                <option value="dsk">Duskmourn (DSK)</option>
                <option value="mh3">Modern Horizons 3</option>
                <option value="ltr">Lord of the Rings</option>
            </select>
        </div>

        <button class="btn-apply" onclick="applyFilters()">Aplicar Filtros</button>
    </section>

    <main class="container">
        <div class="grid" id="catalog-grid">
            <p style="grid-column: 1/-1; text-align: center; padding: 50px;">Buscando cartas...</p>
        </div>
    </main>

    <footer role="contentinfo">
        <div class="footer-content">
            <div class="footer-section">
                <img src="http://localhost:8000/logo.jpg" alt="CardFactory Logo" class="footer-logo">
                <p>Tu mercado de confianza para comprar y vender cartas de Magic: The Gathering.</p>
                <div class="social-icons">
                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <div class="footer-section">
                <h3>Enlaces Rápidos</h3>
                <ul class="footer-links">
                    <li><a href="/catalogo">Catálogo Completo</a></li>
                    <li><a href="/colecciones">Ver Colecciones</a></li>
                    <li><a href="/login" id="footer-login-link">Acceso Login</a></li> 
                    <li><a href="javascript:void(0)" onclick="openAccModal()" id="acc-trigger" style="color: #ffbf00;">Accesibilidad</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 CardFactory. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script>
        /* --- GESTIÓN DE FOCO Y ACCESIBILIDAD --- */
        let lastFocusedElement;

        function toggleMenu() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            const menuBtn = document.getElementById('menuBtn');
            const closeBtn = document.getElementById('closeSidebarBtn');

            const isActive = sidebar.classList.toggle('active');
            overlay.classList.toggle('active');

            if (isActive) {
                lastFocusedElement = document.activeElement;
                setTimeout(() => closeBtn.focus(), 300);
            } else {
                if(menuBtn) menuBtn.focus();
            }
        }

        /* --- MODAL ACCESIBILIDAD --- */
        function openAccModal() {
            lastFocusedElement = document.activeElement;
            const modal = document.getElementById('acc-modal');
            modal.classList.add('active');
            
            // Focus trap simple
            setTimeout(() => { modal.querySelector('.modal-close').focus(); }, 100);
            document.body.style.overflow = 'hidden'; // Bloquear scroll
        }

        function closeAccModal() {
            document.getElementById('acc-modal').classList.remove('active');
            document.body.style.overflow = ''; 
            if (lastFocusedElement) lastFocusedElement.focus();
        }

        /* --- LÓGICA DE USUARIO --- */
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

        /* --- API Y CATÁLOGO --- */
        async function checkLocalStock(scryfallIds) {
            // Simulación de respuesta vacía si falla la API interna
            try {
                // En producción esto iría a tu backend real
                return {}; 
            } catch (error) { return {}; }
        }

        async function fetchCards(q = 'f:standard') {
            const grid = document.getElementById('catalog-grid');
            if(!grid) return;
            grid.innerHTML = '<p style="grid-column: 1/-1; text-align: center; padding: 50px;"><i class="fas fa-circle-notch fa-spin"></i> Cargando cartas...</p>';

            try {
                const res = await fetch(`https://api.scryfall.com/cards/search?q=${encodeURIComponent(q)}`);
                const data = await res.json();
                
                if(!data.data || data.data.length === 0) {
                    grid.innerHTML = '<p style="grid-column: 1/-1; text-align: center;">No se encontraron cartas.</p>';
                    return;
                }

                // Generamos el HTML
                grid.innerHTML = data.data.map(card => {
                    // Obtener imagen (manejo de doble cara)
                    let imgUrl = 'https://via.placeholder.com/488x680';
                    if (card.image_uris && card.image_uris.normal) {
                        imgUrl = card.image_uris.normal;
                    } else if (card.card_faces && card.card_faces[0].image_uris) {
                        imgUrl = card.card_faces[0].image_uris.normal;
                    }

                    // Precio simulado o de Scryfall si no hay stock local
                    const price = card.prices?.eur ? `${card.prices.eur}€` : 'N/A';

                    return `
                        <a href="/carta?id=${card.id}" class="card-catalog" tabindex="0">
                            <img src="${imgUrl}" alt="Carta: ${card.name}" loading="lazy">
                            <div class="card-info">
                                <h3>${card.name}</h3>
                                <p class="card-price">${price}</p>
                            </div>
                        </a>
                    `;
                }).join('');
            } catch (e) { 
                console.error(e);
                grid.innerHTML = '<p style="grid-column: 1/-1; text-align: center;">Error de conexión con la base de datos.</p>'; 
            }
        }

        function applyFilters() {
            const name = document.getElementById('search-name').value;
            const color = document.getElementById('color').value;
            const rarity = document.getElementById('rarity').value;
            const set = document.getElementById('set').value;
            
            let queryParts = [];
            
            // Construir query de Scryfall
            if (name) queryParts.push(`name:${name}`);
            if (color) queryParts.push(`c:${color}`);
            if (rarity) queryParts.push(`r:${rarity}`);
            if (set) queryParts.push(`s:${set}`);
            
            // Si no hay filtros, busca estándar por defecto
            const finalQuery = queryParts.length > 0 ? queryParts.join(' ') : 'f:standard';
            fetchCards(finalQuery);
        }

        /* --- INICIALIZACIÓN --- */
        document.addEventListener('DOMContentLoaded', () => {
            checkLoginStatus();
            
            // Verificar si hay parámetros en la URL (ej: ?set=dft)
            const params = new URLSearchParams(window.location.search);
            const setCode = params.get('set');
            
            if (setCode) {
                // Si venimos de la página de Sets, pre-seleccionar filtro
                const setSelect = document.getElementById('set');
                // Intentar seleccionar si existe la opción, o añadirla dinámicamente si es necesario
                if(setSelect) {
                    setSelect.value = setCode;
                    // Si el valor no existe en el select (porque tenemos pocos hardcoded), forzamos búsqueda igual
                    fetchCards(`s:${setCode}`);
                }
            } else {
                fetchCards(); // Carga por defecto
            }

            // Enter en el buscador
            const searchInput = document.getElementById('search-name');
            if (searchInput) {
                searchInput.addEventListener('keypress', (e) => {
                    if (e.key === 'Enter') applyFilters();
                });
            }
        });
    </script>
</body>
</html>