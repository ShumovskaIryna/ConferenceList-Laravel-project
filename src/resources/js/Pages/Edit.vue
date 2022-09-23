<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link, useForm} from '@inertiajs/inertia-vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    conference: {
        type: Array,
        default: [],
    },
    countries: {
        type: Array,
        default: [],
    },
});
axios.get('/get-countries').then(response => {
    props.countries = response.data;
}).catch(error => {
    console.error(error);
});

const form = useForm({
    title: props.conference.title,
    date: props.conference.date,
    lat: props.conference.lat,
    lng: props.conference.lng,
    countries: props.conference.countries,
    terms: false,
});

const submit = () => {
form.post(route('edit_save', props.conference.id));
};
</script>

<template>
    <Head title="Edit" />

    <AuthenticatedLayout>
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <Head title="Edit" />
                <form @submit.prevent="submit">
                    <div class="mt-4">
                        <InputLabel for="title" value="Title" />
                        <TextInput id="title" type="text" class="mt-1 block w-full"
                                   v-model="form.title" required autofocus autocomplete="title" />
                        <InputError class="mt-2" :message="form.errors.title" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="date" value="Date" />
                        <TextInput id="date" type="datetime-local" class="mt-1 block w-full"
                                   v-model="form.date" required autocomplete="date" />
                        <InputError class="mt-2" :message="form.errors.date" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="lat" value="Lattitude" />
                        <TextInput id="lat" type="text" class="mt-1 block w-full"
                                   v-model="form.lat" required autofocus autocomplete="lat" />
                        <InputError class="mt-2" :message="form.errors.lat" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="lng" value="Longitude" />
                        <TextInput id="lng" type="text" class="mt-1 block w-full"
                                   v-model="form.lng" required autofocus autocomplete="lng" />
                        <InputError class="mt-2" :message="form.errors.lng" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="countries" value="Country" />
                        <select id="countries" class="mt-1 block w-full" v-model="form.countries" required>
                            <option class="form-control" disabled selected>{{props.conference.countries}}</option>
                            <option v-for="country in props.countries"
                                    :value="country.nicename" class="form-control">{{ country.nicename }}</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.countries" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <PrimaryButton class="ml-4"
                                       :class="{ 'opacity-25': form.processing }"
                                       :disabled="form.processing">
                            Save
                        </PrimaryButton>
                    </div>
                </form>
                <Link :href="route('Details', conference.id)">
                    <button class="btn btn-outline-dark mr-4">Back</button></Link>
                <Link :href="route('Delete', conference.id )">
                    <button class="btn btn-outline-danger">Delete</button></Link>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

