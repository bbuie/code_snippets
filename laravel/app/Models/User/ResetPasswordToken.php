<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class ResetPasswordToken extends Model
{
    protected $table = 'reset_password_tokens';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'token',
        'expiration'
    ];

}
