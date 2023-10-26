<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Productos extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "productos";
    protected $fillable = [
        'codigo_barras',
        'nombre_producto',
        'proveedores_id',
        'categoria_productos_id',
        'inventario',
        'cantidad_producto',
        'alerta_minima',
        'alert_maxima',
        'precio_venta',
        'users_id',
        'estatus',
    ];
    public function proveedor()
    {
        return $this->belongsTo(Proveedores::class, 'proveedores_id');
    }
    public function categoria()
    {
        return $this->belongsTo(CategoriaProductos::class, 'categoria_productos_id');
    }
    public function usuario()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

}
