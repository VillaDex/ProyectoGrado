<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ClienteController,
    ProveedorController,
    CompraController,
    VentaController,
    AuthController,
    ForgotPasswordController,
    WelcomeController,
    RoleController,
    UserController,
    PasswordResetController,
    PerfilController,
    ProductoController,
    ReporteController
};

// RUTAS PÚBLICAS
Route::get('/', fn() => view('auth.login'))->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
Route::get('/register', fn() => view('auth.register'))->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.attempt');

Route::get('/terminos-y-condiciones', fn() => view('auth.tyc'))->name('tyc');

// Recuperación de contraseña
Route::get('/password/verify', [PasswordResetController::class, 'showVerifyForm'])->name('password.verify.form');
Route::post('/password/verify', [PasswordResetController::class, 'verify'])->name('password.verify');
Route::post('/password/reset', [PasswordResetController::class, 'reset'])->name('password.update');

// RUTAS PARA USUARIOS AUTENTICADOS
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/welcome', [WelcomeController::class, 'index'])->name('welcome');

    // Perfil
    Route::get('/perfil', [PerfilController::class, 'index'])->name('perfil');
    Route::post('/perfil/actualizar', [PerfilController::class, 'actualizar'])->name('perfil.actualizar');
    Route::post('/perfil/actualizar-nombre', [PerfilController::class, 'actualizarNombre'])->name('perfil.actualizar.nombre');
    Route::post('/perfil/eliminar-foto', [PerfilController::class, 'eliminarFoto'])->name('perfil.eliminarFoto');

    // Productos (acceso lectura para todos)
    Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');
    Route::get('/productos/{producto}', [ProductoController::class, 'show'])->name('productos.show');
});

// RUTAS DE REPORTES (Autenticado y con rol específico)
Route::middleware(['auth', 'role:superadmin|funcionario-compra|funcionario-venta'])->prefix('reportes')->group(function () {
    Route::get('/', [ReporteController::class, 'index'])->name('reportes.index');
    Route::get('ventas/previa', [ReporteController::class, 'mostrarPreviaVentas'])->name('reportes.ventas.previa');
    Route::get('ventas/descargar', [ReporteController::class, 'descargarVentas'])->name('reportes.ventas.descargar');
    Route::get('compras/previa', [ReporteController::class, 'mostrarPreviaCompras'])->name('reportes.compras.previa');
    Route::get('compras/descargar', [ReporteController::class, 'descargarCompras'])->name('reportes.compras.descargar');
});

// RUTAS PARA SUPERADMIN
Route::middleware(['auth', 'role:superadmin'])->group(function () {
    Route::resources([
        'clientes' => ClienteController::class,
        'proveedores' => ProveedorController::class,
        'compras' => CompraController::class,
        'ventas' => VentaController::class,
        'users' => UserController::class,
    ]);

    // CRUD completo de productos (excepto index/show ya definidos arriba)
    Route::resource('productos', ProductoController::class)->except(['index', 'show']);

    // Roles
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::post('/assign-role/{user}', [RoleController::class, 'assignRole'])->name('assign.role');
});

// RUTAS PARA FUNCIONARIO-COMPRA
Route::middleware(['auth', 'role:funcionario-compra'])->group(function () {
    Route::resource('compras', CompraController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::resource('proveedores', ProveedorController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

    // Permisos extendidos para productos
    Route::get('/productos/create', [ProductoController::class, 'create'])->name('productos.create');
    Route::post('/productos', [ProductoController::class, 'store'])->name('productos.store');
    Route::get('/productos/{producto}/edit', [ProductoController::class, 'edit'])->name('productos.edit');
    Route::put('/productos/{producto}', [ProductoController::class, 'update'])->name('productos.update');
});

// RUTAS PARA FUNCIONARIO-VENTA
Route::middleware(['auth', 'role:funcionario-venta'])->group(function () {
    Route::resource('ventas', VentaController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::resource('clientes', ClienteController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
});

// FUNCIONARIO-NORMAL ya tiene acceso a productos (index/show)

