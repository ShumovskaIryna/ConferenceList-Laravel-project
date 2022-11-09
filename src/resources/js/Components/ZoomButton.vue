<script setup>
import 'vue3-social-share/lib/index.css'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import { library } from '@fortawesome/fontawesome-svg-core'
import { faVideo} from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
library.add(faVideo)

const props = defineProps({
    report: {
        type: Array,
        default: [],
    },
    conference: {
        type: Array,
        default: [],
    },
});
</script>

<template>
    <div>
        <div v-if="report.isWaiting">
            <div class="h-8 p-1 ml-2 btn btn-outline-warning ml-1 mt-1">
                Waiting
            </div>
            00:10:00
        </div>
        <div v-if="report.isStarted && report.isNotEnded">
            <div class="h-8 p-1 ml-2 btn btn-outline-success">
                Started
            </div>
            <button class="btn btn-outline-primary ml-1">
                <font-awesome-icon icon="fa-solid fa-video" />
            </button>
        </div>
        <div v-if="report.isEnded">
            <div class="h-8 p-1 ml-2 btn btn-outline-danger">
                Ended
            </div>
        </div>
    </div>
</template>