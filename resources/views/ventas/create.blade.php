<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Venta</title>
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
            <h1 class="mb-4">Crear Nueva Venta</h1>
            <a href="{{ route('ventas.index') }}" class="btn btn-secondary mb-3">Volver a la Lista</a>
            <div class="card p-4">
                <form id="formVenta" action="{{ route('ventas.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="cliente_id" class="form-label">Cliente</label>
                        <select name="cliente_id" class="form-control" required>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="producto_id" class="form-label">Producto</label>
                        <select name="producto_id" id="producto_id" class="form-control" required>
                            <option value="" selected disabled>Seleccione un producto</option>
                            @foreach($productos as $producto)
                                <option value="{{ $producto->id }}" data-precio="{{ $producto->precio }}" data-stock="{{ $producto->stock }}">
                                    {{ $producto->nombre }} (Stock: {{ $producto->stock }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="precio_distribuidor" class="form-label">Precio Distribuidor</label>
                        <input type="number" step="0.01" id="precio_distribuidor" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="precio_unitario" class="form-label">Precio por Unidad</label>
                        <input type="number" step="0.01" name="precio_unitario" id="precio_unitario" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="cantidad" class="form-label">Cantidad</label>
                        <input type="number" name="cantidad" id="cantidad" class="form-control" required>
                        <div id="stockHelp" class="form-text"></div>
                    </div>
                    <div class="mb-3">
                        <label for="precio_total" class="form-label">Precio Total</label>
                        <input type="number" step="0.01" id="precio_total" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="fecha_hora" class="form-label">Fecha y Hora</label>
                        <input type="datetime-local" name="fecha_hora" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmación para Stock Bajo -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i>Alerta de Stock Bajo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="confirmModalBody">
                    <!-- Mensaje dinámico se insertará aquí -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="confirmContinue">Continuar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Función para actualizar información del producto
        function actualizarInfoProducto() {
            const productoSelect = document.getElementById('producto_id');
            const precioDistribuidor = document.getElementById('precio_distribuidor');
            const stockHelp = document.getElementById('stockHelp');
            
            if (productoSelect.value) {
                const precio = productoSelect.options[productoSelect.selectedIndex].getAttribute('data-precio');
                const stock = productoSelect.options[productoSelect.selectedIndex].getAttribute('data-stock');
                
                precioDistribuidor.value = precio;
                stockHelp.textContent = `Stock disponible: ${stock} unidades`;
                
                // Actualizar precio unitario por defecto
                document.getElementById('precio_unitario').value = precio;
                calcularTotal();
            }
        }

        // Calcular el precio total
        function calcularTotal() {
            const cantidad = parseFloat(document.getElementById('cantidad').value) || 0;
            const precioUnitario = parseFloat(document.getElementById('precio_unitario').value) || 0;
            document.getElementById('precio_total').value = (cantidad * precioUnitario).toFixed(2);
        }

        // Validar stock bajo antes de enviar
        document.getElementById('formVenta').addEventListener('submit', function(event) {
            const productoSelect = document.getElementById('producto_id');
            const cantidadInput = document.getElementById('cantidad');
            
            if (productoSelect.value && cantidadInput.value) {
                const stock = parseInt(productoSelect.options[productoSelect.selectedIndex].getAttribute('data-stock'));
                const cantidad = parseInt(cantidadInput.value);
                const stockRestante = stock - cantidad;

                if (stockRestante <= 3 && stockRestante >= 0) {
                    event.preventDefault();
                    
                    const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
                    const modalBody = document.getElementById('confirmModalBody');
                    const productoNombre = productoSelect.options[productoSelect.selectedIndex].text.split(' (')[0];
                    
                    let mensaje = '';
                    if (stockRestante === 0) {
                        mensaje = `¡ATENCIÓN! El producto "${productoNombre}" se AGOTARÁ COMPLETAMENTE.`;
                    } else {
                        mensaje = `Alerta: El producto "${productoNombre}" tendrá solo ${stockRestante} unidades después de esta venta.`;
                    }
                    
                    modalBody.innerHTML = `<p>${mensaje}</p><p>¿Desea continuar con la venta?</p>`;
                    
                    document.getElementById('confirmContinue').onclick = function() {
                        document.getElementById('formVenta').submit();
                    };
                    
                    modal.show();
                } else if (stockRestante < 0) {
                    event.preventDefault();
                    alert('No hay suficiente stock disponible.');
                }
            }
        });

        // Event listeners
        document.getElementById('producto_id').addEventListener('change', actualizarInfoProducto);
        document.getElementById('cantidad').addEventListener('input', calcularTotal);
        document.getElementById('precio_unitario').addEventListener('input', calcularTotal);

        // Inicializar al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            actualizarInfoProducto();
        });
    </script>
</body>
</html>