<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link, useForm} from '@inertiajs/inertia-vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import 'vue3-social-share/lib/index.css'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

const CONFERENCE_ID_INDEX = 4;

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
});

const form = useForm({
    comment: '',
    terms: false,
});

const submit = () => {
    form.post(route('comment_create', [confId, props.report.id]), {
        onFinish: () => form.reset('comment'),
    });
};
</script>

<template>
    <Head title="Details" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0 bg-gray-100">
                <div class="w-full sm:max-w-md px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                    <div class="mb-2 text-sky-900 text-lg text-center">
                        Report #{{props.report.id}}
                    </div>
                    <div class="mb-2 bg-white text-sky-900 border-b border-gray-200">
                        Topic: {{props.report.topic}}
                    </div>
                    <div class="mb-2 bg-white text-sky-800 border-b border-gray-200">
                        From {{props.report.time_start}}
                        Untill {{props.report.time_finish}}
                    </div>
                    <div class="mb-2 bg-white text-sky-700 border-b border-gray-200">
                        Description: {{props.report.description}}
                    </div>
                    <div class="mb-4 bg-white text-sky-600 border-b border-gray-200">
                        Presentation: {{props.report.file_path}}
                    </div>
                    <div v-if="props.report.isOwn" class="mt-4">
                        <Link :href="route('report_edit', [confId, props.report.id])">
                            <button class="mb-4 mr-2 btn btn-outline-warning">
                                Edit
                            </button>
                        </Link>
                        <Link :href="route()">
                        <button class="mb-4 btn btn-outline-danger">
                                Leave & delete
                            </button>
                        </Link>
                    </div>
                    <div class="mb-4 bg-white text-sky-600 border-b border-gray-200">
                        <form @submit.prevent="submit">
                            <div class="mt-4">
                                <InputLabel for="comment" value="Write your comment" />
                                <TextInput id="comment" type="text" class="mt-1 block w-full"
                                           v-model="form.comment" required/>
                                <InputError class="mt-2" :message="form.errors.comment" />
                            </div>
                            <div class="flex items-center justify-end mt-4">
                                <PrimaryButton class="ml-4"
                                               :class="{ 'opacity-25': form.processing }"
                                               :disabled="form.processing">
                                    Add comment
                                </PrimaryButton>
                            </div>
                        </form>
                        Comments:
                        <div v-for="comment in props.comments.data">
                            <div class="mb-2 text-sky-900 text-lg text-center">
                                Comment #{{comment.id}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
