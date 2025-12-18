<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerifyOtpMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class VerifyEmailController extends Controller
{
    /**
     * Mengirim OTP untuk verifikasi email
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return response()->json(['message' => 'Email tidak ditemukan'], 404);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email sudah terverifikasi'], 400);
        }

        // Generate OTP
        $otp = rand(100000, 999999);

        // Simpan OTP di cache (10 menit)
        Cache::put('otp_'.$user->email, $otp, now()->addMinutes(10));

        // Kirim email HTML
        Mail::to($user->email)->send(new VerifyOtpMail($user->email, $otp));

        return response()->json(['message' => 'OTP telah dikirim ke email']);
    }

    /**
     * Memverifikasi OTP
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp'   => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return response()->json(['message' => 'Email tidak ditemukan'], 404);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email sudah terverifikasi']);
        }

        $cachedOtp = Cache::get('otp_'.$user->email);

        if (! $cachedOtp) {
            return response()->json(['message' => 'Kode OTP tidak ditemukan atau sudah kadaluwarsa'], 400);
        }

        if ($cachedOtp != $request->otp) {
            return response()->json(['message' => 'Kode OTP salah'], 400);
        }

        // Verifikasi email
        $user->email_verified_at = now();
        $user->save();

        // Hapus OTP
        Cache::forget('otp_'.$user->email);

        return response()->json(['message' => 'Email berhasil diverifikasi']);
    }

    /**
     * Kirim ulang OTP baru
     */
    public function resendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return response()->json(['message' => 'Email tidak ditemukan'], 404);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email sudah terverifikasi'], 400);
        }

        // OTP baru
        $otp = rand(100000, 999999);

        // Simpan ulang di cache
        Cache::put('otp_'.$user->email, $otp, now()->addMinutes(10));

        // Kirim email HTML lagi
        Mail::to($user->email)->send(new VerifyOtpMail($user->email, $otp));

        return response()->json(['message' => 'OTP baru telah dikirim ke email']);
    }
}