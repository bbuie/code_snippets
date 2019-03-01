<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RequireSuperUserAccess
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if(!in_array('access super-admin', $user->current_account_user->all_permission_names)){
            return response()->json(['message' => 'This operation requires admin access'], 403);
        }

        return $next($request);
    }
}