<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/inertia-vue3';
import { Inertia } from "@inertiajs/inertia";
import {Share} from 'vue3-social-share';
import 'vue3-social-share/lib/index.css'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import Pagination from '@/Components/Pagination.vue'

const props = defineProps({
    conferences: {
        type: Array,
        default: [],
    },
    auth: {
        type: Object,
        default: {},
    },
});

function createReport(id)
{
    Inertia.get(route("get_report_form", id));
}

function unjoin(id)
{
    Inertia.post(route("unjoin", id));
}
</script>

<template>
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-x-scroll shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">

                    <h2>I AM {{props.auth?.user?.role || 'GUEST'}}</h2>

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
                            <td class="max-w-xs">{{ conference.title }}</td>
                            <td>{{ conference.date }}</td>
<!--                            IF USER IS NOT GUEST-->
                            <td>
                                <Link :href="route('Details', conference.id )">
                                    <button class="btn btn-outline-info">
                                        Details
                                    </button>
                                </Link>
                            </td>

<!--                            IF USER IS ADMIN OR OWNER-->
                            <td>
                                <div v-if="props.auth?.user?.role === 'ADMIN' || conference.isOwn">
                                    <Link :href="route('Delete', conference.id )">
                                        <button class="btn btn-outline-danger mr-4">
                                            Delete
                                        </button>
                                    </Link>
                                </div>
<!--                            IF USER IS NOT ADMIN-->
                                <div v-else>
                                    <div v-if="conference.isAlreadyJoined" class="relative flex">
                                        <button class="btn btn-outline-danger" @click="unjoin(conference.id)">
                                            Cancel participation
                                        </button>
                                            <div class="hide ml-5">
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
                                        <button v-else class="btn btn-outline-success" @click="createReport(conference.id)">
                                            Join
                                        </button>
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
