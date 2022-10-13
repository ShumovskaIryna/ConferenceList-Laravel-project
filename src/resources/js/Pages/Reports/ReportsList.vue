<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/inertia-vue3';
import 'vue3-social-share/lib/index.css'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import Pagination from '@/Components/Pagination.vue'

const CONFERENCE_ID_INDEX = 4;

const url = window.location.href;
const lastParam = url.split("/");
const confId = lastParam[CONFERENCE_ID_INDEX];

const props = defineProps({
    reports: {
        type: Array,
        default: [],
    },
});
</script>
<template>
    <AuthenticatedLayout>
        <Link :href="route('conference_details', confId)">
            <button class="absolute ml-4 mt-1 btn btn-outline-primary">
                Back
            </button>
        </Link>
        <div class="py-12">
            <div v-if="props.reports.data.length == 0"
                  class="min-h-screen flex flex-col items-center pt-6 sm:pt-0 bg-gray-100">
                    <div class="w-full sm:max-w-md px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                This conference don`t have any reports 🤷‍♀️
                    </div>
            </div>
            <div v-else v-for="report in props.reports.data" class="max-w-7xl inline-block sm:px-6 lg:px-8">
                <Link :href="route('report_details', [confId, report.id])" class="no-underline">
                    <div class="relative w-80 p-5 ml-4 mt-4 bg-white shadow-sm sm:rounded-lg">
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
                        <div class="absolute right-3 bottom-3">
                            Comments count: {{report.comments_count}} 💬 
                        </div>
                    </div>
                </Link>
                    <div class="relative flex justify-center">
                            <Pagination :links="reports.links" />
                    </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
