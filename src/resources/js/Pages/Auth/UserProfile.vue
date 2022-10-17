<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import 'vue3-social-share/lib/index.css'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

const props = defineProps({
    countries: {
        type: Array,
        default: [],
    },

    user: {
        type: Array,
        default: [],
    },
});

const form = useForm({
    first_name: props.user.first_name,
    last_name: props.user.last_name,
    email: props.user.email,
    password: null,
    password_confirmation: null,
    birthdate: props.user.birthdate.slice(0,10),
    countries: props.user.countries,
    phone: props.user.phone,
    role: props.user.role,
    terms: false,
});

const submit = () => {
    form.post(route('user_profile_update'))};
</script>

<template>
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="min-h-screen flex flex-col sm:justify-center items-center pt-2 sm:pt-0 bg-gray-100">
                <div class="w-full sm:max-w-md mt-2 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
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
                                    v-model="form.password" required autocomplete="current-password" />
                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>
                        <div class="mt-4">
                            <InputLabel for="password_confirmation" value="Confirm Password" />
                            <TextInput id="password_confirmation" type="password" class="mt-1 block w-full"
                                    v-model="form.password_confirmation" required autocomplete="current-password" />
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
                                <option v-for="country in props.countries" :value="country.nicename"
                                        class="form-control">{{ country.nicename }} + {{ country.phonecode }}
                                </option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.countries" />
                        </div>
                        <div class="mt-4">
                            <InputLabel for="phone" value="Phone Number" />
                            <TextInput id="phone" type="tel" class="mt-1 block w-full"
                                    v-model="form.phone" required autocomplete="phone" />
                            <InputError class="mt-2" :message="form.errors.phone" />
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <PrimaryButton class="ml-4"
                                        :class="{ 'opacity-25': form.processing }"
                                        :disabled="form.processing">
                                Save
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>