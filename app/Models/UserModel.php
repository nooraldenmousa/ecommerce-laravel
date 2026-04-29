<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    protected $table = 'USER';
    protected $primaryKey = 'user_id';
    public $timestamps = false;

    protected $fillable = [
        'username',
        'password',
        'account_status'
    ];

    protected $hidden = ['password'];

    public function personalInfo()
    {
        return $this->hasOne(PersonalInformation::class, 'user_id', 'user_id');
    }
}