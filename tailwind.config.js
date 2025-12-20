import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class', // Enable dark mode with class strategy
    
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
                    50: '#E8F4FA',
                    100: '#D1E9F5',
                    200: '#A3D3EB',
                    300: '#75BDE1',
                    400: '#47A7D7',
                    500: '#2387C0',
                    600: '#1C6C9A',
                    700: '#155173',
                    800: '#0E364D',
                    900: '#071B26',
                },
                secondary: {
                    DEFAULT: '#858788',
                    50: '#F5F5F5',
                    100: '#EBEBEB',
                    200: '#D6D7D7',
                    300: '#C2C3C3',
                    400: '#ADAFAF',
                    500: '#858788',
                    600: '#6A6C6D',
                    700: '#505152',
                    800: '#353636',
                    900: '#1B1B1B',
                },
                // Dark mode specific colors
                dark: {
                    DEFAULT: '#1A1A2E',
                    card: '#16213E',
                    sidebar: '#0F172A',
                    border: '#334155',
                    hover: '#1E293B',
                },
                // Status colors
                success: {
                    DEFAULT: '#28A745',
                    light: '#D4EDDA',
                    dark: '#1E7E34',
                },
                danger: {
                    DEFAULT: '#DC3545',
                    light: '#F8D7DA',
                    dark: '#BD2130',
                },
                warning: {
                    DEFAULT: '#FFA500',
                    light: '#FFF3CD',
                    dark: '#E69500',
                },
                info: {
                    DEFAULT: '#17A2B8',
                    light: '#D1ECF1',
                    dark: '#138496',
                },
            },
            boxShadow: {
                'soft': '0 2px 15px -3px rgba(0, 0, 0, 0.07), 0 10px 20px -2px rgba(0, 0, 0, 0.04)',
                'card': '0 0 20px rgba(0, 0, 0, 0.05)',
                'sidebar': '4px 0 10px rgba(0, 0, 0, 0.05)',
            },
            animation: {
                'fade-in': 'fadeIn 0.5s ease-in-out',
                'slide-in': 'slideIn 0.3s ease-out',
                'pulse-slow': 'pulse 3s infinite',
            },
            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                slideIn: {
                    '0%': { transform: 'translateX(-100%)' },
                    '100%': { transform: 'translateX(0)' },
                },
            },
        },
    },

    plugins: [forms],
};
