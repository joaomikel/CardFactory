<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Detalle de Carta - CardFactory</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" href="http://localhost:8000/css/carta.css">
</head>
<body>

    <div class="sidebar-overlay" id="overlay" onclick="toggleMenu()"></div>
    
    <div class="sidebar" id="sidebar">
        <button class="close-sidebar" id="closeBtn" onclick="toggleMenu()" aria-label="Cerrar menú">&times;</button>
        <h3 style="color: var(--primary); margin-bottom: 1.5rem; font-weight: 800;">Menú</h3>
        <a href="/">Inicio</a>
        <a href="/dashboard" id="link-perfil-sidebar">Perfil</a>
        <a href="/colecciones">Colecciones</a>
        <a href="/catalogo">Catálogo</a>
        <a href="/carrito">Carrito</a>    
    </div>

    <header>
        <button class="menu-trigger" id="menuBtn" onclick="toggleMenu()" aria-label="Abrir menú">
            <i class="fas fa-bars"></i>
        </button>
        
        <div class="auth-actions" id="auth-container">
            </div>
    </header>

    <main class="container">
        <div style="margin-bottom: 25px; margin-top: 20px;">
            <a href="javascript:history.back()" style="color: var(--secondary); text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; border-radius: 4px;">
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

    <script src="http://localhost:8000/js/carta.js"></script>
</body>
</html>