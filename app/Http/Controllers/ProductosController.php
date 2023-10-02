<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Product;

class ProductosController extends Controller
{
    public function index()
    {
        return view('productos.index');
    }
    public function productList()
    {



        $products = Product::where('estatus', 'Disponible')
        ->where(function ($query) {
            $query->where('inventario', true)->where('cantidad_producto', '>', 0);
        })
        ->orWhere('inventario', false)
        ->get();


return $products;
    }
}
