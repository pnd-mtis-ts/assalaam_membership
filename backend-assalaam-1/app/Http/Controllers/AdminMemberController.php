<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserProfil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;


class AdminMemberController extends Controller
{
    /**
     * 🔹 Ambil semua data member (gabungan tabel users + user_profil)
     */


public function index(Request $request)
{
    $now = \Carbon\Carbon::now()->toDateString();
    $oneMonthLater = \Carbon\Carbon::now()->addMonth()->toDateString();

    $status = $request->query('status'); 
    $search = $request->query('q'); // ← TAMBAHAN

    $query = \DB::table('users')
        ->leftJoin('user_profil', 'users.member_id', '=', 'user_profil.MEMBER_ID')
        ->select(
            'users.id as USER_ID',
            'users.name as USER_NAME',
            'users.email as USER_EMAIL',
            'user_profil.MEMBER_ID',
            'user_profil.MEMBER_CARD_NO',
            'user_profil.MEMBER_NAME',
            'user_profil.MEMBER_ADDRESS',
            'user_profil.MEMBER_IS_ACTIVE',
            'user_profil.MEMBER_IS_VALID',
            'user_profil.MEMBER_ACTIVE_TO',
            'user_profil.MEMBER_KECAMATAN',
            'user_profil.MEMBER_KOTA',
            'user_profil.MEMBER_RT',
            'user_profil.MEMBER_RW',
            'user_profil.MEMBER_POST_CODE',
            \DB::raw("
                CASE
                    WHEN user_profil.MEMBER_ACTIVE_TO IS NOT NULL
                    AND user_profil.MEMBER_ACTIVE_TO BETWEEN '$now' AND '$oneMonthLater'
                    THEN 1 ELSE 0
                END AS WILL_EXPIRE_SOON
            ")
        )
        ->whereNotNull('user_profil.MEMBER_CARD_NO')
        ->orderBy('users.name', 'asc');

        // 🔹 Filter status
        if ($status === 'active') {
        $query->where('user_profil.MEMBER_IS_ACTIVE', 1);
        } elseif ($status === 'inactive') {
        $query->where('user_profil.MEMBER_IS_ACTIVE', 0);
        } elseif ($status === 'expiring') {
        $query->whereBetween('user_profil.MEMBER_ACTIVE_TO', [$now, $oneMonthLater]);
        } elseif ($status === 'expired') {
        $query->where('user_profil.MEMBER_ACTIVE_TO', '<', $now);
        }


    // 🔍 🔥 FILTER SEARCH (NO MEMBER, NAMA, ALAMAT)
    if (!empty($search)) {
        $query->where(function ($q2) use ($search) {
           $q2->where('user_profil.MEMBER_CARD_NO', 'like', "%$search%")
              ->orWhere('user_profil.MEMBER_NAME', 'like', "%$search%")
              ->orWhere('users.name', 'like', "%$search%")
              ->orWhere('users.email', 'like', "%$search%") // ← DITAMBAHKAN
              ->orWhere('user_profil.MEMBER_ADDRESS', 'like', "%$search%")
              ->orWhere('user_profil.MEMBER_KELURAHAN', 'like', "%$search%")
              ->orWhere('user_profil.MEMBER_KECAMATAN', 'like', "%$search%")
              ->orWhere('user_profil.MEMBER_KOTA', 'like', "%$search%")
              ->orWhere('user_profil.MEMBER_RT', 'like', "%$search%")
              ->orWhere('user_profil.MEMBER_RW', 'like', "%$search%")
              ->orWhere('user_profil.MEMBER_POST_CODE', 'like', "%$search%");





        });
    }

    // 🔹 Pagination
    $members = $query->paginate(10)->appends([
        'status' => $status,
        'q' => $search
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Daftar member berhasil diambil.',
        'data' => $members->items(),
        'pagination' => [
            'current_page' => $members->currentPage(),
            'last_page' => $members->lastPage(),
            'per_page' => $members->perPage(),
            'total' => $members->total(),
            'next_page_url' => $members->nextPageUrl(),
            'prev_page_url' => $members->previousPageUrl(),
        ],
    ]);
}

    /**
     * 🔹 Ambil detail member berdasarkan MEMBER_ID
     */
    public function show($id)
    {
        $member = \DB::table('users')
            ->join('user_profil', 'users.member_id', '=', 'user_profil.MEMBER_ID')
            ->where('user_profil.MEMBER_ID', $id)
            ->select(
                'users.id as USER_ID',
                'users.name as USER_NAME',
                'users.email as USER_EMAIL',
                'user_profil.*'
            )
            ->first();

        if (!$member) {
            return response()->json([
                'success' => false,
                'message' => 'Data member tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $member
        ]);
    }

  /**
     * Update status aktivasi member via MySQL + API ke backend kedua (SQL Server)
     */
public function updateActivation(Request $request, $id)
{
    $request->validate([
        'MEMBER_IS_ACTIVE' => 'required|integer',
    ]);

    try {
        // Ambil member dari MySQL
        $userProfil = UserProfil::on('mysql')->findOrFail($id);

        // Update flag aktif / nonaktif
        $userProfil->MEMBER_IS_ACTIVE = $request->MEMBER_IS_ACTIVE;
        $userProfil->save();

        // Payload ke backend 2 (SQL Server)
        $payload = [
            'MEMBER_ID'           => $userProfil->MEMBER_ID,
            'MEMBER_IS_ACTIVE'    => $userProfil->MEMBER_IS_ACTIVE,
            'MEMBER_ACTIVE_FROM'  => $userProfil->MEMBER_ACTIVE_FROM,  // tetap ikut
            'MEMBER_ACTIVE_TO'    => $userProfil->MEMBER_ACTIVE_TO,    // tetap ikut
        ];

        // Kirim ke backend 2
        $token = JWTAuth::getToken();
        $backend2Url = env('BACKEND_2');
        $response = Http::withToken($token)
            ->post($backend2Url . '/api/member/active', $payload);

        if ($response->failed()) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal update aktivasi member di backend kedua',
                'details' => json_decode($response->body(), true)
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => $userProfil->MEMBER_IS_ACTIVE == 1
                ? 'Member berhasil diaktifkan'
                : 'Member berhasil dinonaktifkan',
            'data' => [
                'user_profil' => $userProfil,
                'backend2'    => $response->json(),
            ],
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
        ], 500);
    }
}



   

