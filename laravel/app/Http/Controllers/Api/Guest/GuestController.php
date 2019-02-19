<?php

namespace App\Http\Controllers\Api\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function getClientEnv(Request $request)
    {
        $envSettings = [
            'baseURL' => config('app.url')
        ];
        return response()->json($envSettings, 200);
    }
}