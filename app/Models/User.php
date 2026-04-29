<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'USER';
    protected $primaryKey = 'user_id';
    public $timestamps = false;

    protected $fillable = ['username', 'password', 'account_status'];
    protected $hidden = ['password'];

    public function personalInformation()
    {
        return $this->hasOne(PersonalInformation::class, 'user_id', 'user_id');
    }
}
