<?php

namespace App\Http\Controllers\Api\Guest\User;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Guest\User\Services\PasswordGrantLogin;
use App\Http\Controllers\Api\Guest\User\Services\InputValidator;
use App\Models\User;

class LoginController extends Controller{

    use AuthenticatesUsers;
    private $passwordGrantLogin;

    public function __construct(PasswordGrantLogin $passwordGrantLogin){
        $loginController = $this;
        $loginController->passwordGrantLogin = $passwordGrantLogin;
    }

    public function login(Request $request){

        $loginController = $this;
        $payload = $request->all();
        $validator = new InputValidator(['any_email', 'single_password']);
        $validator->validate($payload);
        $email =  $payload['email'];
        $password = $payload['password'];
        $token = $loginController->passwordGrantLogin->attemptLogin($email, $password);
        $user = User::where('email', $email)->first();
        $response = new \stdclass;
        $response->user = $user;
        $response->token = $token;
        return response()->json($response, 200);
    }
    public function refresh(Request $request){
        $loginController = $this;
        return response()->json($loginController->passwordGrantLogin->attemptRefresh());
    }
    public function logout(){
        $loginController = $this;
        $loginController->passwordGrantLogin->logout();
        return response()->json(null, 204);
    }
}
