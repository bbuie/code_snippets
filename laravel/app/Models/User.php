<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = [
        'current_account',
    ];

    public function accounts(){
        return $this->belongsToMany('App\Models\Account')->using('App\Models\AccountUser');
    }

    public function getCurrentAccountAttribute(){
        $user = $this;

        return $user->accounts()->first();
    }

    public static function mergeOrCreate($payload){

        if(isset($payload['id'])) {
            $user = User::findOrFail($payload['id']);
        } else {
            $user = new User;
        }

        $user->name = $payload['name'];
        $user->email = $payload['email'];

        if(!empty($payload['password'])){
            $user->password = bcrypt($payload['password']);
        }

        return $user;
    }
}
