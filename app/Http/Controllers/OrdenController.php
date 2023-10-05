<?php

namespace App\Http\Controllers;

use App\Models\Pedidos;
use App\Models\Product;
use App\Models\Product_Pedido;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdenController extends Controller
{
    public function index()
    {
        $productos = Product::where('estatus', 'Disponible')
            ->where(function ($query) {
                $query->where('inventario', true)
                    ->where('cantidad_producto', '>', 0);
            })
            ->orWhere('inventario', false)
            ->get();

        return view('orden.index', compact('productos'));
    }

    public function getProducto(Request $request)
    {
        return Product::where('estatus', 'Disponible')
            ->where('nombre_producto', $request->producto)
            ->where(function ($query) {
                $query->where('inventario', true)
                    ->where('cantidad_producto', '>', 0);
            })
            ->orWhere('inventario', false)
            ->get();
    }

    public function enviarOrden(Request $request)
    {
        try {
            DB::beginTransaction();

            $productos = $request->productos;
            $totalCompra = $request->total_venta;

            $user = $request->codigo_usuario;
            $usuario = User::where('codigo_usuario', $user)->first();

            if (is_null($usuario)) {
                throw new Exception('No se encontro el usuario con ese codigo');
            }

            $pedido = Pedidos::create([
                'numero_orden' => 0,
                'linea_referencia' => 0,
                'estatus' => 'ENVIADO',
                'precio' => $totalCompra,
                'users_id' => $usuario->id,
            ]);
            $numero_orden = '000' . $pedido->id;
            $linea_referencia = $pedido->id .  mt_rand(1, 990) . "COM";

            $pedido->update([
                'numero_orden' => $numero_orden,
                'linea_referencia' => $linea_referencia,
            ]);

            // Obtener los datos de cada producto
            foreach ($productos as $producto) {
                Product_Pedido::create([
                    'cantidad' => $producto['unidades'],
                    'productos_id' => $producto['id'],
                    'pedidos_id' => $pedido->id,
                    'lActivo' => true
                ]);
            }

            DB::commit();
            return response()->json([
                'lSuccess' => true,
                'cMensaje' => "Se genero el pedido de manera exitosa",
            ]);
        } catch (Exception $ex) {
            DB::rollBack();

            return response()->json([
                'lSuccess' => false,
                'cMensaje' => $ex->getMessage(),
            ]);
        }
    }
}
