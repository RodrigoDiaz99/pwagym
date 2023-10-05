<?php

use App\Http\Controllers\OrdenController;
use App\Http\Controllers\PedidosController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('pedidos')->name('pedidos.')->controller(PedidosController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('getPedidos', 'getPedidos')->name('getPedidos');
    Route::post('getDetalles', 'getDetalles')->name('getDetalles');
    Route::post('updateEstatus', 'updateEstatus')->name('updateEstatus');
});

Route::prefix('orden')->name('orden.')->controller(OrdenController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('getProducto', 'getProducto')->name('getProducto');
    Route::post('getDetalles', 'getDetalles')->name('getDetalles');
    Route::post('updateEstatus', 'updateEstatus')->name('updateEstatus');
});
