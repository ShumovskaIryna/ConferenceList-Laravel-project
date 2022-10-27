<script setup>
import {useForm} from '@inertiajs/inertia-vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    durationReport: {
        type: Array,
        default: [5, 35],
    },
    timeConf: {
        type: Array,
        default: [],
    },
    categories:{
        type: Array,
        default: [],
    }
});

const form = useForm({
    maxDurationReport: props.durationReport[0],
    minDurationReport: props.durationReport[1],
    selectedCategories: [7],
    TimeStart: props.timeConf[0],
    TimeFinish: props.timeConf[1],
    terms: false,
});

const categoriesNames = props.categories.map((category) => ({
    id: category.id,
    name: category.name
}));

function onMultipleSelectIput(...args) {
    console.log(args)
}

const submit = () => {
    form.post(route('conference_create'));
};

</script> 
<template>
    <div class="relative inline-block top-0 left-0 border-b border-gray-200">
        <div class="single-sidebar-box">
            <form @submit.prevent="submit">
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
                    <Multiselect
                        v-model="form.selectedCategories"
                        label="name"
                        name="name"
                        track-by="id"
                        @input="onMultipleSelectIput"
                        :options="categoriesNames">
                    </Multiselect>
                 <pre>{{ form.selectedCategories }}</pre>
                </div>
                <div class="flex items-center justify-end mt-4">
                    <PrimaryButton class="ml-4"
                                    :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing">
                        Apply
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </div>
</template>