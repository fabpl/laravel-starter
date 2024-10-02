const colors = require('tailwindcss/colors')
const forms = require('@tailwindcss/forms')
const typography = require('@tailwindcss/typography')

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
    ],
    plugins: [
        forms,
        typography,
    ],
    theme: {
        extend: {
            colors: {
                danger: colors.red,
                primary: colors.indigo,
                success: colors.green,
            }
        },
    },
}

