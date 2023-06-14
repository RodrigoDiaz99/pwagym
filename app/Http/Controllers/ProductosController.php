<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductosController extends Controller
{
    public function index()
    {
        return view('productos.index');
    }
    public function productList()
    {

        $product = Product::join('category_products', 'products.category_products_id', '=', 'category_products.id')
        ->join('inventories', 'inventories.products_id', '=', 'inventories.products_id')
       ->where('products.requireInventory', 0)
        ->select('products.id', 'products.bar_code', 'products.name', 'inventories.sales_price')

        ->get();

        foreach ($product as $lstProduct) {
            $lista[] = array(
                'iIDProducto' => $lstProduct->id,
                'cNombreProduct' => $lstProduct->name,
                'cCodeBar' => $lstProduct->bar_code,
                'price' => $lstProduct->sales_price,

            );
        }

        return response()->json($lista);

    }
}
