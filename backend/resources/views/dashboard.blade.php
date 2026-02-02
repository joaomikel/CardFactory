<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - CardFactory</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

    <style>
        :root { --primary: #816EB2; --dark: #111827; --bg: #f3f4f6; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        
        body { background-color: var(--bg); color: var(--dark); padding-bottom: 40px; }

        .top-nav { padding: 20px 5%; display: flex; justify-content: flex-start; }
        .btn-back { text-decoration: none; color: var(--primary); font-weight: 700; }

        .profile-container { max-width: 450px; margin: 0 auto; padding: 20px; }
        
        .profile-header { text-align: center; margin: 1rem 0 2rem; }
        .avatar-circle { 
            width: 100px; height: 100px; background: #e5e7eb; border-radius: 50%; 
            margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center;
            font-size: 3rem; color: #9ca3af; border: 4px solid white; box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }
        .user-name { font-size: 1.5rem; font-weight: 800; letter-spacing: -0.5px; }

        /* --- TABS --- */
        .ui-widget.ui-widget-content { border: none; background: transparent; }
        .ui-widget-header { border: none; background: transparent; font-weight: normal; }
        .ui-tabs { padding: 0; }
        .ui-tabs .ui-tabs-nav {
            display: flex; background: #e5e7eb; padding: 4px;
            border-radius: 12px; margin-bottom: 25px; border: none;
        }
        .ui-tabs .ui-tabs-nav li {
            flex: 1; margin: 0; border: none; background: transparent;
            list-style: none; text-align: center; border-radius: 8px; cursor: pointer; outline: none;
        }
        .ui-tabs .ui-tabs-nav li a {
            display: block; width: 100%; padding: 10px; text-decoration: none;
            font-weight: 600; color: #6b7280; font-size: 0.95rem; outline: none;
        }
        .ui-tabs .ui-tabs-nav li.ui-tabs-active { background: white; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .ui-tabs .ui-tabs-nav li.ui-tabs-active a { color: var(--primary); }
        .ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default { border: none; background: transparent; }

        /* --- FORMS & CARDS --- */
        .form-group { margin-bottom: 15px; }
        .form-label { display: block; margin-bottom: 6px; font-size: 0.9rem; font-weight: 600; color: #374151; }
        .form-input { 
            width: 100%; padding: 12px 15px; border-radius: 10px; border: 1px solid #d1d5db; 
            font-size: 1rem; outline: none; transition: 0.2s;
        }
        .form-input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(129, 110, 178, 0.1); }
        .btn-save {
            width: 100%; padding: 14px; background: var(--primary); color: white; border: none;
            border-radius: 12px; font-weight: 700; font-size: 1rem; cursor: pointer; margin-top: 10px;
        }
        
        .sales-card {
            background: white; border-radius: 20px; padding: 30px 20px; text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03); margin-bottom: 20px;
        }
        .sales-number { font-size: 3rem; font-weight: 800; color: var(--primary); line-height: 1; margin-bottom: 5px; }
        .sales-text { color: #6b7280; font-weight: 600; }

        .btn-products {
            display: block; width: 100%; text-align: center; padding: 14px; 
            background: var(--dark); color: white; border-radius: 12px; 
            text-decoration: none; font-weight: 700; transition: 0.2s;
        }

        .info-card { 
            background: white; border-radius: 20px; padding: 10px 20px; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.03); margin-top: 2rem;
        }
        .info-item { display: flex; justify-content: space-between; padding: 15px 0; border-bottom: 1px solid #f3f4f6; }
        .info-item:last-child { border-bottom: none; }
        .info-label { color: #6b7280; font-weight: 600; font-size: 0.9rem; }
        .info-value { font-weight: 700; }

        .btn-logout { 
            display: flex; align-items: center; justify-content: space-between;
            width: 100%; padding: 18px 20px; background: white; border-radius: 16px;
            margin-top: 20px; color: #ef4444; border: 1px solid #fee2e2; cursor: pointer; font-weight: 700;
        }

        /* --- NUEVOS ESTILOS PARA LAS CARTAS Y MODAL --- */
        
        .grid-cards {
            display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;
        }

        .user-card-item {
            background: white; padding: 10px; border-radius: 12px; 
            box-shadow: 0 2px 5px rgba(0,0,0,0.05); text-align: center;
            position: relative; overflow: hidden;
            transition: transform 0.2s;
        }

        .user-card-item:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }

        .card-img-wrapper {
            position: relative;
            width: 100%; height: 150px;
            margin-bottom: 10px;
            border-radius: 8px;
            overflow: hidden;
        }

        .card-img-wrapper img {
            width: 100%; height: 100%; object-fit: contain;
        }

        /* Overlay con botones (oculto por defecto) */
        .card-actions {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.6);
            display: flex; align-items: center; justify-content: center; gap: 10px;
            opacity: 0; transition: opacity 0.3s;
        }

        /* En móvil siempre visible un poco, en PC al hover */
        .user-card-item:hover .card-actions { opacity: 1; }
        @media (max-width: 768px) {
             /* Opcional: en móvil quizás prefieras botones siempre visibles debajo */
        }

        .action-btn {
            width: 40px; height: 40px; border-radius: 50%; border: none;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; color: white; font-size: 1.1rem;
            transition: transform 0.2s;
        }
        .action-btn:hover { transform: scale(1.1); }
        .btn-edit { background: #f59e0b; }
        .btn-delete { background: #ef4444; }

        /* Estilos del Modal */
        .modal-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.8); z-index: 2000;
            display: none; align-items: center; justify-content: center;
            backdrop-filter: blur(2px);
        }
        .modal-overlay.active { display: flex; animation: fadeIn 0.3s; }
        
        .modal-content {
            background: white; width: 90%; max-width: 400px; padding: 25px;
            border-radius: 16px; position: relative;
        }
        
        .modal-header-edit { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .modal-header-edit h3 { font-size: 1.2rem; font-weight: 700; }
        
        @keyframes fadeIn { from{opacity:0;} to{opacity:1;} }

    </style>
</head>
<body>

    <div class="top-nav">
        <a href="/" class="btn-back"><i class="fas fa-chevron-left"></i> Inicio</a>
    </div>

    <div class="profile-container">
        
        @if (session('status'))
            <div style="background-color: #d1fae5; color: #065f46; padding: 15px; border-radius: 12px; margin-bottom: 20px; border: 1px solid #a7f3d0; text-align: center;">
                <i class="fas fa-check-circle"></i> {{ session('status') }}
            </div>
        @endif

        @if (session('error'))
            <div style="background-color: #fee2e2; color: #991b1b; padding: 15px; border-radius: 12px; margin-bottom: 20px; border: 1px solid #fecaca; text-align: center;">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        <div class="profile-header">
            <div class="avatar-circle">
                <i class="fas fa-user"></i>
            </div>
            <h1 class="user-name">{{ Auth::user()->name }}</h1>
        </div>

        <div id="tabs">
            <ul>
                <li><a href="#tabs-config">Configuración</a></li>
                <li><a href="#tabs-sales">Ventas</a></li>
            </ul>

            <div id="tabs-config">
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('patch')

                    <div class="form-group">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="name" class="form-input" value="{{ Auth::user()->name }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Apellidos</label>
                        <input type="text" name="surname" class="form-input" value="{{ Auth::user()->surname ?? '' }}" placeholder="Tus apellidos">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Número de teléfono</label>
                        <input type="tel" name="phone" class="form-input" value="{{ Auth::user()->phone ?? '' }}" placeholder="600 000 000">
                    </div>

                    <button type="submit" class="btn-save">Guardar Cambios</button>
                </form>
            </div>

            <div id="tabs-sales">
                <div class="sales-card">
                    <div class="sales-number">{{ $listings->count() }}</div>
                    <div class="sales-text">Productos disponibles</div>
                </div>

                <a href="{{ route('vender') }}" class="btn-products">
                    <i class="fas fa-box-open" style="margin-right: 8px;"></i> Publicar Nuevo Producto
                </a>

                <h3 style="margin-top: 30px; margin-bottom: 15px; font-weight: 800;">Mis Cartas en Venta</h3>

                @if($listings->isEmpty())
                    <p style="text-align: center; color: #6b7280;">No tienes cartas a la venta.</p>
                @else
                    <div class="grid-cards">
                        @foreach($listings as $listing)
                            <div class="user-card-item">
                                <div class="card-img-wrapper">
                                    <img src="{{ $listing->card->image_url }}" alt="{{ $listing->card->name }}">
                                    
                                    <div class="card-actions">
                                        <button type="button" class="action-btn btn-edit" 
                                                onclick="openEditModal({{ $listing->id }}, '{{ $listing->card->name }}', {{ $listing->price }}, '{{ $listing->condition }}')">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                        
                                        <form action="/listings/{{ $listing->id }}" method="POST" onsubmit="return confirm('¿Eliminar?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn btn-delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                
                                <h4 style="font-size: 0.9rem; font-weight: 700; margin-bottom: 5px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $listing->card->name }}
                                </h4>
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 5px;">
                                    <span style="color: #816EB2; font-weight: 800;">{{ $listing->price }} €</span>
                                    <span style="font-size: 0.7rem; background: #f3f4f6; padding: 2px 6px; border-radius: 4px;">{{ $listing->condition }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        
        <div class="info-card">
            <div class="info-item">
                <span class="info-label">Creación de cuenta</span>
                <span class="info-value">{{ Auth::user()->created_at->format('d/m/Y') }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Id Usuario</span>
                <span class="info-value">{{ Auth::user()->id }}</span>
            </div>
        </div>

        <form method="POST" action="{{ route('logout') }}" id="logoutForm">
            @csrf
            <button type="submit" class="btn-logout">
                <span><i class="fas fa-sign-out-alt" style="margin-right: 10px;"></i> Cerrar sesión</span>
                <i class="fas fa-chevron-right" style="color: #cbd5e1; font-size: 0.8rem;"></i>
            </button>
        </form>

    </div>

    <div id="editModal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header-edit">
                <h3>Editar Producto</h3>
                <button onclick="closeEditModal()" style="background:none; border:none; font-size:1.5rem; cursor:pointer;">&times;</button>
            </div>
            
            <form id="editForm" method="POST" action="">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label class="form-label">Carta</label>
                    <input type="text" id="modalName" class="form-input" disabled style="background:#f3f4f6; color:#666;">
                </div>

                <div class="form-group">
                    <label class="form-label">Precio (€)</label>
                    <input type="number" step="0.01" name="price" id="modalPrice" class="form-input" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Estado</label>
                    <select name="condition" id="modalCondition" class="form-input">
                        <option value="NM">Near Mint</option>
                        <option value="EX">Excellent</option>
                        <option value="GD">Good</option>
                        <option value="LP">Light Played</option>
                        <option value="PL">Played</option>
                        <option value="PO">Poor</option>
                    </select>
                </div>

                <button type="submit" class="btn-save">Guardar Cambios</button>
            </form>
        </div>
    </div>

    <script>
        // --- LOGOUT ---
        document.getElementById('logoutForm').addEventListener('submit', function() {
            sessionStorage.removeItem('auth_token');
            sessionStorage.removeItem('user_data');
            localStorage.removeItem('auth_token');
            localStorage.removeItem('user_data');
        });

        // --- TABS ---
        $( function() {
            $( "#tabs" ).tabs({
                show: { effect: "fade", duration: 300 },
                hide: { effect: "fade", duration: 300 }
            });
        } );

        // --- LÓGICA DEL MODAL ---
        function openEditModal(id, name, price, condition) {
            // 1. Rellenar datos
            document.getElementById('modalName').value = name;
            document.getElementById('modalPrice').value = price;
            document.getElementById('modalCondition').value = condition;

            // 2. ACTUALIZAMOS LA RUTA AL CONTROLADOR DE LISTINGS
            const form = document.getElementById('editForm');
            form.action = '/listings/' + id; 

            // 3. Mostrar modal
            document.getElementById('editModal').classList.add('active');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.remove('active');
        }

        // Cerrar al hacer clic fuera
        document.getElementById('editModal').addEventListener('click', function(e) {
            if(e.target === this) closeEditModal();
        });
    </script>

</body>
</html>