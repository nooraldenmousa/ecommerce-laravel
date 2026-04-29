<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductStore extends Model
{
    protected $table = 'PRODUCT_STORE';
    public $timestamps = false;
    protected $fillable = ['product_id', 'store_id'];
}
