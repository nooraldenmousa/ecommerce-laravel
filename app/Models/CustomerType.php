<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CustomerType extends Model
{
    protected $table = 'CUSTOMER_TYPE';
    protected $primaryKey = 'customer_type_id';
    public $timestamps = false;
    protected $fillable = ['type'];
}
