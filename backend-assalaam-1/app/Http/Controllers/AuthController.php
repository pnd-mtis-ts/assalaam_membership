<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\UserProfil;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
public function register(Request $request)
{
    try {
        $validated = $request->validate([
            'member_card_no' => 'nullable|string',
            'date_of_birth'  => 'nullable|date|before:today',
            'email'          => 'required|string|email|max:255',
            'password'       => 'required|string|min:8',
            'name'           => 'nullable|string|max:255',
            'profile_photo'  => 'nullable|image|mimes:jpeg,png,jpg|max:5120', // max 5MB
        ]);

        if (User::where('email', $validated['email'])->exists()) {
            return response()->json([
                'errors' => ['email' => ['Email ini sudah terdaftar. Gunakan email lain.']]
            ], 422);
        }

        $memberId     = null;
        $memberCardNo = null;
        $name         = $validated['name'] ?? null;
        $dob          = $validated['date_of_birth'] ?? null;

        if (!empty($validated['member_card_no'])) {
            if (empty($validated['date_of_birth'])) {
                return response()->json([
                    'errors' => ['date_of_birth' => ['Tanggal lahir wajib diisi jika menggunakan member card.']]
                ], 422);
            }

            $inputDob = Carbon::parse($validated['date_of_birth'])->format('Y-m-d');

            // cek profil lokal
            $existingProfil = UserProfil::where('MEMBER_CARD_NO', $validated['member_card_no'])->first();

            if ($existingProfil) {
                $profileDob = !empty($existingProfil->MEMBER_DATE_OF_BIRTH)
                    ? Carbon::parse($existingProfil->MEMBER_DATE_OF_BIRTH)->format('Y-m-d')
                    : null;

                if ($profileDob && $profileDob !== $inputDob) {
                    return response()->json([
                        'errors' => ['date_of_birth' => ['Tanggal lahir tidak sesuai dengan data member lokal.']]
                    ], 422);
                }

                if (User::where('member_id', $existingProfil->MEMBER_ID)->exists()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Member ini sudah memiliki akun.',
                    ], 409);
                }

                $existingProfil->update(['MEMBER_IS_ACTIVE' => 1]);

                $memberId     = $existingProfil->MEMBER_ID;
                $memberCardNo = $existingProfil->MEMBER_CARD_NO;
                $name         = $existingProfil->MEMBER_NAME;
                $dob          = $existingProfil->MEMBER_DATE_OF_BIRTH;

            } else {
                // ambil dari backend2
                $backend2Url = env('BACKEND_2');
                $response = Http::post($backend2Url . '/api/member/check', [
                    'card_no' => $validated['member_card_no'],
                ]);

                $body = $response->json();
                $member = $body['data'] ?? null;

                if (!$member || empty($member['MEMBER_ID'])) {
                    return response()->json([
                        'errors' => ['member_card_no' => ['Nomor member card tidak ditemukan.']]
                    ], 422);
                }

                $memberDob = !empty($member['MEMBER_DATE_OF_BIRTH'])
                    ? Carbon::parse($member['MEMBER_DATE_OF_BIRTH'])->format('Y-m-d')
                    : null;

                if ($memberDob && $memberDob !== $inputDob) {
                    return response()->json([
                        'errors' => ['date_of_birth' => ['Tanggal lahir tidak sesuai dengan data member.']]
                    ], 422);
                }

                if (User::where('member_id', $member['MEMBER_ID'])->exists()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Member ini sudah memiliki akun.',
                    ], 409);
                }

                // sanitize semua field sebelum insert
                $profilData = [];
                $numericColumns = [
                    'MEMBER_JML_TANGGUNGAN','MEMBER_PENDAPATAN',
                    'MEMBER_TOP','MEMBER_PLAFON','MEMBER_LEAD_TIME','MEMBER_POIN'
                ];
                $dateColumns = ['MEMBER_DATE_OF_BIRTH','MEMBER_REGISTERED_DATE','MEMBER_ACTIVE_FROM','MEMBER_ACTIVE_TO','DATE_CREATE','DATE_MODIFY'];

                foreach ($member as $key => $value) {
                    if (in_array($key, $numericColumns)) {
                        $profilData[$key] = is_numeric($value) ? $value : 0;
                    } elseif (in_array($key, $dateColumns)) {
                        $profilData[$key] = !empty($value) ? $value : null;
                    } else {
                        $profilData[$key] = !empty($value) ? $value : null;
                    }
                }

                // field wajib lokal
                $profilData['MEMBER_CARD_NO'] = $validated['member_card_no'];
                $profilData['MEMBER_IS_ACTIVE'] = 1;
                $profilData['DATE_CREATE'] = now();
                $profilData['USER_CREATE'] = 'web'; // otomatis web

                UserProfil::create($profilData);

                $memberId     = $member['MEMBER_ID'];
                $memberCardNo = $validated['member_card_no'];
                $name         = $member['MEMBER_NAME'] ?? $validated['email'];
                $dob          = $member['MEMBER_DATE_OF_BIRTH'];
            }
        }

        // buat user
        $user = User::create([
            'name'           => $name ?? $validated['email'],
            'email'          => $validated['email'],
            'password'       => Hash::make($validated['password']),
            'role'           => 'user',
            'member_id'      => $memberId,
            'member_card_no' => $memberCardNo,
        ]);

        // 🔹 Upload & compress foto profil tanpa menghapus logika sebelumnya
 // 🔹 Upload foto profil tanpa compress otomatis
