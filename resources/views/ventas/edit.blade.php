<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Venta</title>
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
            <li class="nav-item"><a href="{{ route('ventas.index') }}" class="nav-link active"><i class="fas fa-cash-register"></i> Ventas</a></li>
        </ul>
    </div>
    
    <div class="content">
        <div class="container mt-4">
            <h1 class="mb-4">Editar Venta</h1>
            <a href="{{ route('ventas.index') }}" class="btn btn-secondary mb-3">Volver a la Lista</a>
            <div class="card p-4">
                <form id="formVenta" action="{{ route('ventas.update', $venta->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="cliente_id">Cliente</label>
                        <select name="cliente_id" class="form-control" required>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}" {{ $cliente->id == $venta->cliente_id ? 'selected' : '' }}>{{ $cliente->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="producto_id">Producto</label>
                        <select name="producto_id" id="producto_id" class="form-control" required>
                            @foreach($productos as $producto)
                                <option value="{{ $producto->id }}" data-stock="{{ $producto->stock }}" {{ $producto->id == $venta->producto_id ? 'selected' : '' }}>{{ $producto->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="cantidad">Cantidad</label>
                        <input type="number" name="cantidad" id="cantidad" class="form-control" value="{{ $venta->cantidad }}" required>
                    </div>
                    <div class="form-group">
                        <label for="precio">Precio</label>
                        <input type="number" step="0.01" name="precio" class="form-control" value="{{ $venta->precio }}" required>
                    </div>
                    <div class="form-group">
                        <label for="fecha_hora">Fecha y Hora</label>
                        <input type="datetime-local" name="fecha_hora" class="form-control" value="{{ $venta->fecha_hora }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
