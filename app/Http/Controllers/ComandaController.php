<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

class ComandaController extends Controller
{
    public function index()
    {
        return view('comanda.index');
    }

    public function getComanda(Request $request)
    {
        try {
            return response()->json([
                'lSuccess' => true,
                'cMensaje' => '¡Correcto!',
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
