<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Compras</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-brand">
            <i class="fas fa-box-open"></i>
            <span>Sistema Inventario</span>
        </div>
    </nav>
    
    <div class="sidebar">
        <div class="sidebar-header">
            <i class="fas fa-box-open fa-2x"></i>
            <h3>Inventario</h3>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item"><a href="{{ route('compras.index') }}" class="nav-link active"><i class="fas fa-shopping-cart"></i> Compras</a></li>
        </ul>
    </div>
    
    <div class="content">
        <div class="container mt-4">
            <h1 class="mb-4">Lista de Compras</h1>
            <div class="d-flex align-items-center mb-3">
                <a href="{{ route('compras.create') }}" class="btn btn-primary me-2"><i class="fas fa-plus"></i> Crear Compra</a>
                <a href="{{ route('welcome') }}" class="btn btn-secondary"><i class="fas fa-home"></i> Volver al Inicio</a>
            </div>
            <div class="card p-4">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Proveedor</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Fecha de Compra</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($compras as $compra)
                        <tr>
                            <td>{{ $compra->proveedor ? $compra->proveedor->nombre : 'N/A' }}</td>
                            <td>{{ $compra->producto ? $compra->producto->nombre : 'N/A' }}</td>
                            <td>{{ $compra->cantidad }}</td>
                            <td>{{ $compra->precio }}</td>
                            <td>{{ $compra->fecha_compra }}</td>
                            <td>
                                <a href="{{ route('compras.edit', $compra->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Editar</a>
                                <form action="{{ route('compras.destroy', $compra->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>