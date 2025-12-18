<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    */
    'defaults' => [
        'guard' => null,
        'passwords' => null,
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    | Karena backend ini tidak pakai login berbasis User,
    | bagian guards bisa dikosongkan atau diisi nanti kalau
    | butuh auth khusus (misalnya admin/member).
    */
    'guards' => [
        'api' => [
            'driver' => 'jwt',
            'provider' => 'users',
        ],
        'admin' => [
            'driver' => 'jwt',
            'provider' => 'admins',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    | Kosongkan agar Laravel tidak lagi mencari tabel "users".
    */
    'providers' => [
        // contoh kalau nanti butuh provider khusus
        // 'admins' => [
        //     'driver' => 'eloquent',
        //     'model' => App\Models\Admin::class,
        //     'connection' => 'sqlsrv',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    | Tidak diperlukan karena tidak ada users.
    */
    'passwords' => [
        // kosong
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    */
    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
