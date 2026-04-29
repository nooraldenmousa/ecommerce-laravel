<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Warehouse extends Model
{
    protected $table = 'WAREHOUSE';
    protected $primaryKey = 'warehouse_id';
    public $timestamps = false;

    protected $fillable = [
        'warehouse_name',
        'city',
        'address',
        'phone',
        'upload_file',
        'manager_id'
    ];

    public function manager()
    {
        return $this->belongsTo(PersonalInformation::class, 'manager_id', 'personal_id');
    }

    public function stores()
    {
        return $this->belongsToMany(Store::class, 'WAREHOUSE_STORE', 'warehouse_id', 'store_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'WAREHOUSE_PRODUCT', 'warehouse_id', 'product_id');
    }
}