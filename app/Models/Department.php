<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PersonalInformation;

class Department extends Model
{
    protected $table = 'DEPARTMENT';
    protected $primaryKey = 'department_id';
    public $timestamps = false;

    protected $fillable = ['department_name'];

    public function employees()
    {
        return $this->hasMany(PersonalInformation::class, 'department_id', 'department_id');
    }
}
