import './bootstrap';
import { createApp, h } from 'vue';
import { createInertiaApp, Link } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';

// AdminKit (required)
import "./modules/bootstrap";
import "./modules/sidebar";
import "./modules/theme";
import "./modules/feather";

// Charts
import "./modules/chartjs";

// Forms
import "./modules/flatpickr";

// Maps
import "./modules/vector-maps";

// Fontawesome
import "@fortawesome/fontawesome-free/js/all";

// Mantén el código existente para el modo oscuro y otras funcionalidades
document.addEventListener('DOMContentLoaded', function() {
    // Tu código JavaScript existente
});

createInertiaApp({
    title: title => `${title} - QUALITY STORE`,
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
        return pages[`./Pages/${name}.vue`]
    },
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
        app.use(plugin)

        // Configurar Ziggy globalmente
        app.mixin({ methods: { route } })
        app.component('Link', Link)

        // Evento global para el modo oscuro
        app.config.globalProperties.$darkMode = {
            toggle() {
                document.body.classList.toggle('dark-mode')
                localStorage.setItem('darkMode',
                    document.body.classList.contains('dark-mode') ? 'enabled' : 'disabled'
                )
            },
            init() {
                if (localStorage.getItem('darkMode') === 'enabled') {
                    document.body.classList.add('dark-mode')
                }
            }
        }

        app.mount(el)
    },
    progress: {
        color: '#4B5563',
    },
})
