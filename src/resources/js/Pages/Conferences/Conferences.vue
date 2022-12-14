<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/inertia-vue3';
import { Inertia } from "@inertiajs/inertia";
import { Share } from 'vue3-social-share';
import 'vue3-social-share/lib/index.css'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import Pagination from '@/Components/Pagination.vue'
import Filters from '../../Components/FiltersConferences.vue'
import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue'
import { library } from '@fortawesome/fontawesome-svg-core'
import { faFilter} from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
library.add(faFilter)

const props = defineProps({
    conferences: {
        type: Array,
        default: [],
    },
    auth: {
        type: Object,
        default: {},
    },
    categories: {
        type: Array,
        default: [],
    },
    countReport: {
        type: Array,
        default: [0, 20]
    },
    dateConf: {
        type: Array,
        default: []
    },
    selectedCategories: {
        type: Array,
        default: []
    },
});

const filterValue = {
    countReport: props.countReport ?? [0, 20],
    dateConf: props.dateConf,
    selectedCategories: props.selectedCategories
}

function createReport(id, categoryId)
{
    Inertia.get(route("get_report_form", [id, categoryId]));
}

function join(id)
{
    Inertia.post(route("join", id));
}

function unjoin(id)
{
    Inertia.post(route("unjoin", id));
}

function submitFilter(values)
{
    Inertia.get(
        route('conferences_list'),
        values,
    );
}
</script>

<template>
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Disclosure v-if="props.auth.user?.role === 'ANNOUNCER' ||
                        props.auth.user?.role === 'ADMIN' ||
                        props.auth.user?.role === 'LISTENER'">
                    <DisclosureButton className="py-2 top-10 ml-4 absolute">
                        <button class="btn btn-outline-secondary mt-4">
                            <font-awesome-icon icon="fa-solid fa-filter" />
                        </button>
                    </DisclosureButton>
                    <DisclosurePanel className="sm:flex relative w-full sm:w-48 max-h-max p-3 mb-2 mr-1 bg-white shadow-sm sm:rounded-lg float-left">
                            <Filters
                                @submit = "submitFilter"
                                :defaultFilterValues = "filterValue"
                                :categories = "props.categories"
                            />
                    </DisclosurePanel>
                </Disclosure>
                <div class="relative bg-white w-full sm:w-auto ml-2 overflow-x-scroll shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">

                    <h2>I AM {{props.auth?.user?.role || 'GUEST'}}</h2>

                    <div v-if="props.auth.user?.role === 'ANNOUNCER' ||
                        props.auth.user?.role === 'ADMIN'"
                        class="relative text-right bg-blue-200">
                        <ResponsiveNavLink class="no-underline text-sky-700" 
                            :href="route('conference_new')" :active="route().current('conference_new')">
                            <h4>+ New Conference</h4>
                        </ResponsiveNavLink>
                    </div>
                    <div v-if="props.auth.user?.role === 'ADMIN'" class="relative text-right">
                        <a class="btn btn-danger mt-1" :href="route('conferences_export')">Export conferences</a>
                    </div>
                    <b-table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Date</th>
                            <th scope="col"> </th>
                            <th scope="col"> </th>
                        </tr>
                        </thead>
                        <tbody v-for="conference in props.conferences.data">
                            <tr>
                                <th scope="row">{{ conference.id }}</th>
                                <td class="max-w-xs p-2">{{ conference.title }}</td>
                                <td>
                                    {{new Date(conference.date).toLocaleString('en-US',
                                    {month: 'short', day: 'numeric', hour: 'numeric', minute: 'numeric', hour24: false,
                                    timeZone: Intl.DateTimeFormat().resolvedOptions().timeZone })}}
                                </td>
        <!--                            IF USER IS NOT GUEST-->
                                <td>
                                    <Link :href="route('conference_details', conference.id )">
                                        <button class="btn btn-outline-info mr-1 mt-1">
                                            Details
                                        </button>
                                    </Link>
                                    <Link :href="route('reports_list', conference.id)">
                                        <button class="btn btn-outline-dark mt-1">
                                            Reports
                                        </button>
                                    </Link>
        <!--                            IF USER IS ADMIN OR OWNER-->
                                    <div v-if="props.auth?.user?.role === 'ADMIN' || conference.isOwn">
                                        <Link :href="route('conference_delete', conference.id )">
                                            <button class="btn btn-outline-danger mt-1">
                                                Delete
                                            </button>
                                        </Link>
                                    </div>
        <!--                            IF USER IS NOT ADMIN-->
                                    <div v-else>
                                        <div v-if="conference.isAlreadyJoined" class="relative flex">
                                            <button class="btn btn-outline-danger mt-1" @click="unjoin(conference.id)">
                                                Cancel participation
                                            </button>
                                                <div class="hide">
                                                    <Share
                                                        source="modifySource"
                                                        :QQ="false"
                                                        :QZone="false"
                                                        :weibo="false"
                                                        :weChat="false"
                                                        :twitter="true"
                                                        :facebook="true"
                                                    ></Share>
                                                </div>
                                        </div>
                                        <div v-else>
                                            <div v-if="props.auth?.user?.role === 'ANNOUNCER'">
                                                <button v-if="conference.category"
                                                        class="btn btn-outline-success mt-1"
                                                        @click="createReport(conference.id, conference.category)">
                                                    Join
                                                </button>
                                                <button v-else
                                                        class="btn btn-outline-success mt-1"
                                                        @click="createReport(conference.id, 0)">
                                                    Join
                                                </button>
                                            </div>
                                            <button v-else
                                                    class="btn btn-outline-success mt-1"
                                                    @click="join(conference.id)">
                                                Join
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </b-table>
                        <div class="relative flex justify-center">
                            <Pagination :links="conferences.links" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>