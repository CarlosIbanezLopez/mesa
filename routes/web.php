<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

require(base_path('routes/route-list/route-auth.php'));

// Rutas de autenticación (mantén las que ya tienes)
Auth::routes();

// Ruta principal
Route::get('/', function () {
    return redirect()->route('home');
});

// Home
Route::get('/home', [HomeController::class, 'index'])
    ->name('home')
    ->middleware('auth');

// Inventario (con Inertia)
Route::middleware(['auth', 'check.role:1'])->group(function () {
    Route::get('/inventario', [App\Http\Controllers\InventarioController::class, 'index'])
        ->name('inventario_home');

    Route::get('/inventario/create', function () {
        return Inertia::render('Inventario/Create');
    })->name('inventario_create');

    Route::get('/inventario/{id}', [App\Http\Controllers\InventarioController::class, 'edit'])
        ->name('inventario_edit');

    Route::post('/inventario', [App\Http\Controllers\InventarioController::class, 'store'])
        ->name('inventario_store');

    Route::put('/inventario/{id}', [App\Http\Controllers\InventarioController::class, 'update'])
        ->name('inventario_update');

    Route::delete('/inventario/{id}', [App\Http\Controllers\InventarioController::class, 'destroy'])
        ->name('inventario_delete');
});

// Promociones (con Inertia)
Route::middleware(['auth', 'check.role:1'])->group(function () {
    Route::get('/promociones', [App\Http\Controllers\PromocionController::class, 'index'])
        ->name('promocion_home');
    Route::get('/promociones/create', [App\Http\Controllers\PromocionController::class, 'create'])
        ->name('promocion_create');
    Route::post('/promociones_create', [App\Http\Controllers\PromocionController::class, 'store'])
        ->name('promocion_store');
    Route::get('/promociones/{id}', [App\Http\Controllers\PromocionController::class, 'edit'])
        ->name('promocion_edit');
    Route::put('/promociones_update/{id}', [App\Http\Controllers\PromocionController::class, 'update'])
        ->name('promocion_update');
    Route::delete('/promociones_delete/{id}', [App\Http\Controllers\PromocionController::class, 'destroy'])
        ->name('promocion_delete');
});

// Productos (con Inertia)
Route::middleware(['auth', 'check.role:1'])->group(function () {
    Route::get('/producto', [App\Http\Controllers\ProductoController::class, 'index'])
        ->name('producto_home');
    Route::get('/producto/create', [App\Http\Controllers\ProductoController::class, 'create'])
        ->name('producto_create');
    Route::post('/producto', [App\Http\Controllers\ProductoController::class, 'store'])
        ->name('producto_store');
    Route::get('/producto/{id}', [App\Http\Controllers\ProductoController::class, 'edit'])
        ->name('producto_edit');
    Route::put('/producto/{id}', [App\Http\Controllers\ProductoController::class, 'update'])
        ->name('producto_update');
    Route::delete('/producto/{id}', [App\Http\Controllers\ProductoController::class, 'destroy'])
        ->name('producto_delete');
});

// Tienda
Route::middleware(['auth'])->group(function () {
    Route::get('/tienda', [App\Http\Controllers\TiendaController::class, 'index'])
        ->name('tienda_home');
    Route::post('/tienda/comprar', [App\Http\Controllers\TiendaController::class, 'store'])
        ->name('tienda_store');
    Route::get('/tienda/checkout/{ventaId}', [App\Http\Controllers\TiendaController::class, 'checkout'])
        ->name('checkout');
    Route::get('/tienda/mis-compras', [App\Http\Controllers\TiendaController::class, 'misCompras'])
        ->name('compras_home');
    Route::get('/tienda/detalle-venta/{id}', [App\Http\Controllers\TiendaController::class, 'detallesVenta'])
        ->name('detalles_venta');
    Route::post('/tienda/generar-qr', [App\Http\Controllers\QrController::class, 'qr'])
        ->name('generar_qr');
});

// Clientes
Route::get('/clientes', [App\Http\Controllers\ClienteController::class, 'index'])->name('clientes_home')->middleware('check.role:1');
Route::delete('/clientes_eliminar/{id}', [App\Http\Controllers\ClienteController::class, 'destroy'])->name('eliminar_cliente')->middleware('check.role:1');
// Reporte
Route::get('/reporte', [App\Http\Controllers\ReporteController::class, 'index'])->name('reporte_home')->middleware('check.role:1');
