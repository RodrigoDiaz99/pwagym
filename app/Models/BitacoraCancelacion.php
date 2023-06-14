<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BitacoraCancelacion extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'motivo',
        'carts_id',
        'userCreator',
        'cSistema',


    ];
    protected $table = "bitacora_cancelacions";
}
