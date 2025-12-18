<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class UserService
{
    public static function getUserById($id)
    {
        $response = Http::get(env('BACKEND1_URL') . "/users/{$id}");

        if ($response->successful()) {
            return $response->json()['data'] ?? null;
        }

        return null;
    }
}
