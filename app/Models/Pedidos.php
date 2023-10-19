<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pedidos extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['numero_orden', 'linea_referencia', 'estatus', 'precio', 'users_id'];

    public function productos()
    {
        return $this->belongsToMany(Product::class, 'productos_pedidos', 'pedidos_id', 'productos_id');
    }
}
