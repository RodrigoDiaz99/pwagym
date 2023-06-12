<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['bar_code', 'name', 'product_units_id', 'description', 'providers_id', 'requireInventory', 'category_products_id'];

    /*
     * Get all of the Units for the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productUnit()
    {
        return $this->HasOne(ProductUnit::class, 'id', 'product_units_id');
    }

    /*
     * Get all of the Providers for the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productProvider()
    {
        return $this->HasOne(Provider::class, 'id', 'providers_id');
    }

    /*
     * Get all of the Category for the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productCategory()
    {
        return $this->HasOne(CategoryProduct::class, 'id', 'category_products_id');
    }
}
