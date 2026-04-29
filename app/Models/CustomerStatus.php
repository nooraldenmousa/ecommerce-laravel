<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CustomerStatus extends Model
{
    protected $table = 'CUSTOMER_STATUS';
    protected $primaryKey = 'customer_status_id';
    public $timestamps = false;
    protected $fillable = ['status'];
}
