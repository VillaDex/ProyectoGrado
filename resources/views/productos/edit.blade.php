<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Imagen de Producto</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4f46e5;
            --bg-color: #f3f4f6;
            --card-bg: #ffffff;
        }

        body {
            background-color: var(--bg-color);
            font-family: 'Arial', sans-serif;
        }

        .navbar, .sidebar {
            background-color: var(--card-bg);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .navbar-brand, .sidebar-header {
            color: var(--primary-color);
            font-weight: bold;
        }

        .sidebar {
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            padding-top: 20px;
            z-index: 1000;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
        }

        .stats-card {
            background: var(--card-bg);
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 600px;
            margin: 50px auto;
            transition: all 0.3s ease;
        }

        .product-image-container {
            position: relative;
            width: 200px;
            height: 200px;
            margin: 0 auto 20px;
        }

        .product-image {
            width: 200px;
            height: 200px;
            border-radius: 10px;
            object-fit: cover;
            border: 3px solid var(--primary-color);
        }

        .product-image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 10px;
            background: rgba(79, 70, 229, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            cursor: pointer;
        }

        .product-image-container:hover .product-image-overlay {
            opacity: 1;
        }

        .nav-link.active {
            background-color: rgba(79, 70, 229, 0.1);
            color: var(--primary-color);
        }

        @media (max-width: 768px) {
            .content { margin-left: 0; }
            .sidebar { position: static; width: 100%; height: auto; }
        }
    </style>
</head>
<body>
    <nav class="navbar p-3">
        <div class="navbar-brand">
            <i class="fas fa-box-open me-2"></i>
            <span>Sistema Inventario</span>
        </div>
    </nav>

    <div class="sidebar">
        <div class="sidebar-header d-flex align-items-center justify-content-center mb-4">
            <i class="fas fa-box-open fa-2x me-2"></i>
            <h3>Inventario</h3>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('welcome') }}" class="nav-link">
                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('productos.index') }}" class="nav-link active">
                    <i class="fas fa-box me-2"></i>Productos
                </a>
            </li>
        </ul>
    </div>

    <div class="content">
        <div class="stats-card">
            <h4 class="text-center mb-4"><i class="fas fa-image me-2"></i>Editar Imagen de Producto</h4>
            
            <form action="{{ route('productos.update', $producto->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="product-image-container text-center mb-4">
                    <img id="imagenPreview" 
                         src="{{ $producto->imagen ?: 'https://img.freepik.com/vector-premium/vector-icono-imagen-predeterminado-pagina-imagen-faltante-diseno-sitio-web-o-aplicacion-movil-no-hay-foto-disponible_87543-11093.jpg' }}" 
                         alt="Vista Previa del Producto" 
                         class="product-image">
                    <div class="product-image-overlay" id="changeImageOverlay">
                        <i class="fas fa-camera text-white fs-3"></i>
                    </div>
                </div>

                <!-- Campos de solo lectura -->
                <div class="mb-3">
                    <label class="form-label">Nombre del Producto</label>
                    <input type="text" class="form-control" value="{{ $producto->nombre }}" readonly>
                    <input type="hidden" name="nombre" value="{{ $producto->nombre }}">
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Precio</label>
                        <input type="text" class="form-control" value="{{ $producto->precio }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Stock</label>
                        <input type="text" class="form-control" value="{{ $producto->stock }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Estado</label>
                        <input type="text" class="form-control" value="{{ $producto->estado }}" readonly>
                    </div>
                </div>

                <!-- Campo editable de la imagen -->
                <div class="mb-3">
                    <label for="imagen" class="form-label">URL de la Imagen</label>
                    <input type="url" class="form-control" id="imagen" name="imagen" value="{{ $producto->imagen }}">
                </div>

                <div class="d-flex justify-content-center gap-3 mb-3">
                    <button type="button" class="btn btn-danger" id="eliminarImagen">
                        <i class="fas fa-trash-alt me-2"></i>Eliminar Imagen
                    </button>
                </div>

                <div class="d-flex justify-content-center gap-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Guardar Cambios
                    </button>
                    <a href="{{ route('productos.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Volver
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.getElementById('imagen').addEventListener('input', function() {
            document.getElementById('imagenPreview').src = this.value || 'https://img.freepik.com/vector-premium/vector-icono-imagen-predeterminado-pagina-imagen-faltante-diseno-sitio-web-o-aplicacion-movil-no-hay-foto-disponible_87543-11093.jpg';
        });

        document.getElementById('eliminarImagen').addEventListener('click', function() {
            document.getElementById('imagen').value = '';
            document.getElementById('imagenPreview').src = 'https://img.freepik.com/vector-premium/vector-icono-imagen-predeterminado-pagina-imagen-faltante-diseno-sitio-web-o-aplicacion-movil-no-hay-foto-disponible_87543-11093.jpg';
        });
        
        document.getElementById('changeImageOverlay').addEventListener('click', function() {
            document.getElementById('imagen').focus();
        });
    </script>
</body>
</html>