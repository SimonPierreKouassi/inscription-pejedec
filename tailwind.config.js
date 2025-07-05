import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './index.html', 
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
        "./resources/**/*.vue",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    50: '#eff6ff',
                    100: '#dbeafe',
                    200: '#bfdbfe',
                    300: '#93c5fd',
                    400: '#60a5fa',
                    500: '#3b82f6',
                    600: '#2563eb',
                    700: '#1d4ed8',
                    800: '#1e40af',
                    900: '#1e3a8a',
                    950: '#172554',
                },
                secondary: {
                    50: '#f0fdf4',
                    100: '#dcfce7',
                    200: '#bbf7d0',
                    300: '#86efac',
                    400: '#4ade80',
                    500: '#22c55e',
                    600: '#16a34a',
                    700: '#15803d',
                    800: '#166534',
                    900: '#14532d',
                    950: '#052e16',
                },
                accent: {
                    50: '#fff7ed',
                    100: '#ffedd5',
                    200: '#fed7aa',
                    300: '#fdba74',
                    400: '#fb923c',
                    500: '#f97316',
                    600: '#ea580c',
                    700: '#c2410c',
                    800: '#9a3412',
                    900: '#7c2d12',
                    950: '#431407',
                },
            },
            spacing: {
                '18': '4.5rem',
                '88': '22rem',
                '128': '32rem',
            },
            animation: {
                'fade-in': 'fadeIn 0.5s ease-in-out',
                'slide-in': 'slideIn 0.3s ease-out',
                'bounce-in': 'bounceIn 0.6s ease-out',
                'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
            },
            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0', transform: 'translateY(10px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                slideIn: {
                    '0%': { transform: 'translateX(-100%)' },
                    '100%': { transform: 'translateX(0)' },
                },
                bounceIn: {
                    '0%': { transform: 'scale(0.3)', opacity: '0' },
                    '50%': { transform: 'scale(1.05)' },
                    '70%': { transform: 'scale(0.9)' },
                    '100%': { transform: 'scale(1)', opacity: '1' },
                },
            },
            'box-shadow': {
                'soft': '0 2px 15px -3px rgba(0, 0, 0, 0.07), 0 10px 20px -2px rgba(0, 0, 0, 0.04)',
                'medium': '0 4px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)',
                'large': '0 10px 50px -12px rgba(0, 0, 0, 0.25)',
            },
            backdropBlur: {
                xs: '2px',
            },
            screens: {
                'xs': '475px',
                '3xl': '1600px',
            },
            container: {
                center: true,
                padding: {
                    DEFAULT: '1rem',
                    sm: '2rem',
                    lg: '4rem',
                    xl: '5rem',
                    '2xl': '6rem',
                },
            },
        },
    },

    plugins: [
        forms({
            strategy: 'class',
        }),
        typography,
        function({ addUtilities, addComponents, theme }) {
            // Utilitaires personnalisés
            addUtilities({
                '.text-shadow': {
                    textShadow: '0 2px 4px rgba(0,0,0,0.10)',
                },
                '.text-shadow-md': {
                    textShadow: '0 4px 8px rgba(0,0,0,0.12), 0 2px 4px rgba(0,0,0,0.08)',
                },
                '.text-shadow-lg': {
                    textShadow: '0 15px 35px rgba(0,0,0,0.1), 0 5px 15px rgba(0,0,0,0.07)',
                },
                '.text-shadow-none': {
                    textShadow: 'none',
                },
            });

            // Composants personnalisés
            addComponents({
                '.btn': {
                    padding: `${theme('spacing.2')} ${theme('spacing.4')}`,
                    borderRadius: theme('borderRadius.md'),
                    fontWeight: theme('fontWeight.medium'),
                    fontSize: theme('fontSize.sm'),
                    lineHeight: theme('lineHeight.5'),
                    display: 'inline-flex',
                    alignItems: 'center',
                    justifyContent: 'center',
                    transition: 'all 0.2s ease-in-out',
                    cursor: 'pointer',
                    '&:focus': {
                        outline: 'none',
                        boxShadow: `0 0 0 3px ${theme('colors.blue.500')}40`,
                    },
                    '&:disabled': {
                        opacity: '0.5',
                        cursor: 'not-allowed',
                    },
                },
                '.btn-primary': {
                    backgroundColor: theme('colors.blue.600'),
                    color: theme('colors.white'),
                    '&:hover': {
                        backgroundColor: theme('colors.blue.700'),
                    },
                    '&:active': {
                        backgroundColor: theme('colors.blue.800'),
                    },
                },
                '.btn-secondary': {
                    backgroundColor: theme('colors.gray.200'),
                    color: theme('colors.gray.900'),
                    '&:hover': {
                        backgroundColor: theme('colors.gray.300'),
                    },
                    '&:active': {
                        backgroundColor: theme('colors.gray.400'),
                    },
                },
                '.btn-success': {
                    backgroundColor: theme('colors.green.600'),
                    color: theme('colors.white'),
                    '&:hover': {
                        backgroundColor: theme('colors.green.700'),
                    },
                    '&:active': {
                        backgroundColor: theme('colors.green.800'),
                    },
                },
                '.btn-danger': {
                    backgroundColor: theme('colors.red.600'),
                    color: theme('colors.white'),
                    '&:hover': {
                        backgroundColor: theme('colors.red.700'),
                    },
                    '&:active': {
                        backgroundColor: theme('colors.red.800'),
                    },
                },
                '.card': {
                    backgroundColor: theme('colors.white'),
                    borderRadius: theme('borderRadius.lg'),
                    boxShadow: theme('boxShadow.md'),
                    padding: theme('spacing.6'),
                },
                '.form-input': {
                    borderRadius: theme('borderRadius.md'),
                    borderWidth: '1px',
                    borderColor: theme('colors.gray.300'),
                    padding: `${theme('spacing.2')} ${theme('spacing.3')}`,
                    fontSize: theme('fontSize.sm'),
                    lineHeight: theme('lineHeight.5'),
                    '&:focus': {
                        outline: 'none',
                        borderColor: theme('colors.blue.500'),
                        boxShadow: `0 0 0 3px ${theme('colors.blue.500')}20`,
                    },
                    '&.error': {
                        borderColor: theme('colors.red.500'),
                        '&:focus': {
                            borderColor: theme('colors.red.500'),
                            boxShadow: `0 0 0 3px ${theme('colors.red.500')}20`,
                        },
                    },
                },
                '.badge': {
                    display: 'inline-flex',
                    alignItems: 'center',
                    padding: `${theme('spacing.1')} ${theme('spacing.2')}`,
                    fontSize: theme('fontSize.xs'),
                    fontWeight: theme('fontWeight.medium'),
                    borderRadius: theme('borderRadius.full'),
                },
                '.badge-success': {
                    backgroundColor: theme('colors.green.100'),
                    color: theme('colors.green.800'),
                },
                '.badge-warning': {
                    backgroundColor: theme('colors.yellow.100'),
                    color: theme('colors.yellow.800'),
                },
                '.badge-error': {
                    backgroundColor: theme('colors.red.100'),
                    color: theme('colors.red.800'),
                },
                '.badge-info': {
                    backgroundColor: theme('colors.blue.100'),
                    color: theme('colors.blue.800'),
                },
            });
        },
    ],
};