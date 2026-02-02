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
            /* CAMBIO: Color amarillo intenso para el foco */
            --focus-ring: #ffe600;
            --text-light: #f4f4f4;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        
        /* CAMBIO: Regla global para forzar el foco amarillo en navegación por teclado */
        *:focus-visible {
            outline: 3px solid var(--focus-ring);
            outline-offset: 2px;
            z-index: 10; /* Asegura que el anillo de foco quede por encima */
        }
        /* Fallback para navegadores antiguos */
        *:focus {
            outline: 3px solid var(--focus-ring);
            outline-offset: 2px;
        }
        
        body { 
            background-color: var(--bg); 
            color: var(--dark); 
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* --- MODAL ACCESIBILIDAD --- */
        .modal-overlay { 
            position: fixed; top: 0; left: 0; width: 100%; height: 100%; 
            background: rgba(0,0,0,0.8); z-index: 2000; display: none; 
            align-items: center; justify-content: center; backdrop-filter: blur(4px); 
        }
        .modal-overlay.active { display: flex; animation: fadeIn 0.3s; }
        .modal-content { 
            background: white; width: 90%; max-width: 600px; max-height: 85vh; 
            overflow-y: auto; border-radius: 12px; padding: 30px; position: relative; 
        }
        .modal-header { 
            display: flex; justify-content: space-between; align-items: center; 
            margin-bottom: 20px; border-bottom: 2px solid #eee; padding-bottom: 10px; 
        }
        .modal-close { 
            background: transparent; border: 2px solid var(--secondary); color: var(--secondary); 
            width: 40px; height: 40px; border-radius: 50%; cursor: pointer; font-size: 1.2rem; 
        }
        .acc-list { margin-left: 20px; margin-bottom: 20px; }
        .acc-tag { display: inline-block; padding: 2px 8px; border-radius: 4px; font-weight: bold; font-size: 0.8rem; margin-right: 5px; }
        .tag-aa { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

        /* --- HEADER --- */
        header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
            flex-shrink: 0;
        }

        .menu-trigger {
            font-size: 1.8rem;
            background: none;
            border: none;
            color: var(--white);
            cursor: pointer;
            padding: 10px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .header-title {
            color: white; 
            font-weight: 800; 
            font-size: 1.2rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .auth-actions {
            display: flex;
            gap: 10px;
            align-items: center;
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
            background: var(--white);
            color: var(--primary);
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }
        .btn-register:hover { transform: translateY(-2px); }

        /* --- WIDGET PERFIL USUARIO --- */
        .user-profile-widget {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(255, 255, 255, 0.25);
            padding: 5px 15px 5px 5px;
            border-radius: 30px;
            border: 1px solid rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(5px);
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .user-profile-widget:hover {
            background: rgba(255, 255, 255, 0.4);
            transform: translateY(-2px);
        }
        .profile-avatar {
            width: 32px;
            height: 32px;
            background: var(--primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            border: 2px solid rgba(255,255,255,0.8);
        }
        .profile-name {
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
            max-width: 100px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: none;
        }
        @media (min-width: 480px) { .profile-name { display: block; } }

        /* --- SIDEBAR --- */
        .sidebar-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.6); z-index: 101; opacity: 0;
            pointer-events: none; transition: 0.3s; backdrop-filter: blur(2px);
        }
        .sidebar-overlay.active { opacity: 1; pointer-events: all; }

        .sidebar {
            position: fixed; top: 0; left: -100%; width: 85%; max-width: 320px;
            height: 100%; background: var(--white); z-index: 102; padding: 2rem;
            transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1); display: flex;
            flex-direction: column; gap: 1rem; box-shadow: 5px 0 15px rgba(0,0,0,0.2);
        }
        .sidebar.active { left: 0; }
        
        .close-sidebar {
            position: absolute; top: 20px; right: 20px; font-size: 2rem;
            background: none; border: none; cursor: pointer; color: #666;
        }
        .sidebar a {
            padding: 15px 10px; font-weight: 500; color: var(--secondary);
            border-bottom: 1px solid #eee; text-decoration: none; font-size: 1.1rem;
        }

        /* --- FILTROS --- */
        .filters {
            background: white; padding: 20px; display: flex; flex-direction: column;
            gap: 15px; border-bottom: 1px solid #ddd; margin-top: 0;
            box-shadow: 0 4px 10px rgba(0,0,0,0.03);
        }
        .filter-group { display: flex; flex-direction: column; gap: 8px; flex: 1; }
        .filter-group label { font-size: 0.75rem; font-weight: 800; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; }
        
        .filter-control { 
            padding: 12px; border: 1px solid #d1d5db; border-radius: 10px; 
            font-size: 16px; background: #fafafa; width: 100%; outline: none; transition: 0.3s;
        }
        
        /* CAMBIO: Borde amarillo en los inputs al hacer foco */
        .filter-control:focus { 
            border-color: var(--focus-ring); 
            background: white; 
            box-shadow: 0 0 0 1px var(--focus-ring);
        }
        
        .btn-apply { 
            background: var(--primary); color: white; padding: 15px; border: none; 
            border-radius: 10px; font-weight: 700; cursor: pointer;
            box-shadow: 0 4px 12px rgba(129, 110, 178, 0.3);
            margin-top: 10px; transition: 0.3s;
        }
        .btn-apply:hover { transform: translateY(-2px); box-shadow: 0 6px 15px rgba(129, 110, 178, 0.4); }

        /* --- GRID --- */
        .container { 
            padding: 20px; max-width: 1200px; margin: 0 auto; flex-grow: 1; width: 100%;
        }
        .grid { 
            display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 20px; 
        }
        .card-catalog {
            background: white; border-radius: 12px; overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06); display: flex; flex-direction: column;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card-catalog:hover { transform: translateY(-8px); box-shadow: 0 15px 30px rgba(0,0,0,0.1); }
        .card-catalog img { width: 100%; aspect-ratio: 2.5/3.5; object-fit: cover; border-bottom: 1px solid #f0f0f0; }
        .card-info { padding: 15px; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between; }
        .card-info h3 { font-size: 0.9rem; color: var(--dark); margin-bottom: 8px; line-height: 1.3; }
        .card-price { color: var(--primary); font-weight: 800; font-size: 1.1rem; }

        /* --- FOOTER --- */
        footer { margin-top: auto; background: #2b2440; color: var(--text-light); padding-top: 60px; }
        .footer-content {
            display: grid; grid-template-columns: 1fr; gap: 40px;
            max-width: 1200px; margin: 0 auto; padding: 0 20px 40px;
        }
        .footer-section h3 { font-size: 1.3rem; margin-bottom: 20px; color: var(--white); }
        .footer-section p { font-size: 1rem; line-height: 1.6; opacity: 1; color: #e0e0e0; }
        .footer-links { list-style: none; }
        .footer-links li { margin-bottom: 12px; }
        .footer-links a {
            text-decoration: underline; text-underline-offset: 4px;
            color: #e0e0e0; transition: 0.3s; font-size: 1rem; cursor: pointer;
        }
        .footer-links a:hover, .footer-links a:focus {
            color: var(--white); background-color: rgba(255,255,255,0.1);
            /* El foco amarillo ya está forzado globalmente, pero mantenemos esto por si acaso */
            outline: 3px solid var(--focus-ring);
        }
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
            .grid { gap: 25px; }
            .btn-apply { padding: 12px 30px; margin-top: 0; height: 46px; }
            .sidebar { width: 300px; }
            .footer-content { grid-template-columns: repeat(2, 1fr); }
        }
        @media (min-width: 1024px) {
            .footer-content { grid-template-columns: repeat(4, 1fr); }
        }
    </style>
</head>
<body>

    <div class="modal-overlay" id="acc-modal" aria-modal="true" role="dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 style="color: var(--primary);">Accesibilidad</h2>
                <button class="modal-close" onclick="closeAccModal()" aria-label="Cerrar modal de accesibilidad">&times;</button>
            </div>
            <div>
                <p>CardFactory sigue los estándares WCAG 2.1.</p>
                <ul class="acc-list">
                    <li><span class="acc-tag tag-aa">AA</span> Contraste y navegación por teclado.</li>
                    <li><span class="acc-tag tag-aa">ARIA</span> Etiquetas para lectores de pantalla.</li>
                </ul>
                <button onclick="closeAccModal()" style="width: 100%; padding: 10px; background: #666; color: white; border:none; border-radius: 8px; cursor: pointer;">Cerrar</button>
            </div>
        </div>
    </div>

    <div class="sidebar-overlay" id="overlay" onclick="toggleMenu()"></div>
    <div class="sidebar" id="sidebar">
        <button class="close-sidebar" onclick="toggleMenu()" aria-label="Cerrar menú">&times;</button>
        <h3 style="color: var(--primary); margin-bottom: 1rem;">Menú</h3>
        <a href="/">Inicio</a> 
        <a href="/dashboard" id="link-perfil-sidebar">Perfil</a>
        <a href="/colecciones">Colecciones</a>
        <a href="/catalogo" style="color: var(--primary); font-weight: 700; border-left: 4px solid var(--primary); padding-left: 6px;">Catálogo</a>
        <a href="/carrito">Carrito</a>
    </div>

    <header>
        <button class="menu-trigger" onclick="toggleMenu()" aria-label="Abrir Menú">☰</button>
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
                <i class="fas fa-search" style="position: absolute; right: 15px; top: 15px; color: #9ca3af;" aria-hidden="true"></i>
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
            <label for="cmc">Mana (CMC)</label>
            <select id="cmc" class="filter-control">
                <option value="">Cualquiera</option>
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7+</option>
            </select>
        </div>

        <div class="filter-group">
            <label for="set">Colección</label>
            <select id="set" class="filter-control">
                <option value="">Todas</option>
                <option value="dft">Aetherdrift (DFT)</option>
                <option value="fdn">Foundations (FDN)</option>
                <option value="dsk">Duskmourn (DSK)</option>
                <option value="blb">Bloomburrow (BLB)</option>
                <option value="otj">Thunder Junction (OTJ)</option>
                <option value="mh3">Modern Horizons 3 (MH3)</option>
                <option value="ltr">Lord of the Rings (LTR)</option>
                <option value="lrw">Lorwyn (LRW)</option>
            </select>
        </div>

        <button class="btn-apply" onclick="applyFilters()">Aplicar</button>
    </section>

    <main class="container">
        <div class="grid" id="catalog-grid">
            <p style="grid-column: 1/-1; text-align: center; padding: 50px;">Buscando cartas...</p>
        </div>
    </main>

    <footer role="contentinfo">
        <div class="footer-content">
            <div class="footer-section">
                <h3>CardFactory</h3>
                <p>Tu mercado de confianza para comprar y vender cartas de Magic: The Gathering.</p>
                <div class="social-icons">
                    <a href="#" aria-label="Síguenos en Facebook"><i class="fab fa-facebook-f" aria-hidden="true"></i></a>
                    <a href="#" aria-label="Síguenos en Twitter"><i class="fab fa-twitter" aria-hidden="true"></i></a>
                    <a href="#" aria-label="Síguenos en Instagram"><i class="fab fa-instagram" aria-hidden="true"></i></a>
                </div>
            </div>
            <div class="footer-section">
                <h3>Enlaces Rápidos</h3>
                <ul class="footer-links">
                    <li><a href="/catalogo">Catálogo Completo</a></li>
                    <li><a href="/colecciones">Ver Colecciones</a></li>
                    <li><a href="/login" id="footer-login-link">Acceso Login</a></li> 
                    <li><a href="javascript:void(0)" onclick="openAccModal()" style="color: var(--focus-ring);">Declaración de Accesibilidad</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 CardFactory. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script>
        // --- GESTIÓN DE FOCO Y ACCESIBILIDAD ---
        let lastFocusedElement;
        
        // Elementos de fondo que queremos desactivar cuando el menú está abierto
        const mainContentSelectors = ['header', '.filters', 'main', 'footer'];

        function toggleMainContentInert(isInert) {
            mainContentSelectors.forEach(selector => {
                const el = document.querySelector(selector);
                if (el) {
                    if (isInert) {
                        el.setAttribute('inert', ''); // Soporte moderno para bloquear interacción
                        el.setAttribute('aria-hidden', 'true');
                    } else {
                        el.removeAttribute('inert');
                        el.removeAttribute('aria-hidden');
                    }
                }
            });
        }

        function trapFocus(e, container) {
            const focusables = container.querySelectorAll('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
            if (focusables.length === 0) return;

            const first = focusables[0];
            const last = focusables[focusables.length - 1];

            if (e.key === 'Tab') {
                if (e.shiftKey) { // Shift + Tab
                    if (document.activeElement === first) {
                        e.preventDefault();
                        last.focus();
                    }
                } else { // Tab
                    if (document.activeElement === last) {
                        e.preventDefault();
                        first.focus();
                    }
                }
            }
        }

        // --- MENU LATERAL ---
        function toggleMenu() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            const isActive = sidebar.classList.contains('active');

            if (!isActive) {
                // ABRIR
                lastFocusedElement = document.activeElement;
                sidebar.classList.add('active');
                overlay.classList.add('active');
                
                // Hacerlo visible para la accesibilidad
                sidebar.style.visibility = 'visible';
                
                // Bloquear fondo
                toggleMainContentInert(true);

                // Mover foco al botón cerrar
                setTimeout(() => {
                    const closeBtn = sidebar.querySelector('.close-sidebar');
                    if (closeBtn) closeBtn.focus();
                }, 100);

                sidebar.addEventListener('keydown', handleSidebarKeydown);
            } else {
                // CERRAR
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
                
                // Desbloquear fondo
                toggleMainContentInert(false);

                // Ocultar tras animación para que no se pueda tabular
                setTimeout(() => {
                    sidebar.style.visibility = 'hidden';
                }, 300);

                if (lastFocusedElement) lastFocusedElement.focus();
                
                sidebar.removeEventListener('keydown', handleSidebarKeydown);
            }
        }

        function handleSidebarKeydown(e) {
            if (e.key === 'Escape') toggleMenu();
            trapFocus(e, document.getElementById('sidebar'));
        }

        // --- MODAL ACCESIBILIDAD ---
        function openAccModal() {
            lastFocusedElement = document.activeElement;
            const modal = document.getElementById('acc-modal');
            modal.classList.add('active');
            
            // Hacer modal visible si tenía display:none en CSS, aunque aquí usamos visibility/opacity para transiciones
            modal.style.display = 'flex'; 

            toggleMainContentInert(true);

            setTimeout(() => {
                const closeBtn = modal.querySelector('.modal-close');
                if (closeBtn) closeBtn.focus();
            }, 100);

            modal.addEventListener('keydown', handleModalKeydown);
        }

        function closeAccModal() {
            const modal = document.getElementById('acc-modal');
            modal.classList.remove('active');
            
            // Esperar animación si la hubiera, o cerrar directo
            setTimeout(() => { modal.style.display = 'none'; }, 300);

            toggleMainContentInert(false);
            if (lastFocusedElement) lastFocusedElement.focus();
            modal.removeEventListener('keydown', handleModalKeydown);
        }

        function handleModalKeydown(e) {
            if (e.key === 'Escape') closeAccModal();
            trapFocus(e, document.getElementById('acc-modal'));
        }

        // --- LÓGICA DE DATOS ---
        function checkLoginStatus() {
            const token = localStorage.getItem('auth_token') || sessionStorage.getItem('auth_token');
            const authContainer = document.getElementById('auth-container');
            const linkSidebar = document.getElementById('link-perfil-sidebar');
            const footerLoginLink = document.getElementById('footer-login-link');
            
            let userData = {};
            let userName = "Mi Perfil"; 

            try {
                const storedUser = localStorage.getItem('user_data') || sessionStorage.getItem('user_data');
                if (storedUser) {
                    userData = JSON.parse(storedUser);
                    if (userData && userData.name) {
                        userName = String(userData.name).split(' ')[0];
                    }
                }
            } catch (e) { }

            if (token) {
                if (authContainer) {
                    authContainer.innerHTML = `
                        <a href="/dashboard" class="user-profile-widget" title="Ir a mi perfil">
                            <div class="profile-avatar"><i class="fas fa-user"></i></div>
                            <span class="profile-name">${userName}</span>
                        </a>`;
                }
                if(linkSidebar) {
                    linkSidebar.innerHTML = `Hola, ${userName}`;
                    linkSidebar.href = "/dashboard";
                    linkSidebar.style.color = "var(--primary)";
                }
                if(footerLoginLink) {
                    footerLoginLink.textContent = "Ir a mi Perfil";
                    footerLoginLink.href = "/dashboard";
                }
            }
        }

        async function checkLocalStock(scryfallIds) {
            try {
                const response = await fetch('/api/check-stock-batch', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ ids: scryfallIds })
                });
                return response.ok ? await response.json() : {};
            } catch (error) { return {}; }
        }

        async function fetchCards(q = 'f:standard') {
            const grid = document.getElementById('catalog-grid');
            if(!grid) return;
            grid.innerHTML = '<p style="grid-column: 1/-1; text-align: center; padding: 50px;"><i class="fas fa-circle-notch fa-spin"></i> Buscando cartas...</p>';

            try {
                const res = await fetch(`https://api.scryfall.com/cards/search?q=${encodeURIComponent(q)}`);
                const data = await res.json();
                if(!data.data) {
                    grid.innerHTML = '<p style="grid-column: 1/-1; text-align: center;">Sin resultados.</p>';
                    return;
                }
                const localStockData = await checkLocalStock(data.data.map(c => c.id));

                grid.innerHTML = data.data.map(card => {
                    const img = card.image_uris?.normal || card.card_faces?.[0].image_uris?.normal || 'https://via.placeholder.com/488x680';
                    const localPrice = localStockData[card.id]; 
                    const priceHtml = localPrice ? `${parseFloat(localPrice).toFixed(2)} €` : 'Sin Stock';
                    return `
                        <a href="/carta?id=${card.id}" class="card-catalog" style="text-decoration:none; color:inherit;">
                            <img src="${img}" alt="${card.name}">
                            <div class="card-info">
                                <h3>${card.name}</h3>
                                <p class="card-price">${priceHtml}</p>
                            </div>
                        </a>
                    `;
                }).join('');
            } catch (e) { grid.innerHTML = '<p>Error de conexión.</p>'; }
        }

        function applyFilters() {
            const name = document.getElementById('search-name').value;
            const color = document.getElementById('color').value;
            const rarity = document.getElementById('rarity').value;
            const cmc = document.getElementById('cmc').value;
            const set = document.getElementById('set').value;
            let q = [];
            if (name) q.push(name);
            if (color) q.push(`c:${color}`);
            if (rarity) q.push(`r:${rarity}`);
            if (set) q.push(`s:${set}`);
            if (cmc) q.push(cmc === "7" ? `cmc>=7` : `cmc:${cmc}`);
            fetchCards(q.length ? q.join(' ') : 'f:standard');
        }

        document.addEventListener('DOMContentLoaded', () => {
            // Inicializar visibilidad del sidebar para que no sea focuseable al inicio
            const sidebar = document.getElementById('sidebar');
            if(sidebar) sidebar.style.visibility = 'hidden';

            checkLoginStatus();
            const params = new URLSearchParams(window.location.search);
            if (params.get('q')) fetchCards(params.get('q'));
            else fetchCards();
            
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