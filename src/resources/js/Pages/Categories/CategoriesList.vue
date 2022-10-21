<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/inertia-vue3';
import 'vue3-social-share/lib/index.css'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import { library } from '@fortawesome/fontawesome-svg-core'
import { faTrash, faPen} from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
library.add(faTrash, faPen)

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
                            <th scope="col">Categories</th>
                            <th scope="col">Conferences/Reports Count</th>
                            <th scope="col">Delete</th>
                            <th scope="col">Edit</th>
                        </tr>
                        </thead>
                        <tbody v-for="category in props.categories" class="text-purple-700 mt-3">
                        <tr>
                            <td scope="row">{{ category.id }}</td>
                            <td scope="row">
                                {{ category.name }}
                                <ul v-for="child in category.children" class="text-blue-700 mt-3">
                                    <li>
                                        {{ child.name }}
                                            <Link :href="route('category_delete', child.id )">
                                                <font-awesome-icon class="ml-1" icon="fa-solid fa-trash" />
                                            </Link>
                                            <Link :href="route('category_edit', child.id )">
                                                <font-awesome-icon class="ml-1" icon="fa-solid fa-pen" />
                                            </Link>
                                        <ul v-for="grandChild in child.children" class="text-sky-600 mt-3">
                                            <li>
                                                {{ grandChild.name }}
                                                    <Link :href="route('category_delete', grandChild.id )">
                                                        <font-awesome-icon class="ml-1" icon="fa-solid fa-trash" />
                                                    </Link>
                                                    <Link :href="route('category_edit', grandChild.id )">
                                                        <font-awesome-icon class="ml-1" icon="fa-solid fa-pen" />
                                                    </Link>
                                                <ul v-for="ggrandChild in grandChild.children" class="text-cyan-600 mt-3">
                                                    <li>{{ ggrandChild.name }}
                                                        <Link :href="route('category_delete', ggrandChild.id )">
                                                            <font-awesome-icon class="ml-1" icon="fa-solid fa-trash" />
                                                        </Link>
                                                        <Link :href="route('category_edit', ggrandChild.id )">
                                                            <font-awesome-icon class="ml-1" icon="fa-solid fa-pen" />
                                                        </Link>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </td>
                            <td scope="row">
                                {{ category.conferences_count }}/{{ category.reports_count }}
                                <ul v-for="child in category.children" class="text-blue-700 mt-3">
                                    <li>
                                        {{ child.conferences_count }}/{{ child.reports_count }}
                                        <ul v-for="grandChild in child.children" class="text-sky-600 mt-3">
                                            <li>
                                                {{ grandChild.conferences_count }}/{{ grandChild.reports_count }}
                                                <ul v-for="ggrandChild in grandChild.children" class="text-cyan-600 mt-3">
                                                    <li>
                                                        {{ ggrandChild.conferences_count }}/{{ ggrandChild.reports_count }}
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </td>
                            <td scope="row">
                                <Link :href="route('category_delete', category.id )">
                                    <font-awesome-icon icon="fa-solid fa-trash" />
                                </Link>
                            </td>
                            <td scope="row">
                                <Link :href="route('category_edit', category.id )">
                                    <font-awesome-icon icon="fa-solid fa-pen" />
                                </Link>
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