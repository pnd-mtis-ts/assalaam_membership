<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class ApiTokenMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // ambil token dari header Authorization: Bearer ...
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // cek token + role CS/Admin
        $user = User::where('api_token', $token)
                    ->whereIn('role', ['cs', 'admin'])
                    ->first();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // simpan user ke request supaya bisa dipakai di route
        $request->merge(['user' => $user]);

        return $next($request);
    }
}
