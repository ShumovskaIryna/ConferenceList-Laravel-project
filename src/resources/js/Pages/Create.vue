<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link, useForm} from '@inertiajs/inertia-vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Map from './Map.vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

const props = defineProps({
    countries: {
        type: Array,
        default: [],
    },
    components: {
            Map
    },
    center: {
        type: Object,
    },
});

axios.get('/get-countries').then(response => {
    props.countries = response.data;
}).catch(error => {
    console.error(error);
});

const form = useForm({
    title: '',
    date: '',
    position: {
        lat: '',
        lng: ''
    },
    countries: '',
    terms: false,
});

const submit = () => {
    form.post(route('conferences'));
};
</script>

<template>
    <Head title="Create" />

    <AuthenticatedLayout>
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        <Head title="Create" />

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
                           v-model="form.position.lat" autofocus/>
                <InputError class="mt-2" :message="form.errors.lat"/>
            </div>

            <div class="mt-4">
                <InputLabel for="lng" value="Longitude" />
                <TextInput id="lng" type="text" class="mt-1 block w-full"
                           v-model="form.position.lng" autofocus/>
                <InputError class="mt-2" :message="form.errors.lng" />
            </div>

            <div class="mt-4" id="app"
                 v-if="form.position.lat && form.position.lng">
                    <Map
                        :center="form.position"
                        :position="form.position" />
                </div>

            <div class="mt-4">
                <InputLabel for="countries" value="Country" />
                <select id="countries" class="mt-1 block w-full" v-model="form.countries" required>
                    <option class="form-control" selected>Ukraine</option>
                    <option v-for="country in props.countries" :value="country.nicename"
                            class="form-control">{{ country.nicename }}</option>
                </select>
                <InputError class="mt-2" :message="form.errors.countries" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <PrimaryButton class="ml-4"
                               :class="{ 'opacity-25': form.processing }"
                               :disabled="form.processing">
                    Create
                </PrimaryButton>
            </div>
        </form>
                <Link :href="route('Conferences')">
                <button class="btn btn-outline-dark">Back</button></Link>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
