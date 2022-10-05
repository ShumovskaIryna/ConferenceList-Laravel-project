<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import 'vue3-social-share/lib/index.css'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

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
                <div class="relative w-80 p-5 ml-4 mt-4 bg-white shadow-sm sm:rounded-lg">
                    Report #{{report.id}}
                    <div class="bg-white border-b border-gray-200">
                        Topic: {{report.topic}}
                    </div>
                    <div class="bg-white border-b border-gray-200">
                        From {{report.time_start}}
                        Untill {{ report.time_finish }}
                    </div>
                    <div class="bg-white border-b border-gray-200">
                        Description: {{report.description}}
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
