import defaultTheme from 'tailwindcss/defaultTheme';

export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Poppins', ...defaultTheme.fontFamily.sans],
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
                },

                background: '#f8fafc',
                surface: '#ffffff',
                border: '#e5e7eb',

                text: {
                    primary: '#0f172a',
                    secondary: '#475569',
                    muted: '#64748b',
                },

                success: '#16a34a',
                warning: '#f59e0b',
                danger: '#dc2626',
                info: '#0ea5e9',
            },

            borderRadius: {
                xl: '1rem',
                '2xl': '1.25rem',
            },

            boxShadow: {
                soft: '0 10px 30px rgba(0,0,0,.06)',
            },
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
    ],
};
