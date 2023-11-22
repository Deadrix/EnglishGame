/** @type {import('tailwindcss').Config} */
module.exports = {
    content: ["./src/**/*.{html,php,js}"],
    theme: {
        extend: {
            colors: {
                "ppblue": '#233179',
                "ppyellow": '#f3d24a',
                "ppred": '#ff3131',
            },
            fontFamily: {
                'ppfont': ['Bubblegum Sans', 'sans-serif'],
            },
        },
    },
    plugins: [],
}

