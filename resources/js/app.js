import Alpine from 'alpinejs';

import './bootstrap';
import './sortable';

import tallTheme from './theme'
import focusTrap from './focus-trap';

window.focusTrap = focusTrap;
window.tallTheme = tallTheme;

document.addEventListener('alpine:init', () => {
    Alpine.data('themeData', tallTheme);
})

window.Alpine = Alpine;
Alpine.start();
