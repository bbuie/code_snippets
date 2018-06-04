<?php

namespace App\Http\Controllers\Api\Guest\User;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller{

    use SendsPasswordResetEmails;

    public function __construct()
    {
    }

    public function requestReset(Request $request){

        $forgotPasswordController = $this;

        $forgotPasswordController->validate($request, ['email' => 'required|email']);
        $forgotPasswordController->validate($request, ['email' => 'required|email']);
        $payload = $request->all();
        $email =  $payload['email'];
        $user = User::where('email', $email)->first();

        if($user){
           $token = Password::broker()->createToken($user);
           $user->sendPasswordResetNotification($token);

           return response()->json(['message' => 'An email was sent.'], 204);
        }

        return response()->json(['message' => 'If you have an account with us, an email was sent.'], 204);
    }
}
