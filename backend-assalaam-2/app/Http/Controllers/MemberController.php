<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;


class MemberController extends Controller
{
    public function activate(Request $request)
    {
        $token = $request->bearerToken();

        if (!$token) {
            Log::error('Token JWT tidak ada di header Authorization');
            return response()->json([
                'success' => false,
                'message' => 'Token JWT tidak ada di header Authorization'
            ], 401);
        }

        try {
            $user = JWTAuth::setToken($token)->authenticate();
        } catch (\Exception $e) {
            Log::error('Token JWT tidak valid: '.$e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Token JWT tidak valid: ' . $e->getMessage()
            ], 401);
        }

        // Validasi input
        $validator = Validator::make($request->all(), [
            'MEMBER_ID'             => 'required|string',
            'MEMBER_NAME'           => 'required|string',
            'MEMBER_PLACE_OF_BIRTH' => 'nullable|string',
            'MEMBER_DATE_OF_BIRTH'  => 'nullable|date',
            'MEMBER_KTP_NO'         => 'nullable|string',
            'MEMBER_SEX'            => 'nullable|integer|in:0,1',
            'MEMBER_IS_WNI'         => 'nullable|integer|in:0,1',
            'MEMBER_RT'             => 'nullable|integer',
            'MEMBER_RW'             => 'nullable|integer',
            'MEMBER_KELURAHAN'      => 'nullable|string',
            'MEMBER_KECAMATAN'      => 'nullable|string',
            'MEMBER_KOTA'           => 'nullable|string',
            'MEMBER_POST_CODE'      => 'nullable|integer',
            'MEMBER_ADDRESS'        => 'nullable|string',
            'MEMBER_JML_TANGGUNGAN' => 'nullable|integer',
            'MEMBER_PENDAPATAN'     => 'nullable|numeric',
            'MEMBER_TELP'           => 'nullable|string',
            'MEMBER_NPWP'           => 'nullable|string',
        ]);

        if ($validator->fails()) {
            Log::error('Validasi gagal', $validator->errors()->toArray());
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();
        $tipeMember = $data['MEMBER_TYPE'] ?? 'PAS';

        try {
            // Generate nomor member
            $noMember = DB::connection('sqlsrv')
                ->selectOne("SELECT dbo.fn_nomember(?) as nomember", [$tipeMember]);
            Log::info('Hasil fn_nomember', ['result' => $noMember]);

            if (!$noMember || empty($noMember->nomember)) {
                Log::error('Gagal generate nomor member dari SQL Server');
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal generate nomor member dari SQL Server'
                ], 500);
            }

            $memberCardNo = $noMember->nomember;

            // Simpan ke SQL Server
            DB::connection('sqlsrv')->table('MEMBER')->updateOrInsert(
                ['MEMBER_ID' => $data['MEMBER_ID']],
                [
                    'MEMBER_CARD_NO'        => $memberCardNo,
                    'MEMBER_NAME'           => $data['MEMBER_NAME'],
                    'MEMBER_PLACE_OF_BIRTH' => $data['MEMBER_PLACE_OF_BIRTH'] ?? null,
                    'MEMBER_DATE_OF_BIRTH'  => $data['MEMBER_DATE_OF_BIRTH'] ?? null,
                    'MEMBER_KTP_NO'         => $data['MEMBER_KTP_NO'] ?? null,
                    'MEMBER_SEX'            => $data['MEMBER_SEX'] ?? null,
                    'MEMBER_IS_WNI'         => $data['MEMBER_IS_WNI'] ?? null,
                    'MEMBER_RT'             => $data['MEMBER_RT'] ?? null,
                    'MEMBER_RW'             => $data['MEMBER_RW'] ?? null,
                    'MEMBER_KELURAHAN'      => $data['MEMBER_KELURAHAN'] ?? null,
                    'MEMBER_KECAMATAN'      => $data['MEMBER_KECAMATAN'] ?? null,
                    'MEMBER_KOTA'           => $data['MEMBER_KOTA'] ?? null,
                    'MEMBER_POST_CODE'      => $data['MEMBER_POST_CODE'] ?? null,
                    'MEMBER_ADDRESS'        => $data['MEMBER_ADDRESS'] ?? null,
                    'MEMBER_JML_TANGGUNGAN' => $data['MEMBER_JML_TANGGUNGAN'] ?? 0,
                    'MEMBER_PENDAPATAN'     => $data['MEMBER_PENDAPATAN'] ?? 0,
                    'MEMBER_TELP'           => $data['MEMBER_TELP'] ?? null,
                    'MEMBER_NPWP'           => $data['MEMBER_NPWP'] ?? null,
                    'MEMBER_IS_VALID'       => 1,
                    'MEMBER_ACTIVE_FROM'    => now(),
                    'MEMBER_ACTIVE_TO'      => now()->addYear(),
                    'DATE_CREATE'           => now(),
                ]
            );
            Log::info('Berhasil insert/update MEMBER', ['MEMBER_ID' => $data['MEMBER_ID']]);

