import './bootstrap.js';

/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './vendor/bootstrap/dist/css/bootstrap.min.css';
import './styles/critical.css';
import './styles/desktop.css';
import './styles/admin.css';
import './javascript/tva_calc_form_v2.js';
import './javascript/feedback_form.js';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');

