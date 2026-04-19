import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import wireuiConfig from './vendor/wireui/wireui/tailwind.config.js';

/** @type {import('tailwindcss').Config} */
export default {
    presets: [wireuiConfig],

    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './vendor/wireui/wireui/resources/**/*.blade.php',
        './vendor/wireui/wireui/ts/**/*.ts',
        './vendor/wireui/wireui/src/View/**/*.php',
        './vendor/livewire/livewire/src/views/**/*.php',
        './vendor/livewire/livewire/src/views/**/*.blade.php',
        './vendor/wireui/wireui/src/*.php',
        './vendor/wireui/wireui/src/WireUi/**/*.php',
        './vendor/wireui/wireui/src/Components/**/*.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    primary: 'var(--brand-primary)',
                    secondary: 'var(--brand-secondary)',
                    accent: 'var(--brand-accent)',
                    surface: 'var(--brand-surface)',
                    text: 'var(--brand-text)',
                },
            },
            borderRadius: {
                brand: '1rem',
                card: '1.25rem',
            },
            boxShadow: {
                brand: '0 10px 25px -10px rgb(15 118 110 / 0.35)',
                card: '0 10px 30px -14px rgb(15 23 42 / 0.25)',
            },
            spacing: {
                '18': '4.5rem',
                '22': '5.5rem',
            },
        },
    },

    plugins: [forms],
};
