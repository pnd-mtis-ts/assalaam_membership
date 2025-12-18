<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class ServiceAuthController extends Controller
{
    public function login(Request $request)
    {
        $secretFromClient = $request->input('secret');

        // validasi secret
        if ($secretFromClient !== env('BACKEND_SHARED_SECRET')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized - Invalid Secret'
            ], 401);
        }

        // payload JWT
        $payload = [
            'iss' => 'backend2', // issuer
            'aud' => 'backend1', // audience
            'iat' => time(),     // issued at
            'exp' => time() + 3600, // expire 1 jam
        ];

        $jwt = JWT::encode($payload, env('JWT_SECRET'), 'HS256');

        return response()->json([
            'success' => true,
            'token' => $jwt
        ]);
    }
}
