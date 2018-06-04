<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAccount
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $accountId = (int)$request->header('current_account_id');
        $user = Auth::user();
        $userAccountIds = $user->accounts()->pluck('accounts.id')->toArray();
        $hasAccountAccess = in_array($accountId, $userAccountIds);

        if(!$hasAccountAccess){
            return response()->json(['message' => 'You don\'t have access to this account.'], 403);
        }

        return $next($request);
    }
}
