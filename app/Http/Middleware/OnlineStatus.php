<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class OnlineStatus
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $userId = Auth::user()->id;
            $expiresAt = now()->addMinutes(1);

            DB::table('users')
                ->where('id', $userId)
                ->update(['last_seen' => now()]);

            Cache::put('user-is-online-' . $userId, true, $expiresAt);
            Cache::put('user-online-expiration-' . $userId, $expiresAt, $expiresAt);
        } else {
            foreach (Cache::get('user-is-online-*', []) as $key => $value) {
                Cache::forget($key);
            }
        }

        return $next($request);
    }
}
