<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarehouseProduct extends Model
{
    protected $table = 'WAREHOUSE_PRODUCT';
    protected $primaryKey = 'warehouse_product_id';
    public $timestamps = false;

    protected $fillable = ['warehouse_id', 'product_id'];
}