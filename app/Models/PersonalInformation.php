<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalInformation extends Model
{
    protected $table = 'PERSONAL_INFORMATION';
    protected $primaryKey = 'personal_id';
    public $timestamps = false;

    protected $fillable = [
        'firstNmae', 'lastName', 'father', 'mother', 'birthday',
        'gender', 'national_number', 'phone', 'email', 'address',
        'upload_file', 'salary', 'role_id', 'user_id', 'department_id',
        'warehouse_id', 'stores_id', 'employee_status_id',
        'customer_status_id', 'customer_type_id', 'assigned_to'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }

    public function employeeStatus()
    {
        return $this->belongsTo(EmployeeStatus::class, 'employee_status_id', 'employee_status_id');
    }

    public function customerStatus()
    {
        return $this->belongsTo(CustomerStatus::class, 'customer_status_id', 'customer_status_id');
    }

    public function customerType()
    {
        return $this->belongsTo(CustomerType::class, 'customer_type_id', 'customer_type_id');
    }

    public function offers()
    {
        return $this->belongsToMany(Offer::class, 'OFFER_PERSONALINFORMATION', 'personal_id', 'offer_id');
    }
}
