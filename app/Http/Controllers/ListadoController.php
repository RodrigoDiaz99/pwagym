<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ListadoController extends Controller
{
    public function index(Request $request){
        return view('listado.listado');
    }

    public function getLista(Request $request){
        $usuarios =User::join('pedidos', 'users.id', '=', 'pedidos.users_id')
        ->join('product_pedidos', 'pedidos.id', '=', 'product_pedidos.pedidos_id')
      //  ->where('product_pedidos.lActivo', true)
        ->select('users.*')
        ->distinct()
        ->get();
        return $usuarios;

    }

    public function verProductos(Request $request){
        $userID = $request->iIDUsuario;

        $user = User::with('pedidos.productos')->find($userID);

        $productosTotales = [];

        foreach ($user->pedidos as $pedido) {
            $productos = $pedido->productos;

            foreach ($productos as $producto) {
                $productoId = $producto->id;

                // Si ya existe el producto en el arreglo, suma la cantidad
                if (isset($productosTotales[$productoId])) {
                    $productosTotales[$productoId]['cantidad'] += 1; // Aquí podrías usar la cantidad del producto en el pedido actual
                } else {
                    // Si no existe, agrega el producto al arreglo con su cantidad
                    $productosTotales[$productoId] = [
                        'id' => $producto->id,
                        'name' => $producto->name,
                        'cantidad' => 1, // Aquí podrías usar la cantidad del producto en el pedido actual
                    ];
                }
            }
        }

        return array_values($productosTotales);

    }
}
