<?php

namespace App\Http\Controllers;

use App\Models\Pedidos;
use App\Models\Product;
use App\Models\Product_Pedido;
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
            return Pedidos::where('estatus', '!=', "CANCELADO")->get();
        } catch (Exception $ex) {
            return null;
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
                    $productos_pedido = Product_Pedido::where('pedidos_id', $id)->get();
                    foreach ($productos_pedido as $producto_pedido) {
                        $producto = Product::where('id', $producto_pedido->productos_id)->where('inventario', '1')->first();
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
}
