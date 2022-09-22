<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';

const props = defineProps({
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
    first_name: '',
    last_name: '',
    email: '',
    password: '',
    password_confirmation: '',
    role: '',
    birthdate: '',
    countries: '',
    phone: '',
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <form @submit.prevent="submit">
            <div class="mt-4">
                <InputLabel for="first_name" value="First Name" />
                <TextInput id="first_name" type="text" class="mt-1 block w-full"
                           v-model="form.first_name" required autofocus autocomplete="first_name" />
                <InputError class="mt-2" :message="form.errors.first_name" />
            </div>

            <div class="mt-4">
                <InputLabel for="last_name" value="Last Name" />
                <TextInput id="last_name" type="text" class="mt-1 block w-full"
                           v-model="form.last_name" required autofocus autocomplete="last_name" />
                <InputError class="mt-2" :message="form.errors.last_name" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email" />
                <TextInput id="email" type="email" class="mt-1 block w-full"
                           v-model="form.email" required autocomplete="username" />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />
                <TextInput id="password" type="password" class="mt-1 block w-full"
                           v-model="form.password" required autocomplete="new-password" />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Confirm Password" />
                <TextInput id="password_confirmation" type="password" class="mt-1 block w-full"
                           v-model="form.password_confirmation" required autocomplete="new-password" />
                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div class="mt-4">
                <InputLabel for="birthdate" value="Birthdate" />
                <TextInput id="birthdate" type="date" class="mt-1 block w-full"
                           v-model="form.birthdate" required autocomplete="birthdate" />
                <InputError class="mt-2" :message="form.errors.birthdate" />
            </div>

            <div class="mt-4">
                <InputLabel for="countries" value="Country" />
                <select id="countries" class="mt-1 block w-full" v-model="form.countries" required>
                    <option class="form-control" disabled selected>Select Country</option>
                    <option v-for="country in props.countries" :value="country.nicename" class="form-control">{{ country.nicename }} + {{ country.phonecode }}</option>
                </select>
                <InputError class="mt-2" :message="form.errors.countries" />
            </div>

            <div class="mt-4">
                <InputLabel for="phone" value="Phone Number" />
                <TextInput id="phone" type="tel" class="mt-1 block w-full"
                           v-model="form.phone" required autocomplete="phone" />
                <InputError class="mt-2" :message="form.errors.phone" />
            </div>

            <div class="mt-4">
                <InputLabel for="role" value="Register as" />
                <select id="role" class="mt-1 block w-full" v-model="form.role" required>
                    <option>Announcer</option>
                    <option selected>Listener</option>
                </select>
                <InputError class="mt-2" :message="form.errors.role" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900">
                    Already registered?
                </Link>

                <PrimaryButton class="ml-4"
                               :class="{ 'opacity-25': form.processing }"
                               :disabled="form.processing">
                    Register
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
