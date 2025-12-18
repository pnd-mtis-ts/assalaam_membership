<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Transaksi;
use Carbon\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AdminDashboardController extends Controller
{
    public function index()
    {
        try {
            // Validasi token & ambil user
            $user = JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Token tidak valid atau sudah kadaluarsa',
            ], 401);
        }

        // 1. Jumlah member aktif
        $totalMembers = Member::count();

        // 2. Jumlah transaksi
        $totalTransactions = Transaksi::count();

        // 3. Chart member baru per bulan (12 bulan terakhir)
        $months = [];
        $memberPerMonth = [];

        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthLabel = $month->format('M Y');
            $months[] = $monthLabel;

            $count = Member::whereYear('MEMBER_REGISTERED_DATE', $month->year)
                ->whereMonth('MEMBER_REGISTERED_DATE', $month->month)
                ->count();

            $memberPerMonth[] = $count;
        }

        return response()->json([
            'success' => true,
            'data' => [
                'total_members'      => $totalMembers,
                'total_transactions' => $totalTransactions,
                'chart'              => [
                    'months'             => $months,
                    'members_registered' => $memberPerMonth,
                ],
            ],
        ]);
    }
}
