<?php

namespace App\Http\Controllers;

use App\Models\Configuracion;
use App\Models\Pedidos;
use App\Models\Productos;
use App\Models\Productos_Pedidos;
use App\Models\User;
use App\Models\Users;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComanderaController extends Controller
{
    public function index()
    {
        $rolesPermitidos = array("Cocina");

        $productos = Productos::where('estatus', 'Disponible')
            ->where(function ($query) {
                $query->where('inventario', true)
                    ->where('cantidad_producto', '>', 0);
            })
            ->orWhere('inventario', false)
            ->get();
        $usuarios = Users::whereHas('rol', function ($query) use ($rolesPermitidos) {
            $query->whereIn('nombre', $rolesPermitidos);
        })->get();

        return view('comandera.index', compact('productos', 'usuarios'));
    }

    public function getProducto(Request $request)
    {
        return Productos::where('estatus', 'Disponible')
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
            $comentario = $request->comentarios;
            $user = $request->codigo_usuario;
            $usuario = User::where('codigo_usuario', $user)->first();

            if (is_null($usuario)) {
                throw new Exception('No se encontro el usuario con ese codigo');
            }
            $numero_orden = Configuracion::getConfiguracion('numero_orden');
            $pedido = Pedidos::create([
                'numero_orden' => $numero_orden,
                'linea_referencia' => 0,
                'estatus' => 'ENVIADO',
                'comentarios' => $comentario,
                'precio' => $totalCompra,
                'users_id' => $usuario->id,
            ]);

            $numero_orden = '000' . $numero_orden;
            $linea_referencia = $pedido->id .  mt_rand(1, 990) . "COM";

            $pedido->update([
                'numero_orden' => $numero_orden,
                'linea_referencia' => $linea_referencia,
            ]);

            // Obtener los datos de cada producto
            foreach ($productos as $producto) {

                Productos_Pedidos::create([
                    'cantidad' => $producto['unidades'],
                    'productos_id' => $producto['id'],
                    'pedidos_id' => $pedido->id,
                    'lActivo' => true
                ]);
            }

            Configuracion::guardarConfiguracion("numero_orden", $numero_orden + 1);
            DB::commit();
            return response()->json([
                'lSuccess' => true,
                'cMensaje' => "Se genero el pedido de manera exitosa",
            ]);
        } catch (Exception $ex) {
            DB::rollBack();

            return response()->json([
                'lSuccess' => false,
                'iLine' => $ex->getLine(),
                'cMensaje' => $ex->getMessage(),
            ]);
        }
    }
}
