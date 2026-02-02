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
    <link rel="stylesheet" href="http://localhost:8000/css/dashboard.css">
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
                            <div class="user-card-item" tabindex="0">
                                <div class="card-img-wrapper">
                                    <img src="{{ $listing->card->image_url }}" alt="{{ $listing->card->name }}">
                                </div>
                                
                                <div class="card-info">
                                    <h4 class="card-title">{{ $listing->card->name }}</h4>
                                    <span class="card-edition">
                                        {{ $listing->card->set ? $listing->card->set->name : 'N/A' }}
                                    </span>
                                    <div class="card-details">
                                        <span style="color: #816EB2; font-weight: 800;">{{ $listing->price }} €</span>
                                        <span style="font-size: 0.7rem; background: #f3f4f6; padding: 2px 6px; border-radius: 4px;">{{ $listing->condition }}</span>
                                    </div>
                                </div>

                                <div class="card-actions-bar">
                                    <button type="button" class="btn-action-mobile btn-edit-mobile" 
                                            onclick="openEditModal({{ $listing->id }}, '{{ addslashes($listing->card->name) }}', {{ $listing->price }}, '{{ $listing->condition }}', {{ $listing->card->set_id ?? 'null' }})">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                    
                                    <form action="{{ url('/listings/' . $listing->id) }}" method="POST" onsubmit="return confirm('¿Eliminar esta carta de la venta?');" style="margin:0; flex:1; display:flex;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action-mobile btn-delete-mobile" style="width:100%;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
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
                <button onclick="closeEditModal()" class="close-modal-btn" style="background:none; border:none; font-size:1.5rem; cursor:pointer;">&times;</button>
            </div>
            
            <form id="editForm" method="POST" action="">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label class="form-label">Carta</label>
                    <input type="text" id="modalName" class="form-input" disabled style="background:#f3f4f6; color:#666;">
                </div>

                <div class="form-group">
                    <label class="form-label">Edición</label>
                    <select name="set_id" id="modalSet" class="form-input">
                        @if(isset($sets))
                            @foreach($sets as $set)
                                <option value="{{ $set->id }}">{{ $set->name }} ({{ strtoupper($set->code) }})</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Precio (€)</label>
                    <input type="number" step="0.01" name="price" id="modalPrice" class="form-input" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Estado</label>
                    <select name="condition" id="modalCondition" class="form-input">
                        <option value="Mint">Mint (Perfecta)</option>
                        <option value="Near Mint">Near Mint (Casi Nueva)</option>
                        <option value="Excellent">Excellent</option>
                        <option value="Good">Good</option>
                        <option value="Played">Played (Muy usada)</option>
                        <option value="Poor">Poor</option>
                    </select>
                </div>

                <button type="submit" class="btn-save">Guardar Cambios</button>
            </form>
        </div>
    </div>

    <script src="http://localhost:8000/js/dashboard.js"></script>

</body>
</html>