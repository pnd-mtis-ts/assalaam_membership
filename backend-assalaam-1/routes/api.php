<?php

use App\Http\Controllers\AdminChatController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AddUserController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminMemberController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CardMemberController;
use App\Http\Controllers\AdminGuestController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\MemberProfileController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\UserChatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\VerifyEmailController;


// ===== AUTH ROUTES =====
Route::group(['prefix' => 'auth', 'middleware' => 'api'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('resend-verification', [AuthController::class, 'resendVerification']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('me', [AuthController::class, 'me']);
    Route::post('forgot-password', [ForgotPasswordController::class, 'resetByMember']);

    // ===== CS CREATE USER + MEMBER =====
    
        Route::post('cs/add-user-member', [AddUserController::class, 'register']);

});

// ====== MEMBER ROUTES ======
Route::group([
    'middleware' => ['api', 'auth:api'],
    'prefix' => 'auth',
], function () {
    Route::get('/dashboard', [UserDashboardController::class, 'getDashboard']);
    Route::get('/semua', [UserDashboardController::class, 'getSemuanya']);
    Route::get('/transaction', [UserDashboardController::class, 'getAllTransactions']);
    Route::get('/barcode', [UserDashboardController::class, 'barcodeMember']);
     Route::get('/qr', [UserDashboardController::class, 'qrMember']);
     Route::get('/auth/kartu-pas', [UserDashboardController::class, 'kartuPasMember'])->middleware('auth:api');
    Route::post('/change-password', [ForgotPasswordController::class, 'changePassword']);
    
});


Route::group([
    'middleware' => ['api'],
    'prefix' => 'email',
], function () {
   
    Route::post('/send-otp', [VerifyEmailController::class, 'sendOtp']);
    Route::post('/verify-otp', [VerifyEmailController::class, 'verifyOtp']);
    Route::post('/resend-otp', [VerifyEmailController::class, 'resendOtp']);
    
});

// ====== MEMBER MANAGEMENT ======
Route::group([
    'middleware' => ['api', 'auth:api'],
    'prefix' => 'member',
], function () {
    Route::get('/profile', [CardMemberController::class, 'profile']);
    Route::post('/register-profil', [CardMemberController::class, 'registerOrUpdate']);
    Route::patch('/status', [CardMemberController::class, 'updateStatus']);
    Route::delete('/delete', [CardMemberController::class, 'delete']);
    Route::get('/profile-member', [MemberProfileController::class, 'show']);
    Route::put('/profile-update', [MemberProfileController::class, 'update']);
    Route::post('/profile-photo', [MemberProfileController::class, 'uploadPhoto']);
    Route::post('/check-email', [MemberProfileController::class, 'checkEmail']);
    Route::post('/profile-photo/delete', [MemberProfileController::class, 'deletePhoto']);
});

// ====== ADMIN ROUTES ======
Route::group([
    'middleware' => ['api', 'auth:api'],
    'prefix' => 'admin',
], function () {
    Route::post('/register-cs', [AuthController::class, 'regcs']);

    Route::get('/card-members', [AdminMemberController::class, 'index']);
    Route::get('/card-members/{id}', [AdminMemberController::class, 'show']);
    Route::post('/card-members/{id}/activation', [AdminMemberController::class, 'updateActivation']);
    Route::post('/card-members/{id}/validation', [AdminMemberController::class, 'updateValidation']);

    Route::post('/card-members/extend/{id}', [AdminMemberController::class, 'extendMembershipOnly']);
    Route::get('/all-users', [AdminMemberController::class, 'getAllUsers']);
    Route::get('/transaksi', [TransaksiController::class, 'index']);
    Route::get('/transaksi/{transNo}', [TransaksiController::class, 'show']);
        // 🔥🔥🔥 TAMBAHAN DI SINI
    // List user ADMIN & CS
    // Filter: ?role=admin | cs | all
    // Search: ?q=keyword
    Route::get('/users-admin-cs', [AdminMemberController::class, 'getAdminAndCsUsers']);
    // 🔥🔥🔥


    Route::get('/dashboard', [AdminDashboardController::class, 'getDashboardSummary']);
    Route::get('/card-guest', [AdminGuestController::class, 'index']);
    Route::get('/card-guest/{id}', [AdminGuestController::class, 'show']);
    Route::post('/card-guest/{id}/activate', [AdminGuestController::class, 'activate']);
    Route::post('/card-guest/{id}/update-card', [AdminGuestController::class, 'updateCardNo']);
    Route::post('/activated-callback', [AdminGuestController::class, 'activatedCallback']);

    Route::get('/card-admin', [AdminController::class, 'index']);

    Route::get('/promo', [PromoController::class, 'index']);
    Route::post('/promo-save', [PromoController::class, 'store']);
    Route::delete('/promo/{id}', [PromoController::class, 'destroy']);
});


// ====== GUEST ROUTES ======

Route::group([
    'middleware' => ['api', 'auth:api'],
    'prefix' => 'guest',
], function () {

    Route::get('/create', [GuestController::class, 'create'])->name('guest.create'); 
    Route::post('/send', [GuestController::class, 'store'])->name('guest.store'); 
    Route::get('/waiting-approval',[GuestController::class, 'waitingApproval'])->name('waitingApproval');
    Route::get('/me',[AdminGuestController::class, 'me'])->name('me');
});

// ====== USER CHAT ROUTES ======
Route::group([
    'middleware' => ['api', 'auth:api'],
    'prefix' => 'message',
], function () {
    Route::get('/chats', [UserChatController::class, 'getMessages']);
    Route::get('/chats-admin', [UserChatController::class, 'getAdminMessages']);
    Route::post('/chats-send', [UserChatController::class, 'sendMessage']);

    Route::get('/admin-user', [AdminChatController::class, 'getUsers']);
    Route::get('/chats/{userId}', [AdminChatController::class, 'getMessages']);
    Route::post('/chats/{userId}', [AdminChatController::class, 'sendMessage']);


});
Route::post('/member/check-email-add', [AddUserController::class, 'checkEmailAdd']);
Route::post('/member/check-nik', [AddUserController::class, 'checkNIK']);
    Route::get('/minimal-poin', function() {
        $minimalPoin = DB::table('settings')->where('key','minimal_poin')->value('value');
        return response()->json(['minimal_poin'=> (int)$minimalPoin]);
    });
Route::group(['middleware' => ['auth:api']], function() {


    Route::post('/minimal-poin/update', function(Illuminate\Http\Request $request) {
        $request->validate(['minimal_poin'=>'required|integer|min:0']);
        DB::table('settings')->updateOrInsert(
            ['key'=>'minimal_poin'],
            ['value'=>$request->minimal_poin,'updated_at'=>now()]
        );
        return response()->json(['message'=>'Minimal poin berhasil diupdate']);
    });
});




