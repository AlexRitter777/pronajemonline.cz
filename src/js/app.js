
import Alpine from 'alpinejs';
import select2 from "./components/select2";

import sidebar from "./sidebar";

import "./calculations.js";
import "./advanced_form.js";
import "./form_validation.js";
import "./remove_entity_confirmation.js";
import "./validation.js"


window.$ = $;
window.jQuery = $;


window.Alpine = Alpine;

Alpine.data('select2', select2);

Alpine.start();

sidebar();

console.log('vite is running...')