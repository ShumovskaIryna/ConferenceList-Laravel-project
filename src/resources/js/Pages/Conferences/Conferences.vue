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

function join(id)
{
    Inertia.post(route("join", id));
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
                            <td class="max-w-xs p-2">{{ conference.title }}</td>
                            <td> 
                                {{new Date(conference.date).toLocaleString('en-US', 
                                {month: 'short', day: 'numeric', hour: 'numeric', minute: 'numeric', hour24: false, 
                                timeZone: Intl.DateTimeFormat().resolvedOptions().timeZone })}}
                            </td>
<!--                            IF USER IS NOT GUEST-->
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
<!--                            IF USER IS ADMIN OR OWNER-->
                                <div v-if="props.auth?.user?.role === 'ADMIN' || conference.isOwn">
                                    <Link :href="route('conference_delete', conference.id )">
                                        <button class="btn btn-outline-danger mt-1">
                                            Delete
                                        </button>
                                    </Link>
                                </div>
<!--                            IF USER IS NOT ADMIN-->
                                <div v-else>
                                    <div v-if="conference.isAlreadyJoined" class="relative flex">
                                        <button class="btn btn-outline-danger mt-1" @click="unjoin(conference.id)">
                                            Cancel participation
                                        </button>
                                            <div class="hide">
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
                                    <div v-else>
                                        <button v-if="props.auth?.user?.role === 'ANNOUNCER'"
                                                class="btn btn-outline-success mt-1"
                                                @click="createReport(conference.id)">
                                            Join
                                        </button>
                                        <button v-else
                                                class="btn btn-outline-success mt-1"
                                                @click="join(conference.id)">
                                            Join
                                        </button>
                                    </div>
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