<script setup>
import { ref } from 'vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import { Link } from '@inertiajs/inertia-vue3';

</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Navigation Links -->
                            <div class="space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <NavLink :href="route('Conferences')" :active="route().current('Conferences')"
                                         class="font-bold text-lg text-sky-700 no-underline">
                                    <button type="button"
                                            class="inline-flex items-center px-3 py-2 text-sm leading-4 font-bold
                                                    rounded-md text-sky-600 hover:text-sky-800
                                                    focus:outline-none transition ease-in-out duration-150">
                                                <span
                                                    class="font-bold text-lg text-sky-800">
                                                    Conferences
                                                </span>
                                    </button>
                                </NavLink>
                            </div>
                            <div v-if="$page.props.auth.user?.role === 'ANNOUNCER' ||
                                       $page.props.auth.user?.role === 'ADMIN'"
                                 class="space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <NavLink :href="route('Create')" :active="route().current('Create')"
                                         class="font-bold text-lg text-sky-700 no-underline">
                                    <button type="button"
                                            class="inline-flex items-center px-3 py-2 text-sm leading-4 font-bold
                                                    rounded-md text-sky-600 hover:text-sky-800
                                                    focus:outline-none transition ease-in-out duration-150">
                                                <span
                                                    class="font-bold text-lg text-sky-800">
                                                    +New
                                                </span>
                                    </button>
                                </NavLink>
                            </div>
                        </div>
                        <div class="sm:flex sm:items-center sm:ml-6">
                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button"
                                                    class="inline-flex items-center px-3 py-2 border
                                                    border-transparent text-sm leading-4 font-bold
                                                    rounded-md text-sky-600 bg-slate-200 hover:text-sky-800
                                                    focus:outline-none transition ease-in-out duration-150">
                                                <span
                                                    class="font-bold text-lg text-sky-600">
                                                    {{ $page.props.auth.user?.first_name || 'Guest'}}
                                                </span>
                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10
                                                    10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414
                                                    0l-4-4a1 1 0 010-1.414z"
                                                          clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>
                                    <template #content v-if="$page.props.auth?.user">
                                        <DropdownLink :href="route('logout')" method="post" as="button">
                                            Log Out
                                        </DropdownLink>
                                    </template>
                                    <template #content v-else>
                                        <Link :href="route('login')"
                                              class="ml-5 mt-48 text-sky-500 leading-relaxed no-underline">
                                            Log In
                                        </Link>
                                        <Link :href="route('register')"
                                              class="ml-5 mr-5 mt-48 text-cyan-500 leading-relaxed no-underline">
                                            Register
                                        </Link>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>
            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
