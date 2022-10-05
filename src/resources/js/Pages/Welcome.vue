<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
})
</script>

<template>
    <Head title="Welcome" />
    <div class="relative flex items-top justify-center min-h-screen bg-slate-200 content-center
            sm:items-center sm:pt-0">
        <div v-if="canLogin" class="content-center text-center ">
                <Link :href="route('Conferences')"
                    class="font-bold text-3xl text-sky-400 hover:bg-gray-300">
                    <button type="button"
                            class="inline-flex items-center px-3 py-2 text-sm leading-4 font-bold
                                rounded-md text-sky-600 hover:text-sky-800
                                focus:outline-none transition ease-in-out duration-150">
                        <span class="font-bold text-lg text-sky-800">
                            Conferences
                        </span>
                    </button>
                </Link>
                <Link :href="route('login')"
                      class="font-bold text-3xl text-sky-400 hover:bg-gray-300">
                    <button type="button"
                            class="inline-flex items-center px-3 py-2 text-sm leading-4 font-bold
                                rounded-md text-sky-600 hover:text-sky-800
                                focus:outline-none transition ease-in-out duration-150">
                    <span class="font-bold text-lg text-sky-800">
                       Login
                    </span>
                    </button>
                </Link>
                <Link v-if="canRegister" :href="route('register')"
                      class="font-bold text-3xl text-sky-400 hover:bg-gray-300">
                    <button type="button"
                            class="inline-flex items-center px-3 py-2 text-sm leading-4 font-bold
                                rounded-md text-sky-600 hover:text-sky-800
                                focus:outline-none transition ease-in-out duration-150">
                    <span class="font-bold text-lg text-sky-800">
                       Register
                    </span>
                    </button>
                </Link>
        </div>
    </div>
</template>
