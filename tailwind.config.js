import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    darkMode: 'class',
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                ccblack: "#1e1e1e",
                ccwhite: "#fbfbfa",
                primary: "#00509D",
                dark: "#003F88",
                darker: "#00296B",
                light: "#FDC500",
                lighter: "#FFD500",
            },
            boxShadow: {
                aroundShadow: "0px 0px 15px rgba(101, 119, 134, 0.5)"
            }
        },
    },
    plugins: [],
};
