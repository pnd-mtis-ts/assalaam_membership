<?php

use Illuminate\Support\Facades\Config;

if (!function_exists('api_url')) {
    /**
     * Helper untuk mengambil base URL API dari konfigurasi.
     *
     * @param string|null $path Tambahkan path opsional, misal '/api/admin/register-cs'
     * @return string
     */
    function api_url(string $path = null): string
    {
        $base = rtrim(Config::get('services.api.base_url'), '/');
        $path = $path ? '/' . ltrim($path, '/') : '';
        return $base . $path;
    }
}
