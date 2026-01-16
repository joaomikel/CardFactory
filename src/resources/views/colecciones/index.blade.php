<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>CardFactory - Todas las Colecciones</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* --- 1. RESET Y BASE BLINDADA --- */
        :root {
            --primary: #816EB2;
            --secondary: #958EA0;
            --text-dark: #222;
            --text-light: #f4f4f4;
            --white: #ffffff;
            --radius: 16px;
        }

        * { 
            margin: 0; padding: 0; 
            box-sizing: border-box; /* Fundamental para que el padding no rompa el ancho */
            -webkit-tap-highlight-color: transparent; 
        }

        html, body {
            width: 100%;
            max-width: 100vw; /* Asegura que nunca sea más ancho que la pantalla */
            overflow-x: hidden; /* Oculta lo que sobre salga horizontalmente */
            background-color: #f8f9fa; 
            color: var(--text-dark);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* --- 2. HEADER FIJO SEGURO --- */
        header {
            background: transparent;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 15px; /* Padding interno seguro */
            position: absolute;
            top: 0;
            left: 0; 
            right: 0; /* Anclado a izquierda y derecha */
            width: 100%;
            z-index: 100;
        }

        .menu-trigger { 
            font-size: 1.5rem; background: none; border: none; 
            color: var(--white); cursor: pointer; padding: 5px;
            text-shadow: 0 1px 3px rgba(0,0,0,0.5);
        }

        .auth-actions { display: flex; gap: 8px; }
        .btn-header {
            padding: 6px 12px; border-radius: 20px; font-weight: 600;
            text-decoration: none; font-size: 0.75rem; 
        }
        .btn-login { background: rgba(255,255,255,0.2); color: var(--white); border: 1px solid rgba(255,255,255,0.4); backdrop-filter: blur(4px); }
        .btn-register { background: var(--primary); color: var(--white); }

        /* --- 3. SIDEBAR --- */
        .sidebar-overlay {
            position: fixed; top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.6); z-index: 101; opacity: 0; pointer-events: none; transition: 0.3s;
            backdrop-filter: blur(3px);
        }
        .sidebar-overlay.active { opacity: 1; pointer-events: all; }

        .sidebar {
            position: fixed; top: 0; left: -100%; width: 280px; height: 100%;
            background: var(--white); z-index: 102; padding: 2rem; 
            transition: left 0.3s ease;
            box-shadow: 5px 0 20px rgba(0,0,0,0.1);
        }
        .sidebar.active { left: 0; }
        .close-sidebar { position: absolute; top: 15px; right: 15px; font-size: 1.8rem; background: none; border: none; color: #666; }
        .sidebar a { display: block; padding: 15px 0; border-bottom: 1px solid #eee; color: var(--text-dark); text-decoration: none; font-size: 1.1rem; }

        /* --- 4. HERO SECTION (Ajustado para no desbordar) --- */
        .hero-mini {
            position: relative;
            width: 100%;
            padding: 90px 20px 40px 20px; 
            display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center;
            background: 
                linear-gradient(180deg, rgba(0,0,0,0.4) 0%, rgba(129, 110, 178, 0.95) 100%),
                url('https://cards.scryfall.io/art_crop/front/e/3/e37da81e-be12-45a2-9128-376f1ad7b3e8.jpg?1562202585'); 
            background-size: cover; background-position: center top;
            margin-bottom: 20px;
            color: white;
            border-bottom-left-radius: 25px;
            border-bottom-right-radius: 25px;
            overflow: hidden; /* Evita que la imagen se salga */
        }
        
        .hero-mini h1 { 
            font-size: 1.8rem; 
            margin-bottom: 20px; 
            line-height: 1.2;
            word-wrap: break-word; /* Rompe palabras largas si es necesario */
        }
        
        .search-wrapper-mini { width: 100%; max-width: 500px; position: relative; }
        .search-wrapper-mini input {
            width: 100%; padding: 14px 45px 14px 20px; font-size: 1rem;
            border: none; border-radius: 50px; outline: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2); 
        }
        .search-icon-mini {
            position: absolute; right: 20px; top: 50%; transform: translateY(-50%);
            color: var(--primary);
        }

        /* --- 5. CONTENEDOR FLUIDO --- */
        .container { 
            width: 100%; 
            padding: 0 15px; 
            margin: 0 auto; 
            flex: 1; 
        }
        
        /* Grid que se comporta como Lista en Móvil */
        .sets-grid { 
            display: grid; 
            grid-template-columns: 1fr; /* Una sola columna por defecto (móvil) */
            gap: 15px; 
            margin-bottom: 30px;
            width: 100%;
        }

        .set-item {
            background: var(--white);
            border-radius: var(--radius);
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            padding: 15px;
            gap: 15px;
            cursor: pointer;
            border-left: 4px solid var(--primary);
            width: 100%; /* Asegura que ocupe el ancho disponible */
            overflow: hidden; /* Evita desbordamiento interno */
        }

        .set-icon {
            width: 40px; height: 40px;
            flex-shrink: 0;
            fill: var(--text-dark);
        }
        
        /* SOLUCIÓN AL CORTE DE TEXTO: Flexbox con min-width 0 */
        .set-info { 
            flex: 1; 
            min-width: 0; /* TRUCO DE ORO: Permite que el flex-child se encoja */
            display: flex; flex-direction: column; justify-content: center;
        }

        .set-info h3 { 
            font-size: 1rem; 
            color: var(--text-dark); 
            margin-bottom: 4px; 
            font-weight: 700;
            /* Puntos suspensivos si el texto es muy largo */
            white-space: nowrap; 
            overflow: hidden; 
            text-overflow: ellipsis; 
        }

        .set-info p { font-size: 0.85rem; color: #666; margin: 0; }
        
        .arrow-indicator { font-size: 1.2rem; color: #ccc; margin-left: auto; }

        /* Botón cargar más */
        .btn-more {
            display: block; width: 100%; max-width: 300px; margin: 20px auto;
            background: white; color: var(--primary); border: 2px solid var(--primary);
            padding: 12px; border-radius: 50px; font-weight: 700; font-size: 1rem;
            cursor: pointer; box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        /* --- 6. FOOTER --- */
        footer {
            margin-top: auto;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: var(--text-light);
            padding: 40px 20px 20px 20px;
        }
        .footer-content {
            display: grid; grid-template-columns: 1fr; gap: 30px;
            max-width: 1200px; margin: 0 auto;
        }
        .footer-bottom { 
            margin-top: 30px; border-top: 1px solid rgba(255,255,255,0.1); 
            padding-top: 20px; text-align: center; font-size: 0.8rem; opacity: 0.7; 
        }

        /* --- 7. TABLET Y DESKTOP (Scaling Up) --- */
        @media (min-width: 768px) {
            .container { max-width: 1200px; padding: 0 40px; }
            
            /* El grid pasa a ser cuadrícula real */
            .sets-grid { 
                grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); 
                gap: 25px; 
            }
            
            .hero-mini { padding: 140px 40px 80px 40px; border-radius: 0; }
            .hero-mini h1 { font-size: 3rem; }
            
            header { padding: 0 40px; height: 80px; }
            .footer-content { grid-template-columns: repeat(3, 1fr); }
        }
    </style>
</head>
<body>

    <div class="sidebar-overlay" id="overlay" onclick="toggleMenu()"></div>
    <div class="sidebar" id="sidebar">
        <button class="close-sidebar" onclick="toggleMenu()">&times;</button>
        <h3 style="color: var(--primary); margin-bottom: 1.5rem;">Menú</h3>
        <a href="index.html">Inicio</a>
        <a href="#">Perfil</a>
        <a href="collections.html" style="color: var(--primary); font-weight: 700;">Colecciones</a>
        <a href="#">Catálogo</a>
    </div>

    <header>
        <button class="menu-trigger" onclick="toggleMenu()">&#9776;</button>
        <div class="auth-actions">
            <a href="{{ route('login') }}" class="btn-header btn-login">Login</a>
            <a href="{{ route('register') }}" class="btn-header btn-register">Registro</a>
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

    <footer>
        <div class="footer-content">
            <div>
                <h3 style="margin-bottom:10px; color:white;">CardFactory</h3>
                <p style="font-size:0.9rem; opacity:0.8;">Explora el multiverso de Magic.</p>
            </div>
            <div>
                <h3 style="margin-bottom:10px; color:white;">Links</h3>
                <a href="index.html" style="color:white; text-decoration:none; display:block; margin-bottom:5px;">Inicio</a>
                <a href="#" style="color:white; text-decoration:none;">Catálogo</a>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; 2026 CardFactory.
        </div>
    </footer>

    <script>
        function toggleMenu() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('overlay').classList.toggle('active');
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
                // Ordenar más reciente primero
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

            container.innerHTML = setsList.map(set => {
                const dateYear = new Date(set.released_at).getFullYear();
                return `
                <div class="set-item" onclick="console.log('${set.code}')">
                    <img src="${set.icon_svg_uri}" class="set-icon" alt="" loading="lazy">
                    <div class="set-info">
                        <h3>${set.name}</h3>
                        <p>${set.card_count} Cartas • ${dateYear}</p>
                    </div>
                    <div class="arrow-indicator">›</div>
                </div>
            `}).join('');
        }

        document.getElementById('setSearchInput').addEventListener('keyup', (e) => {
            const term = e.target.value.toLowerCase();
            const filtered = allSets.filter(set => set.name.toLowerCase().includes(term));
            currentCount = 20;
            renderSets(filtered.slice(0, currentCount));
            document.getElementById('loadMoreBtn').style.display = (term !== '' || filtered.length <= currentCount) ? 'none' : 'block';
        });

        document.getElementById('loadMoreBtn').addEventListener('click', () => {
            currentCount += 20;
            const term = document.getElementById('setSearchInput').value.toLowerCase();
            let listToRender = allSets;
            if(term !== '') listToRender = allSets.filter(set => set.name.toLowerCase().includes(term));
            
            renderSets(listToRender.slice(0, currentCount));
            if (currentCount >= listToRender.length) document.getElementById('loadMoreBtn').style.display = 'none';
        });

        window.onload = loadSets;
    </script>
</body>
</html>
apps-fileview.texmex_20260108.00_p0
colecciones.html
Mostrando colecciones.html.