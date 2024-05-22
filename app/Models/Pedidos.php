<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pedidos extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['numero_orden','comentarios', 'linea_referencia', 'estatus', 'precio', 'users_id', 'cliente_id', 'cobrado'];

    public function productos()
    {
        return $this->belongsToMany(Productos::class, 'productos_pedidos', 'pedidos_id', 'productos_id')->withPivot('cantidad');
    }

    public function users(){
        return $this->hasOne(Users::class, 'id', 'users_id');
    }

    public function cliente(){
        return $this->hasOne(Users::class, 'id', 'cliente_id');
    }
}
