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

// Rutas públicas
Route::get('/', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [AuthController::class, 'register'])->name('register.attempt');

// Password reset
Route::get('/password/verify', [PasswordResetController::class, 'showVerifyForm'])->name('password.verify.form');
Route::post('/password/verify', [PasswordResetController::class, 'verify'])->name('password.verify');
Route::post('/password/reset', [PasswordResetController::class, 'reset'])->name('password.update');

// Terminos y condiciones
Route::get('/terminos-y-condiciones', function () {
    return view('auth.tyc');
});


// RUTAS AUTENTICADAS (para todos los usuarios)

Route::middleware(['auth'])->group(function () {
    // Cerrar sesión
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Dashboard
    Route::get('/welcome', [WelcomeController::class, 'index'])->name('welcome');
    
    // Perfil de usuario
    Route::get('/perfil', [PerfilController::class, 'index'])->name('perfil');
    Route::post('/perfil/actualizar', [PerfilController::class, 'actualizar'])->name('perfil.actualizar');
    Route::post('/perfil/actualizar-nombre', [PerfilController::class, 'actualizarNombre'])->name('perfil.actualizar.nombre');
    Route::post('/perfil/eliminar-foto', [PerfilController::class, 'eliminarFoto'])->name('perfil.eliminarFoto');
    
    // Productos (acceso básico para todos los usuarios autenticados)
    Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');
    Route::get('/productos/{producto}', [ProductoController::class, 'show'])->name('productos.show');
});


// RUTAS PARA REPORTES (roles específicos)

Route::middleware(['auth', 'role:superadmin|funcionario-compra|funcionario-venta'])->group(function () {
    Route::prefix('reportes')->group(function() {
        Route::get('/', [ReporteController::class, 'index'])->name('reportes.index');
        
        // Ventas
        Route::get('ventas/previa', [ReporteController::class, 'mostrarPreviaVentas'])->name('reportes.ventas.previa');
        Route::get('ventas/descargar', [ReporteController::class, 'descargarVentas'])->name('reportes.ventas.descargar');
        
        // Compras
        Route::get('compras/previa', [ReporteController::class, 'mostrarPreviaCompras'])->name('reportes.compras.previa');
        Route::get('compras/descargar', [ReporteController::class, 'descargarCompras'])->name('reportes.compras.descargar');
    });
});


// RUTAS PARA SUPERADMIN

Route::middleware(['auth', 'role:superadmin'])->group(function () {
    // Acceso completo a todos los recursos
    Route::resources([
        'clientes' => ClienteController::class,
        'proveedores' => ProveedorController::class,
        'compras' => CompraController::class,
        'ventas' => VentaController::class,
        'users' => UserController::class
    ]);
    
    // Productos (CRUD completo)
    Route::resource('productos', ProductoController::class)->except(['index', 'show']);
    
    // Gestión de roles
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::post('/assign-role/{user}', [RoleController::class, 'assignRole'])->name('assign.role');
});


// RUTAS PARA FUNCIONARIO-COMPRA

Route::middleware(['auth', 'role:funcionario-compra'])->group(function () {
    // Acceso completo a compras
    Route::resource('compras', CompraController::class);
    
    // Acceso completo a proveedores
    Route::resource('proveedores', ProveedorController::class);
    
    // Permisos adicionales para productos
    Route::get('/productos/create', [ProductoController::class, 'create'])->name('productos.create');
    Route::post('/productos', [ProductoController::class, 'store'])->name('productos.store');
    Route::get('/productos/{producto}/edit', [ProductoController::class, 'edit'])->name('productos.edit');
    Route::put('/productos/{producto}', [ProductoController::class, 'update'])->name('productos.update');
});


// RUTAS PARA FUNCIONARIO-VENTA

Route::middleware(['auth', 'role:funcionario-venta'])->group(function () {
    // Acceso completo a ventas
    Route::resource('ventas', VentaController::class);
    
    // Acceso completo a clientes
    Route::resource('clientes', ClienteController::class);
});


// RUTAS PARA FUNCIONARIO-NORMAL

Route::middleware(['auth', 'role:funcionario-normal'])->group(function () {
    // Solo acceso de lectura a productos (ya está cubierto por las rutas generales)
});