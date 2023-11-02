<?php

namespace App\Http\Controllers;

use App\Models\Configuracion;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConfiguracionController extends Controller
{
    public function index()
    {
        $configuracion = (object)array(
            "numero_orden" => Configuracion::getConfiguracion('numero_orden')
        );

        return view('configuracion.index', compact("configuracion"));
    }

    public function guardarConfiguracion(Request $request)
    {
        try {
            DB::beginTransaction();
            $numero_orden = $request->numero_orden;
            if ($numero_orden < 0) {
                throw new Exception("El número de orden especificado no es válido.");
            }

            Configuracion::guardarConfiguracion('numero_orden', $numero_orden);

            DB::commit();
            return response()->json([
                'lSuccess' => true,
                'cMensaje' => '¡Se guardó la configuración con éxito!',
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
