<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';

const props = defineProps({
    conference: {
        type: Array,
        default: [],
    },
});
</script>

<template>
    <Head title="Details" />

    <AuthenticatedLayout>
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-2 sm:pt-0 bg-gray-100">
            <div class="w-full sm:max-w-md mt-2 px-9 py-6 bg-white shadow-md overflow-hidden sm:rounded-lg">
                    <div class="mt-4">
                        Title
                        <div class="mt-4">
                            <i>{{conference.title}}</i>
                        </div>
                    </div>

                    <div class="mt-4">
                        Date
                        <div class="mt-4">
                            <i>{{conference.date}}</i>
                        </div>
                    </div>

                    <div class="mt-4">
                        Address
                        <div class="mt-4">
                             <i>Lattitude - {{conference.lat}}</i>
                        </div>
                        <div class="mt-4">
                             <i>Longitude - {{conference.lng}}</i>
                        </div>
                    </div>

                    <div class="mt-4">
                        Country
                        <div class="mt-4">
                            <i>{{conference.countries}}</i>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-4">
<!--                        <Link :href="route('Edit', conference.id )" class="text-sm text-gray-700 dark:text-gray-500 underline">Edit</Link>-->
<!--                        <Link :href="route('Delete', conference.id )" class="text-sm text-gray-700 dark:text-gray-500 underline">Delete</Link>-->
<!--                        <Link :href="route('Join', conference.id )" class="text-sm text-gray-700 dark:text-gray-500 underline">Join</Link>-->
                    </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
