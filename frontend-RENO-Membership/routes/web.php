<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

// === Public Pages ===
Route::view('/', 'auth.beranda')->name('beranda');
Route::view('/beranda', 'auth.beranda');

// === Auth Pages ===
Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');
Route::view('/regcs', 'auth.new-regis')->name('regcs');

// === Promo Management Page ===
Route::view('/promocs', 'auth.promocs')->name('promoCS');
Route::view('/promoadmin', 'auth.promoadmin')->name('promoadmin');

// === Dashboard/User Pages ===
Route::view('/dashboard', 'auth.dashboard')->name('dashboard');
Route::view('/new-dashboard', 'auth.new_dashboard')->name('new-dashboard');
Route::view('/form', 'auth.form')->name('form');
Route::view('/formem', 'auth.form-member')->name('form-member');
Route::view('/dashboardCS', 'auth.dashboardCS')->name('dashboardCS');
Route::view('/form_ubah_poin', 'auth.form_ubah_poin')->name('form_ubah_poin');
Route::view('/form_ubah_poin_admin', 'auth.form_ubah_poin_admin')->name('form_ubah_poin_admin');



// === Admin Pages ===
Route::view('/table', 'auth.table')->name('table');
Route::view('/table-akun', 'auth.table_akun')->name('table-akun');
Route::view('/table-calon', 'auth.data_calon_member')->name('table-calon');
Route::view('/table-belumverif', 'auth.table_belumverified')->name('table-belumverif');

Route::view('/add', 'auth.adduser')->name('add-user');
Route::view('/new-regis', 'auth.new-regis')->name('new-regis');
Route::view('/infor', 'auth.information')->name('information');
Route::view('/cek', 'auth.cek')->name('cek');
Route::view('/tableadmin', 'auth.table_akun_admin')->name('table-admin');

// === Email Verification (Laravel default) ===
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill(); // verifikasi user
    return redirect()->route('login')->with('verified', true);
})->name('verification.verify');

Route::post('/email/resend', function (Request $request) {
    $request->user()?->sendEmailVerificationNotification();
    return back()->with('message', 'Link verifikasi baru sudah dikirim!');
})->name('verification.send');

Route::get('/logout', function () {
    Auth::logout();                         // Logout user
    request()->session()->invalidate();      // Hapus session
    request()->session()->regenerateToken(); // Regenerate CSRF token

    return redirect('/login');               // Redirect ke halaman login
})->name('logout');

// === Membership Form ===
Route::view('/form-member', 'auth.form-member')->name('membership.form');
Route::view('/adduser', 'auth.adduser')->name('adduser');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
