<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>CardFactory - Todas las Colecciones</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" href="http://localhost:8000/css/colecciones.css">
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
                    <li><span class="acc-tag tag-aa">Navegación</span> Foco visible en elementos interactivos.</li>
                    <li><span class="acc-tag tag-aa">Semántica</span> Estructura correcta de encabezados.</li>
                </ul>
                <span class="acc-subtitle">❌ Pendiente de corrección:</span>
                <ul class="acc-list">
                    <li><span class="acc-tag tag-fail">Imágenes</span> Faltan textos alternativos dinámicos.</li>
                    <li><span class="acc-tag tag-fail">Formularios</span> Etiquetas ocultas visualmente.</li>
                    <li><span class="acc-tag tag-fail">Modal</span> Falta "Focus Trap".</li>
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
        <a href="/ayuda">Ayuda</a>
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
            <input type="text" placeholder="Buscar edición..." id="setSearchInput" alt="Buscador">
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
                <img src="http://localhost:8000/logo.jpg" alt="CardFactory Logo" class="footer-logo">
                <p>Tu mercado de confianza para comprar y vender cartas de Magic.</p>
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
                    <li><a href="/ayuda">Ayuda</a></li>                    
                    <li><a href="javascript:void(0)" onclick="openAccModal()" id="acc-trigger" style="color: #ffbf00;">Accesibilidad</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 CardFactory. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="http://localhost:8000/js/colecciones.js"></script>
</body>
</html>