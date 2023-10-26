<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BitacoraCancelaciones extends Model
{
    use HasFactory;
    protected $table = "bitacora_cancelaciones";

    public function pedidos()
    {
        return $this->hasOne(Pedidos::class, 'id', 'pedidos_id');
    }

    public function users()
    {
        return $this->hasOne(Users::class, 'id', 'users_id');
    }
}
