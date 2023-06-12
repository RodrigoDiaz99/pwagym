<?php

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

Route::get('/productos',[ProductosController::class,'index'])->name('product.view');
Route::post('/getProducts',[ProductosController::class,'productList'])->name('product.list');

Route::get('/pedidos',[PedidosController::class,'index'])->name('pedidos.view');
Route::post('/realizacion',[PedidosController::class,'realizacion'])->name('carrito.enviar');
Route::post('/getData',[PedidosController::class,'getData'])->name('productos.data');
