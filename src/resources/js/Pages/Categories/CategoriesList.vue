<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/inertia-vue3';
import 'vue3-social-share/lib/index.css'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

const props = defineProps({
    categories: {
        type: Array,
        default: [],
    },
});
</script>

<template>
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-x-scroll shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                    <b-table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name of Parent Category</th>
                            <th scope="col">Name of Child Category</th>
                        </tr>
                        </thead>
                        <tbody v-for="category in props.categories">
                        <tr>
                            <th scope="row">{{ category.id }}</th>
                            <td class="max-w-xs p-2">{{ category.name }}</td>
                            <td class="max-w-xs p-2">{{ category.name }}</td>
                            <td>
                                <!-- <Link :href="route('category_delete', category.id )">
                                    <button class="btn btn-outline-danger mt-1">
                                        Delete
                                    </button>
                                </Link> -->
                            </td>
                        </tr>
                        </tbody>
                    </b-table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>