<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import GoBack from '@/Components/GoBack.vue';
import ZoomButton from '@/Components/ZoomButton.vue';
import {Head, Link, useForm} from '@inertiajs/inertia-vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import 'vue3-social-share/lib/index.css'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import {Inertia} from "@inertiajs/inertia";
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import Pagination from '@/Components/Pagination.vue'

const CONFERENCE_ID_INDEX = 4;

const editorConfig = {};
const url = window.location.href;
const lastParam = url.split("/");
const confId = lastParam[CONFERENCE_ID_INDEX];

const props = defineProps({
    report: {
        type: Array,
        default: [],
    },
    comments: {
        type: Array,
        default: [],
    },
    comment: {
        type: Array,
        default: [],
    },
    conference: {
        type: Array,
        default: [],
    },
    auth: {
        type: Object,
        default: {},
    },
});

const form = useForm({
    comment_message: '',
    terms: false,
});

const submit = () => {
    form.post(route('comment_create', [confId, props.report.id]), {
        onFinish: () => {
            form.defaults({
                comment_message: '',
            });
            form.reset();
        }
    });
};

function unjoin(confId)
{
    Inertia.post(route("unjoin", confId));
}

function deleteComment(confId, reportId, commentId)
{
    Inertia.post(route('comment_delete', [confId, reportId, commentId]));
}

function editComment(confId, reportId, commentId)
{
    Inertia.get(route('comment_edit', [confId, reportId, commentId]));
}

</script>

<template>
    <Head title="Details" />

    <AuthenticatedLayout>
        <GoBack/>
        <div v-if="props.auth.user?.role === 'ADMIN'" class="top-16 right-4 absolute">
            <a class="btn btn-danger mt-1 mb-1 ml-4" :href="route('comments_export', [confId, props.report.id])">
                Export comments
            </a>
        </div>
        <div class="py-12">
            <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0 bg-gray-100">
                <div class="w-full sm:max-w-md px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                    <div class="mb-2 text-sky-900 text-lg text-center">
                        Report #{{props.report.id}}
                        <ZoomButton
                            :conference = "props.conference"
                            :report = "props.report"/>
                    </div>
                    <div class="mb-2 bg-white text-sky-900 border-b border-gray-200">
                        Topic: {{props.report.topic}}
                    </div>
                    <div class="mb-2 bg-white text-sky-800 border-b border-gray-200">
                            On: {{new Date(props.report.time_start).toLocaleString('en-US',
                        {month: 'long', day: 'numeric', weekday: 'long',
                        timeZone: Intl.DateTimeFormat().resolvedOptions().timeZone })}}
                        <br>
                            from: {{new Date(props.report.time_start).toLocaleString('en-US',
                        {hour: 'numeric', minute: 'numeric', hour24: false, 
                        timeZone: Intl.DateTimeFormat().resolvedOptions().timeZone })}}
                        <br>
                            untill: {{new Date(props.report.time_finish).toLocaleString('en-US', 
                        {hour: 'numeric', minute: 'numeric', hour24: false, 
                        timeZone: Intl.DateTimeFormat().resolvedOptions().timeZone })}}
                    </div>
                    <div class="mb-2 bg-white text-sky-700 border-b border-gray-200">
                        Description: {{props.report.description}}
                    </div>
                    <div class="mb-4 bg-white text-sky-600 border-b border-gray-200">
                        <a :href="props.report.file_path" download>
                            Open presentation
                        </a>
                    </div>
                    <div v-if="props.report.isOwn" class="mt-4">
                        <Link v-if="props.conference.category" :href="route('report_edit', [confId, props.report.id, props.conference.category])">
                            <button class="mb-4 mr-2 btn btn-outline-warning">
                                Edit
                            </button>
                        </Link>
                        <Link v-else :href="route('report_edit', [confId, props.report.id, 0])">
                            <button class="mb-4 mr-2 btn btn-outline-warning">
                                Edit
                            </button>
                        </Link>
                        <button class="mb-4 btn btn-outline-danger" @click="unjoin(confId)">
                                Leave & delete
                        </button>
                    </div>
                    <div class="mb-4 bg-white text-sky-600 border-b border-gray-200">
                        <form @submit.prevent="submit">
                            <div class="mt-4">
                                <ckeditor  id="comment_message" type="text" class="mt-1 block w-full" 
                                        :editor="ClassicEditor" v-model="form.comment_message" 
                                        :config="editorConfig" required>
                                </ckeditor>
                            </div>
                            <div class="flex items-center justify-end mt-4">
                                <PrimaryButton class="ml-4"
                                               :class="{ 'opacity-25': form.processing }"
                                               :disabled="form.processing">
                                    Add comment
                                </PrimaryButton>
                            </div>
                        </form>
                        <div v-for="comment in props.comments.data">
                            <div class="mt-2 text-sm text-sky-400 border-b border-gray-200">
                                <div class="mt-1 text-sm text-sky-600">
                                    {{comment.user.first_name}} {{comment.user.last_name}} |                 
                                    {{new Date(comment.created_at).toLocaleString('en-US', 
                                {month: 'short', day: 'numeric', hour: 'numeric', minute: 'numeric', 
                                hour24: false, timeZone: Intl.DateTimeFormat().resolvedOptions().timeZone })}}
                                </div>
                                <div class="mt-1 text-lg text-sky-900" v-html="comment.comment_message">
                                </div>
                                <div class="mt-1 text-sm text-cyan-600">
                                    <button
                                        v-if="props.auth?.user?.role === 'ADMIN' || comment.isOwn"
                                        @click="deleteComment(confId, props.report.id, comment.id)">
                                        Delete | 
                                    </button>
                                    <button
                                        v-if="props.auth?.user?.role === 'ADMIN' || comment.isOwn"
                                        @click="editComment(confId, props.report.id, comment.id)">
                                         | Edit
                                    </button>
                                </div>
                            </div>
                        </div>
                            <div class="relative flex justify-center">
                                <Pagination :links="comments.links" />
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
