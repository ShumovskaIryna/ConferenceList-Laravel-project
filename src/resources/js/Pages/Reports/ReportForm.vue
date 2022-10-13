<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link, useForm} from '@inertiajs/inertia-vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

const CONFERENCE_ID_INDEX = 4;

const url = window.location.href;
const lastParam = url.split("/");
const confId = lastParam[CONFERENCE_ID_INDEX];

const form = useForm({
    topic: '',
    time_start: '',
    time_finish: '',
    description: '',
    file: '',
    terms: false,
});

const submit = () => {
    form.post(route('report_create', confId));
};
</script>

<template>
    <Head title="ReportForm" />

    <AuthenticatedLayout>
        <Link :href="route('conference_details', confId)">
            <button class="absolute ml-4 mt-1 btn btn-outline-primary">
                Back
            </button>
        </Link>
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <Head title="ReportForm" />

                <form @submit.prevent="submit">
                    <div class="mt-4">
                        <InputLabel for="topic" value="Topic" />
                        <TextInput id="topic" type="text" class="mt-1 block w-full"
                                   v-model="form.topic" required autofocus />
                        <InputError class="mt-2" :message="form.errors.topic" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="time_start" value="Time Start" />
                        <TextInput id="time_start" type="datetime-local" class="mt-1 block w-full"
                                   v-model="form.time_start" required />
                        <InputError class="mt-2" :message="form.errors.time_start" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="time_finish" value="Time Finish" />
                        <TextInput id="time_finish" type="datetime-local" class="mt-1 block w-full"
                                   v-model="form.time_finish" required />
                        <InputError class="mt-2" :message="form.errors.time_finish" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="description" value="Description" />
                        <textarea v-model="form.description" id="description" type="text"
                                  class="mt-1 block w-full" required>
                        </textarea>
                        <InputError class="mt-2" :message="form.errors.description" />
                    </div>

                    <div class="mt-4 block w-full">
                        <InputLabel for="file" value="Presentation" />
                        <TextInput id="file" type="file"
                                   @input="form.file = $event.target.files[0]"/>
                        <InputError class="mt-2" :message="form.errors.file" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <PrimaryButton class="ml-4" as="button"
                                       :class="{ 'opacity-25': form.processing }"
                                       :disabled="form.processing" >
                            Create Report
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
