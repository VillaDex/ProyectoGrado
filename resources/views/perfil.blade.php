<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        :root {
            --primary-color: #4f46e5;
            --secondary-color: #7c3aed;
            --accent-color: #ec4899;
            --text-color: #1f2937;
            --bg-color: #f3f4f6;
            --card-bg: #ffffff;
        }

        body {
            background-color: var(--bg-color);
            font-family: 'Arial', sans-serif;
        }

        .navbar {
            background-color: var(--card-bg);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 15px 20px;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            color: var(--primary-color);
            font-weight: bold;
        }

        .navbar-brand i {
            margin-right: 10px;
        }

        .sidebar {
            background-color: var(--card-bg);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            padding-top: 20px;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
            z-index: 1000;
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
            color: var(--primary-color);
        }

        .sidebar-header i {
            margin-right: 10px;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
        }

        .profile-container {
            max-width: 600px;
            margin: 50px auto;
        }

        .stats-card {
            background: var(--card-bg);
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
        }

        .profile-pic-container {
            position: relative;
            width: 200px;
            height: 200px;
            margin: 0 auto 20px;
        }

        .profile-pic {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid var(--primary-color);
            transition: all 0.3s ease;
        }

        .profile-pic-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: rgba(79, 70, 229, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            cursor: pointer;
        }

        .profile-pic-container:hover .profile-pic-overlay {
            opacity: 1;
        }

        .profile-pic-overlay i {
            color: white;
            font-size: 36px;
        }

        .nav {
            flex-direction: column;
        }

        .nav-link {
            color: var(--text-color);
            padding: 10px 20px;
            transition: all 0.3s ease;
        }

        .nav-link:hover, .nav-link.active {
            background-color: rgba(79, 70, 229, 0.1);
            color: var(--primary-color);
        }

        .nav-link i {
            margin-right: 10px;
        }

        @media (max-width: 768px) {
            .content {
                margin-left: 0;
            }
            
            .sidebar {
                width: 100%;
                height: auto;
                position: static;
            }
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
            <li class="nav-item">
                <a href="{{ route('welcome') }}" class="nav-link">
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
        </ul>
    </div>

    <div class="content">
        <div class="profile-container">
            <div class="stats-card animate_animated animate_fadeIn">
                <form id="formPerfil" method="POST" action="{{ route('perfil.actualizar.nombre') }}">
                    @csrf
                    <div class="profile-pic-container text-center mb-4">
                        <label for="foto" class="position-relative d-inline-block">
                            <img id="preview" 
                                 src="{{ $user->foto ? asset('storage/' . $user->foto) : 'https://cdn-icons-png.flaticon.com/512/6326/6326055.png' }}" 
                                 alt="Foto de perfil" 
                                 class="profile-pic">
                            <div class="profile-pic-overlay">
                                <i class="fas fa-camera"></i>
                            </div>
                        </label>
                        <input type="file" id="foto" name="foto" 
                               accept="image/*" 
                               class="d-none" 
                               onchange="subirImagen(event)">
                        
                        <!-- Botón de eliminar foto, ahora mejor posicionado y estilizado -->
                        @if ($user->foto)
                            <div class="mt-3">
                                <button id="eliminarFotoBtn" class="btn btn-outline-danger btn-sm" onclick="eliminarFoto()">
                                    <i class="fas fa-trash-alt"></i> Eliminar Foto
                                </button>
                            </div>
                        @endif
                    </div>
                    
                    

                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control text-center" 
                               id="nombre" 
                               name="nombre" 
                               value="{{ $user->name }}" 
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control text-center" 
                               value="{{ $user->email }}" 
                               readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Rol</label>
                        <input type="text" class="form-control text-center" 
                               value="{{ $user->roles->first()->name ?? 'Sin rol' }}" 
                               readonly>
                    </div>

                    <div class="d-flex justify-content-center gap-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Actualizar Nombre
                        </button>
                        <a href="{{ route('welcome') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Volver al Inicio
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    function subirImagen(event) {
        const formData = new FormData();
        formData.append('foto', event.target.files[0]);

        fetch("{{ route('perfil.actualizar') }}", {
            method: "POST",
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('preview').src = data.foto;
                window.parent.document.getElementById('userProfilePic').src = data.foto;
            }
        })
        .catch(error => console.error("Error:", error));
    }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function subirImagen(event) {
            const formData = new FormData();
            formData.append('foto', event.target.files[0]);
        
            fetch("{{ route('perfil.actualizar') }}", {
                method: "POST",
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('preview').src = data.foto;
                    document.getElementById('userProfilePic').src = data.foto;
                    location.reload(); // Recargar para actualizar el botón de eliminar
                }
            })
            .catch(error => console.error("Error:", error));
        }
        
        function eliminarFoto() {
    fetch("{{ route('perfil.eliminarFoto') }}", {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('preview').src = data.foto;
            document.getElementById('userProfilePic').src = data.foto;
            location.reload(); // Recargar para quitar el botón de eliminar
        }
    })
    .catch(error => console.error("Error:", error));
}

        </script>
        
</body>
</html>