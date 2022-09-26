<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';

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
                            <i>{{props.conference.title}}</i>
                        </div>
                    </div>

                    <div class="mt-4">
                        Date
                        <div class="mt-4">
                            <i>{{props.conference.date}}</i>
                        </div>
                    </div>

                    <div class="mt-4">
                        Address
                        <div class="mt-4">
                             <i>Lattitude - {{props.conference.lat}}</i>
                        </div>
                        <div class="mt-4">
                             <i>Longitude - {{props.conference.lng}}</i>
                        </div>
                    </div>

                    <div class="mt-4">
                        Country
                        <div class="mt-4">
                            <i>{{props.conference.countries}}</i>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <Link :href="route('Edit', props.conference.id )">
                            <button class="btn btn-outline-warning mr-4">Edit</button></Link>
                        <Link :href="route('Conferences')">
                            <button class="btn btn-outline-dark mr-4">Back</button></Link>
                        <Link :href="route('Delete', props.conference.id )">
                            <button class="btn btn-outline-danger">Delete</button></Link>
<!--                        <Link :href="route('Join', conference.id )">Join</Link>-->
                    </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
