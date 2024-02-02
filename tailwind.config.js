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

          "primary": "#e500c2",
          "secondary": "#00f100",
          "accent": "#00e500",
          "neutral": "#161707",
          "base-100": "#242424",
          "info": "#00b0d3",
          "success": "#669500",
          "warning": "#ff7700",
          "error": "#f7526c",
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

