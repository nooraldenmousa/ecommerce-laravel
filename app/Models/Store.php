<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $table = 'STORE';
    protected $primaryKey = 'store_id';
    public $timestamps = false;

    protected $fillable = [
        'store_name', 'city', 'address',
        'phone', 'upload_file', 'manager_id'
    ];

    public function manager()
    {
        return $this->belongsTo(PersonalInformation::class, 'manager_id', 'personal_id');
    }

    public function employees()
    {
        return $this->hasMany(PersonalInformation::class, 'stores_id', 'store_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'PRODUCT_STORE', 'store_id', 'product_id');
    }

    public function warehouses()
    {
        return $this->belongsToMany(Warehouse::class, 'WAREHOUSE_STORE', 'store_id', 'warehouse_id');
    }
}
