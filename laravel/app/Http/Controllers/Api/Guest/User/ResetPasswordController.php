<?php

namespace App\Http\Controllers\Api\Guest\User;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use \Carbon\Carbon;
use App\Http\Controllers\Api\Guest\User\Services\InputValidator;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller{

    use ResetsPasswords;

    public function __construct()
    {
    }

    public function resetPassword(Request $request){
        $resetPasswordController = $this;
        $resetPasswordController->validate($request, [
            'token' => 'required', 'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);

        $credentials = $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );

        $response = Password::broker()->reset(
            $credentials, function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        if($response === Password::PASSWORD_RESET){
            return response()->json(['message' => 'Password Reset'], 204);
        } else {
            return response()->json(['message' => 'We weren\'t able to reset your password.'], 500);
        }
    }
}
