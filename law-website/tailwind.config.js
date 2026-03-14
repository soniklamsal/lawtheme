/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './*.php',
    './template-parts/**/*.php',
    './templates/**/*.php',
    './inc/**/*.php',
    './assets/js/**/*.js',
  ],
  theme: {
    extend: {
      colors: {
        primary: '#26cf71',
        'primary-dark': '#1eb863',
        'text-dark': '#1A2B3C',
      },
      fontFamily: {
        sans: ['Inter', 'system-ui', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'sans-serif'],
      },
    },
  },
  plugins: [],
}
