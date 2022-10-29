<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/inertia-vue3';
import 'vue3-social-share/lib/index.css'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
// import Pagination from '@/Components/Pagination.vue'
import { library } from '@fortawesome/fontawesome-svg-core'
import { faHeart, faHeartCirclePlus, faFilter } from '@fortawesome/free-solid-svg-icons'
library.add(faHeart, faHeartCirclePlus, faFilter)

const props = defineProps({
    reports: {
        type: Array,
        default: [],
    },
    conferences: {
        type: Array,
        default: [],
    },
});
</script>

<template>
    <AuthenticatedLayout>
        <Link>
            <button class="absolute ml-4 mt-1 btn btn-outline-primary">
                Back
            </button>
        </Link>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div v-if="props.conferences.length == 0"
                    class="relative flex flex-col items-center bg-gray-100">
                    <div class="ml-2 mr-2 mb-2 p-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                        Don`t have any conferences 🤷‍♀️
                    </div>
                </div>
                <div v-else class="relative bg-white w-full sm:w-auto ml-2 mb-2 overflow-x-scroll shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
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
                            <tbody v-for="conference in props.conferences">
                                <tr>
                                    <th scope="row">{{ conference.id }}</th>
                                    <td class="max-w-xs p-2">{{ conference.title }}</td>
                                    <td>
                                        {{new Date(conference.date).toLocaleString('en-US',
                                        {month: 'short', day: 'numeric', hour: 'numeric', minute: 'numeric', hour24: false,
                                        timeZone: Intl.DateTimeFormat().resolvedOptions().timeZone })}}
                                    </td>
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
                                    </td>
                                </tr>
                            </tbody>
                        </b-table>
                    </div>
                </div>
                <div class="w-full inline-block sm:px-6 lg:px-8">
                    <div v-if="props.reports.length == 0"
                        class="relative w-full sm:w-auto min-h-screen flex flex-col items-center bg-gray-100">
                        <div class="ml-2 mr-2 p-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                            Don`t have any reports 🤷‍♀️
                        </div>
                    </div>
                    <div v-else v-for="report in props.reports" class="max-w-7xl inline-block sm:px-6 lg:px-8">
                        <div class="relative w-80 p-5 mr-4 mb-4 bg-white shadow-sm sm:rounded-lg">
                            <Link :href="route('report_details', [report.conference_id, report.id])" class="no-underline">
                                <div class="mb-2 text-sky-900 text-lg text-center">
                                    Report #{{report.id}}
                                </div>
                                <div class="text-sky-800 border-b border-gray-200">
                                    Topic: {{report.topic}}
                                </div>
                                <div class="text-sky-700 border-b border-gray-200">
                                    On: {{new Date(report.time_start).toLocaleString('en-US',
                                {month: 'long', day: 'numeric', weekday: 'long',
                                timeZone: Intl.DateTimeFormat().resolvedOptions().timeZone })}}
                                <br>
                                    from: {{new Date(report.time_start).toLocaleString('en-US',
                                {hour: 'numeric', minute: 'numeric', hour24: false, 
                                timeZone: Intl.DateTimeFormat().resolvedOptions().timeZone })}}
                                <br>
                                    untill: {{new Date(report.time_finish).toLocaleString('en-US', 
                                {hour: 'numeric', minute: 'numeric', hour24: false, 
                                timeZone: Intl.DateTimeFormat().resolvedOptions().timeZone })}}
                                </div>
                                <div class="text-sky-600 border-b border-gray-200">
                                    Description: {{report.description.slice(0,100) + '...'}}
                                </div>
                                <div v-if="report.isOwn" class="mt-4">
                                    <button class="mb-4 btn btn-outline-success">
                                        It is mine report
                                    </button>
                                </div>
                            </Link>
                            <div class="absolute right-3 bottom-3">
                                Comments count: {{report.comments_count}} 💬
                            </div>
                        </div>
                    </div>
                    <!-- <div class="relative flex justify-center">
                        <Pagination :links="reports.links" />
                    </div> -->
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>