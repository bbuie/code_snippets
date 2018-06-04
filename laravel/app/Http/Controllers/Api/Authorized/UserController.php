<?php

namespace App\Http\Controllers\Api\Authorized;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class UserController extends Controller{

    public function getUser(){

        $user = Auth::user();
        return response()->json([
          'user' => $user
        ]);
    }
    public function checkAccountAccess(){

        $user = Auth::user();
        return response()->json($user);
    }
}
