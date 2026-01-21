<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración - CardFactory</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary: #816EB2; --dark: #111827; --bg: #f3f4f6; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background-color: var(--bg); color: var(--dark); padding-bottom: 40px; }

        .top-nav { padding: 20px 5%; display: flex; justify-content: flex-start; }
        .btn-back { text-decoration: none; color: var(--primary); font-weight: 700; display: flex; align-items: center; gap: 8px;}

        .profile-container { max-width: 450px; margin: 0 auto; padding: 20px; }
        
        .form-card { 
            background: white; border-radius: 20px; padding: 25px; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.03); 
        }
        
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; color: #6b7280; font-weight: 600; font-size: 0.9rem; margin-bottom: 8px; }
        .form-input { 
            width: 100%; padding: 15px; border-radius: 12px; border: 1px solid #e5e7eb; 
            font-size: 1rem; font-weight: 600; color: var(--dark); outline: none; transition: 0.2s;
        }
        .form-input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(129, 110, 178, 0.1); }

        .btn-save { 
            width: 100%; padding: 18px; background: var(--primary); color: white; border: none; 
            border-radius: 16px; font-weight: 700; font-size: 1rem; cursor: pointer; margin-top: 10px;
        }
        .btn-save:hover { opacity: 0.9; }

        /* Mensaje de éxito */
        .alert-success {
            background-color: #d1fae5; color: #065f46; padding: 15px; 
            border-radius: 12px; margin-bottom: 20px; font-weight: 600; 
            display: flex; align-items: center; gap: 10px;
        }
    </style>
</head>
<body>

    <div class="top-nav">
        <a href="/dashboard" class="btn-back">
            <i class="fas fa-chevron-left"></i> Volver al Perfil
        </a>
    </div>

    <div class="profile-container">
        <h1 style="margin-bottom: 20px; font-size: 1.8rem;">Editar mis datos</h1>

        @if (session('status') === 'profile-updated')
            <div class="alert-success">
                <i class="fas fa-check-circle"></i> Datos actualizados correctamente
            </div>
        @endif

        <div class="form-card">
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PATCH')

                <div class="form-group">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="name" class="form-input" value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Apellido</label>
                    <input type="text" name="surname" class="form-input" value="{{ old('surname', $user->surname) }}" placeholder="Tu apellido">
                </div>

                <div class="form-group">
                    <label class="form-label">Teléfono</label>
                    <input type="tel" name="phone" class="form-input" value="{{ old('phone', $user->phone) }}" placeholder="+34 ...">
                </div>

                <div class="form-group">
                    <label class="form-label">Email (No modificable)</label>
                    <input type="email" class="form-input" value="{{ $user->email }}" disabled style="background: #f9fafb; color: #9ca3af;">
                </div>

                <button type="submit" class="btn-save">Guardar Cambios</button>
            </form>
        </div>
    </div>

</body>
</html>