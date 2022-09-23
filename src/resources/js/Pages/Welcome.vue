<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
})
</script>

<template>
    <Head title="Welcome" />

    <div class="relative flex items-top justify-center min-h-screen bg-slate-200 content-center
            sm:items-center sm:pt-0">
        <div v-if="canLogin" class="fixed w-6/12 content-center text-center ">
            <Link v-if="$page.props.auth.user" :href="route('Conferences')"
                  class="font-bold text-6xl text-sky-400">
                Conferences<span class="text-sky-500">-></span>
                <span class="text-sky-600">></span>
                <span class="text-sky-700">></span>
                <span class="text-sky-800">></span>
                <span class="text-sky-900">></span>
            </Link>

            <template v-else>
                <Link :href="route('login')"
                      class="font-bold text-6xl text-sky-500 leading-relaxed">
                    Log In<span class="text-sky-500">-></span>
                    <span class="text-sky-600">></span>
                    <span class="text-sky-700">></span>
                    <span class="text-sky-800">></span>
                    <span class="text-sky-900">></span>
                </Link>

                <Link v-if="canRegister" :href="route('register')"
                      class="ml-48 mt-48 font-bold text-6xl text-cyan-500 leading-relaxed">
                    Register<span class="text-cyan-500">-></span>
                    <span class="text-cyan-600">></span>
                    <span class="text-cyan-700">></span>
                    <span class="text-cyan-800">></span>
                    <span class="text-cyan-900">></span>
                </Link>
            </template>
        </div>
    </div>
</template>
