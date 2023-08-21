<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['products_id', 'quantity', 'minimum_alert', 'maximun_alert', 'purchase_price', 'sales_price', 'asigned_by', 'status'];

    /*
     * Get all of the Product for the Inventory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function product()
    {
        return $this->HasOne(Product::class, 'id', 'products_id');
    }

    /*
     * Get all of the User for the Inventory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function asignedBy()
    {
        return $this->HasOne(User::class, 'id', 'asigned_by');
    }
}
