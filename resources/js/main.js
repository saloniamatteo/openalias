// Load assets (for Vite)
import.meta.glob([
    '../img/*',
    '../css/fonts/*.woff2',
]);

// Icons
import { createIcons,
ArrowRight, CircleCheck, CircleX, Github, TextSearch,
} from 'lucide';

// Handle form submit
import { submitForm } from './form.js';
window.submitForm = submitForm; // Make function available in HTML

// Fire events after page load
document.addEventListener('DOMContentLoaded', () => {
    // Load icons
    // This is a heavier task, compared to handling hash changes,
    // and making nav-btns clickable. Since this impacts our
    // loading times visibily, and it is visible only after
    // the page scrolling (handle hash change), execute it later.
    //lucide.createIcons();
    createIcons({
        icons: {
            ArrowRight,
            CircleCheck,
            CircleX,
            Github,
            TextSearch,
        }
    });
});
