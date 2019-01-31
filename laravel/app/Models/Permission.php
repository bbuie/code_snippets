<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permissions';
    public $timestamps = false;

    public function accountUsers()
    {
        return $this->belongsToMany('App\Models\AccountUser');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Models\Role');
    }

}
