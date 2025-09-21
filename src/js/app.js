import Alpine from 'alpinejs';
import sidebar from "./sidebar";
import "./calculations.js";
import "./advanced_form.js";
import "./form_validation.js";
import "./remove_entity_confirmation";

window.Alpine = Alpine;

Alpine.start();

window.$ = $;
window.jQuery = $;

sidebar();

console.log('vite is running...')