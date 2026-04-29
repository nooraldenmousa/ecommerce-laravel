<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarehouseStore extends Model
{
    protected $table = 'WAREHOUSE_STORE';
    protected $primaryKey = 'warehouse_store_id';
    public $timestamps = false;

    protected $fillable = ['warehouse_id', 'store_id'];
}