<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos - Inventario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .header-banner {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://via.placeholder.com/1200x300');
            background-size: cover;
            color: white;
            padding: 60px 0;
            text-align: center;
            margin-bottom: -50px;
        }
        .main-card {
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border: none;
        }
        .badge-admin { background-color: #ffc107; color: #000; }
        .badge-almacen { background-color: #6c5ce7; }
        .badge-auxiliar { background-color: #00b894; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold" href="{{ url('/') }}">SGI Almacén</a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDarkDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse justify-content-end" id="navbarNavDarkDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <button class="btn btn-dark dropdown-toggle d-flex align-items-center gap-2" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle fs-5 text-warning"></i>
                            {{ Auth::user()->name ?? 'Usuario' }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end shadow" aria-labelledby="navbarDarkDropdownMenuLink">
                            <li>
                                {{-- Usamos url() temporalmente para evitar que Laravel falle si la ruta no está registrada --}}
                                <a class="dropdown-item" href="{{ url('/perfil/cambiar-contratena') }}">
                                    <i class="fas fa-key fa-sm fa-fw me-2 text-gray-400"></i> Cambiar Contraseña
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw me-2"></i> Cerrar Sesión
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="header-banner">
        <h1>@yield('titulo_superior', 'Panel de Control')</h1>
    </div>

    <div class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card main-card">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0">@yield('subtitulo', '')</h5>
                            <a href="{{ url('/') }}" class="btn btn-link text-decoration-none {{ Request::is('/') ? 'd-none' : '' }}">← Volver al Dashboard</a>
                        </div>
                        
                        @yield('content')
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    async function darDeBaja(id) {
        if (!confirm('¿Estás seguro de que deseas dar de baja a este usuario?')) return;

        try {
            const response = await fetch(`/api/usuarios/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            });

            if (response.ok) {
                document.getElementById(`fila-usuario-${id}`).remove();
                alert('Usuario eliminado con éxito');
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }
    </script>
</body>
</html>