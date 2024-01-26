/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./app/Presenters/templates/@layout.latte",
    "./app/Presenters/templates/**/*.{js,ts,jsx,tsx,latte}",
    "./src/**/*.{js,ts,jsx,tsx,latte}"
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require("daisyui")
  ],
  daisyui: {
    themes: [
      {
        mytheme: {
          "primary": "#009eff",
          "secondary": "#5875ff",
          "accent": "#00b7ff",
          "neutral": "#281d0f",
          "base-100": "#24211c",
          "info": "#22c9ff",
          "success": "#a3cb00",
          "warning": "#ff9d00",
          "error": "#c10034",
        },
      },
    ],
    darkTheme: "light", // name of one of the included themes for dark mode
    base: true, // applies background color and foreground color for root element by default
    styled: true, // include daisyUI colors and design decisions for all components
    utils: true, // adds responsive and modifier utility classes
    prefix: "", // prefix for daisyUI classnames (components, modifiers and responsive class names. Not colors)
    logs: true, // Shows info about daisyUI version and used config in the console when building your CSS
    themeRoot: ":root", // The element that receives theme color CSS variables
  },
}

