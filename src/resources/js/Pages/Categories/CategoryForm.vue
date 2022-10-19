<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link, useForm} from '@inertiajs/inertia-vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

const form = useForm({
    name: '',
    terms: false,
});

const submit = () => {
    form.post(route('category_create'));
};
</script>

<template>
    <Head title="Category Form" />

    <AuthenticatedLayout>
        <Link :href="route('conferences_list')">
            <button class="absolute ml-4 mt-1 btn btn-outline-primary">
                Back
            </button>
        </Link>
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <Head title="Category Form" />

                <form @submit.prevent="submit">
                    <div class="mt-4">
                        <InputLabel for="name" value="Name of category" />
                        <TextInput id="name" type="text" class="mt-1 block w-full"
                                   v-model="form.name" required autofocus />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <PrimaryButton class="ml-4" as="button"
                                       :class="{ 'opacity-25': form.processing }"
                                       :disabled="form.processing" >
                            Create Category
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>