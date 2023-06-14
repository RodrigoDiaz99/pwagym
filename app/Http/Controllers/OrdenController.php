<?php

namespace App\Http\Controllers;

use App\Models\Pedidos;
use App\Models\Product_Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdenController extends Controller
{
    public function index()
    {
        return view('ordenes.index');
    }
    public function getOrdenes(Request $request){
    $pedidos= Pedidos::get();

    return $pedidos;

    }

    public function data(Request $request){
     $pedidos= Pedidos::where('id',$request->iIDPedido)->first();
    //  $producto_pedidos = Product_Pedido::where('pedidos_id',$pedidos->id)->get();

     $producto_pedidos =  Product_Pedido::select('products_id', DB::raw('count(*) as total'))->groupBy('products_id')->where('id',$pedidos->id)->get();


     dd($producto_pedidos);
    }
}
