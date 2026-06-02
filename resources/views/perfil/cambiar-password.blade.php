<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGI - Configuración de Seguridad</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), 
                              url('{{ asset("img/fondo.png") }}'); 
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: flex-start;
            justify-content: center;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.98); 
            border-radius: 20px;
            padding: 2.5rem;
            margin-top: 5rem;
            width: 100%;
            max-width: 750px; /* Un poco más angosta para un formulario de login/password */
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5); 
        }
        .btn-primary {
            background-color: #0d6efd;
            transition: 0.3s;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(13, 110, 253, 0.4);
        }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center">
        <div class="glass-card">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-dark fw-bold mb-0">Configuración de Seguridad</h2>
                <a href="{{ url('/') }}" class="btn btn-outline-secondary rounded-pill">Volver al Panel</a>
            </div>

            {{-- Alertas de Éxito o Errores --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <ul class="mb-0 mt-1 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="p-2">
                <h5 class="text-muted mb-4">Modificar Contraseña de Acceso</h5>
                
                <form action="{{ route('password.actualizar') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="current_password" class="form-label fw-semibold text-muted">Contraseña Actual</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-shield-alt text-muted"></i></span>
                            <input type="password" name="current_password" id="current_password" class="form-control" placeholder="Introduce tu clave actual" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="new_password" class="form-label fw-semibold text-muted">Nueva Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-key text-muted"></i></span>
                            <input type="password" name="new_password" id="new_password" class="form-control" placeholder="Mínimo 8 caracteres" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="new_password_confirmation" class="form-label fw-semibold text-muted">Confirmar Nueva Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-check text-muted"></i></span>
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" placeholder="Repite la nueva clave" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ url('/') }}" class="btn btn-light border rounded-pill px-4">Cancelar</a>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            <i class="fas fa-save me-2"></i> Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>