<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Productos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <style>
        .product-image {
            width: 100px; /* Ajusta el ancho según tus necesidades */
            height: auto;
        }
    </style>
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
            <li class="nav-item"><a href="{{ route('productos.index') }}" class="nav-link active"><i class="fas fa-box"></i> Productos</a></li>
        </ul>
    </div>

    <div class="content">
    <div class="container mt-4">
        <h1 class="mb-4">Lista de Productos</h1>

        <!-- Botones alineados en la misma línea -->
        <div class="d-flex align-items-center mb-3">
            <a href="{{ route('welcome') }}" class="btn btn-secondary"><i class="fas fa-home"></i> Volver al Inicio</a>
        </div>

        <!-- Formulario de búsqueda avanzada -->
        <form action="{{ route('productos.index') }}" method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-10">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-box"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Buscar por nombre">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Estado</th>
                        <th>Imagen</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productos as $producto)
                    <tr>
                        <td>{{ $producto->id }}</td>
                        <td>{{ $producto->nombre }}</td>
                        <td>{{ $producto->precio }}</td>
                        <td>{{ $producto->stock }}</td>
                        <td>{{ $producto->estado }}</td>
                        <td>
                            <img src="{{ $producto->imagen ?: 'https://img.freepik.com/vector-premium/vector-icono-imagen-predeterminado-pagina-imagen-faltante-diseno-sitio-web-o-aplicacion-movil-no-hay-foto-disponible_87543-11093.jpg' }}" class="product-image" alt="Imagen del Producto">
                        </td>
                        <td>
                            <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Editar</a>
                            <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" style="display:inline;">
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

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
