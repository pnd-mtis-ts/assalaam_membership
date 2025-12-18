<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function getAllTransactions()
    {
        try {
            // Ambil user yang login
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'error' => true,
                    'message' => 'User tidak terautentikasi',
                ], 401);
            }

            if (!$user->member_id || !$user->member) {
                return response()->json([
                    'transactions' => [],
                    'message' => 'User belum menjadi member',
                ], 200);
            }

            $member = $user->member;

            // Ambil semua transaksi milik member
            $transactionsRaw = $member->transaksi()
                ->orderBy('TRANS_DATE', 'desc')
                ->get();

            $transactions = $transactionsRaw->map(function ($trx) {
                // Ambil kolom langsung dari attributes untuk menghindari masalah case
                $attributes = $trx->getAttributes();

                return [
                    'id'     => $attributes['TRANS_NO'] ?? null,
                    'date'   => isset($attributes['TRANS_DATE']) ? Carbon::parse($attributes['TRANS_DATE'])->format('d-m-Y') : null,
                    'amount' => $attributes['TRANS_TOTAL_TRANSACTION'] ?? $attributes['TRANS_TOTAL_BAYAR'] ?? 0,
                    'point'  => $attributes['trans_poin_member'] ?? 0,
                    'coupon' => $attributes['TRANS_KUPON_UNDIAN'] ?? 0, // ambil dari kolom asli
                ];
            });

            return response()->json([
                'transactions'    => $transactions,
                'total_transaksi' => $transactions->count(),
                'total_poin'      => $transactions->sum('point'),
                'total_kupon'     => $transactions->sum('coupon'),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error'   => true,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
