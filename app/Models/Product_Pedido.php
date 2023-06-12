<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product_Pedido extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "product_pedidos";

    protected $fillable = [
        'products_id',
        'pedidos_id',
    ];
}
