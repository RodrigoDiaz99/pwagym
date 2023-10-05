<?php

namespace App\Http\Controllers;

use App\Models\BitacoraCancelacion;
use App\Models\Pedidos;
use App\Models\Product;
use App\Models\Product_Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrdenControllsser extends Controller
{
    public function index()
    {
        return view('orden.index');
    }
    public function getOrdenes(Request $request)
    {
        $pedidos = Pedidos::get();

        return $pedidos;
    }

    public function data(Request $request)
    {
        $lstPedido = array();
        $pedidos = Pedidos::where('id', $request->iIDPedido)->first();

        $producto_pedidos = Product_Pedido::where('pedidos_id', $pedidos->id)->get();

        $lstProdu = array(); // Mover la declaración del array fuera del bucle

        foreach ($producto_pedidos as $lstPP) {
            $productos = Product::where('id', $lstPP->products_id)->get();

            foreach ($productos as $lstProductos) {
                $lstProdu[] = array(
                    'cantidad' => $lstPP->cantidad,
                    'producto' => $lstProductos->name,
                );
            }
        }

        $lstPedido[] = array(
            'total' => $pedidos->price,
            'lstprodu' => $lstProdu,
        );

        return response()->json($lstPedido);
    }
    public function estatus(Request $request)
    {

        try {
            $pedidos = Pedidos::where('id', $request->iIDPedido)->first();
            switch ($request->cEstatus) {
                case "AC":
                    $pedidos->update([

                        'estatus' => "ACEPTADO",
                    ]);
                    break;
                case "PREP":
                    $pedidos->update([

                        'estatus' => "PREPARACION",
                    ]);
                    break;
                case "LIS":
                    $pedidos->update([

                        'estatus' => "LISTO",
                    ]);
                    break;
                case "FINALIZADO":
                    $pedidos->update([

                        'estatus' => "ENTREGADO",
                    ]);
                    break;
            }
            return response()->json(["lSuccess" => true, 'cMEnsaje' => 'Estatus cambiado de manera exitosa']);
        } catch (\Throwable $th) {
            return response()->json([
                "lSuccess" => false,
                'cMensaje' => 'No se pudo cambiar el estatus'
            ]);
        }
    }
    public function estatusCan(Request $request)
    {
        DB::beginTransaction();
        try {
            $pedidos = Pedidos::where('id', $request->iIDPedido)->first();
            $pedidos->update(['estatus' => 'CANCELADO']);

            $bitacora = BitacoraCancelacion::create([
                'carts_id' => $pedidos->id,
                'motivo' => $request->motivo,
                'userCreator' => Auth::id(),
                'cSistema' => "COMANDERA",
            ]);
            DB::commit();
            return response()->json(["lSuccess" => true, 'cMEnsaje' => 'Estatus cambiado de manera exitosa']);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                "lSuccess" => false,
                'cMensaje' => 'No se pudo cambiar el estatus'
            ]);
        }
    }
    public function MotivoCanc(Request $request)
    {
        DB::beginTransaction();
        try {

            $bitacora = BitacoraCancelacion::where('carts_id', $request->iIDPedido)
                ->where('cSistema', $request->cSistema)
                ->first();


            DB::commit();
            return response()->json(["lSuccess" => true, 'cMensaje' => $bitacora->motivo]);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                "lSuccess" => false,
                'cMensaje' => 'No se pudo cambiar el estatus'
            ]);
        }
    }
}
