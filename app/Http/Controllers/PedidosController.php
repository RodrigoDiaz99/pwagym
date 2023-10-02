<?php

namespace App\Http\Controllers;

use App\Models\Pedidos;
use App\Models\Product;
use App\Models\Product_Pedido;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidosController extends Controller
{
    public function index()
    {

        $product = Product::where('estatus', 'Disponible')
        ->where(function ($query) {
            $query->where('inventario', true)->where('cantidad_producto', '>', 0);
        })
        ->orWhere('inventario', false)
        ->get();

        return view('pedidos.index', compact('product'));
    }
    public function getData(Request $request)
    {
        $product = Product::where('estatus', 'Disponible')
        ->where('nombre_producto', $request->producto)
        ->where(function ($query) {
            $query->where('inventario', true)->where('cantidad_producto', '>', 0);
        })
        ->orWhere('inventario', false)
         ->select('id', 'codigo_barras as bar_code',
          'nombre_producto as name', 'precio_venta as sales_price')
        ->get();
        // ->where('products.name', $request->producto)
        // $product = Product::join('category_products', 'products.category_products_id', '=', 'category_products.id')
        //     ->join('inventories', 'inventories.products_id', '=', 'inventories.products_id')
        //     ->where('inventories.status', 'Disponible')
        //     ->where('nombre_producto.name', $request->producto)
        //     ->select('products.id', 'products.bar_code',
        //         'products.name', 'inventories.sales_price')
        //     ->get();
        return $product;
    }

    public function realizacion(Request $request)
    {
        DB::beginTransaction();
        try {

            $productos = json_decode($request->input('productos'), true);
            $totalCompra = $request->input('totalCompra');

            $user = $request->input('code_user');
            $usuario = User::where(function ($query) use ($user) {
                $query->where('code_user', $user)
                      ->orWhere('id', $user)
                      ->orWhere('username',$user); // Agrega aquí los campos adicionales que quieras verificar
            })->first();

            if (is_null($usuario)) {
                throw new Exception('No se encontro el usuario con ese codigo');
            }
            $pedido = Pedidos::create([
                'orden_number' => 0,
                'reference_line' => 0,
                'estatus' => 'ENVIADO',
                'price' => $totalCompra,
                'users_id' => $usuario->id,
            ]);
            $reference = mt_rand(1, 990);
            $ordenNumber = '000' . $pedido->id;
            $referenceLine = $pedido->id . $reference . "COM";

            $pedido->update([
                'orden_number' => $ordenNumber,
                'reference_line' => $referenceLine,
            ]);

            // Obtener los datos de cada producto
            foreach ($productos as $nombre => $detalles) {

                $product = Product::join('category_products', 'products.category_products_id', '=', 'category_products.id')
                    ->join('inventories', 'inventories.products_id', '=', 'inventories.products_id')
                    ->where('inventories.status', 'Disponible')
                    ->where('products.name', $nombre)
                    ->select('products.id', 'products.bar_code',
                        'products.name', 'inventories.sales_price')
                    ->first(); // Utilizamos first() en lugar de get() para obtener solo un resultado en lugar de una colección

                $cantidad = $detalles['cantidad'];
                Product_Pedido::create([
                    'cantidad' => $cantidad,
                    'products_id' => $product->id,
                    'pedidos_id' => $pedido->id,
                    'lActivo'=>true
                ]);

                // Realizar las operaciones necesarias con los datos del producto
                // ...

                // ...
            }
            DB::commit();
            return back()->with('success', 'Se genero el pedido de manera exitosa');
        } catch (\Throwable $th) {
            DB::rollBack();

            return back()->with('error', 'No se pudo generar el pedido, ' . $th->getMessage());
        }

    }
}
