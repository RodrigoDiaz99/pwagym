<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Productos_Pedidos extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "productos_pedidos";

    protected $fillable = [
        'cantidad',
        'productos_id',
        'pedidos_id',
        'lActivo'
    ];

    public function productos()
    {
        return $this->hasMany('productos');
    }
}
