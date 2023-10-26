<?php

namespace App\Http\Controllers;

use App\Models\Pedidos;
use App\Models\Productos;
use App\Models\Productos_Pedidos;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidosController extends Controller
{
    public function index()
    {
        return view('pedidos.index');
    }

    public function getPedidos()
    {
        try {
             return Pedidos::with('users')->where('estatus', '!=', "CANCELADO")->get();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function cambiarEstatus(Request $request)
    {
        try {
            DB::beginTransaction();
            $id = $request->id;
            $estatus = $request->estatus;
            $pedido = Pedidos::where('id', $id)->first();
            switch ($estatus) {
                case "ACEPTADO":
                    // Obtener los productos del pedido.
                    $productos_pedido = Productos_Pedidos::where('pedidos_id', $id)->get();
                    foreach ($productos_pedido as $producto_pedido) {
                        $producto = Productos::where('id', $producto_pedido->productos_id)->where('inventario', '1')->first();
                        $producto->cantidad_producto -= $producto_pedido->cantidad;
                        $producto->save();
                    }
                    $pedido->estatus = $estatus;
                    $pedido->save();
                    break;
                case "CANCELADO":
                    break;
                default:
                    $pedido->estatus = $estatus;
                    $pedido->save();
                    break;
            }
            throw new Exception("Llegó al final");
            DB::commit();
            return response()->json([
                'lSuccess' => true,
                'cMensaje' => '¡Correcto!',
            ]);
        } catch (Exception $ex) {
            DB::rollback();
            return response()->json([
                'lSuccess' => false,
                'cMensaje' => $ex->getMessage(),
                'cTrace' => $ex->getTrace()
            ]);
        }
    }

    public function getDetallesPedido(Request $request)
    {
        try {
            $productos_pedido = Pedidos::where('id', $request->pedidos_id)->first();
            return $productos_pedido->productos;
        } catch (Exception $ex) {
            return response()->json([
                'lSuccess' => false,
                'cMensaje' => $ex->getMessage(),
                'cTrace' => $ex->getTrace()
            ]);
        }
    }
}
