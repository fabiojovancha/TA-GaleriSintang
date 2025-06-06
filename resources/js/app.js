import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faFilePdf, faUser, faEdit, faCheck,faEye,faPen, faTrash  } from '@fortawesome/free-solid-svg-icons';
import { createPinia } from 'pinia';

library.add(faFilePdf, faUser, faEdit, faCheck,faEye,faPen,faTrash ); 

const appName = import.meta.env.VITE_APP_NAME || 'Galeri Sintang';


window.Pusher = Pusher;
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY, 
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
});


    createInertiaApp({
        title: (title) => `${title} - ${appName}`,
        resolve: (name) =>
            resolvePageComponent(
                `./Pages/${name}.vue`,
                import.meta.glob('./Pages/**/*.vue'),
            ),
        setup({ el, App, props, plugin }) {
            const vueApp = createApp({ render: () => h(App, props) });
            const pinia = createPinia();

            vueApp.component('font-awesome-icon', FontAwesomeIcon);
    
            return vueApp
                .use(plugin)
                .use(ZiggyVue)
                .use(pinia)
                .mount(el);
        },
        progress: {
            color: '#4B5563',
        },
    });
