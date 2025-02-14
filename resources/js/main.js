// Load assets (for Vite)
import.meta.glob([
    '../img/*',
    '../css/fonts/*.woff2',
]);

// Icons
import { createIcons, createElement,
ArrowRight, CircleCheck, CircleX, Github, TextSearch,
} from 'lucide';

// Load Livewire
import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
Livewire.start()

// Icons loaded
const iconsList = {
    ArrowRight,
    CircleCheck,
    CircleX,
    Github,
    TextSearch,
};

// Fire events after page load
document.addEventListener('DOMContentLoaded', () => {
    // Load icons
    createIcons({ icons: iconsList });
});

// These two hooks are needed to properly
// render icons in the Livewire component.
// -------------------------------------------
// On Livewire component init, re-create icons
Livewire.hook('element.init', ({ component, cleanup }) => {
    // Load icons
    createIcons({ icons: iconsList });
})

// On Livewire component updates, re-create icons
Livewire.hook('morphed', ({ el, component }) => {
    // Load icons
    createIcons({ icons: iconsList });
})
