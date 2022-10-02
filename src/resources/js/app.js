import './bootstrap';
import '../css/app.css';
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import VueGoogleMaps from '@fawmi/vue-google-maps'
import { InertiaProgress } from '@inertiajs/progress';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import PeterAlbusVue from 'vue3-social-share';
import 'vue3-social-share/lib/index.css'

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(PeterAlbusVue)
            .use(VueGoogleMaps, {
                load: {
                    key: 'AIzaSyA69OWMQ-Hpg2G4Cwx5rvnDfAnJRxTKpTQ',
                }
            })
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
