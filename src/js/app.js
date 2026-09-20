
import Alpine from 'alpinejs';
import select2 from "./components/select2";

import sidebar from "./sidebar";

import "./calculations.js";
import "./advanced_form.js";
import "./form_validation.js";
import "./remove_entity_confirmation.js";
import "./validation.js";
import "./property_form.js";
import "./services-settlement/exepenses-rows.js"
import "./services-settlement/meters-rows.js"
import "./services-settlement/reading-sources.js"
import "./services-settlement/heating-coefficient.js"
import "./services-settlement/heating-correction.js"
import "./services-settlement/expenses-correction.js"
import "./tooltips.js";


window.$ = $;
window.jQuery = $;


window.Alpine = Alpine;

Alpine.data('select2', select2);

Alpine.start();

sidebar();

console.log('vite is running...')