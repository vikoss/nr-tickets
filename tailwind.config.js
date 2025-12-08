import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    // Enable dark mode via class strategy for manual toggle
    darkMode: 'class',
    
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            // Branding colors - these reference CSS custom properties
            // allowing runtime theming via config/branding.php values
            colors: {
                brand: {
                    primary: {
                        50: 'var(--color-primary-50)',
                        100: 'var(--color-primary-100)',
                        200: 'var(--color-primary-200)',
                        300: 'var(--color-primary-300)',
                        400: 'var(--color-primary-400)',
                        500: 'var(--color-primary-500)',
                        600: 'var(--color-primary-600)',
                        700: 'var(--color-primary-700)',
                        800: 'var(--color-primary-800)',
                        900: 'var(--color-primary-900)',
                        950: 'var(--color-primary-950)',
                        DEFAULT: 'var(--color-primary-500)',
                    },
                    secondary: {
                        50: 'var(--color-secondary-50)',
                        100: 'var(--color-secondary-100)',
                        200: 'var(--color-secondary-200)',
                        300: 'var(--color-secondary-300)',
                        400: 'var(--color-secondary-400)',
                        500: 'var(--color-secondary-500)',
                        600: 'var(--color-secondary-600)',
                        700: 'var(--color-secondary-700)',
                        800: 'var(--color-secondary-800)',
                        900: 'var(--color-secondary-900)',
                        950: 'var(--color-secondary-950)',
                        DEFAULT: 'var(--color-secondary-500)',
                    },
                    accent: {
                        50: 'var(--color-accent-50)',
                        100: 'var(--color-accent-100)',
                        200: 'var(--color-accent-200)',
                        300: 'var(--color-accent-300)',
                        400: 'var(--color-accent-400)',
                        500: 'var(--color-accent-500)',
                        600: 'var(--color-accent-600)',
                        700: 'var(--color-accent-700)',
                        800: 'var(--color-accent-800)',
                        900: 'var(--color-accent-900)',
                        950: 'var(--color-accent-950)',
                        DEFAULT: 'var(--color-accent-500)',
                    },
                },
            },
        },
    },

    plugins: [forms],
};
