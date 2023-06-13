<?php

namespace App\Http\Controllers;

use App\Models\Pedidos;
use Illuminate\Http\Request;

class OrdenController extends Controller
{
    public function index()
    {
        return view('ordenes.index');
    }
    public function getOrdenes(Request $request){
    $pedidos= Pedidos::get();

    return $pedidos;

    }
}
