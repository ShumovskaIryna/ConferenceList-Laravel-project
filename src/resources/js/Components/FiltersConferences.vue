<script setup>
import {useForm} from '@inertiajs/inertia-vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    countReport: {
        type: Array,
        default: [5, 35],
    },
    dateConf: {
        type: Array,
        default: [],
    },
    categories:{
        type: Array,
        default: [],
    }
});

const form = useForm({
    maxCountReport: props.countReport[0],
    minCountReport: props.countReport[1],
    selectedCategories: [7],
    maxDate: props.dateConf[0],
    minDate: props.dateConf[1],
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
                <h6>Count of report in conference</h6>
                <div class="mt-5 mb-2">
                    <Slider
                        :min="0"
                        :max="50"
                        :step="1"
                        v-model="props.countReport">
                    </Slider>
                </div>
                <h6>Select date conference</h6>
                <div class="justify-center mt-2 mb-2">
                    <Datepicker 
                        :range="true"
                        v-model="props.dateConf">
                    </Datepicker>
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