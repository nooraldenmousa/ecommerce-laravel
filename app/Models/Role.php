<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PersonalInformation;

class Role extends Model
{
    protected $table = 'ROLE';
    protected $primaryKey = 'role_id';
    public $timestamps = false;

    protected $fillable = ['type'];

    public function employees()
    {
        return $this->hasMany(PersonalInformation::class, 'role_id', 'role_id');
    }
}
