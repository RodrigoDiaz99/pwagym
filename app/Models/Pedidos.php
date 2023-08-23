<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pedidos extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['orden_number', 'reference_line', 'estatus', 'price', 'users_id'];

    public function productos()
    {
        return $this->belongsToMany(Product::class, 'product_pedidos', 'pedidos_id', 'products_id')
            ->where('lActivo', true);
    }
}
