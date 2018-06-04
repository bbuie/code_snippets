<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    public function users(){
        return $this->belongsToMany('App\Models\User')->using('App\Models\AccountUser');
    }
}
