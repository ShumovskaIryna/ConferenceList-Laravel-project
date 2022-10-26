<script setup>
import {useForm} from '@inertiajs/inertia-vue3';

const props = defineProps({
    durationReport: {
    type: Array,
    default: [5, 35],
},
    timeConf: {
    type: Array,
    default: [],
}
});

const form = useForm({
    maxDurationReport: props.durationReport[0],
    minDurationReport: props.durationReport[1],
    category: '',
    TimeStart: props.timeConf[0],
    TimeFinish: props.timeConf[1],
    terms: false,
});

</script> 
<template>
    <div class="relative inline-block top-0 left-0 border-b border-gray-200">
        <div class="single-sidebar-box">
            <form>
                <h6>Time Start</h6>
                <div class="mt-2 mb-2">
                    <Datepicker 
                        :range="true"
                        v-model="props.timeConf">
                    </Datepicker>
                </div>
                <h6>Time Finish</h6>
                <div class="mt-2 mb-2">
                    <Datepicker 
                        :range="true"
                        v-model="props.timeConf">
                    </Datepicker>
                </div>
                <h6>Duration of the report</h6>
                <div class="mt-5 mb-2">
                    <Slider
                        :min="1"
                        :max="60"
                        :step="1"
                        v-model="props.durationReport">
                    </Slider>
                </div>
                <h6>Select Category</h6>
                <div class="mt-2 mb-2">
                    <div class="form-group">
                        <input type="checkbox">
                    It
                    </div>
                    <div class="form-group">
                        <input type="checkbox" >
                    Transport
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>