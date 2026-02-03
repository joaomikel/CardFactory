<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Detalle de Carta - CardFactory</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* --- VARIABLES --- */
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

        body { background-color: var(--bg); color: var(--text-dark); min-height: 100vh; display: flex; flex-direction: column; }

        /* --- ACCESIBILIDAD (MODAL) --- */
        .modal-overlay {
            display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.7); z-index: 2000; align-items: center; justify-content: center;
            backdrop-filter: blur(5px);
        }
        .modal-content {
            background: white; width: 90%; max-width: 500px; padding: 25px; border-radius: var(--radius);
            box-shadow: 0 10px 30px rgba(0,0,0,0.3); animation: fadeIn 0.3s ease;
        }
        .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 10px; }
        .modal-close { background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #666; }
        .acc-tag { padding: 2px 6px; border-radius: 4px; font-size: 0.75rem; font-weight: bold; margin-right: 5px; }
        .tag-aa { background: #d1fae5; color: #065f46; }
        .tag-fail { background: #fee2e2; color: #991b1b; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }

        /* --- SIDEBAR (MENU LATERAL) --- */
        .sidebar-overlay {
            position: fixed; top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.6); z-index: 1001; opacity: 0; pointer-events: none; transition: 0.3s;
            backdrop-filter: blur(3px);
        }
        .sidebar-overlay.active { opacity: 1; pointer-events: all; }

        .sidebar {
            position: fixed; top: 0; left: -100%; width: 280px; height: 100%;
            background: var(--white); z-index: 1002; padding: 2rem; 
            transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex; flex-direction: column; gap: 1rem;
            box-shadow: 5px 0 20px rgba(0,0,0,0.1);
        }
        .sidebar.active { left: 0; }
        .close-sidebar { position: absolute; top: 15px; right: 15px; font-size: 1.8rem; background: none; border: none; color: #666; cursor: pointer; }
        .sidebar a { padding: 12px 0; border-bottom: 1px solid #eee; color: var(--text-dark); text-decoration: none; font-size: 1.1rem; font-weight: 500; display: block; }
        .sidebar a:hover { color: var(--primary); padding-left: 5px; transition: 0.2s; }

        /* --- HEADER --- */
        header {
            background: var(--primary); height: 70px; display: flex; align-items: center; justify-content: space-between;
            padding: 0 20px; position: sticky; top: 0; left: 0; right: 0; z-index: 100;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .menu-trigger { font-size: 1.5rem; background: none; border: none; color: var(--white); cursor: pointer; padding: 5px; }
        .header-title { font-weight: 800; font-size: 1.5rem; color: white; position: absolute; left: 50%; transform: translateX(-50%); letter-spacing: -1px; }
        
        .auth-actions { display: flex; gap: 10px; align-items: center; }
        .btn-header { padding: 8px 16px; border-radius: 20px; font-weight: 600; text-decoration: none; font-size: 0.85rem; transition: 0.3s; white-space: nowrap; }
        .btn-login { background: rgba(255,255,255,0.25); color: var(--white); border: 1px solid rgba(255,255,255,0.5); backdrop-filter: blur(4px); }
        .btn-register { background: var(--text-dark); color: var(--white); }
        
        /* Widget Perfil en Header */
        .user-profile-widget { display: flex; align-items: center; gap: 10px; text-decoration: none; color: white; background: rgba(255,255,255,0.2); padding: 4px 12px 4px 4px; border-radius: 30px; }
        .profile-avatar { width: 28px; height: 28px; background: white; color: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; }

        /* --- LAYOUT CARTA --- */
        .container { max-width: 1200px; margin: 20px auto; padding: 0 20px; flex: 1; width: 100%; }
        .detail-grid { display: grid; grid-template-columns: 1fr; gap: 30px; background: white; padding: 25px; border-radius: var(--radius); margin-bottom: 30px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
        .card-image-large { width: 100%; max-width: 350px; border-radius: 18px; box-shadow: 0 15px 35px rgba(0,0,0,0.25); margin: 0 auto; display: block; transition: transform 0.3s; }

        /* --- TABLA VENDEDORES --- */
        .table-container { background: white; border-radius: var(--radius); overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #eee; }
        table { width: 100%; border-collapse: collapse; text-align: left; }
        thead { background-color: #2b2440; color: white; }
        th { padding: 18px 20px; font-weight: 600; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.5px; }
        td { padding: 18px 20px; border-bottom: 1px solid #f0f0f0; vertical-align: middle; }
        
        .price-tag { font-weight: 800; color: var(--primary-dark); font-size: 1.1rem; }
        .badge { padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: bold; }
        .badge-foil { background: linear-gradient(135deg, #fceabb 0%,#f8b500 100%); color: #fff; text-shadow: 0 1px 2px rgba(0,0,0,0.2); }
        .badge-normal { background: #e5e7eb; color: #666; }

        .btn-add { background: var(--text-dark); color: white; border: none; width: 42px; height: 42px; border-radius: 10px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: 0.2s; font-size: 1.1rem; }
        
        /* Drag & Drop Styles */
        .listing-row[draggable="true"] { cursor: grab; }
        .listing-row[draggable="true"]:active { cursor: grabbing; }

        /* --- FOOTER --- */
        footer { background: #2b2440; color: white; padding: 40px 20px 20px; margin-top: auto; }
        .footer-content { max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 40px; }
        .footer-logo { max-width: 150px; margin-bottom: 15px; border-radius: 8px; }
        .footer-links { list-style: none; }
        .footer-links li { margin-bottom: 10px; }
        .footer-links a { color: #ccc; text-decoration: none; transition: 0.2s; }
        .footer-links a:hover { color: var(--focus-ring); }
        .social-icons a { color: white; margin-right: 15px; font-size: 1.2rem; }
        .footer-bottom { text-align: center; margin-top: 40px; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.1); font-size: 0.9rem; color: #888; }

        /* --- CARRITO FLOTANTE --- */
        .floating-cart-zone {
            position: fixed; bottom: 30px; right: 30px; width: 70px; height: 70px;
            background: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center;
            color: white; box-shadow: 0 10px 30px rgba(129, 110, 178, 0.5); z-index: 1000; cursor: pointer; border: 4px solid white;
            transition: transform 0.2s;
        }
        .floating-cart-zone:hover { transform: scale(1.1); }
        .drag-over-active { transform: scale(1.3); background: #10b981; border-color: #10b981; }
        .pop { animation: popAnim 0.4s ease-out; }
        @keyframes popAnim { 0% { transform: scale(1.3); } 50% { transform: scale(1.6); } 100% { transform: scale(1); } }
        .cart-badge { position: absolute; top: 0; right: 0; background: #ff4757; color: white; width: 26px; height: 26px; border-radius: 50%; font-size: 0.85rem; font-weight: bold; display: flex; align-items: center; justify-content: center; border: 2px solid white; }

        @media (max-width: 768px) {
            thead { display: none; }
            tbody tr { display: block; background: white; margin-bottom: 15px; border: 1px solid #e5e7eb; border-radius: 12px; padding: 15px; }
            td { display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid #f8f9fa; text-align: right; }
            td:last-child { border-bottom: none; justify-content: center; }
            td::before { content: attr(data-label); font-weight: 700; color: #888; text-align: left; }
            .btn-add { width: 100%; }
        }
        @media (min-width: 769px) {
            .detail-grid { grid-template-columns: 350px 1fr; padding: 40px; }
        }
    </style>
</head>
<body>

    <div class="modal-overlay" id="acc-modal" aria-modal="true" role="dialog" aria-labelledby="acc-title">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="acc-title" style="font-size:1.2rem;">Declaración de Accesibilidad</h2>
                <button class="modal-close" onclick="closeAccModal()" aria-label="Cerrar declaración">&times;</button>
            </div>
            <div style="font-size: 0.95rem; line-height: 1.6;">
                <p style="margin-bottom: 15px;">CardFactory está optimizando la accesibilidad del Catálogo.</p>
                <div style="background: #fff3cd; color: #856404; padding: 10px; border-radius: 8px; margin-bottom: 15px;">
                    <strong>Estado:</strong> En proceso de mejora (WCAG 2.1).
                </div>
                <ul class="acc-list" style="list-style:none; margin-bottom:15px;">
                    <li><span class="acc-tag tag-aa">Teclado</span> Foco visible.</li>
                    <li><span class="acc-tag tag-fail">Imágenes</span> Textos alternativos pendientes.</li>
                </ul>
                <button onclick="closeAccModal()" style="width: 100%; padding: 10px; background: var(--secondary); color: white; border: none; border-radius: 8px; font-weight: bold; cursor: pointer;">Entendido</button>
            </div>
        </div>
    </div>

    <div class="sidebar-overlay" id="overlay" onclick="toggleMenu()"></div>
    <div class="sidebar" id="sidebar">
        <button class="close-sidebar" id="closeSidebarBtn" onclick="toggleMenu()" aria-label="Cerrar menú">&times;</button>
        <h3 style="color: var(--primary); margin-bottom: 1rem;">Menú</h3>
        <a href="{{ url('/') }}">Inicio</a> 
        
        @auth
            <a href="{{ url('/dashboard') }}" style="color: var(--primary);">Mi Perfil</a>
        @else
            <a href="{{ route('login') }}">Login</a>
        @endauth
        
        <a href="{{ url('/colecciones') }}">Colecciones</a>
        <a href="{{ url('/catalogo') }}">Catálogo</a>
        <a href="{{ url('/carrito') }}">Carrito</a>
    </div>

    <header>
        <button class="menu-trigger" id="menuBtn" onclick="toggleMenu()" aria-label="Abrir Menú">
            <i class="fas fa-bars"></i>
        </button>
        
        <div class="header-title">Card<span style="color: #ffbf00;">Factory</span></div>
        
        <div class="auth-actions" id="auth-container">
            @auth
                <a href="{{ url('/dashboard') }}" class="user-profile-widget">
                    <div class="profile-avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
                    <span style="font-size: 0.85rem; padding-right: 5px;">{{ Auth::user()->name }}</span>
                </a>
            @else
                <a href="{{ route('login') }}" class="btn-header btn-login">Login</a>
                <a href="{{ route('register') }}" class="btn-header btn-register">Registro</a>
            @endauth
        </div>
    </header>

    <main class="container">
        <div style="margin-bottom: 25px; margin-top: 20px;">
            <a href="javascript:history.back()" style="color: var(--secondary); text-decoration: none; font-weight: 600;">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>

        <div class="detail-grid" id="main-content">
            <div style="text-align: center; padding: 40px; color: #888;">Cargando información...</div>
        </div>

        <div class="sellers-section">
            <h3 style="margin-bottom: 20px; color: var(--text-dark);">
                <span><i class="fas fa-store" style="color: var(--primary);"></i> Ofertas</span>
                <span style="font-size: 0.8rem; color: #888; font-weight: normal; margin-left: 10px;">(Arrastra al carrito)</span>
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
                        @forelse($listings as $listing)
                            @php
                                $setName = $listing->card && $listing->card->set ? $listing->card->set->name : ($listing->set_name ?? 'Desconocido');
                                $sellerName = $listing->user ? $listing->user->name : 'Usuario';
                            @endphp
                            <tr class="listing-row" 
                                draggable="true" 
                                ondragstart="handleDragStart(event)"
                                data-id="{{ $listing->id }}"
                                data-price="{{ $listing->price }}"
                                data-seller="{{ $sellerName }}"
                                data-condition="{{ $listing->condition }}"
                                data-foil="{{ $listing->is_foil }}"
                                data-set="{{ $setName }}"
                            >
                                <td data-label="Vendedor">
                                    <div style="display:flex; align-items:center; gap:10px; justify-content: flex-end; @media(min-width:769px){justify-content:flex-start;}">
                                        <i class="fas fa-user-circle" style="font-size:1.8rem; color:#ccc;"></i>
                                        <strong>{{ $sellerName }}</strong>
                                    </div>
                                </td>
                                <td data-label="Estado">
                                    {{ $listing->condition }} 
                                    @if($listing->is_foil)<span class="badge badge-foil">Foil</span>@endif
                                </td>
                                <td data-label="Edición">{{ $setName }}</td>
                                <td data-label="Precio" class="price-tag">{{ number_format($listing->price, 2) }} €</td>
                                <td>
                                    <button class="btn-add" onclick="addToCartClick(this)"
                                        data-id="{{ $listing->id }}"
                                        data-price="{{ $listing->price }}"
                                        data-seller="{{ $sellerName }}"
                                        data-condition="{{ $listing->condition }}"
                                        data-foil="{{ $listing->is_foil }}"
                                        data-set="{{ $setName }}">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" style="text-align:center; padding: 20px;">Sin ofertas.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <footer role="contentinfo">
        <div class="footer-content">
            <div class="footer-section">
                <h4 style="margin-bottom:10px; font-weight:800; font-size:1.2rem;">CardFactory</h4>
                <p style="font-size:0.9rem; color:#ccc; line-height:1.5;">Tu mercado de confianza para comprar y vender cartas.</p>
                <div class="social-icons" style="margin-top:15px;">
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
                    <li><a href="javascript:void(0)" onclick="openAccModal()" id="acc-trigger" style="color: #ffbf00;">Accesibilidad</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 CardFactory. Todos los derechos reservados.</p>
        </div>
    </footer>

    <a id="cart-drop-zone" class="floating-cart-zone" onclick="window.location.href='/carrito'">        
        <span class="cart-badge" id="cart-count">0</span>
        <i class="fas fa-shopping-cart" style="font-size: 1.5rem;"></i>
    </a>

    <script>
        // --- VARIABLES DE AUTENTICACION ---
        // Aquí detectamos si está logueado o no para usarlos abajo
        const isUserLoggedIn = @json(Auth::check());
        const loginUrl = "{{ route('login') }}";

        // --- LOGICA DEL MENU Y MODAL ---
        function toggleMenu() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('overlay').classList.toggle('active');
        }
        function openAccModal() { document.getElementById('acc-modal').style.display = 'flex'; }
        function closeAccModal() { document.getElementById('acc-modal').style.display = 'none'; }

        // --- LOGICA DE CARTA Y CARRITO ---
        const params = new URLSearchParams(window.location.search);
        const cardId = params.get('id');
        let currentCardInfo = {}; 

        async function init() {
            updateCartCount();
            setupDropZone();
            if(!cardId) return;

            try {
                const res = await fetch(`https://api.scryfall.com/cards/${cardId}`);
                const card = await res.json();
                
                let img = "https://via.placeholder.com/400";
                if(card.image_uris) img = card.image_uris.large;
                else if(card.card_faces) img = card.card_faces[0].image_uris.large;

                currentCardInfo = { name: card.name, image: img };
                
                document.getElementById('main-content').innerHTML = `
                    <div style="text-align:center;">
                        <img src="${img}" class="card-image-large" alt="${card.name}">
                    </div>
                    <div>
                        <h1 style="font-size:2rem; margin-bottom:10px; font-weight: 800; color: var(--text-dark);">${card.name}</h1>
                        <p style="color:var(--secondary); font-weight:600; margin-bottom: 20px;">${card.type_line}</p>
                        <div style="background:white; padding:25px; border-radius:12px; border:1px solid #eee;">
                            ${card.oracle_text ? card.oracle_text.replace(/\n/g, '<br>') : 'Sin descripción.'}
                        </div>
                    </div>
                `;
            } catch(e) { console.error("Scryfall Error:", e); }
        }

        function processAddToCart(itemData) {
            let cart = JSON.parse(localStorage.getItem('myCart')) || [];
            if(cart.find(i => i.id === itemData.id)) {
                alert("⚠️ Esta oferta ya está en tu carrito.");
                return false;
            }
            const fullItem = {
                ...itemData,
                scryfall_id: cardId,
                name: currentCardInfo.name || "Cargando...",
                image: currentCardInfo.image || "",
                addedAt: new Date().getTime()
            };
            cart.push(fullItem);
            localStorage.setItem('myCart', JSON.stringify(cart));
            updateCartCount();
            return true;
        }

        // AGREGAR CLICK: Verificación de Login
        function addToCartClick(btn) {
            if(!isUserLoggedIn) {
                alert("Debes iniciar sesión para añadir productos al carrito.");
                window.location.href = loginUrl;
                return;
            }

            const ds = btn.dataset;
            const item = { id: ds.id, price: parseFloat(ds.price), seller: ds.seller, condition: ds.condition, is_foil: ds.foil == "1", set_name: ds.set };
            if(processAddToCart(item)) {
                const original = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-check"></i>'; btn.style.background = '#10b981';
                setTimeout(() => { btn.innerHTML = original; btn.style.background = ''; }, 1500);
            }
        }

        // DRAG START: Verificación de Login
        function handleDragStart(e) {
            if(!isUserLoggedIn) {
                e.preventDefault(); // Evita que empiece a arrastrar
                window.location.href = loginUrl;
                return;
            }

            const ds = e.target.dataset;
            const item = { id: ds.id, price: parseFloat(ds.price), seller: ds.seller, condition: ds.condition, is_foil: ds.foil == "1", set_name: ds.set };
            e.dataTransfer.setData("application/json", JSON.stringify(item));
        }

        function setupDropZone() {
            const zone = document.getElementById('cart-drop-zone');
            zone.addEventListener('dragover', (e) => { e.preventDefault(); zone.classList.add('drag-over-active'); });
            zone.addEventListener('dragleave', () => zone.classList.remove('drag-over-active'));
            zone.addEventListener('drop', (e) => {
                e.preventDefault(); zone.classList.remove('drag-over-active');
                
                // Si por alguna razón el drag start no lo bloqueó (navegadores viejos), bloqueamos aquí también
                if(!isUserLoggedIn) {
                    window.location.href = loginUrl;
                    return;
                }

                const data = JSON.parse(e.dataTransfer.getData("application/json"));
                if(processAddToCart(data)) {
                    zone.classList.add('pop'); setTimeout(() => zone.classList.remove('pop'), 400);
                }
            });
        }

        function updateCartCount() {
            const cart = JSON.parse(localStorage.getItem('myCart')) || [];
            const el = document.getElementById('cart-count');
            if(el) el.innerText = cart.length;
        }

        window.onload = init;
    </script>
</body>
</html>