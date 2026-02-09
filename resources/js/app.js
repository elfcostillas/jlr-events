import './bootstrap';
import '../css/app.css';
import 'primeicons/primeicons.css'

import 'primeflex/primeflex.css';


// @import 'primeflex/primeflex.scss';

// import Aura from 'primevue/resources/themes/aura/aura.css';
import Aura from '@primeuix/themes/aura';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import PrimeVue from 'primevue/config';
import { createPinia } from 'pinia';

import Menubar from 'primevue/menubar';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Button from 'primevue/button';
// import Dialog from 'primevue/dialog';
import { Dialog } from 'primevue';
import { InputText } from 'primevue';
import { DatePicker } from 'primevue';


const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(PrimeVue ,{ theme : { preset :Aura }})
            .use(plugin)
            .use(ZiggyVue)
            .use(createPinia())
            .component('Menubar', Menubar)
            .component('DataTable', DataTable)
            .component('Column', Column)
            .component('Button', Button)
            .component('Dialog', Dialog)
            .component('InputText', InputText)
            .component('DatePicker', DatePicker)
            
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