    /**
 * 🔹 Perpanjang masa aktif member otomatis (+2 tahun) berdasarkan nomor kartu
 */
public function extendMembershipOnly(Request $request, $id)
{
    try {
        $userProfil = UserProfil::on('mysql')->findOrFail($id);

        $currentTo = Carbon::parse($userProfil->MEMBER_ACTIVE_TO);
        $today = Carbon::now();

        // Ambil bulan dan hari dari tanggal lama
        $month = $currentTo->month;
        $day   = $currentTo->day;

        // Tahun baru = tahun sekarang
        $newFrom = Carbon::create($today->year, $month, $day);

        // Jika tanggal baru lebih kecil dari hari ini, geser ke tahun berikutnya
        // if ($newFrom->lt($today)) {
        //     $newFrom->addYear();
        // }

        // Perpanjang 2 tahun dari newFrom
        $newTo = $newFrom->copy()->addYears(2);

        // Update database utama
        $userProfil->update([
            'MEMBER_IS_ACTIVE'   => 1,
            'MEMBER_ACTIVE_FROM' => $newFrom,
            'MEMBER_ACTIVE_TO'   => $newTo,
        ]);

        // Format untuk backend2
        $formattedFrom = $newFrom->format('Y-m-d H:i:s') . '.000';
        $formattedTo   = $newTo->format('Y-m-d H:i:s') . '.000';

        $payload = [
            'MEMBER_ID'           => $userProfil->MEMBER_ID,
            'MEMBER_IS_ACTIVE'    => 1,
            'MEMBER_ACTIVE_FROM'  => $formattedFrom,
            'MEMBER_ACTIVE_TO'    => $formattedTo,
        ];

        Log::info('🔄 Extend membership lewat API backend2', $payload);

        $token = JWTAuth::getToken();
        $backend2Url = env('BACKEND_2');

        $response = Http::withToken($token)
            ->post($backend2Url . '/api/member/active', $payload);

        if ($response->failed()) {
            Log::error('❌ Backend kedua gagal menerima extend membership', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Perpanjangan berhasil di backend utama, tapi gagal di backend kedua.',
                'details' => $response->body()
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Masa aktif member berhasil diperpanjang 2 tahun dari bulan & hari sebelumnya.',
            'data' => [
                'MEMBER_ACTIVE_FROM' => $newFrom,
                'MEMBER_ACTIVE_TO'   => $newTo,
                'backend2'           => $response->json(),
            ],
        ]);

    } catch (\Exception $e) {
        Log::error('💥 Error extendMembershipOnly: ' . $e->getMessage(), [
            'trace' => $e->getTraceAsString()
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
        ], 500);
    }
}



/**
 * 🔹 Ambil semua data user dari tabel users (bukan user_profil)
 * ✅ Mendukung pagination, filter verifikasi email, dan pencarian (optional)
 *
 * Query parameter:
 * - ?verified=1 → hanya yang sudah verifikasi email
 * - ?verified=0 → hanya yang belum verifikasi email
 * - ?q=keyword → cari berdasarkan nama atau email
 * - ?page=2 → pagination
 */
public function getAllUsers(Request $request)
{
    $verified = $request->query('verified');
    $search   = $request->query('q');

    // 🔹 Query dasar: hanya ambil role 'user'
    $query = \DB::table('users')
        ->select(
            'id',
            'member_id',
            'member_card_no',
            'name',
            'email',
            'role',
            'email_verified_at',
            'created_at',
            'updated_at'
        )
        ->where('role', 'user') // hanya tampilkan role user
        ->orderBy('created_at', 'desc');

    // 🔹 Filter status verifikasi
    if ($verified === '1') {
        $query->whereNotNull('email_verified_at');
    } elseif ($verified === '0') {
        $query->whereNull('email_verified_at');
    }

    // 🔹 Filter pencarian (nama atau email)
    if (!empty($search)) {
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%')
              ->orWhere('email', 'like', '%' . $search . '%');
        });
    }

    // 🔹 Pagination (default 10 data per halaman)
    $users = $query->paginate(10)->appends([
        'verified' => $verified,
        'q' => $search,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Data users berhasil diambil.',
        'data' => $users->items(),
        'pagination' => [
            'current_page' => $users->currentPage(),
            'last_page' => $users->lastPage(),
            'per_page' => $users->perPage(),
            'total' => $users->total(),
            'next_page_url' => $users->nextPageUrl(),
            'prev_page_url' => $users->previousPageUrl(),
        ],
    ]);
}
/**
 * 🔹 Ambil data user dengan role admin & cs
 * ✅ Pagination
 * ✅ Filter role: admin | cs | all
 * ✅ Search nama & email
 *
 * Query:
 * ?role=admin | cs | all
 * ?q=keyword
 * ?page=1
 */
