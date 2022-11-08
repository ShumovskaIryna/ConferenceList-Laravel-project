<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import GoBack from '@/Components/GoBack.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import Map from './Map.vue'
import {Inertia} from "@inertiajs/inertia";
import {Share} from 'vue3-social-share';
import 'vue3-social-share/lib/index.css'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

const props = defineProps({
    conference: {
        type: Array,
        default: [],
    },
    components: {
        Map
    },
    center: {
        type: Object,
    },
    position: {
        type: Object,
    },
    auth: {
        type: Object,
        default: {},
    },
});

function createReport(id, categoryId)
{
    Inertia.get(route("get_report_form", [id, categoryId]));
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
    <Head title="Details" />

    <AuthenticatedLayout>
        <GoBack/>
        <div v-if="props.auth.user?.role === 'ADMIN'" class="relative text-right">
            <a class="btn btn-danger mt-1 mr-4" :href="route('members_export', conference.id)">Export members</a>
        </div>
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-2 sm:pt-0 bg-gray-100">
            <div class="w-full mt-5 sm:max-w-md mt-2 px-9 py-6 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <div class="row">
                    <div class="col">
                        {{props.conference.title}}
                    </div>
                    <div class="col">
                        {{new Date(props.conference.date).toLocaleString('en-US', 
                        {year: 'numeric', month: 'long', day: 'numeric',
                        weekday: 'long', hour: 'numeric', minute: 'numeric', hour24: false, 
                        timeZone: Intl.DateTimeFormat().resolvedOptions().timeZone })}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <div v-if="props.conference.lat && props.conference.lng" class="mt-4">
                            <Map
                                :center="{lat: parseFloat(props.conference.lat), lng: parseFloat(props.conference.lng)}"
                                :position="{ lat: parseFloat(props.conference.lat), lng: parseFloat(props.conference.lng)}"
                            />
                        </div>
                    </div>
                </div>
                <div class="row mt-4" v-if="props.conference.lat && props.conference.lng">
                    <div class="col">
                           Address -  {{props.conference.countries}} (lat: {{props.conference.lat}}; lng: {{props.conference.lng}})
                    </div>
                </div>
                <div class="flex items-center justify-end mt-4">
<!--              IF USER IS ADMIN OR OWNER-->
                    <div v-if="props.auth?.user?.role === 'ADMIN' || conference.isOwn">
                        <Link :href="route('conference_edit', conference.id )">
                            <button class="btn btn-outline-warning mr-4">
                                Edit
                            </button>
                        </Link>
                        <Link :href="route('conference_delete', conference.id )">
                            <button class="btn btn-outline-danger mr-4">
                                Delete
                            </button>
                        </Link>
                    </div>
<!--                IF USER IS NOT ADMIN-->
                    <div v-else>
                        <div v-if="props.conference.isAlreadyJoined" class="relative flex">
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
                        <div v-else>
                            <button v-if="props.auth?.user?.role === 'ANNOUNCER'"
                                    class="btn btn-outline-success"
                                    @click="createReport(conference.id, conference.category)">
                                Join
                            </button>
                            <button v-else
                                    class="btn btn-outline-success"
                                    @click="join(conference.id)">
                                Join
                            </button>
                        </div>
                    </div>
                    <Link :href="route('reports_list', conference.id)">
                        <button class="btn btn-outline-dark ml-5">
                            Reports
                        </button>
                    </Link>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
