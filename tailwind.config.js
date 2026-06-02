/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./*.php",
    "./inc/**/*.php",
    "./template-parts/**/*.php",
    "./assets/js/**/*.js"
  ],
  theme: {
    extend: {
      fontFamily: {
        serif: ['"Cinzel"', 'serif'],
        sans: ['"Manrope"', 'sans-serif'],
      },
      colors: {
        void: '#050505',
        metal: '#151515',
        surface: '#1E1E1E',
        gold: '#C5A059',
        goldDim: '#8A703E',
        dust: '#666666'
      },
      letterSpacing: {
        'cinematic': '0.3em',
      },
      backgroundImage: {
        'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
      }
    },
  },
  plugins: [],
}
