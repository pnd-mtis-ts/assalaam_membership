/** @type {import('tailwindcss').Config} */
export default {
    darkMode: "class",
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        // "./resources/**/*.jsx",
        // "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            animation: {
                fadeIn: "fadeIn 1s ease-in-out", // Tidak ada koma di akhir
            },
            keyframes: {
                // Harus ada koma sebelum "keyframes"
                fadeIn: {
                    "0%": {
                        opacity: 0,
                        transform: "scale(0.65) translateX(100%) ",
                    },
                    "100%": {
                        opacity: 1,
                        transform: "scale(1) translateX(0) rotate(0)",
                    },
                },
            },
        },
    },
    plugins: [require("daisyui")],
};
