<?php

namespace App\Http\Controllers;

use App\Models\Pedidos;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComandaController extends Controller
{
    public function index()
    {
        return view('comanda.index');
    }

    public function gridPedidosComanda(Request $request)
    {
        try {
            return Pedidos::where('estatus', '!=', "CANCELADO")
                ->where('users_id', Auth::user()->id)
                ->get();
        } catch (Exception $ex) {
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
