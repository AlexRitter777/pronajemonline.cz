import Alpine from 'alpinejs';
import sidebar from "./sidebar";

window.Alpine = Alpine;
Alpine.start();

window.$ = $;
window.jQuery = $;

sidebar();

console.log('vite is running...')