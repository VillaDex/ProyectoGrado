<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Compra</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/css/welcome.css?<?= filemtime(public_path('css/welcome.css')) ?>" />
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
            <h1 class="mb-4">Crear Compra</h1>
            <a href="{{ route('compras.index') }}" class="btn btn-secondary mb-3">Volver a la Lista</a>
            
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
                
                <!-- Pestañas para separar los flujos -->
                <ul class="nav nav-tabs mb-0" id="compraTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="producto-existente-tab" data-bs-toggle="tab" data-bs-target="#producto-existente" type="button" role="tab" aria-controls="producto-existente" aria-selected="true">
                            <i class="fas fa-check-circle"></i> Producto Existente
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="producto-nuevo-tab" data-bs-toggle="tab" data-bs-target="#producto-nuevo" type="button" role="tab" aria-controls="producto-nuevo" aria-selected="false">
                            <i class="fas fa-plus-circle"></i> Producto Nuevo
                        </button>
                    </li>
                </ul>
                
                <!-- Contenido de las pestañas con fondo blanco -->
                <div class="tab-content" id="compraTabContent">
                    <!-- Pestaña de producto existente -->
                    <div class="tab-pane fade show active" id="producto-existente" role="tabpanel" aria-labelledby="producto-existente-tab">
                        <form action="{{ route('compras.store') }}" method="POST" id="form-producto-existente">
                            @csrf
                            <input type="hidden" name="tipo_compra" value="existente">
                            
                            <div class="form-group mb-3">
                                <label for="proveedor_id_existente"><i class="fas fa-truck"></i> Proveedor:</label>
                                <select name="proveedor_id" class="form-control" required>
                                    @foreach($proveedores as $proveedor)
                                        <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="producto_id"><i class="fas fa-box"></i> Seleccione el producto:</label>
                                <select id="select_producto" name="producto_id" class="form-control select2" required>
                                    <option value="" selected disabled>Busque un producto</option>
                                    @foreach($productos as $producto)
                                        <option value="{{ $producto->id }}" data-precio="{{ $producto->precio }}">
                                            {{ $producto->nombre }} - ${{ $producto->precio }} (Stock: {{ $producto->stock }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="precio_producto_existente"><i class="fas fa-tag"></i> Precio Distribuidor:</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" step="0.01" name="precio_producto" id="precio_producto_existente" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="cantidad_existente"><i class="fas fa-sort-numeric-up"></i> Cantidad:</label>
                                        <input type="number" name="cantidad" id="cantidad_existente" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="precio_total_existente"><i class="fas fa-money-bill-wave"></i> Precio Total:</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" step="0.01" name="precio_total" id="precio_total_existente" class="form-control" readonly required>
                                </div>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="fecha_compra_existente"><i class="fas fa-calendar-alt"></i> Fecha de Compra:</label>
                                <input type="datetime-local" name="fecha_compra" id="fecha_compra_existente" class="form-control" required>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Guardar Compra
                            </button>
                        </form>
                    </div>
                    
                    <!-- Pestaña de producto nuevo -->
                    <div class="tab-pane fade" id="producto-nuevo" role="tabpanel" aria-labelledby="producto-nuevo-tab">
                        <form action="{{ route('compras.store') }}" method="POST" id="form-producto-nuevo">
                            @csrf
                            <input type="hidden" name="tipo_compra" value="nuevo">
                            <input type="hidden" name="producto_id" value="">
                            
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> Está creando un producto nuevo que se añadirá al inventario.
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="proveedor_id_nuevo"><i class="fas fa-truck"></i> Proveedor:</label>
                                <select name="proveedor_id" class="form-control" required>
                                    @foreach($proveedores as $proveedor)
                                        <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="nombre_producto"><i class="fas fa-file-signature"></i> Nombre del Producto:</label>
                                <input type="text" name="nombre_producto" id="nombre_producto" class="form-control" required placeholder="Ingrese el nombre del nuevo producto">
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="precio_producto_nuevo"><i class="fas fa-tag"></i> Precio Distribuidor:</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" step="0.01" name="precio_producto" id="precio_producto_nuevo" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="cantidad_nuevo"><i class="fas fa-sort-numeric-up"></i> Cantidad:</label>
                                        <input type="number" name="cantidad" id="cantidad_nuevo" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="precio_total_nuevo"><i class="fas fa-money-bill-wave"></i> Precio Total:</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" step="0.01" name="precio_total" id="precio_total_nuevo" class="form-control" readonly required>
                                </div>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="fecha_compra_nuevo"><i class="fas fa-calendar-alt"></i> Fecha de Compra:</label>
                                <input type="datetime-local" name="fecha_compra" id="fecha_compra_nuevo" class="form-control" required>
                            </div>
                            
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-plus-circle"></i> Crear Producto y Registrar Compra
                            </button>
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
                placeholder: "Busque un producto",
                allowClear: true,
                width: '100%',
                dropdownParent: $('#producto-existente')
            });

            // Producto existente
            $('#select_producto').on('change', function() {
                const productoSeleccionado = $(this).find(':selected');
                const precioProducto = productoSeleccionado.data('precio');

                if (productoSeleccionado.val()) {
                    $('#precio_producto_existente').val(precioProducto);
                } else {
                    $('#precio_producto_existente').val('');
                }

                calcularPrecioTotal('existente');
            });

            // Función para calcular el precio total
            function calcularPrecioTotal(tipo) {
                const precioProducto = parseFloat($('#precio_producto_' + tipo).val()) || 0;
                const cantidad = parseFloat($('#cantidad_' + tipo).val()) || 0;
                const precioTotal = precioProducto * cantidad;

                $('#precio_total_' + tipo).val(precioTotal.toFixed(2));
            }

            // Escuchar cambios en los campos
            $('#precio_producto_existente, #cantidad_existente').on('input', function() {
                calcularPrecioTotal('existente');
            });

            $('#precio_producto_nuevo, #cantidad_nuevo').on('input', function() {
                calcularPrecioTotal('nuevo');
            });

            // CORRECCIÓN PARA LA HORA DE COLOMBIA
            const ahora = new Date();
            // Ajustar para la zona horaria de Colombia (UTC-5)
            const offsetColombia = 5 * 60 * 60000; // 5 horas en milisegundos
            const fechaColombia = new Date(ahora.getTime() - offsetColombia);
            const fechaHora = fechaColombia.toISOString().slice(0, 16);
            
            $('#fecha_compra_existente, #fecha_compra_nuevo').val(fechaHora);
        });
    </script>
</body>
</html>