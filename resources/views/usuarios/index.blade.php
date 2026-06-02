@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Gestión de Usuarios</h2>
        <a href="{{ route('usuarios.create') }}" class="btn btn-success shadow-sm">
             + Nuevo Usuario
        </a>
    </div>

    <div class="card shadow-sm border-0" style="border-radius: 15px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol de Usuario</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usuarios as $user)
                        <tr id="fila-usuario-{{ $user->id }}">
                            <td class="ps-4">{{ $user->id }}</td>
                            <td class="fw-bold">{{ $user->nombre }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @php
                                    $badgeClass = match($user->rol) {
                                        'Administrador' => 'bg-warning text-dark',
                                        'Gestor de Almacén' => 'bg-primary',
                                        default => 'bg-info text-dark',
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }} p-2">
                                    {{ $user->rol ?? 'Auxiliar de Inventario' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm text-primary me-2" onclick="abrirModal({{ $user->id }}, '{{ $user->rol }}')">
                                    <i class="fas fa-edit"></i> Editar Rol
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
        </div>
    </div>
</div>

{{-- MODAL DE EDICIÓN --}}
<div class="modal fade" id="modalEditar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Actualizar Rol</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editUserId">
                <label class="form-label fw-bold">Nuevo Rol:</label>
                <select id="editRol" class="form-select shadow-sm">
                    <option value="Administrador">Administrador</option>
                    <option value="Gestor de Almacén">Gestor de Almacén</option>
                    <option value="Auxiliar de Inventario">Auxiliar de Inventario</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="ejecutarActualizacion()">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>

<script>
    function abrirModal(id, rol) {
        document.getElementById('editUserId').value = id;
        document.getElementById('editRol').value = rol;
        var myModal = new bootstrap.Modal(document.getElementById('modalEditar'));
        myModal.show();
    }

    async function ejecutarActualizacion() {
        const id = document.getElementById('editUserId').value;
        const nuevoRol = document.getElementById('editRol').value;

        const response = await fetch(`/api/usuarios/${id}/rol`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ rol: nuevoRol })
        });

        if (response.ok) {
            location.reload();
        } else {
            alert('Error al actualizar');
        }
    }

    async function confirmarBaja(id) {
        if (!confirm('¿Seguro que deseas eliminar este usuario?')) return;
        
        const response = await fetch(`/api/usuarios/${id}`, { method: 'DELETE' });

        if (response.ok) {
            document.getElementById(`fila-usuario-${id}`).remove();
        } else {
            alert('Error al eliminar');
        }
    }
</script>
@endsection