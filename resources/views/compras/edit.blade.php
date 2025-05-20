<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Compra</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .tab-container {
            background-color: #f5f5f5;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .nav-tabs .nav-link {
            font-weight: 600;
            color: #495057;
        }
        
        .nav-tabs .nav-link.active {
            background-color: white;
            border-bottom-color: white;
        }
        
        .tab-content {
            background-color: white;
            border: 1px solid #dee2e6;
            border-top: none;
            border-radius: 0 0 8px 8px;
            padding: 20px;
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
            <li class="nav-item"><a href="{{ route('compras.index') }}" class="nav-link active"><i class="fas fa-shopping-cart"></i> Compras</a></li>
        </ul>
    </div>
    
    <div class="content">
        <div class="container mt-4">
            <h1 class="mb-4">Editar Compra</h1>
            <a href="{{ route('compras.index') }}" class="btn btn-secondary mb-3">
                <i class="fas fa-arrow-left"></i> Volver a la Lista
            </a>
            
            <!-- Contenedor principal con fondo gris -->
            <div class="card tab-container">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <!-- Contenido con fondo blanco -->
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="compra-form" role="tabpanel">
                        <form id="formCompra" action="{{ route('compras.update', $compra->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="proveedor_id">
                                            <i class="fas fa-truck"></i> Proveedor:
                                        </label>
                                        <select name="proveedor_id" id="proveedor_id" class="form-control select2" required>
                                            @foreach($proveedores as $proveedor)
                                                <option value="{{ $proveedor->id }}" {{ $compra->proveedor_id == $proveedor->id ? 'selected' : '' }}>
                                                    {{ $proveedor->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="fecha_compra">
                                            <i class="fas fa-calendar-alt"></i> Fecha de Compra:
                                        </label>
                                        <input type="datetime-local" name="fecha_compra" id="fecha_compra" class="form-control" 
                                               value="{{ \Carbon\Carbon::parse($compra->fecha_compra)->format('Y-m-d\TH:i') }}" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="producto_id">
                                    <i class="fas fa-box"></i> Producto:
                                </label>
                                <select name="producto_id" id="producto_id" class="form-control select2" required>
                                    @foreach($productos as $producto)
                                        <option value="{{ $producto->id }}" 
                                                data-precio="{{ $producto->precio }}"
                                                {{ $compra->producto_id == $producto->id ? 'selected' : '' }}>
                                            {{ $producto->nombre }} 
                                            (Precio actual: ${{ $producto->precio }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="precio">
                                            <i class="fas fa-tag"></i> Precio Distribuidor:
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" step="0.01" name="precio" id="precio" 
                                                   class="form-control" value="{{ $compra->precio }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="cantidad">
                                            <i class="fas fa-sort-numeric-up"></i> Cantidad:
                                        </label>
                                        <input type="number" name="cantidad" id="cantidad" class="form-control" 
                                               value="{{ $compra->cantidad }}" required>
                                        <input type="hidden" id="cantidad_original" value="{{ $compra->cantidad }}">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="precio_total">
                                    <i class="fas fa-money-bill-wave"></i> Precio Total:
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" step="0.01" id="precio_total" class="form-control" 
                                           value="{{ $compra->precio * $compra->cantidad }}" readonly>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Actualizar Compra
                                </button>
                                <a href="{{ route('compras.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times"></i> Cancelar
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Inicializar Select2
            $('.select2').select2({
                width: '100%'
            });
            
            // Actualizar el precio cuando cambia el producto
            $('#producto_id').on('change', function() {
                const productoSeleccionado = $(this).find(':selected');
                const precioProducto = productoSeleccionado.data('precio');
                
                if (productoSeleccionado.val()) {
                    // Sugerimos el precio actual pero no lo establecemos automáticamente
                    if ({{ $compra->producto_id }} != productoSeleccionado.val()) {
                        $('#precio').val(precioProducto);
                    }
                }
                
                calcularTotal();
            });
            
            // Calcular el precio total cuando cambia la cantidad o el precio
            $('#cantidad, #precio').on('input', function() {
                calcularTotal();
            });
            
            function calcularTotal() {
                const cantidad = parseFloat($('#cantidad').val()) || 0;
                const precio = parseFloat($('#precio').val()) || 0;
                
                const precioTotal = cantidad * precio;
                $('#precio_total').val(precioTotal.toFixed(2));
            }
            
            // Validar antes de enviar el formulario
            $('#formCompra').on('submit', function(event) {
                const cantidad = parseInt($('#cantidad').val()) || 0;
                const precio = parseFloat($('#precio').val()) || 0;
                
                if (cantidad <= 0) {
                    event.preventDefault();
                    alert("La cantidad debe ser mayor a 0.");
                }
                
                if (precio <= 0) {
                    event.preventDefault();
                    alert("El precio debe ser mayor a 0.");
                }
            });
        });
    </script>
</body>
</html>