            return response()->json([
                'success'        => true,
                'message'        => 'Member berhasil diaktifkan di SQL Server',
                'member_card_no' => $memberCardNo,
                'MEMBER_TYPE'    => $tipeMember,
            ]);
        } catch (\Exception $e) {
            Log::error('Error SQL Server: '.$e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json([
                'success' => false,
                'message' => 'Error SQL Server: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function updateActivation(Request $request)
    {
        // Validasi input
        $request->validate([
            'MEMBER_ID'        => 'required',
            'MEMBER_IS_ACTIVE' => 'required|integer',
        ]);

        try {
            // Ambil payload
            $memberId       = $request->input('MEMBER_ID');
            $statusAktif    = $request->input('MEMBER_IS_ACTIVE');
            $activeFrom     = $request->input('MEMBER_ACTIVE_FROM');
            $activeTo       = $request->input('MEMBER_ACTIVE_TO');

            Log::info('Menerima update aktivasi dari backend pertama', [
                'MEMBER_ID' => $memberId,
                'MEMBER_IS_ACTIVE' => $statusAktif,
                'MEMBER_ACTIVE_FROM' => $activeFrom,
                'MEMBER_ACTIVE_TO' => $activeTo
            ]);

            // Update ke tabel MEMBER di SQL Server
            DB::connection('sqlsrv')->table('MEMBER')
                ->where('MEMBER_ID', $memberId)
                ->update([
                    'MEMBER_IS_ACTIVE'   => $statusAktif,
                    'MEMBER_ACTIVE_FROM' => $activeFrom ?? now(),
                    'MEMBER_ACTIVE_TO'   => $activeTo ?? now()->addYear(),
                    'DATE_MODIFY'        => now(),
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Status aktivasi member berhasil diupdate di SQL Server',
                'data' => [
                    'MEMBER_ID' => $memberId,
                    'MEMBER_IS_ACTIVE' => $statusAktif,
                    'MEMBER_ACTIVE_FROM' => $activeFrom,
                    'MEMBER_ACTIVE_TO' => $activeTo,
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Gagal update aktivasi di SQL Server: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal update aktivasi di SQL Server: ' . $e->getMessage()
            ], 500);
        }
    }

    public function check(Request $request)
{
    try {
        $cardNo = $request->input('card_no');

        // 🔹 catat setiap request masuk
        Log::info('Request check member', [
            'card_no' => $cardNo,
            'ip' => $request->ip(),
        ]);

        if (empty($cardNo)) {
            Log::warning('Nomor kartu tidak diisi oleh client', [
                'ip' => $request->ip(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Nomor kartu harus diisi.'
            ], 400);
        }

        // 🔹 Query ke SQL Server
        $member = DB::connection('sqlsrv')->table('MEMBER')
            ->where('MEMBER_CARD_NO', $cardNo)
            ->first();

        if (!$member) {
            Log::warning('Member tidak ditemukan', [
                'card_no' => $cardNo,
                'ip' => $request->ip(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Member tidak ditemukan.'
            ], 404);
        }

        // 🔹 Return JSON lengkap supaya backend1 bisa insert ke user_profil
        $data = [
            'MEMBER_ID'             => $member->MEMBER_ID,
            'MEMBER_CARD_NO'        => $member->MEMBER_CARD_NO,
            'MEMBER_NAME'           => $member->MEMBER_NAME,
            'MEMBER_PLACE_OF_BIRTH' => $member->MEMBER_PLACE_OF_BIRTH,
            'MEMBER_DATE_OF_BIRTH'  => $member->MEMBER_DATE_OF_BIRTH,
            'MEMBER_KTP_NO'         => $member->MEMBER_KTP_NO,
            'MEMBER_SEX'            => $member->MEMBER_SEX,
            'MEMBER_RT'             => $member->MEMBER_RT,
            'MEMBER_RW'             => $member->MEMBER_RW,
            'MEMBER_KELURAHAN'      => $member->MEMBER_KELURAHAN,
            'MEMBER_KECAMATAN'      => $member->MEMBER_KECAMATAN,
            'MEMBER_KOTA'           => $member->MEMBER_KOTA,
            'MEMBER_POST_CODE'      => $member->MEMBER_POST_CODE,
            'MEMBER_ADDRESS'        => $member->MEMBER_ADDRESS,
            'MEMBER_JML_TANGGUNGAN' => $member->MEMBER_JML_TANGGUNGAN,
            'MEMBER_PENDAPATAN'     => $member->MEMBER_PENDAPATAN,
            'MEMBER_TELP'           => $member->MEMBER_TELP,
            'MEMBER_NPWP'           => $member->MEMBER_NPWP,
            'MEMBER_IS_MARRIED'     => $member->MEMBER_IS_MARRIED,
            'MEMBER_IS_WNI'         => $member->MEMBER_IS_WNI,
            'REF$AGAMA_ID'          => $member->{'REF$AGAMA_ID'},
            'MEMBER_IS_VALID'       => $member->MEMBER_IS_VALID,
            'MEMBER_ACTIVE_FROM'    => $member->MEMBER_ACTIVE_FROM,
            'MEMBER_ACTIVE_TO'      => $member->MEMBER_ACTIVE_TO,
            'MEMBER_KUPON'          => $member->MEMBER_KUPON
        ];

        Log::info('Member ditemukan', [
            'card_no' => $cardNo,
            'member_id' => $member->MEMBER_ID,
            'ip' => $request->ip(),
        ]);

        return response()->json([
            'success' => true,
            'data' => $data
        ]);

    } catch (\Throwable $e) {
        // 🔹 tangkap error & log
        Log::error('Error saat check member', [
            'card_no' => $request->input('card_no'),
            'error_message' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'ip' => $request->ip(),
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan saat mengambil data member.',
            'error' => $e->getMessage()
        ], 500);
    }
}

public function getMemberTransactions($memberId)
{
    try {
        $transactions = DB::connection('sqlsrv')
            ->table('TRANSAKSI')
            ->where('MEMBER_ID', $memberId)
            ->orderBy('TRANS_DATE', 'desc')
            ->get();

        return response()->json($transactions);
    } catch (\Exception $e) {
        return response()->json([
            'error' => true,
            'message' => $e->getMessage(),
        ], 500);
    }
}
}
