const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        fontSize: {

            xs: '0.6rem',
            sm:'0.8rem',
            md:'0.9rem',
            xl: '1.25rem',

            '2xl': '1.563rem',
            '3xl': '1.953rem',
            '4xl': '2.441rem',
            '5xl': '3.052rem',

          },
          screens: {
            'xs': {'raw': '(min-width: 200px) and (max-width: 600px)'},
            'sm': {'raw': '(min-width: 600px) and (max-width: 767px)'},
            'md': {'raw': '(min-width: 767px) and (max-width: 1023px)'},
            'lg': {'raw': '(min-width: 1023px) and (max-width: 1279px)'},
            'xl': {'raw': '(min-width: 1279px) and (max-width: 1535px)'},
            '2xl': {'raw': '(min-width: 1536px)'},
          },

        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
                cairo: ['Cairo', ...defaultTheme.fontFamily.sans],
            },

            colors:{
                bg:'#fefbff',
                primary:"#EDF5FF",
                primary_blue:"#EDF5FF",
                secondary:'#1277D1',
                secondary_blue:'#1277D1',
                secondary_1:'#064570',
                link:'#3854c4',
                primary_red:'#dc2626',
                secondary_red:'#ef4444',
                valid:'#16a34a',
                svg_primary:'#878787',
                formbutton:'#f9fafb',
                customprogressbar:'#59a3e5'





            },
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography'),    require('tailwind-scrollbar')({ nocompatible: true })],
};
