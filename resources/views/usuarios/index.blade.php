@extends('layouts.app')

@section('content')
<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol de Usuario</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $user)
            <tr id="fila-usuario-{{ $user->id }}">
                <td>{{ $user->id }}</td>
                <td class="fw-bold">{{ $user->nombre }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @php
                        $badgeClass = match($user->rol) {
                            'Administrador' => 'badge-admin',
                            'Gestor de Almacén' => 'badge-almacen',
                            default => 'badge-auxiliar',
                        };
                    @endphp
                    <span id="badge-rol-{{ $user->id }}" class="badge {{ $badgeClass }} p-2">
                        {{ $user->rol ?? 'Auxiliar de Inventario' }}
                    </span>
                </td>
                <td class="text-center">
                    <button class="btn btn-sm text-primary me-2" onclick="abrirModal({{ $user->id }}, '{{ $user->rol }}')">
                        <i class="fas fa-cog"></i> Editar Rol
                    </button>
                    <button class="btn btn-sm text-danger" onclick="confirmarBaja({{ $user->id }})">
                        <i class="fas fa-trash"></i> Dar de baja
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="modal fade" id="modalEditar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Actualizar Rol de Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editUserId">
                <label class="form-label">Selecciona el nuevo rol:</label>
                <select id="editRol" class="form-select">
                    <option value="Administrador">Administrador</option>
                    <option value="Gestor de Almacén">Gestor de Almacén</option>
                    <option value="Auxiliar de Inventario">Auxiliar de Inventario</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="ejecutarActualizacion()">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>

<script>
    // 1. Abrir el modal con los datos actuales
    function abrirModal(id, rol) {
        document.getElementById('editUserId').value = id;
        document.getElementById('editRol').value = rol;
        var myModal = new bootstrap.Modal(document.getElementById('modalEditar'));
        myModal.show();
    }

    // 2. Enviar petición PUT a la API para actualizar el rol
    async function ejecutarActualizacion() {
        const id = document.getElementById('editUserId').value;
        const nuevoRol = document.getElementById('editRol').value;

        try {
            const response = await fetch(`/api/usuarios/${id}/rol`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ rol: nuevoRol })
            });

            if (response.ok) {
                alert('¡Rol actualizado correctamente!');
                location.reload(); // Recarga para actualizar colores de los badges
            } else {
                alert('Error al actualizar el rol.');
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }

    // 3. Enviar petición DELETE a la API para dar de baja
    async function confirmarBaja(id) {
        if (!confirm('¿Estás seguro de que deseas dar de baja a este usuario?')) return;

        try {
            const response = await fetch(`/api/usuarios/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            if (response.ok) {
                // Removemos la fila de la tabla sin recargar la página
                document.getElementById(`fila-usuario-${id}`).remove();
                alert('Usuario dado de baja.');
            } else {
                alert('Error al procesar la baja.');
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }
</script>
@endsection