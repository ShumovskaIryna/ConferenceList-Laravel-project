<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import 'vue3-social-share/lib/index.css'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

const props = defineProps({
    report: {
        type: Array,
        default: [],
    },
});
</script>

<template>
    <Head title="Details" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0 bg-gray-100">
                <div class="w-full sm:max-w-md px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                    <div class="mb-2 text-sky-900 text-lg text-center">
                        Report #{{report.id}}
                    </div>
                    <div class="mb-2 bg-white text-sky-900 border-b border-gray-200">
                        Topic: {{props.report.topic}}
                    </div>
                    <div class="mb-2 bg-white text-sky-800 border-b border-gray-200">
                        From {{props.report.time_start}}
                        Untill {{props.report.time_finish}}
                    </div>
                    <div class="mb-2 bg-white text-sky-700 border-b border-gray-200">
                        Description: {{props.report.description}}
                    </div>
                    <div class="mb-4 bg-white text-sky-600 border-b border-gray-200">
                        Presentation: {{props.report.file_path}}
                    </div>
                    <div v-if="props.report.isOwn" class="mt-4">
                        <button class="mb-4 btn btn-outline-danger">
                            Cancel participation
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
