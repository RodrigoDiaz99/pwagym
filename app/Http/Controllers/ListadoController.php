<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Pedidos;
use App\Models\Product_Pedido;
use App\Models\User;
use Illuminate\Http\Request;

class ListadoController extends Controller
{
    public function index(Request $request)
    {
        return view('listado.listado');
    }

    public function getLista(Request $request)
    {
        $usuarios = User::join('pedidos', 'users.id', '=', 'pedidos.users_id')
            ->join('product_pedidos', 'pedidos.id', '=', 'product_pedidos.pedidos_id')
            ->where('product_pedidos.lActivo', true)
            ->select('users.*')
            ->distinct()
            ->get();
        return $usuarios;

    }

    public function verProductos(Request $request)
    {
        $userID = $request->iIDUsuario;

        $user = User::with('pedidos.productos')->find($userID);

        $productosTotales = [];

        foreach ($user->pedidos as $pedido) {
            // Omitir el pedido si su estado es "CANCELADO"
            if ($pedido->estatus === 'CANCELADO') {
                continue;
            }

            $productos = $pedido->productos;

            foreach ($productos as $producto) {
                $productoId = $producto->id;

                // Obtener el precio de venta desde el modelo Inventory
                $inventory = Inventory::where('products_id', $productoId)->first();

                // Si ya existe el producto en el arreglo, suma la cantidad
                if (isset($productosTotales[$productoId])) {
                    $productosTotales[$productoId]['cantidad'] += 1;
                } else {
                    // Si no existe, agrega el producto al arreglo con su cantidad y precio de venta
                    $productosTotales[$productoId] = [
                        'id' => $producto->id,
                        'name' => $producto->name,
                        'cantidad' => 1,
                        'sales_price' => $inventory->sales_price, // Precio de venta por unidad
                    ];
                }
            }
        }

        // Calcular el precio de venta total para cada producto y sumar para obtener el total del pedido
        $totalPedido = 0;
        foreach ($productosTotales as &$productoTotal) {
            $productoTotal['sales_price_total'] = $productoTotal['cantidad'] * $productoTotal['sales_price'];
            $totalPedido += $productoTotal['sales_price_total'];
        }

        return ['productos' => array_values($productosTotales), 'totalPedido' => $totalPedido];
    }
    public function finalizar(Request $request)
    {
        try {
            $userID = $request->iIDPedido;

            $user = User::where('id', $userID)->first();

            $pedidos = Pedidos::where('users_id', $user->id)->pluck('id')->toArray();

            Product_Pedido::whereIn('pedidos_id', $pedidos)->update(['lActivo' => 0]);
            return response()->json(["lSuccess" => true, 'cMensaje' => 'Estatus cambiado de manera exitosa']);
        } catch (\Throwable $th) {
            return response()->json(["lSuccess" => false,
            'cMensaje' => 'No se pudo cambiar el estatus']);
        }


    }

}