public function getAdminAndCsUsers(Request $request)
{
    $role   = $request->query('role', 'all'); // default all
    $search = $request->query('q');

    $query = \DB::table('users')
        ->select(
            'id',
            'name',
            'email',
            'role',
            'email_verified_at',
            'created_at'
        )
        ->whereIn('role', ['admin', 'cs']) // 🔥 khusus admin & cs
        ->orderBy('created_at', 'desc');

    // 🔹 Filter role
    if ($role === 'admin') {
        $query->where('role', 'admin');
    } elseif ($role === 'cs') {
        $query->where('role', 'cs');
    }
    // role = all → tidak perlu filter tambahan

    // 🔹 Search
    if (!empty($search)) {
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%$search%")
              ->orWhere('email', 'like', "%$search%");
        });
    }

    // 🔹 Pagination
    $users = $query->paginate(10)->appends([
        'role' => $role,
        'q'    => $search,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Data admin & CS berhasil diambil.',
        'data' => $users->items(),
        'pagination' => [
            'current_page' => $users->currentPage(),
            'last_page'    => $users->lastPage(),
            'per_page'     => $users->perPage(),
            'total'        => $users->total(),
            'next_page_url'=> $users->nextPageUrl(),
            'prev_page_url'=> $users->previousPageUrl(),
        ],
    ]);
}


}
