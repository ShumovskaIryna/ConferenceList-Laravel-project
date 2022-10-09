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
    comment: {
        type: Array,
        default: [],
    },
});

const form = useForm({
    comment_message: props.comment.comment_message,
    terms: false,
});

const submit = () => {
    form.post(route('edit_save_comment', [confId, props.report.id, props.comment.id]));
};

</script>

<template>
    <Head title="Details" />

    <AuthenticatedLayout>
        <Link :href="route('report_details', [confId, props.report.id])">
            <button class="absolute ml-4 mt-1 btn btn-outline-primary">
                Back
            </button>
        </Link>
        <div class="py-12">
            <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0 bg-gray-100">
                <div class="w-full sm:max-w-md px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                    <div class="mb-4 bg-white text-sky-600 border-b border-gray-200">
                        <form @submit.prevent="submit">
                            <div class="mt-4">
                                <InputLabel for="comment_message" value="Edit your comment" />
                                <TextInput id="comment_message" type="text" class="mt-1 block w-full"
                                           v-model="form.comment_message" required/>
                                <InputError class="mt-2" :message="form.errors.comment_message" />
                            </div>
                            <div class="flex items-center justify-end mt-4">
                                <PrimaryButton class="ml-4"
                                               :class="{ 'opacity-25': form.processing }"
                                               :disabled="form.processing">
                                    Save comment
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
