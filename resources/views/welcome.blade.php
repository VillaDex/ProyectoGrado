<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Inventario</title>
    
    <!-- Bootstrap primero -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Luego Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Después tu CSS con versión para cache -->
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}?v=<?= time() ?>">
    <style>
        :root {
            --primary-color: #4f46e5;
            --secondary-color: #7c3aed;
            --accent-color: #ec4899;
            --text-color: #1f2937;
            --bg-color: #f3f4f6;
            --card-bg: #ffffff;
        }

        /* Estilos para ambos recuadros */
        .dashboard-card {
            background: var(--card-bg);
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
            height: 100%;
        }

        .dashboard-card h3 {
            font-size: 24px;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid;
        }

        .dashboard-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding: 15px;
            border-radius: 8px;
            background: #f9fafb;
            transition: all 0.3s ease;
        }

        .dashboard-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .dashboard-item img {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            object-fit: cover;
            margin-right: 15px;
            border: 2px solid #e5e7eb;
        }

        .dashboard-item .info {
            flex: 1;
        }

        .dashboard-item .info h4 {
            font-size: 18px;
            margin-bottom: 5px;
            color: var(--text-color);
        }

        .dashboard-item .info p {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 0;
        }

        /* Estilos específicos para bajo stock */
        .low-stock-card h3 {
            color: #ff6384;
            border-color: #ff6384;
        }

        .low-stock-card .stock {
            color: #ff6384;
            font-weight: 600;
        }

        /* Estilos específicos para más vendidos */
        .top-sellers-card h3 {
            color: #4caf50;
            border-color: #4caf50;
        }

        .top-sellers-card .sales {
            color: #4caf50;
            font-weight: 600;
        }
        .product-image {
    width: 100px; /* Adjust the width as needed */
    height: auto;  /* Maintain the aspect ratio */
    object-fit: contain; /* Ensure the image fits within the specified dimensions */
}
.recommendations-section {
    border: 1px solid #ddd; /* Add a border */
    padding: 20px; /* Add padding inside the box */
    margin-bottom: 20px; /* Add space between sections */
    border-radius: 8px; /* Rounded corners */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
}

.recommendations-section h2 {
    margin-top: 0; /* Remove top margin for the heading */
}

.product-list {
    display: flex;
    flex-wrap: wrap;
    gap: 10px; /* Space between product items */
}

.product-item {
    border: 1px solid #eee;
    padding: 10px;
    border-radius: 5px;
    text-align: center;
    width: calc(33.333% - 20px); /* Adjust width for responsiveness */
    box-sizing: border-box;
}

