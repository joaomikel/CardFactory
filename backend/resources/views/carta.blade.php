<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Detalle de Carta - CardFactory</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* --- VARIABLES DEL DISEÑO NUEVO --- */
        :root {
            --primary: #816EB2;
            --primary-dark: #5e4c8d; 
            --secondary: #958EA0;
            --text-dark: #222;
            --text-light: #f4f4f4;
            --white: #ffffff;
            --bg: #f8f9fa;
            --radius: 16px;
            --focus-ring: #ffbf00;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; -webkit-tap-highlight-color: transparent; font-family: 'Inter', sans-serif; }

        body { 
            background-color: var(--bg); 
            color: var(--text-dark); 
            min-height: 100vh; 
            padding-bottom: 100px; /* Espacio para el carrito flotante */
        }

        /* --- HEADER NUEVO (ADAPTADO A FONDO SÓLIDO) --- */
        header {
            background: var(--primary); /* Fondo sólido para que se vean los botones */
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            position: sticky; /* Sticky para que baje contigo */
            top: 0; left: 0; right: 0;
            z-index: 100;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .menu-trigger { 
            font-size: 1.8rem; background: none; border: none; color: var(--white); 
            cursor: pointer; padding: 10px; margin-right: auto;
        }

        .auth-actions { display: flex; gap: 10px; align-items: center; margin-left: auto; }

        /* Botones estilo Glassmorphism del nuevo diseño */
        .btn-header {
            padding: 8px 16px; border-radius: 20px; font-weight: 600;
            text-decoration: none; font-size: 0.85rem; transition: 0.3s; white-space: nowrap;
        }
        .btn-login { 
            background: rgba(255,255,255,0.25); color: var(--white); 
            border: 1px solid rgba(255,255,255,0.5); backdrop-filter: blur(4px); 
        }
        .btn-login:hover { background: rgba(255,255,255,0.4); }

        .btn-register { 
            background: var(--text-dark); color: var(--white); /* Negro para contraste sobre morado */
            box-shadow: 0 4px 10px rgba(0,0,0,0.3); border: none;
        }
        .btn-register:hover { transform: translateY(-2px); background: #000; }

        /* Widget de Perfil Nuevo */
        .user-profile-widget {
            display: flex; align-items: center; gap: 10px;
            background: rgba(255, 255, 255, 0.2); padding: 5px 15px 5px 5px;
            border-radius: 30px; border: 1px solid rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(5px); text-decoration: none; transition: all 0.3s ease; cursor: pointer;
        }
        .user-profile-widget:hover { background: rgba(255, 255, 255, 0.3); transform: translateY(-2px); }
        
        .profile-avatar {
            width: 32px; height: 32px; background: var(--white); color: var(--primary);
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-size: 1rem; border: 2px solid rgba(255,255,255,0.8);
        }
        .profile-name {
            color: white; font-weight: 600; font-size: 0.9rem;
            max-width: 100px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
            display: none; 
        }
        @media (min-width: 480px) { .profile-name { display: block; } }

        /* --- SIDEBAR NUEVO --- */
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
        }
        .sidebar.active { left: 0; }
        .close-sidebar { position: absolute; top: 15px; right: 15px; font-size: 1.8rem; background: none; border: none; color: #666; cursor: pointer;}
        .sidebar a { padding: 15px 0; border-bottom: 1px solid #eee; color: var(--secondary); text-decoration: none; font-size: 1.1rem; font-weight: 500;}


        /* --- LAYOUT ESPECÍFICO DE CARTA (MANTENIDO) --- */
        .container { max-width: 1200px; margin: 20px auto; padding: 0 20px; }
        
        .detail-grid {
            display: grid; grid-template-columns: 1fr; gap: 30px;
            background: white; padding: 25px; border-radius: var(--radius);
            margin-bottom: 30px; box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }

        .card-image-large {
            width: 100%; max-width: 350px; border-radius: 18px; 
            box-shadow: 0 15px 35px rgba(0,0,0,0.25);
            margin: 0 auto; display: block;
            transition: transform 0.3s;
        }
        .card-image-large:hover { transform: scale(1.02); }

        /* --- TABLA RESPONSIVE (MANTENIDA Y ESTILIZADA) --- */
        .table-container {
            background: white; border-radius: var(--radius); overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            border: 1px solid #eee;
        }
        table { width: 100%; border-collapse: collapse; text-align: left; }
        thead { background-color: #2b2440; color: white; } /* Color oscuro del footer nuevo */
        th { padding: 18px 20px; font-weight: 600; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.5px; }
        td { padding: 18px 20px; border-bottom: 1px solid #f0f0f0; vertical-align: middle; }

        .price-tag { font-weight: 800; color: var(--primary-dark); font-size: 1.1rem; }
        .badge { padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: bold; }
        .badge-foil { background: linear-gradient(135deg, #fceabb 0%,#f8b500 100%); color: #fff; text-shadow: 0 1px 2px rgba(0,0,0,0.2); }
        .badge-normal { background: #e5e7eb; color: #666; }
        
        .btn-add { 
            background: var(--text-dark); color: white; border: none; 
            width: 42px; height: 42px; border-radius: 10px; cursor: pointer; 
            display: flex; align-items: center; justify-content: center; 
            transition: 0.2s; font-size: 1.1rem; box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .btn-add:active { transform: scale(0.9); }

        @media (max-width: 768px) {
            thead { display: none; }
            tbody tr {
                display: block; background: white; margin-bottom: 15px;
                border: 1px solid #e5e7eb; border-radius: 12px;
                box-shadow: 0 2px 5px rgba(0,0,0,0.03); padding: 15px;
            }
            td {
                display: flex; justify-content: space-between; align-items: center;
                padding: 10px 0; border-bottom: 1px solid #f8f9fa; text-align: right;
            }
            td:last-child { border-bottom: none; justify-content: center; padding-top: 20px; }
            td::before {
                content: attr(data-label); font-weight: 700; color: #888;
                text-align: left; margin-right: 15px; font-size: 0.85rem;
            }
            .btn-add { width: 100%; height: 50px; font-weight: 700; border-radius: 12px; }
            .btn-add::after { content: " AÑADIR AL CARRITO"; margin-left: 10px; font-size: 0.9rem; }
        }

        @media (min-width: 769px) {
            .detail-grid { grid-template-columns: 350px 1fr; padding: 40px; }
            tbody tr { cursor: grab; transition: background-color 0.2s, transform 0.2s; }
            tbody tr:hover { background-color: #f8f9fa; transform: scale(1.005); box-shadow: 0 4px 15px rgba(0,0,0,0.08); z-index: 10; position: relative; }
        }

        /* --- CARRITO FLOTANTE (MANTENIDO) --- */
        .floating-cart-zone {
            position: fixed; bottom: 30px; right: 30px; width: 70px; height: 70px;
            background: var(--primary); border-radius: 50%; 
            display: flex; align-items: center; justify-content: center;
            color: white; box-shadow: 0 10px 30px rgba(129, 110, 178, 0.5); 
            z-index: 1000; cursor: pointer;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            text-decoration: none;
            border: 4px solid white;
        }
        .floating-cart-zone:hover { transform: scale(1.1); }
        .cart-badge {
            position: absolute; top: 0; right: 0; background: #ff4757; color: white;
            width: 26px; height: 26px; border-radius: 50%; font-size: 0.85rem; font-weight: bold;
            display: flex; align-items: center; justify-content: center; border: 2px solid white;
        }
        .drag-over-active { transform: scale(1.3); background: #00d2d3; border-color: #00d2d3; }
        @keyframes pop { 0% { transform: scale(1); } 50% { transform: scale(1.4); } 100% { transform: scale(1); } }
        .pop-anim { animation: pop 0.3s ease; }
        
        .desktop-only-text { display: none; }
        @media (min-width: 769px) { .desktop-only-text { display: inline; } }

    </style>
</head>
<body>

    <div class="sidebar-overlay" id="overlay" onclick="toggleMenu()"></div>
    
    <div class="sidebar" id="sidebar">
        <button class="close-sidebar" onclick="toggleMenu()">&times;</button>
        <h3 style="color: var(--primary); margin-bottom: 1.5rem; font-weight: 800;">Menú</h3>
        <a href="/">Inicio</a>
        <a href="/dashboard" id="link-perfil-sidebar">Perfil</a>
        <a href="/colecciones">Colecciones</a>
        <a href="/catalogo">Catálogo</a>
        <a href="/carrito">Carrito</a>    
    </div>

    <header>
        <button class="menu-trigger" onclick="toggleMenu()" aria-label="Abrir menú">
            <i class="fas fa-bars"></i>
        </button>
        
        <div class="auth-actions" id="auth-container">
            </div>
    </header>

    <main class="container">
        <div style="margin-bottom: 25px; margin-top: 20px;">
            <a href="javascript:history.back()" style="color: var(--secondary); text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
                <i class="fas fa-arrow-left"></i> Volver al listado
            </a>
        </div>

        <div class="detail-grid" id="main-content">
            <div style="text-align: center; padding: 40px; color: #888;">Cargando carta...</div>
        </div>

        <div class="sellers-section">
            <h3 style="margin-bottom: 20px; display: flex; align-items: center; flex-wrap: wrap; gap: 10px;">
                <span><i class="fas fa-store" style="color: var(--primary);"></i> Ofertas de Vendedores</span>
                <span class="desktop-only-text" style="font-size: 0.9rem; font-weight: normal; color: #888; margin-left: auto;">
                    <i class="fas fa-hand-pointer"></i> Arrastra una fila al carrito 
                </span>
            </h3>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Vendedor</th>
                            <th>Estado</th>
                            <th>Edición</th>
                            <th>Precio</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody id="sellers-tbody">
                        <tr><td colspan="5" style="text-align:center; padding: 40px; color: #999;">Buscando mejores ofertas...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <a id="drop-zone" class="floating-cart-zone" onclick="window.location.href='/carrito'">        
        <span class="cart-badge" id="cart-count">0</span>
        <i class="fas fa-shopping-cart" style="font-size: 1.5rem;"></i>
    </a>

    <script>
    // --- LÓGICA DEL MENÚ ---
    function toggleMenu() {
        document.getElementById('sidebar').classList.toggle('active');
        document.getElementById('overlay').classList.toggle('active');
    }

    // --- LÓGICA DE USUARIO / LOGIN MEJORADA (Versión Definitiva) ---
    function checkLoginStatus() {
        const token = sessionStorage.getItem('auth_token') || localStorage.getItem('auth_token');
        let storedUser = sessionStorage.getItem('user_data') || localStorage.getItem('user_data');
        
        const authContainer = document.getElementById('auth-container');
        const linkSidebar = document.getElementById('link-perfil-sidebar');

        if (token && authContainer) {
            // ESTÁ LOGUEADO
            let userData = { name: 'Usuario' };
            try { if (storedUser) userData = JSON.parse(storedUser); } catch (e) {}

            const userName = userData.name ? userData.name.split(' ')[0] : 'Perfil';
            
            // Render Widget Perfil
            authContainer.innerHTML = `
                <div style="display: flex; align-items: center; gap: 10px;">
                    <a href="/dashboard" class="user-profile-widget" title="Ir a mi perfil">
                        <div class="profile-avatar"><i class="fas fa-user"></i></div>
                        <span class="profile-name">${userName}</span>
                    </a>
                </div>
            `;
            if(linkSidebar) {
                linkSidebar.innerHTML = `Hola, ${userName}`;
                linkSidebar.href = "/dashboard";
            }
        } else if (authContainer) {
            // NO LOGUEADO
            authContainer.innerHTML = `
                <a href="/login" class="btn-header btn-login">Login</a>
                <a href="/register" class="btn-header btn-register">Registro</a>
            `;
        }
    }




    // --- LÓGICA DE CARTA, SCRYFALL Y CARRITO ---
    const API_URL = 'http://localhost:8000/api'; 
    const params = new URLSearchParams(window.location.search);
    const cardId = params.get('id');
    
    let currentCardInfo = {}; 
    let sellersData = []; 

    async function init() {
        checkLoginStatus();
        updateCartCount();
        if(!cardId) return;

        // 1. Info Scryfall
        try {
            const res = await fetch(`https://api.scryfall.com/cards/${cardId}`);
            const card = await res.json();
            
            let img = "https://via.placeholder.com/400";
            if(card.image_uris) img = card.image_uris.large;
            else if(card.card_faces) img = card.card_faces[0].image_uris.large;

            currentCardInfo = { 
                name: card.name, 
                image: img, 
                rarity: card.rarity,
                set_name: card.set_name 
            };
            
            document.getElementById('main-content').innerHTML = `
                <div style="text-align:center;">
                    <img src="${img}" class="card-image-large" alt="${card.name}">
                </div>
                <div>
                    <h1 style="font-size:2rem; margin-bottom:10px; line-height: 1.2; font-weight: 800; color: var(--text-dark);">${card.name}</h1>
                    <p style="color:var(--secondary); font-weight:600; margin-bottom: 20px; font-size: 1.1rem;">${card.type_line}</p>
                    <div style="background:#f8f9fa; padding:25px; border-radius:12px; line-height: 1.6; font-size: 1rem; border: 1px solid #eee;">
                        ${card.oracle_text ? card.oracle_text.replace(/\n/g, '<br>') : 'Sin descripción disponible.'}
                    </div>
                </div>
            `;
        } catch(e) { console.error("Error Scryfall:", e); }

        // 2. Info Vendedores (Backend)
        try {
            const res = await fetch(`${API_URL}/listings/card/${cardId}`);
            if(res.ok) {
                sellersData = await res.json();
                renderSellersTable(sellersData);
            } else {
                document.getElementById('sellers-tbody').innerHTML = 
                    `<tr><td colspan="5" style="text-align:center; padding:30px;">No hay ofertas disponibles actualmente.</td></tr>`;
            }
        } catch(e) { console.error("Error Backend:", e); }
    }

    function renderSellersTable(listings) {
        const tbody = document.getElementById('sellers-tbody');
        if(listings.length === 0) {
            tbody.innerHTML = `<tr><td colspan="5" style="text-align:center; padding: 30px;">No hay vendedores para esta carta aún.</td></tr>`;
            return;
        }

        tbody.innerHTML = listings.map((venta, index) => {
            let editionName = currentCardInfo.set_name; 
            if (venta.card && venta.card.set && venta.card.set.name) editionName = venta.card.set.name;
            else if (venta.set_name) editionName = venta.set_name;

            return `
            <tr draggable="true" ondragstart="handleDragStart(event, ${index})">
                <td data-label="Vendedor">
                    <div style="display:flex; align-items:center; gap:10px; justify-content: flex-end;">
                        <div style="text-align:right;">
                            <strong style="color: var(--primary-dark);">${venta.user ? venta.user.name : 'Vendedor'}</strong>
                            <div style="font-size:0.75rem; color:#888;">ID: ${venta.user_id}</div>
                        </div>
                        <i class="fas fa-user-circle" style="font-size:1.8rem; color:#ccc;"></i>
                    </div>
                </td>
                <td data-label="Estado">
                    <div>
                        <span style="font-weight:bold; margin-right:5px;">${venta.condition}</span>
                        ${venta.is_foil ? '<span class="badge badge-foil">Foil</span>' : '<span class="badge badge-normal">Normal</span>'}
                    </div>
                </td>
                <td data-label="Edición">${editionName}</td>
                <td data-label="Precio" class="price-tag">${parseFloat(venta.price).toFixed(2)} €</td>
                <td>
                    <button class="btn-add" onclick="manualAdd(${index})" title="Añadir al carrito">
                        <i class="fas fa-plus"></i>
                    </button>
                </td>
            </tr>
        `}).join('');
    }

    // --- DRAG AND DROP ---
    function handleDragStart(e, index) {
        if(window.innerWidth < 769) { e.preventDefault(); return; }
        e.target.classList.add('dragging'); 
        e.dataTransfer.setData("text/plain", index);
        e.dataTransfer.effectAllowed = "copy";
    }
    document.addEventListener("dragend", (e) => {
        if (e.target.tagName === 'TR') e.target.classList.remove('dragging');
    });
    const dropZone = document.getElementById('drop-zone');
    dropZone.addEventListener('dragover', (e) => { e.preventDefault(); dropZone.classList.add('drag-over-active'); });
    dropZone.addEventListener('dragleave', () => dropZone.classList.remove('drag-over-active'));
    dropZone.addEventListener('drop', (e) => {
        e.preventDefault(); dropZone.classList.remove('drag-over-active');
        const index = e.dataTransfer.getData("text/plain");
        if(index !== "") addToCart(index);
    });

    // --- CARRITO (CORREGIDO LOCAL/SESSION) ---
    function manualAdd(index) { addToCart(index); }

    function addToCart(index) {
        // CORRECCIÓN APLICADA: Busca en ambos sitios
        const token = sessionStorage.getItem('auth_token') || localStorage.getItem('auth_token');
        
        if (!token) {
            if (confirm("🔒 Para añadir al carrito necesitas iniciar sesión. ¿Ir al login?")) {
                window.location.href = '/login'; 
            }
            return;
        }

        const venta = sellersData[index];
        let finalSet = currentCardInfo.set_name;
        if(venta.card && venta.card.set) finalSet = venta.card.set.name;

        const item = {
            id: venta.id,
            scryfall_id: cardId,
            name: currentCardInfo.name,
            image: currentCardInfo.image,
            price: parseFloat(venta.price),
            seller: venta.user ? venta.user.name : 'Desconocido',
            condition: venta.condition,
            is_foil: venta.is_foil,
            set_name: finalSet,
            addedAt: new Date().getTime()
        };

        let cart = JSON.parse(localStorage.getItem('myCart')) || [];
        if(cart.find(i => i.id === item.id)) {
            alert("⚠️ Esta oferta específica ya está en tu carrito.");
            return;
        }
        cart.push(item);
        localStorage.setItem('myCart', JSON.stringify(cart));

        dropZone.classList.add('pop-anim');
        setTimeout(() => dropZone.classList.remove('pop-anim'), 300);
        updateCartCount();
        
        const btn = document.querySelectorAll('.btn-add')[index];
        const oldContent = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check"></i>';
        btn.style.background = '#10b981';
        setTimeout(() => {
            btn.innerHTML = oldContent;
            btn.style.background = 'var(--text-dark)';
        }, 1500);
    }

    function updateCartCount() {
        const cart = JSON.parse(localStorage.getItem('myCart')) || [];
        document.getElementById('cart-count').innerText = cart.length;
    }

    window.onload = init;
    window.addEventListener('pageshow', updateCartCount);
    window.addEventListener('storage', (e) => { if (e.key === 'myCart') updateCartCount(); });
    </script>
</body>
</html>