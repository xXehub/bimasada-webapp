import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Poppins', ...defaultTheme.fontFamily.sans],
                poppins: ['Poppins', 'sans-serif'],
            },
            colors: {
                // Bimasada Brand Colors
                primary: {
                    DEFAULT: '#2387C0', // Bimasada Blue
                    dark: '#02245B',    // Bimasada Navy
                    light: '#5BA3D0',
                },
                secondary: {
                    DEFAULT: '#858788', // Gray
                },
                success: '#28A745',     // Green
                danger: '#DC3545',      // Red
                warning: '#FFA500',     // Orange
            },
        },
    },

    plugins: [forms],
};
