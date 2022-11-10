import './bootstrap';
import '../css/app.css';
import Vue, { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import VueGoogleMaps from '@fawmi/vue-google-maps';
import { InertiaProgress } from '@inertiajs/progress';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import PeterAlbusVue from 'vue3-social-share';
import 'vue3-social-share/lib/index.css';
import CKEditor from '@ckeditor/ckeditor5-vue';
import Slider from '@vueform/slider';
import '@vueform/slider/themes/default.css';
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import Multiselect from '@vueform/multiselect';
import '@vueform/multiselect/themes/default.css';
import { createWebHistory, createRouter } from "vue-router";
import ConferencesList from './Pages/Conferences/Conferences.vue';
import ConferenceDetails from './Pages/Conferences/Details.vue';
import ConferenceCreate from './Pages/Conferences/Create.vue';
import ConferenceEdit from './Pages/Conferences/Edit.vue';
import ReportsList from './Pages/Reports/ReportsList.vue';
import ReportDetails from './Pages/Reports/ReportDetails.vue';
import ReportForm from './Pages/Reports/ReportForm.vue';
import ReportEdit from './Pages/Reports/ReportEdit.vue';
import ReportsFavoritesList from './Pages/Reports/ReportsFavoritesList.vue';
import CommentEdit from './Pages/Reports/CommentEdit.vue';
import CategoriesList from './Pages/Categories/CategoriesList.vue';
import CategoryForm from './Pages/Categories/CategoryForm.vue';
import CategoryEdit from './Pages/Categories/CategoryEdit.vue';
import SearchCR from './Pages/SearchCR.vue';


const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

const routes = [
    {
        path: '/conferences',
        component: ConferencesList,
    },
    {
        path: '/conferences/:id',
        component: ConferenceDetails,
    },
    {
        path: '/create-conference',
        component: ConferenceCreate,
    },
    {
        path: '/conferences/:id/edit',
        component: ConferenceEdit,
    },
    {
        path: '/conferences/:id/reports-list',
        component: ReportsList,
    },
    {
        path: '/conferences/:confId/reports-list/:reportId',
        component: ReportDetails,
    },
    {
        path: '/conferences/:id/report-form/:categoryId',
        component: ReportForm,
    },
    {
        path: '/conferences/:confId/reports-list/:reportId/edit/:categoryId',
        component: ReportEdit,
    },
    {
        path: '/reports-fav-list',
        component: ReportsFavoritesList,
    },
    {
        path: '/conferences/:confId/reports-list/:reportId/comment-edit/:commentId',
        component: CommentEdit,
    },
    {
        path: '/category-list',
        component: CategoriesList,
    },
    {
        path: '/category-create',
        component: CategoryForm,
    },
    {
        path: '/category-list/{categoryId}/edit',
        component: CategoryEdit,
    },
    {
        path: '/search-list',
        component: SearchCR,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
  });

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(PeterAlbusVue)
            .use( CKEditor )
            .use( Slider, Datepicker, Multiselect)
            .use(router)
            .component('Slider', Slider)
            .component('Datepicker', Datepicker)
            .component('Multiselect', Multiselect)
            .use(VueGoogleMaps, {
                load: {
                    key: 'AIzaSyA69OWMQ-Hpg2G4Cwx5rvnDfAnJRxTKpTQ',
                }
            })
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
