import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                // sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            width: {
                100: "582px",
                99: "520px",
                101: "775px",
                130: "1000px",
            },
            maxWidth: {
                100: "582px",
                99: "520px",
                101: "775px",
            },
            margin: {
                97: "400px",
            },
        },
    },

    plugins: [forms],
};
