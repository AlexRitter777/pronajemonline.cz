import Alpine from 'alpinejs';
import sidebar from "./sidebar";
import "./calculations.js";
import "./advanced_form.js";

window.Alpine = Alpine;


Alpine.start();

window.$ = $;
window.jQuery = $;

sidebar();

console.log('vite is running...')