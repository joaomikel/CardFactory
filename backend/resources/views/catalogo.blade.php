<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Catálogo - CardFactory</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" href="http://localhost:8000/css/catalogo.css">
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
                <img src="{{ asset('logo.jpg') }}" alt="CardFactory Logo" class="footer-logo">
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

    <script src="http://localhost:8000/js/catalogo.js"></script>
</body>
</html>