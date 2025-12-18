<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\User;
use App\Models\UserProfil;
use App\Models\Guest;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;


class AddUserController extends Controller
{
    protected $agamaUUIDMapping = [
        1 => '88923FFE-166A-4FDE-B135-2EF51112FCB0', // Islam
        2 => '860CD318-D524-4D75-85FC-CD6E8BAE4638', // Kristen
        3 => '98130F4C-C047-4471-84B0-5B580C9161C5', // Katolik
        4 => 'EAD4927B-66D5-4F5B-8162-4E4F1C47CCB4', // Budha
        5 => '5FA1757F-8D0E-4D2B-9C87-B8BC003896C7', // Hindu
        6 => 'C2B5D790-095E-48E9-8AF7-86A275F86E2A', // Kong Hu Cu
        7 => 'EAD2F256-091F-417B-B9F6-BD4170205922', // Lain-lain
    ];

public function register(Request $request)
{
    Log::info('📩 Request diterima untuk register user:', $request->all());

    try {

        // ================================
        // 1. Validasi Manual Duplikasi
        // ================================
        $humanErrors = [];

        $nik = $request->MEMBER_KTP_NO;

        $nikExistsInGuest  = Guest::where('MEMBER_KTP_NO', $nik)->exists();
        $nikExistsInProfil = UserProfil::where('MEMBER_KTP_NO', $nik)->exists();

        if ($nikExistsInGuest || $nikExistsInProfil) {
            $humanErrors['nik'] = ['NIK sudah terdaftar dalam sistem'];
        }

        if (User::where('email', $request->email)->exists()) {
            $humanErrors['email'] = ['Email sudah digunakan oleh akun lain'];
        }

        if (!empty($humanErrors)) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $humanErrors
            ], 422);
        }


        // ================================
        // 2. Validasi Laravel
        // ================================
        try {
            $request->validate([
                'MEMBER_NAME'           => 'required|string|max:50',
                'MEMBER_DATE_OF_BIRTH'  => 'required|date',
                'MEMBER_KTP_NO'         => 'required|digits:16',
                'MEMBER_ADDRESS'        => 'required|string|max:255',
                'MEMBER_TELP'           => 'required|string|max:20',
                'REF$AGAMA_ID'          => 'required|in:1,2,3,4,5,6,7',

                'email'                 => 'required|email',
                'password'              => 'required|string|min:6',

            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {

            $errors = [];
            foreach ($e->errors() as $field => $messages) {
                $errors[$this->humanField($field)] = $messages;
            }

            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $errors
            ], 422);
        }


        // ================================
        // 3. Mapping Agama UUID
        // ================================
        $agamaId   = (int) $request->input('REF$AGAMA_ID');
        $agamaUUID = $this->agamaUUIDMapping[$agamaId] ?? null;

        if (!$agamaUUID) {
            return response()->json([
                'success' => false,
                'message' => 'Agama tidak valid',
            ], 422);
        }


        // ================================
        // 4. Simpan Member
        // ================================
        try {
            $member = Guest::create([
                'MEMBER_ID'             => (string) Str::uuid(),
                'MEMBER_NAME'           => $request->MEMBER_NAME,
                'MEMBER_PLACE_OF_BIRTH' => $request->MEMBER_PLACE_OF_BIRTH,
                'MEMBER_DATE_OF_BIRTH'  => $request->MEMBER_DATE_OF_BIRTH,
                'MEMBER_KTP_NO'         => $request->MEMBER_KTP_NO,
                'MEMBER_SEX'            => $request->MEMBER_SEX,
                'MEMBER_ADDRESS'        => $request->MEMBER_ADDRESS,
                'MEMBER_KELURAHAN'      => $request->MEMBER_KELURAHAN,
                'MEMBER_POST_CODE'      => $request->MEMBER_POST_CODE,
                'MEMBER_KECAMATAN'      => $request->MEMBER_KECAMATAN,
                'MEMBER_KOTA'           => $request->MEMBER_KOTA,
                'MEMBER_RT'             => $request->MEMBER_RT,
                'MEMBER_RW'             => $request->MEMBER_RW,
                'MEMBER_TELP'           => $request->MEMBER_TELP,
                'MEMBER_JML_TANGGUNGAN' => $request->MEMBER_JML_TANGGUNGAN,
                'MEMBER_PENDAPATAN'     => $request->MEMBER_PENDAPATAN,
                'MEMBER_NPWP'           => $request->MEMBER_NPWP,
                'MEMBER_IS_MARRIED'     => $request->MEMBER_IS_MARRIED,
                'MEMBER_IS_WNI'         => $request->MEMBER_IS_WNI,
                'REF$AGAMA_ID'          => $agamaUUID,
                'DATE_CREATE'           => now(),
                'MEMBER_IS_ACTIVE'      => $request->input('is_active', 0),
                'MEMBER_ACTIVE_FROM'    => $request->input('active_from'),
                'MEMBER_ACTIVE_TO'      => $request->input('active_to'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data member',
            ], 500);
        }


        // ================================
        // 5. Simpan User
        // ================================
        try {
            $user = User::create([
                'name'      => $member->MEMBER_NAME,
                'email'     => $request->email,
                'password'  => bcrypt($request->password),
                'member_id' => $member->MEMBER_ID
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data user',
            ], 500);
        }


        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil. User dan Member berhasil dibuat.',
            'data'    => [
                'user'   => $user,
                'member' => $member
            ]
        ], 201);

    } catch (\Exception $e) {

        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan pada proses registrasi',
        ], 500);
    }
}


/**
 * Mapping nama field database → bahasa manusia
 */
private function humanField($field)
{
    return [
        'MEMBER_NAME'          => 'Nama lengkap',
        'MEMBER_DATE_OF_BIRTH' => 'Tanggal lahir',
        'MEMBER_KTP_NO'        => 'NIK',
        'MEMBER_ADDRESS'       => 'Alamat',
        'MEMBER_TELP'          => 'Nomor HP',
        'REF$AGAMA_ID'         => 'Agama',
        'email'                => 'Email',
        'password'             => 'Password',
    ][$field] ?? $field;
}


    public function checkEmailAdd(Request $request)
{
    $request->validate([
        'email' => 'required|email'
    ]);

    $exists = User::where('email', $request->email)->exists();

    return response()->json([
        'exists' => $exists
    ]);
}
public function checkNIK(Request $request)
{
    $request->validate([
        'nik' => 'required|digits:16'
    ]);

    $nik = $request->nik;

    $existsInGuest = Guest::where('MEMBER_KTP_NO', $nik)->exists();
    $existsInProfil = UserProfil::where('MEMBER_KTP_NO', $nik)->exists();

    $exists = $existsInGuest || $existsInProfil;

    return response()->json([
        'exists' => $exists,
        'message' => $exists ? 'NIK sudah terdaftar.' : 'NIK tersedia.'
    ]);
}



}
