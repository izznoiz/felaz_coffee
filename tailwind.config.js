import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                'sans': ['Montserrat', 'sans-serif'], // Untuk teks umum
                'serif': ['Playfair Display', 'serif'], // Untuk judul atau highlight
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },

            colors: {
                // Contoh menambahkan custom warna, misal untuk aksen kopi
                'coffee-dark': '#4A2C2A', // Cokelat gelap
                'coffee-medium': '#7B3F00', // Cokelat sedang (lebih ke oranye/merah)
                'coffee-light': '#D2B48C', // Krem kopi
                'latte-cream': '#F5F5DC', // Warna krim muda
                'warm-gray': '#D4D4D4', // Tambahan: abu-abu hangat untuk border input
                'light-coffee-text': '#B38E7E', // Tambahan: warna teks agak terang
                'amber-600': '#D97706', // Warna amber yang sudah ada, tapi definisikan eksplisit jika perlu
            }
        },
    },

    plugins: [forms, typography],
};
