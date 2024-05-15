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
        screens:{
            'xs':{'min': '200px', 'max': '600px'},
            'sm': {'min': '600px', 'max': '767px'},
            // => @media (min-width: 640px and max-width: 767px) { ... }

            'md': {'min': '767px', 'max': '1023px'},
            // => @media (min-width: 768px and max-width: 1023px) { ... }

            'lg': {'min': '1023px', 'max': '1279px'},
            // => @media (min-width: 1024px and max-width: 1279px) { ... }

            'xl': {'min': '1279px', 'max': '1535px'},
            // => @media (min-width: 1280px and max-width: 1535px) { ... }

            '2xl': {'min': '1536px'},
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
