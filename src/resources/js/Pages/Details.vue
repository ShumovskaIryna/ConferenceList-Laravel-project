<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import Map from './Map.vue'
import {Inertia} from "@inertiajs/inertia";

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
function join(id) {
    Inertia.post(route("join", id));
}
function unjoin(id) {
    Inertia.post(route("unjoin", id));
}
</script>

<template>
    <Head title="Details" />

    <AuthenticatedLayout>
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-2 sm:pt-0 bg-gray-100">
            <div class="w-full sm:max-w-md mt-2 px-9 py-6 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <div class="row">
                    <div class="col">
                        {{props.conference.title}}
                    </div>
                    <div class="col">
                        {{props.conference.date}}
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
                <div class="row mt-4">
                </div>
                    <div class="flex items-center justify-end mt-4">
<!--              IF USER IS ADMIN OR OWNER-->
                        <div v-if="props.auth?.user?.role === 'ADMIN' || conference.isOwn">
                            <Link :href="route('Edit', conference.id )">
                                <button class="btn btn-outline-warning mr-4">
                                    Edit
                                </button>
                            </Link>
                            <Link :href="route('Delete', conference.id )">
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
                            <button v-else class="btn btn-outline-success" @click="join(conference.id)">
                                Join
                            </button>
                        </div>
                        <Link :href="route('Conferences')">
                            <button class="btn btn-outline-dark ml-5">
                                Back
                            </button>
                        </Link>
                    </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
