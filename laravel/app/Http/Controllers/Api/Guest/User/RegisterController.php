<?php

namespace App\Http\Controllers\Api\Guest\User;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Guest\User\Services\PasswordGrantLogin;
use App\Http\Controllers\Api\Guest\User\Services\InputValidator;
use Illuminate\Support\Facades\DB;
use App\Models\Account;

class RegisterController extends Controller {

    use RegistersUsers;

    public function __construct(PasswordGrantLogin $passwordGrantLogin){
        $registerController = $this;
        $registerController->passwordGrantLogin = $passwordGrantLogin;
    }

    public function register(Request $request){

        $registerController = $this;

        try{
            DB::beginTransaction();
            $payload = $request->all();
            $validator = new InputValidator(['name', 'email', 'password']);
            $validator->validate($payload);
            $user = User::mergeOrCreate($payload);
            $user->save();
            $email = $payload['email'];
            $password = $payload['password'];
            $token = $registerController->passwordGrantLogin->attemptLogin($email, $password);
            $account = new Account;
            $user->accounts()->save($account);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();
            throw $exception;
        }

        $response = new \stdclass;
        $response->user = $user;
        $response->token = $token;

        return response()->json($response, 201);
    }
}
