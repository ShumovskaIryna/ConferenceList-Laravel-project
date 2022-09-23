<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

const props = defineProps({
    conferences: {
        type: Array,
        default: [],
    },
});

axios.get('/get-conferences').then(response => {
    props.conferences = response.data;
}).catch(error => {
    console.error(error);
});
</script>

<template>
    <Head title="Conferences" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">

                    <b-table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Date</th>
                            <th scope="col"> </th>
                            <th scope="col"> </th>
                            <th scope="col"> </th>
                        </tr>
                        </thead>
                        <tbody v-for="conference in props.conferences">
                        <tr>
                            <th scope="row">{{ conference.id }}</th>
                            <td class="max-w-xs">{{ conference.title }}</td>
                            <td>{{ conference.date }}</td>
                            <td><Link :href="route('Details', conference.id )">
                                <button class="btn btn-outline-info">Details</button></Link></td>
                            <td>Join</td>
                            <td>Share</td>
                        </tr>
                        </tbody>
                    </b-table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