.product-image {
    max-width: 100%; /* Ensure image fits within the box */
    height: auto;
    border-radius: 5px;
}

    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-brand">
            <i class="fas fa-box-open"></i>
            <span>Sistema Inventario</span>
        </div>
        <div class="ms-auto d-flex align-items-center">
            <div class="theme-toggle me-3">
                <label class="theme-switch">
                    <input type="checkbox" id="darkModeToggle">
                    <span class="slider"></span>
                </label>
            </div>
            <div class="user-menu">
                <button class="user-button" data-bs-toggle="dropdown" id="userButton">
                    <img id="userProfilePic" 
     src="{{ auth()->user()->foto ? asset('storage/' . auth()->user()->foto) : 'https://cdn-icons-png.flaticon.com/512/6326/6326055.png' }}" 
     class="rounded-circle" width="40" height="40" alt="Foto de usuario">

                    
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('perfil') }}"><i class="fas fa-user me-2"></i>Mi Perfil</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="dropdown-item" type="submit">
                                <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="sidebar">
        <div class="sidebar-header">
            <i class="fas fa-box-open fa-2x"></i>
            <h3>Inventario</h3>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="#" class="nav-link active">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            @if(auth()->user()->hasRole('funcionario-venta') || auth()->user()->hasRole('superadmin'))
                <li class="nav-item">
                    <a href="{{ route('clientes.index') }}" class="nav-link">
                        <i class="fas fa-users"></i>
                        <span>Clientes</span>
                    </a>
                </li>
            @endif
            @if(auth()->user()->hasRole('funcionario-compra') || auth()->user()->hasRole('superadmin'))
                <li class="nav-item">
                    <a href="{{ route('proveedores.index') }}" class="nav-link">
                        <i class="fas fa-truck"></i>
                        <span>Proveedores</span>
                    </a>
                </li>
            @endif
            
            <li class="nav-item">
                <a href="{{ route('productos.index') }}" class="nav-link">
                    <i class="fas fa-box"></i>
                    <span>Productos</span>
                </a>
            </li>
            @if(auth()->user()->hasRole('funcionario-compra') || auth()->user()->hasRole('superadmin'))
                <li class="nav-item">
                    <a href="{{ route('compras.index') }}" class="nav-link">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Compras</span>
                    </a>
                </li>
            @endif
            @if(auth()->user()->hasRole('funcionario-venta') || auth()->user()->hasRole('superadmin'))
                <li class="nav-item">
                    <a href="{{ route('ventas.index') }}" class="nav-link">
                        <i class="fas fa-cash-register"></i>
                        <span>Ventas</span>
                    </a>
                </li>
            @endif
            @if(auth()->user()->hasRole('superadmin'))
                <li class="nav-item">
                    <a href="{{ route('roles.index') }}" class="nav-link">
                        <i class="fas fa-user-shield"></i>
                        <span>Gestionar Roles</span>
                    </a>
                </li>
            @endif
            @if(auth()->user()->hasRole('superadmin') || auth()->user()->hasRole('funcionario-compra') || auth()->user()->hasRole('funcionario-venta'))
            <li class="nav-item">
                <a href="{{ route('reportes.index') }}" class="nav-link">
                    <i class="fas fa-chart-bar"></i>
                    <span>Reportes</span>
                </a>
            </li>
            @endif
        </ul>
    </div>

    <div class="content">
        <div class="welcome-section fade-in">
            <h2>¡Bienvenido!</h2>
            <p>Este es tu centro de control de inventario. Gestiona tus productos, clientes, proveedores y más desde un solo lugar.</p>
        </div>
        
        <div class="stats-row">
            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="stats-card slide-up" style="animation-delay: 0.1s">
                        <div class="stats-icon" style="background: rgba(67, 97, 238, 0.1); color: var(--primary-color);">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="stats-info">
                            <h3 class="counter">{{ number_format($totalProductos) }}</h3>
                            <p>Productos en Stock</p>
                            <div class="trend-indicator trend-up"></div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 mb-4">
                    <div class="stats-card slide-up" style="animation-delay: 0.2s">
                        <div class="stats-icon" style="background: rgba(76, 201, 240, 0.1); color: var(--accent-color);">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="stats-info">
                            <h3 class="counter">{{ number_format($totalVentas) }}</h3>
                            <p>Cantidad de Ventas</p>
                            <div class="trend-indicator trend-up"></div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 mb-4">
                    <div class="stats-card slide-up" style="animation-delay: 0.3s">
                        <div class="stats-icon" style="background: rgba(46, 196, 182, 0.1); color: #2ec4b6;">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stats-info">
                            <h3 class="counter">{{ number_format($totalClientes) }}</h3>
                            <p>Clientes</p>
                            <div class="trend-indicator trend-up"></div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 mb-4">
                    <div class="stats-card slide-up" style="animation-delay: 0.4s">
                        <div class="stats-icon" style="background: rgba(255, 99, 132, 0.1); color: #ff6384;">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="stats-info">
                            <h3 class="counter">{{ number_format($totalProductosAgotados) }}</h3>
                            <p>Productos Agotados</p>
                            <div class="trend-indicator trend-down"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<!-- Sección de recomendaciones -->
<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="dashboard-card low-stock-card">
            <h3><i class="fas fa-exclamation-circle me-2"></i>Productos con Bajo Stock</h3>
            <div class="product-list">
                @foreach($productosBajoStock as $product)
                    <div class="product-item">
                        <img src="{{ $product->imagen }}" class="product-image" alt="Imagen de {{ $product->nombre }}">
                        <p>{{ $product->nombre }}</p>
                        <p class="stock">Stock actual: {{ $product->stock }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="dashboard-card top-sellers-card">
            <h3><i class="fas fa-trophy me-2"></i>Productos Más Vendidos</h3>
            <div class="product-list">
                @foreach($productosMasVendidos as $product)
                    <div class="product-item">
                        <img src="{{ $product->imagen }}" class="product-image" alt="Imagen de {{ $product->nombre }}">
                        <p>{{ $product->nombre }}</p>
                        <p class="sales">Ventas: {{ $product->ventas_count }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/countup.js/2.0.8/countUp.min.js"></script>
    <script>
        // Inicializar contadores
        document.addEventListener('DOMContentLoaded', () => {
            const counters = document.querySelectorAll('.counter');
            counters.forEach(counter => {
                const value = parseInt(counter.textContent.replace(/,/g, ''));
                const countUp = new CountUp(counter, 0, value, 0, 2.5, {
                    useEasing: true,
                    useGrouping: true,
                    separator: ',',
                    decimal: '.'
                });
                countUp.start();
            });
        });

        // Tema oscuro
        document.getElementById('darkModeToggle').addEventListener('change', function() {
            document.body.classList.toggle('dark-mode');
        });
    </script>
</body>
</html>