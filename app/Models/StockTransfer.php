<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockTransfer extends Model
{
    protected $table = 'STOCK_TRANSFER';
    protected $primaryKey = 'transfer_id';
    public $timestamps = false;
    protected $fillable = ['from_warehouse_id', 'to_store_id', 'product_id', 'quantity', 'transfer_date'];
}
