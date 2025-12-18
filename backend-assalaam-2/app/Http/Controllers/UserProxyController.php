<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserProxyController extends Controller
{
    public function show($id)
    {
        // Ambil user dari Backend 1 (MySQL)
        $user = UserService::getUserById($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan di Backend 1'
            ], 404);
        }

        // Ambil member dari SQL Server (Backend 2)
        $member = Member::find($user['member_id'] ?? null);

        return response()->json([
            'success' => true,
            'user'    => $user,
            'member'  => $member
        ]);
    }
}
