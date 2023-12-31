<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;
    protected $table = "users";

    public function rol()
    {
        return $this->hasOne(Roles::class, "id", "roles_id");
    }
}
