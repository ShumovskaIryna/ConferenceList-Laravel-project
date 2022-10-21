<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/inertia-vue3';
import 'vue3-social-share/lib/index.css'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue'
import { library } from '@fortawesome/fontawesome-svg-core'
import { faTrash} from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
library.add(faTrash)

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
                            <th scope="col">Delete</th>
                            <th scope="col">Edit</th>
                        </tr>
                        </thead>
                        <tbody v-for="category in props.categories">
                        <tr>
                            <td scope="row">{{ category.id }}</td>
                            <td scope="row">
                                <Disclosure>
                                    <DisclosureButton className="py-2">
                                        {{ category.name }} 
                                    </DisclosureButton>
                                    <DisclosurePanel className="text-gray-600">
                                        <ul v-for="child in category.children">
                                            <li>
                                                <Disclosure>
                                                    <DisclosureButton className="py-2">
                                                        {{ child.name }}
                                                            <Link :href="route('category_delete', child.id )">
                                                                <font-awesome-icon icon="fa-solid fa-trash" />
                                                            </Link>
                                                    </DisclosureButton> 
                                                    <DisclosurePanel className="text-gray-500">
                                                        <ul v-for="grandChild in child.children">
                                                            <li>
                                                                <Disclosure>
                                                                    <DisclosureButton className="py-2">
                                                                        {{ grandChild.name }}
                                                                            <Link :href="route('category_delete', grandChild.id )">
                                                                                <font-awesome-icon icon="fa-solid fa-trash" />
                                                                            </Link>
                                                                    </DisclosureButton> 
                                                                    <DisclosurePanel className="text-gray-400">
                                                                        <ul v-for="ggrandChild in grandChild.children">
                                                                            <li>{{ ggrandChild.name }}
                                                                                <Link :href="route('category_delete', ggrandChild.id )">
                                                                                    <font-awesome-icon icon="fa-solid fa-trash" />
                                                                                </Link>
                                                                            </li>
                                                                        </ul>
                                                                    </DisclosurePanel>
                                                                </Disclosure>
                                                            </li>
                                                        </ul>
                                                    </DisclosurePanel>
                                                </Disclosure>
                                            </li>
                                        </ul>
                                    </DisclosurePanel>
                                </Disclosure>
                            </td>
                            <td scope="row">
                                <Link :href="route('category_delete', category.id )">
                                    <font-awesome-icon icon="fa-solid fa-trash" />
                                </Link>
                            </td>
                            <td scope="row">
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