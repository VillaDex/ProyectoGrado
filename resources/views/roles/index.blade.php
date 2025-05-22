<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignar Roles</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/css/welcome.css?<?= filemtime(public_path('css/welcome.css')) ?>" />
</head>
<body>
    <nav class="navbar">
        <div class="navbar-brand">
            <i class="fas fa-user-shield"></i>
            <span>Gestión de Roles</span>
        </div>
    </nav>
    
    <div class="sidebar">
        <div class="sidebar-header">
            <i class="fas fa-users-cog fa-2x"></i>
            <h3>Roles</h3>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item"><a href="{{ route('roles.index') }}" class="nav-link active"><i class="fas fa-user-tag"></i> Asignar Roles</a></li>
        </ul>
    </div>
    
    <div class="content">
        <div class="container mt-4">
            <!-- Título y botón alineados en la misma línea -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Asignar Roles</h1>
                <a href="{{ route('welcome') }}" class="btn btn-secondary">
                    <i class="fas fa-home"></i> Volver al Inicio
                </a>
            </div>

            <!-- Barra de búsqueda -->
            <form action="{{ route('roles.index') }}" method="GET" class="mb-4">
                <div class="row">
                    <div class="col-md-10">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" name="search" class="form-control" placeholder="Buscar usuarios por nombre" value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary">Buscar</button>
                        @if(request('search'))
                            <a href="{{ route('roles.index') }}" class="btn btn-secondary ms-2">Limpiar</a>
                        @endif
                    </div>
                </div>
            </form>

            <div class="card p-4">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Usuario</th>
                            <th>Roles</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>
                                    <form action="{{ route('assign.role', $user->id) }}" method="POST">
                                        @csrf
                                        @foreach ($roles as $role)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->id }}" 
                                                    {{ $user->hasRole($role->name) ? 'checked' : '' }}>
                                                <label class="form-check-label">{{ $role->name }}</label>
                                            </div>
                                        @endforeach
                                        <button type="submit" class="btn btn-primary btn-sm mt-2"><i class="fas fa-save"></i> Guardar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>