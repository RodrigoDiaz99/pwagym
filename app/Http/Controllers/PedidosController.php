<?php

namespace App\Http\Controllers;

use App\Models\BitacoraCancelaciones;
use App\Models\Pedidos;
use App\Models\Productos;
use App\Models\Productos_Pedidos;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            return Pedidos::with('users')->where('estatus', '!=', "CANCELADO")->orderBy('id','desc')->get();
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
            $motivoCancelacion = $request->motivoCancelacion;
            switch ($estatus) {
                case "ACEPTADO":
                    // Obtener los productos del pedido.
                    $productos_pedido = Productos_Pedidos::where('pedidos_id', $id)->get();
                    foreach ($productos_pedido as $producto_pedido) {
                        $producto = Productos::where('id', $producto_pedido->productos_id)->where('inventario', '1')->first();
                        if($producto){
                            $producto->cantidad_producto -= $producto_pedido->cantidad;
                        }
                    }
                    $pedido->estatus = $estatus;
                    $pedido->save();
                    break;
                case "CANCELADO":
                    $pedido->estatus = $estatus;
                    $pedido->save();
                    $bitacoraCancelacion = new BitacoraCancelaciones();
                    $bitacoraCancelacion->pedidos_id = $pedido->id;
                    $bitacoraCancelacion->users_id = Auth::user()->id;
                    $bitacoraCancelacion->motivo = $motivoCancelacion;
                    $bitacoraCancelacion->save();
                    break;
                default:
                    $pedido->estatus = $estatus;
                    $pedido->save();
                    break;
            }
            DB::commit();
            return response()->json([
                'lSuccess' => true,
                'cMensaje' => '¡Se aplicaron los cambios correctamente!',
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
            $productos_pedido = Pedidos::with('productos')->with('cliente')->with('users')->where('id', $request->id)->first();
            return response()->json([
                'lSuccess' => true,
                'pedido' => $productos_pedido,

            ]);
        } catch (Exception $ex) {
            return response()->json([
                'lSuccess' => false,
                'cMensaje' => $ex->getMessage(),
                'cTrace' => $ex->getTrace()
            ]);
        }
    }
}
