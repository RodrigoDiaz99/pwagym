<?php

use App\Http\Controllers\ListadoController;
use App\Http\Controllers\OrdenController;
use App\Http\Controllers\PedidosController;
use App\Http\Controllers\ProductosController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::controller(ProductosController::class)->group(function () {

    Route::get('productos', 'index')->name('product.view');
    Route::post('getProducts', 'productList')->name('product.list');
});

Route::controller(OrdenController::class)->group(function () {
    Route::get('ordenes', 'index')->name('ordenes.index');
    Route::post('listOrdenes', 'getOrdenes')->name('ordenes.list');
    Route::post('detalles', 'data')->name('ordenes.data');
    Route::post('estatus', 'estatus')->name('ordenes.estatus');
    Route::post('estatusCan', 'estatusCan')->name('ordenes.estatusCan');
    Route::post('MotivoCanc', 'MotivoCanc')->name('ordenes.MotivoCanc');
});
Route::controller(PedidosController::class)->group(function () {
    Route::get('pedidos', 'index')->name('pedidos.index');
    Route::post('getPedidos', 'getPedidos')->name('pedidos.getPedidos');
    Route::post('realizacion', 'realizacion')->name('carrito.enviar');
    Route::post('getData', 'getData')->name('productos.data');
});


Route::controller(ListadoController::class)->group(function () {
    Route::get('lista', 'index')->name('listado.view');
    Route::post('getLista', 'getLista')->name('getLista');
    Route::post('verProductos', 'verProductos')->name('verProductos');
    Route::post('finalizar', 'finalizar')->name('finalizar');
});
