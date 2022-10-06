<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/inertia-vue3';
import 'vue3-social-share/lib/index.css'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

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
console.log(33, props);
</script>
<template>
    <AuthenticatedLayout>
        <div class="py-12">
            <div v-for="report in props.reports.data" class="max-w-7xl inline-block sm:px-6 lg:px-8">
                <Link :href="route('report_details', [confId, report.id])" class="no-underline">
                    <div class="relative w-80 p-5 ml-4 mt-4 bg-white shadow-sm sm:rounded-lg">
                        <div class="mb-2 text-sky-900 text-lg text-center">
                            Report #{{report.id}}
                        </div>
                        <div class="text-sky-800 border-b border-gray-200">
                            Topic: {{report.topic}}
                        </div>
                        <div class="text-sky-700 border-b border-gray-200">
                            From {{report.time_start}}
                            Untill {{ report.time_finish }}
                        </div>
                        <div class="text-sky-600 border-b border-gray-200">
                            Description: {{report.description.slice(0,100) + '...'}}
                        </div>
                    </div>
                </Link>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
