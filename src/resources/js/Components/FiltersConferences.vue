<script setup>
import {useForm} from '@inertiajs/inertia-vue3';

const props = defineProps({
    countReport: {
    type: Array,
    default: [5, 35],
},
    dateConf: {
    type: Array,
    default: [],
}
});

const form = useForm({
    maxCountReport: props.countReport[0],
    minCountReport: props.countReport[1],
    category: '',
    maxDate: props.dateConf[0],
    minDate: props.dateConf[1],
    terms: false,
});

</script> 
<template>
    <div class="relative inline-block top-0 left-0 border-b border-gray-200">
        <div class="single-sidebar-box">
            <form>
                <h6>Count of report in conference</h6>
                <div class="mt-5 mb-2">
                    <Slider
                        :min="0"
                        :max="50"
                        :step="1"
                        v-model="props.countReport">
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
                <h6>Select date conference</h6>
                <div class="justify-center mt-2 mb-2">
                    <Datepicker 
                        :range="true"
                        v-model="props.dateConf">
                    </Datepicker>
                </div>
            </form>
        </div>
    </div>
</template>