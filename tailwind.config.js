/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./index.php",
    "./page/**/**/*.php"
  ],
  theme: {
    extend: {},
  },
  plugins: [
    plugin(function({ addUtilities, addComponents, e, config }) {
    }),
  ],
}