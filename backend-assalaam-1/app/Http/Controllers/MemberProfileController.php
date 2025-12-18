<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Auth\VerifyEmailController;

class MemberProfileController extends Controller
{
    /**
     * Tampilkan profil user
     */
    public function show()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User belum login'
            ], 401);
        }

        // Ambil profil dari tabel user_profil (MySQL)
        $profil = DB::table('user_profil')
            ->where('MEMBER_ID', $user->member_id)
            ->first();

        if (!$profil) {
            return response()->json([
                'success' => false,
                'message' => 'Profil belum ditemukan, mungkin belum diaktifkan admin'
            ], 404);
        }

        $statusNikah = $profil->MEMBER_IS_MARRIED == 1 ? 'Menikah' : 'Lajang';
        $statusKewarganegeraan = $profil->MEMBER_IS_WNI == 1? 'WNI' : 'WNA';

        return response()->json([
            'success' => true,
            'data' => [
                'MEMBER_ID'             => $profil->MEMBER_ID,
                'MEMBER_NAME'           => $profil->MEMBER_NAME,
                'MEMBER_CARD_NO'        => $profil->MEMBER_CARD_NO,
                'MEMBER_DATE_OF_BIRTH'  => $profil->MEMBER_DATE_OF_BIRTH,
                'MEMBER_PLACE_OF_BIRTH' => $profil->MEMBER_PLACE_OF_BIRTH,
                'MEMBER_SEX'            => $profil->MEMBER_SEX,
                'MEMBER_IS_WNI'         => $statusKewarganegeraan,
                'MEMBER_KTP_NO'         => $profil->MEMBER_KTP_NO,
                'MEMBER_ADDRESS'        => $profil->MEMBER_ADDRESS,
                'MEMBER_RT'             => $profil->MEMBER_RT,
                'MEMBER_RW'             => $profil->MEMBER_RW,
                'MEMBER_KELURAHAN'      => $profil->MEMBER_KELURAHAN,
                'MEMBER_KECAMATAN'      => $profil->MEMBER_KECAMATAN,
                'MEMBER_IS_MARRIED'     => $statusNikah,
                'MEMBER_TELP'           => $profil->MEMBER_TELP,
                'MEMBER_KOTA'           => $profil->MEMBER_KOTA,
                'MEMBER_POST_CODE'      => $profil->MEMBER_POST_CODE,
                'MEMBER_NPWP'           => $profil->MEMBER_NPWP,
                'MEMBER_JML_TANGGUNGAN' => $profil->MEMBER_JML_TANGGUNGAN,
                'MEMBER_PENDAPATAN'     => $profil->MEMBER_PENDAPATAN,
                'EMAIL'                 => $user->email,
                'PROFILE_PHOTO'         => $user->profile_photo 
                    ? asset('storage/'.$user->profile_photo) 
                    : null,
            ]
        ]);
    }

    /**
     * Update field editable profil + push ke backend kedua
     */
   public function update(Request $request)
{
    $user = Auth::user();
    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'User belum login'
        ], 401);
    }

    // pastikan yang login CS
    if ($user->role !== 'cs') {
        return response()->json([
            'success' => false,
            'message' => 'Hanya CS yang bisa memperbarui profil member'
        ], 403);
    }

    // ambil MEMBER_ID target dari form
    $memberId = $request->input('MEMBER_ID');
    if (!$memberId) {
        return response()->json([
            'success' => false,
            'message' => 'MEMBER_ID wajib dikirim'
        ], 422);
    }

    // cari profil member yang mau diubah
    $profil = DB::table('user_profil')->where('MEMBER_ID', $memberId)->first();
    if (!$profil) {
        return response()->json([
            'success' => false,
            'message' => 'Profil member tidak ditemukan'
        ], 404);
    }

    // validasi field profil
    $validatedProfil = $request->validate([
        'MEMBER_ADDRESS'        => 'nullable|string|max:255',
        'MEMBER_TELP'           => 'nullable|string|max:20',
        'MEMBER_RT'             => 'nullable|integer',
        'MEMBER_RW'             => 'nullable|integer',
        'MEMBER_KTP_NO'         => 'nullable|string|max:30',
        'MEMBER_IS_WNI'         => 'nullable|integer|in:0,1',
        'MEMBER_KELURAHAN'      => 'nullable|string|max:50',
        'MEMBER_KECAMATAN'      => 'nullable|string|max:50',
        'MEMBER_IS_MARRIED'     => 'nullable|integer|in:0,1',
        'MEMBER_KOTA'           => 'nullable|string|max:50',
        'MEMBER_POST_CODE'      => 'nullable|integer',
        'MEMBER_NPWP'           => 'nullable|string|max:50',
        'MEMBER_JML_TANGGUNGAN' => 'nullable|integer',
        'MEMBER_PENDAPATAN'     => 'nullable|numeric',
    ]);

    // update ke user_profil
    DB::table('user_profil')
        ->where('MEMBER_ID', $memberId)
        ->update(array_merge($validatedProfil, [
            'DATE_MODIFY' => now(),
        ]));

  // update email ke tabel users (jika dikirim)
