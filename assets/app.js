// import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import 'bootstrap/dist/css/bootstrap.min.css';
import '@fortawesome/fontawesome-free/css/all.css';
import './styles/fonts.css';
import './styles/variables.css';
import './styles/app.css';

import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import './js/main.js';
import Flash from "./js/Flash.js";

customElements.define('app-flash', Flash);

// import './bootstrap.js';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');

/* Navigation responsive */
