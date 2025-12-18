<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;

class VerifyJwtToken
{
    public function handle($request, Closure $next)
    {
        try {
            // ambil payload dari token
            $payload = JWTAuth::parseToken()->getPayload();

            // inject payload ke request biar bisa dipakai controller
            $request->merge(['auth_user' => $payload->toArray()]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
