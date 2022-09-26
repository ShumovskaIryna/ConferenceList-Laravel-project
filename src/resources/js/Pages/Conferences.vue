<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import { Inertia } from "@inertiajs/inertia";

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

const props = defineProps({
    conferences: {
        type: Array,
        default: [],
    },
});

function join(id) {
    Inertia.post(route("join", id));
}

</script>

<template>
<!--    <Head title="Conferences" />-->

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
                        <tbody v-for="conference in props.conferences.data">
                        <tr>
                            <th scope="row">{{ conference.id }}</th>
                            <td class="max-w-xs">{{ conference.title }}</td>
                            <td>{{ conference.date }}</td>
                            <td>
                                <Link :href="route('Details', conference.id )">
                                    <button class="btn btn-outline-info">
                                        Details
                                    </button>
                                </Link>
                            </td>
                            <td>
                                <button v-if="conference.isOwn"
                                        class="btn btn-outline-success">IT IS MINE</button>
                                <div v-else>
                                <button v-if="conference.isAlreadyJoined" class="btn btn-outline-danger">Cancel participation</button>
                                </div>
                                        <button v-else class="btn btn-outline-success"
                                                @click="join(conference.id)"
                                        >
                                            Join
                                        </button>
                            </td>
                            <td>
                                <div class="hide">
                                <ul>
                                    <li>fb</li>
                                    <li>tw</li>
                                </ul>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </b-table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
