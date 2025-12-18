<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdminOnly
{
    public function handle($request, Closure $next)
    {
        try {
            // parse token dari header Authorization: Bearer <token>
            $payload = JWTAuth::parseToken()->getPayload()->toArray();

            // cek role admin
            if (($payload['role'] ?? null) !== 'admin') {
                return response()->json(['error' => 'Forbidden'], 403);
            }

            // simpan payload di request supaya bisa dipakai di controller
            $request->attributes->set('jwt_payload', $payload);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized', 'message' => $e->getMessage()], 401);
        }

        return $next($request);
    }
}
