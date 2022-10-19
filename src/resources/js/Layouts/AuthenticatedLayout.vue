<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/inertia-vue3';
import { library } from '@fortawesome/fontawesome-svg-core'
import { faHeart } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
library.add(faHeart)

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('conferences_list')">
                                    <ApplicationLogo class="block h-9 w-auto" />
                                </Link>
                            </div>
                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <NavLink :href="route('conferences_list')" :active="route().current('conferences_list')"
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
                                 class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <NavLink :href="route('conference_new')" :active="route().current('conference_new')"
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
                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <!-- Settings Dropdown -->
                            <Link v-if="$page.props.auth.user?.favCount > 0" :href="route('reports_fav_list')">
                                <button v-if="99 >= $page.props.auth.user?.favCount > 0" class="mt-1 btn btn-outline-danger">
                                        <font-awesome-icon icon="fa-solid fa-heart" /> {{$page.props.auth.user?.favCount}}
                                </button>
                                <button v-if="$page.props.auth.user?.favCount > 99" class="mt-1 btn btn-outline-danger">
                                        <font-awesome-icon icon="fa-solid fa-heart" /> 99+
                                </button>
                            </Link>
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
                                        <DropdownLink :href="route('user_profile')">
                                            Profile
                                        </DropdownLink>
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
                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button @click="showingNavigationDropdown = ! showingNavigationDropdown"
                                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400
                                    hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100
                                    focus:text-gray-500 transition duration-150 ease-in-out">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': showingNavigationDropdown, 'inline-flex'
                                    : ! showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round"
                                          stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': ! showingNavigationDropdown, 'inline-flex'
                                    : showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round"
                                          stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Responsive Navigation Menu -->
                <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}"
                     class="sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('conferences_list')" :active="route().current('conferences_list')">
                            Conferences
                        </ResponsiveNavLink>
                    </div>
                    <div v-if="$page.props.auth.user?.role === 'ANNOUNCER' ||
                                       $page.props.auth.user?.role === 'ADMIN'"
                         class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('conference_new')" :active="route().current('conference_new')">
                            +New
                        </ResponsiveNavLink>
                    </div>
                    <template v-if="$page.props.auth?.user">
                        <Link :href="route('logout')" method="post"
                              class="ml-5 mr-5 mt-48 text-cyan-500 leading-relaxed no-underline">
                            Log Out
                        </Link>
                    </template>
                    <template v-else>
                        <Link :href="route('login')"
                              class="ml-5 mt-48 text-sky-500 leading-relaxed no-underline">
                            Log In
                        </Link>
                        <Link :href="route('register')"
                              class="ml-5 mr-5 mt-48 text-cyan-500 leading-relaxed no-underline">
                            Register
                        </Link>
                    </template>
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
