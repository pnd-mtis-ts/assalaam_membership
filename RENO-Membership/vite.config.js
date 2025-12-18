import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    // server: {
    //     host: true, // WAJIB supaya HP bisa akses
    //     hmr: {
    //         host: '192.168.51.239', // ganti sesuai IP komputer kamu
    //         protocol: 'ws'
    //     }
    // },
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