if ($request->hasFile('profile_photo')) {
    $photo = $request->file('profile_photo');

    // Simpan langsung ke storage
    $filename = 'profile_' . $user->id . '.' . $photo->getClientOriginalExtension();
    $path = $photo->storeAs('profile_photos', $filename, 'public');

    // Update path ke user
    $user->profile_photo = $path;
    $user->save();
}


        // kirim OTP
        app(\App\Http\Controllers\Auth\VerifyEmailController::class)
            ->sendOtp(new Request(['email' => $user->email]));

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil. OTP telah dikirim.',
            'user'    => $user,
            'token'   => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
        ]);

    } catch (\Throwable $e) {
        Log::error('Register error', [
            'message' => $e->getMessage(),
            'trace'   => $e->getTraceAsString(),
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan saat registrasi.',
            'error'   => $e->getMessage(),
        ], 500);
    }
}


    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $userExists = \App\Models\User::where('email', $credentials['email'])->exists();
        if (!$userExists) {
            return response()->json([
                'success' => false,
                'message' => 'Email tersebut belum terdaftar.',
            ], 404);
        }

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah.',
            ], 401);
        }

        $user = auth('api')->user();
       
        $user->save();

        // 🔹 Broadcast status online
        event(new \App\Events\AdminStatusUpdated($user));

        $isMember = !empty($user->member_id);
        $memberData = null;

        if ($isMember) {
            $memberData = UserProfil::find($user->member_id);
        }

        $response = [
            'success'      => true,
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => null,
            'role'         => $user->role,
            'user'         => $user,
            'is_member'    => $isMember,
            'member'       => $memberData,
        ];

        return response()->json($response);
    }


    /**
     * Ambil user yang sedang login
     */
    public function me()
    {
        $user = auth('api')->user();

        $memberData = null;
        if (!empty($user->member_id)) {
            $memberData = UserProfil::find($user->member_id);
        }

        return response()->json([
            'user'      => $user,
            'is_member' => !empty($user->member_id),
            'member'    => $memberData,
        ]);
    }

    /**
     * Logout user
     */
    public function logout()
    {
        $user = auth('api')->user();

        if ($user) {
            // Kosongkan last_seen_at
            $user->last_seen_at = null;

            // Paksa save dan cek hasil
            if (!$user->save()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal update status logout.'
                ], 500);
            }

            // Broadcast status offline
            event(new \App\Events\AdminStatusUpdated($user));
        }

        // Logout JWT setelah last_seen_at sudah tersimpan
        auth('api')->logout();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil logout.'
        ]);
    }



    /**
     * Refresh token
     */
    public function refresh()
    {
        try {
            $newToken = JWTAuth::refresh(JWTAuth::getToken());

            return response()->json([
                'success'      => true,
                'access_token' => $newToken,
                'token_type'   => 'bearer',
                'expires_in'   => JWTAuth::factory()->getTTL() * 60,
            ]);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json([
                'success' => false,
                'error'   => 'Token tidak valid atau sudah kadaluarsa.'
            ], 401);
        }
    }

    public function resendVerification(Request $request)
{
    try {
        $user = auth('api')->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada user yang login.',
            ], 401);
        }

        if ($user->email_verified_at) {
            return response()->json([
                'success' => false,
                'message' => 'Email sudah terverifikasi.',
            ], 400);
        }

        // Kirim ulang email verifikasi
        $user->sendEmailVerificationNotification();

        return response()->json([
            'success' => true,
            'message' => 'Email verifikasi telah dikirim ulang. Silakan cek kotak masuk Anda.',
        ], 200);
    } catch (\Throwable $e) {
        \Log::error('Gagal resend verifikasi', ['error' => $e->getMessage()]);
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan saat mengirim ulang email verifikasi.',
            'error'   => $e->getMessage(),
        ], 500);
    }
}
    public function regcs(Request $request)
    {
        try {
            // 🔐 Pastikan hanya admin & cs
            $authUser = auth('api')->user();
            if (!in_array($authUser->role, ['admin', 'cs'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized.'
                ], 403);
            }

            // ✅ Validasi input
            $validated = $request->validate([
                'name'                  => 'required|string|max:255',
                'email'                 => 'required|email|unique:users,email',
                'role'                  => 'required|in:admin,cs',
                'password'              => 'required|string|min:8|confirmed',
                'password_confirmation' => 'required|string|min:8',
            ]);

            // 🧑‍💼 Buat user
            $user = User::create([
                'name'     => $validated['name'],
                'email'    => $validated['email'],
                'role'     => $validated['role'],
                'password' => Hash::make($validated['password']),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'User berhasil ditambahkan.',
                'user'    => $user
            ], 201);

        } catch (\Throwable $e) {
            Log::error('Tambah user error', [
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan user.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
