<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
    use HasFactory;
    protected $table = "configuracions";

    public static function getConfiguracion($cClave)
    {
        return Configuracion::where('cClave', $cClave)->first()->cValor;
    }

    public static function guardarConfiguracion($cClave, $cValor)
    {
        $configuracion = Configuracion::where('cClave', $cClave)->first();
        $configuracion->cValor = $cValor;
        $configuracion->save();
        return true;
    }
}