if ($request->has('USER_EMAIL')) {

    // Validasi format email
    $validatedEmail = $request->validate([
        'USER_EMAIL' => 'required|email|max:255',
    ]);

    $emailBaru = $validatedEmail['USER_EMAIL'];

    // Ambil user lama
    $targetUser = \App\Models\User::where('member_id', $memberId)->first();

    if (!$targetUser) {
        return response()->json([
            'success' => false,
            'message' => 'Akun user untuk member ini tidak ditemukan'
        ], 404);
    }

    $emailLama = $targetUser->email;

    /**
     * =====================================================
     * 🛑 CEK EMAIL DUPLIKAT
     * =====================================================
     */
    $emailExists = \App\Models\User::where('email', $emailBaru)
        ->where('member_id', '!=', $memberId)   // jangan hit email dirinya sendiri
        ->exists();

    if ($emailExists) {
        return response()->json([
            'success' => false,
            'message' => 'Email sudah digunakan oleh member lain.'
        ], 409);
    }

    /**
     * =====================================================
     * 🚀 EMAIL AMAN → PROSES UPDATE
     * =====================================================
     */
    if ($emailLama !== $emailBaru) {

        // reset verifikasi
        $targetUser->email = $emailBaru;
        $targetUser->email_verified_at = null;
        $targetUser->save();

        // Kirim OTP verifikasi baru
        $verifyEmail = new VerifyEmailController();
        return $verifyEmail->sendOtp(
            new Request(['email' => $targetUser->email])
        );
    }
}




    // sinkronisasi ke backend kedua (jika perlu)
    try {
        $token = $request->bearerToken();

        $payload = array_merge($validatedProfil, [
            'MEMBER_ID'   => $memberId,
            'USER_UPDATE' => $user->name,
            'USER_EMAIL'  => $request->input('USER_EMAIL'), // jika mau ikut sync
        ]);

        $backend2Url = env('BACKEND_2');
        $response = Http::withToken($token)
            ->put($backend2Url . '/api/member/update-profile', $payload);

        if ($response->failed()) {
            Log::warning('Gagal sinkron profil ke backend kedua', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
        }
    } catch (\Exception $e) {
        Log::error('Error saat push ke backend kedua', [
            'message' => $e->getMessage(),
        ]);
    }

    return response()->json([
        'success' => true,
        'message' => 'Profil member dan email berhasil diperbarui oleh CS',
    ]);
}

public function checkEmail(Request $request)
{
    $request->validate([
        'email' => 'nullable|email',
        'MEMBER_ID' => 'nullable'
    ]);

    $email = $request->email;
    $memberId = $request->MEMBER_ID;

    // Jika email kosong tidak usah cek
    if (!$email) {
        return response()->json(['exists' => false]);
    }

    $query = DB::table('users')->where('email', $email);

    if ($memberId) {
        // Pastikan bukan miliknya sendiri
        $query->where('member_id', '!=', $memberId);
    }

    $exists = $query->exists();

    return response()->json([
        'exists' => $exists
    ]);
}


    /**
     * Upload / update foto profil user (disimpan di tabel users)
     */
    public function uploadPhoto(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User belum login'
            ], 401);
        }

        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('photo')) {
            // hapus foto lama jika ada
            if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            // simpan foto baru
            $path = $request->file('photo')->store('profile', 'public');
            $user->profile_photo = $path;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Foto profil berhasil diperbarui',
                'photo_url' => asset('storage/'.$path)
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Tidak ada foto yang diupload'
        ], 400);
    }

    public function deletePhoto(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User belum login'
            ], 401);
        }

        if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        $user->profile_photo = null;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Foto profil berhasil dihapus'
        ]);
    }
}
