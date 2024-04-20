<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\MovimientoStockController;
use App\Http\Controllers\RendimientosController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Auth::routes();
Route::middleware('auth')->group(function () {
    Route::get('/',[HomeController::class,'index']);

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::prefix('Cliente')->group(function(){
        Route::get('/', [ClienteController::class, 'index'])->name('cliente.index');
        Route::get('/create', [ClienteController::class, 'create'])->name('cliente.create');
        Route::post('/', [ClienteController::class, 'store'])->name('cliente.store');
        Route::get('/{id}/edit', [ClienteController::class, 'edit'])->name('cliente.edit');
        Route::put('/{id}', [ClienteController::class, 'update'])->name('cliente.update');
        Route::delete('/{id}', [ClienteController::class, 'destroy'])->name('cliente.destroy');
        Route::get('/{id}/show', [ClienteController::class, 'show'])->name('cliente.show');
    });

    Route::prefix('Producto')->group(function(){
        Route::get('/', [ProductoController::class, 'index'])->name('producto.index');
        Route::get('/create', [ProductoController::class, 'create'])->name('producto.create');
        Route::post('/', [ProductoController::class, 'store'])->name('producto.store');
        Route::get('/{id}/edit', [ProductoController::class, 'edit'])->name('producto.edit');
        Route::put('/{id}', [ProductoController::class, 'update'])->name('producto.update');
        Route::delete('/{id}', [ProductoController::class, 'destroy'])->name('producto.destroy');
        Route::get('/buscarNombre', [ProductoController::class, 'buscarNombre'])->name('producto.buscarNombre');
        Route::get('/buscarMarca', [ProductoController::class, 'buscarMarca'])->name('producto.buscarMarca');
        Route::get('/buscarProveedor', [ProductoController::class, 'buscarProovedor'])->name('producto.buscarProveedor');
    });

    Route::prefix('Proveedor')->group(function(){
        Route::get('/', [ProveedorController::class, 'index'])->name('proveedor.index');
        Route::get('/create', [ProveedorController::class, 'create'])->name('proveedor.create');
        Route::post('/', [ProveedorController::class, 'store'])->name('proveedor.store');
        Route::get('/{id}/edit', [ProveedorController::class, 'edit'])->name('proveedor.edit');
        Route::put('/{id}', [ProveedorController::class, 'update'])->name('proveedor.update');
        Route::delete('/{id}', [ProveedorController::class, 'destroy'])->name('proveedor.destroy');
        Route::get('/buscarNombre', [ProveedorController::class, 'buscarNombre'])->name('proveedor.buscarNombre');

    });

    Route::prefix('Pedido')->group(function(){
        Route::get('/', [PedidoController::class, 'index'])->name('pedido.index');
        Route::get('/Finalizados', [PedidoController::class, 'finalizados'])->name('pedido.finalizados');
        Route::get('/Entregados', [PedidoController::class, 'entregados'])->name('pedido.entregados');
        Route::get('/create', [PedidoController::class, 'create'])->name('pedido.create');
        Route::post('/', [PedidoController::class, 'store'])->name('pedido.store');
        Route::get('/{id}/editI', [PedidoController::class, 'editI'])->name('pedido.editI');
        Route::get('/{id}/editF', [PedidoController::class, 'editF'])->name('pedido.editF');
        Route::put('/{id}/inicio', [PedidoController::class, 'updateI'])->name('pedido.updateI');
        Route::put('/{id}/fin', [PedidoController::class, 'updateF'])->name('pedido.updateF');
        Route::delete('/{id}', [PedidoController::class, 'destroy'])->name('pedido.destroy');
        Route::get('/{id}/showI', [PedidoController::class, 'showI'])->name('pedido.showI');
        Route::get('/{id}/showF', [PedidoController::class, 'showF'])->name('pedido.showF');
        Route::get('/clientes', [PedidoController::class, 'obtenerClientes'])->name('pedido.clientesobtener');
        Route::get('/{id}/estados', [PedidoController::class, 'verEstados'])->name('pedido.verestados');
        Route::get('/{pedido_id}/actualizarEstado/{estado_id}', [PedidoController::class, 'actualizarEstado'])->name('pedido.actualizarestado');
        Route::put('/{id}/genera_presupuesto',[PedidoController::class, 'storeAprobacion'])->name('pedido.storeAprobacion');
    });

    Route::prefix('Historial')->group(function(){
        Route::get('/entradas', [MovimientoStockController::class, 'entradas'])->name('historial.entradas');
        Route::get('/salidas', [MovimientoStockController::class, 'salidas'])->name('historial.salidas');
    });

    Route::get('/rendimientos', [RendimientosController::class, 'index'])->name('rendimientos.index');
});