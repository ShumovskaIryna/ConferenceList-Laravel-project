<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import GoBack from '@/Components/GoBack.vue';
import {Head, useForm} from '@inertiajs/inertia-vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import {Inertia} from "@inertiajs/inertia";

const CONFERENCE_ID_INDEX = 4;

const url = window.location.href;
const lastParam = url.split("/");
const confId = lastParam[CONFERENCE_ID_INDEX];

const props = defineProps({
    report: {
        type: Object,
        default: {},
    },
    categories: {
        type: Array,
        default: [],
    },
    conference: {
        type: Array,
        default: [],
    }
});

const form = useForm({
    topic: props.report.topic,
    time_start: props.report.time_start,
    time_finish: props.report.time_finish,
    description: props.report.description,
    file: props.report.filePath,
    category: props.report.category,
    terms: false,
});

const submit = () => {
    if (props.conference.category)
    {
        form.post(route('edit_save_report',[confId, props.report.id, props.conference.category]));
    }
    else
    {
        form.post(route('edit_save_report',[confId, props.report.id, 0]));
    }
};

function unjoin(confId)
{
    Inertia.post(route("unjoin", confId));
}
</script>

<template>
    <Head title="ReportEdit" />

    <AuthenticatedLayout>
        <GoBack/>
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

                    <div class="mt-4 block w-full">
                        <InputLabel for="category" value="Category" />
                        <select id="category" class="mt-1 block w-full" v-model="form.category">
                            <option v-for="category in props.categories" :value="category.id">{{ category.name }}</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.category" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <PrimaryButton class="ml-4" as="button"
                                       :class="{ 'opacity-25': form.processing }"
                                       :disabled="form.processing" >
                            Save
                        </PrimaryButton>
                    </div>
                </form>
                <button class="mb-4 btn btn-outline-danger" @click="unjoin(confId)">
                    Leave & delete
                </button>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
