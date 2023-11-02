<?php

use App\Http\Controllers\ComandaController;
use App\Http\Controllers\ComanderaController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\PedidosController;
use App\Http\Controllers\ProductosController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    if (Auth::check()) {
        return redirect(route('comandera.index'));
    } else {
        return view('auth.login');
    }
});

Auth::routes();
Route::middleware(['auth'])->group(function () {


    // Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::prefix('pedidos')->name('pedidos.')->controller(PedidosController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('getPedidos', 'getPedidos')->name('getPedidos');
        Route::post('cambiarEstatus', 'cambiarEstatus')->name('cambiarEstatus');
        Route::post('updateEstatus', 'updateEstatus')->name('updateEstatus');
        Route::post('getDetallesPedido', 'getDetallesPedido')->name('getDetallesPedido');
    });

    Route::prefix('comandera')->name('comandera.')->controller(ComanderaController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('getProducto', 'getProducto')->name('getProducto');
        Route::post('enviarOrden', 'enviarOrden')->name('enviarOrden');
        Route::get('/agregarProductos/{id}', 'agregarProductos')->name('agregarProductos');
        Route::post('agregarProductosAOrden', 'agregarProductosAOrden')->name('agregarProductosAOrden');
    });

    Route::prefix('configuracion')->name('configuracion.')->controller(ConfiguracionController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('guardarConfiguracion', 'guardarConfiguracion')->name('guardarConfiguracion');
    });

    Route::prefix('productos')->name('productos.')->controller(ProductosController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('gridProductos', 'gridProductos')->name('gridProductos');
    });
});
