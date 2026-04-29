<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PersonalInformation;

class EmployeeStatus extends Model
{
    protected $table = 'EMPLOYEE_STATUS';
    protected $primaryKey = 'employee_status_id';
    public $timestamps = false;

    protected $fillable = ['status'];

    public function employees()
    {
        return $this->hasMany(PersonalInformation::class, 'employee_status_id', 'employee_status_id');
    }
}
