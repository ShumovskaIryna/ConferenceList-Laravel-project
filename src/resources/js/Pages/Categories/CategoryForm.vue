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

const props = defineProps({
    categories: {
        type: Array,
        default: [],
    },
});

const form = useForm({
    name: '',
    type: '',
    category_id: '',
    terms: false,
});

const submit = () => {
    form.post(route('category_create'));
};
</script>

<template>
    <Head title="Category Form" />

    <AuthenticatedLayout>
        <GoBack/>
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <Head title="Category Form" />

                <form @submit.prevent="submit">
                    <div class="mt-4">
                        <InputLabel for="name" value="Category name" />
                        <TextInput id="name" type="text" class="mt-1 block w-full"
                                   v-model="form.name" required/>
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="type" value="Type: (Category or Subcategory)" />
                        <select id="type" class="mt-1 block w-full" v-model="form.type" required>
                            <option :value="Category">Category</option>
                            <option>sub-Category</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.type" />
                    </div>

                    <div class="mt-4" v-if="form.type">
                        <InputLabel for="category_id" value="Choose parent category" />
                        <select id="category_id" class="mt-1 block w-full" v-model="form.category_id">
                            <option v-for="category in props.categories" :value="category.id">{{ category.name }}</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.category_id" />
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