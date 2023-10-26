<?php

use App\Http\Controllers\ComandaController;
use App\Http\Controllers\OrdenController;
use App\Http\Controllers\PedidosController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    if (Auth::check()) {
        return redirect(route('orden.index'));
    } else {
        return view('auth.login');
    }
});

Auth::routes();
Route::middleware(['auth'])->group(function () {


    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::prefix('pedidos')->name('pedidos.')->controller(PedidosController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('getPedidos', 'getPedidos')->name('getPedidos');
        Route::post('cambiarEstatus', 'cambiarEstatus')->name('cambiarEstatus');
        Route::post('updateEstatus', 'updateEstatus')->name('updateEstatus');
        Route::post('getDetallesPedido', 'getDetallesPedido')->name('getDetallesPedido');
    });

    Route::prefix('orden')->name('orden.')->controller(OrdenController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('getProducto', 'getProducto')->name('getProducto');
        Route::post('enviarOrden', 'enviarOrden')->name('enviarOrden');
    });

    Route::prefix('comanda')->name('comanda.')->controller(ComandaController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('gridPedidosComanda', 'gridPedidosComanda')->name('gridPedidosComanda');
        Route::post('getDetallesPedido', 'getDetallesPedido')->name('getDetallesPedido');
    });
});
