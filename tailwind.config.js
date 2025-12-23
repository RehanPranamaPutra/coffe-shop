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
            colors: {
                coffee: {
                    primary: "#8B4646" /* Maroon Kopi (Teks Utama & Button) */,
                    secondary: "#FFC47E" /* Krem/Orange (Hover & Aksen) */,
                    dark: "#1F1F1F" /* Hitam pudar untuk teks paragraf */,
                    gray: "#F9F9F9" /* Background Section selang-seling */,
                },
            },
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
                sans: ["Plus Jakarta Sans", "sans-serif"],
                serif: ["Playfair Display", "serif"],
            },
        },
    },

    plugins: [forms],
};
