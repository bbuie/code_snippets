<?php

namespace App\Http\Controllers\Api\V1\Guest\User\Services;

use Illuminate\Foundation\Application;
use App\Models\User;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PasswordGrantLogin{

    const REFRESH_TOKEN = 'refreshToken';
    private $apiConsumer;
    private $auth;
    private $cookie;
    private $db;
    private $request;

    public function __construct(Application $app) {

        $passwordGrantLogin = $this;
        $passwordGrantLogin->apiConsumer = $app->make('apiconsumer');
        $passwordGrantLogin->auth = $app->make('auth');
        $passwordGrantLogin->cookie = $app->make('cookie');
        $passwordGrantLogin->db = $app->make('db');
        $passwordGrantLogin->request = $app->make('request');
    }

    public function attemptLogin($email, $password){

        $passwordGrantLogin = $this;
        $user = User::where('email', $email)->first();
        $userIsFound = !is_null($user);

        if ($userIsFound) {

            $newAccessToken = $passwordGrantLogin->proxy('password', [
                'username' => $email,
                'password' => $password
            ]);

            return $newAccessToken;
        }

        $statusCode = 404;
        $message = 'Credentials are invalid.';
        $previous = null;
        $headers = array();
        $code = 0;

        throw new HttpException($statusCode, $message, $previous, $headers, $code);
    }
    public function attemptRefresh(){

        $passwordGrantLogin = $this;

        $isRequestFromIOSApp = $passwordGrantLogin->request->headers->get('Origin') === 'capacitor://localhost';
        if ($isRequestFromIOSApp) {
            $refreshToken = $passwordGrantLogin->request->input(self::REFRESH_TOKEN);
        } else {
            $refreshToken = $passwordGrantLogin->request->cookie(self::REFRESH_TOKEN);
        }

        return $passwordGrantLogin->proxy('refresh_token', [
            'refresh_token' => $refreshToken
        ]);
    }
    public function proxy($grantType, array $data = []){

        $passwordGrantLogin = $this;
        $data = array_merge($data, [
            'client_id'     => config('app.client_id'),
            'client_secret' => config('app.client_secret'),
            'grant_type'    => $grantType
        ]);

        $response = $passwordGrantLogin->apiConsumer->post('/oauth/token', $data);
        $contents = json_decode($response->getContent());

        if (!$response->isSuccessful()) {

            $statusCode = 419;
            $message = ($contents && $contents->message)? $contents->message : $response;
            $previous = null;
            $headers = array();
            $code = 0;

            throw new HttpException($statusCode, $message, $previous, $headers, $code);
        }

        // Create a refresh token cookie
        $passwordGrantLogin->cookie->queue(
            self::REFRESH_TOKEN,
            $contents->refresh_token,
            60, // 1 hour
            null,
            null,
            false,
            true // HttpOnly
        );

        $tokens = [
            'access_token' => $contents->access_token,
            'expires_in' => $contents->expires_in,
        ];
        $isRequestFromIOSApp = $passwordGrantLogin->request->headers->get('Origin') === 'capacitor://localhost';
        if ($isRequestFromIOSApp) {
            $tokens['refresh_token'] = $contents->refresh_token;
        }
        return $tokens;
    }
    public function logout(){

        $passwordGrantLogin = $this;
        $accessToken = $passwordGrantLogin->auth->user()->token();

        $refreshToken = $passwordGrantLogin->db
            ->table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update([
                'revoked' => true
            ]);

        $accessToken->revoke();

        $passwordGrantLogin->cookie->queue($passwordGrantLogin->cookie->forget(self::REFRESH_TOKEN));
    }
}
