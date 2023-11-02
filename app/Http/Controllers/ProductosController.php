<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Productos;

class ProductosController extends Controller
{
    public function index()
    {
        return view('productos.index');
    }

    public function gridProductos()
    {
        $products = Productos::where('estatus', 'Disponible')
            ->where(function ($query) {
                $query->where(function ($subquery) {
                    $subquery->where('inventario', true)
                        ->where('cantidad_producto', '>', 0);
                })
                    ->orWhere('inventario', false);
            })
            ->get();


        return $products;
    }
}
