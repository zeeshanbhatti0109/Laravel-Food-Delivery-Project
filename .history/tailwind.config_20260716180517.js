import defaultTheme from 'tailwindcss/defaultTheme'
import forms from '@tailwindcss/forms'
import colors from 'tailwindcss/colors' 
 
/** @type {import('tailwindcss').Config} */
export default {
  // ...
 
  theme: {
    extend: {
      colors: { 
        primary: colors.green, 
        danger: colors.red 
      }, 
 
      // ...
}