<script>

export default {
  props: {
    durationReport: {
        type: Array,
        default: [5, 35],
    },
    timeReport: {
        type: Array,
        default: [],
    },
    selectedCategories: {
        type: Array,
        default: [7],
    },
    categories:{
        type: Array,
        default: [],
    }
  },
  data: function () {
    return {
      options: [],
    };
  },
  created() {
    this.options = this.categories.map((category) => ({
      value: category.id,
      name: category.name
    }));
  },
  methods: {
    submit() {
      this.$emit('submit', {
        durationReport: this.durationReport,
        timeReport: this.timeReport,
        selectedCategories: this.selectedCategories,
      });
    },
  }
}
</script> 
<template>
    <div class="relative inline-block top-0 left-0">
        <div class="single-sidebar-box">
            <form>
                <h6>Duration of the report</h6>
                <div class="mt-5 mb-2">
                    <Slider
                        :min="1"
                        :max="60"
                        :step="1"
                        v-model="durationReport">
                    </Slider>
                </div>
                <h6>Time of Report</h6>
                <div class="mt-2 mb-2">
                    <Datepicker 
                        :range="true"
                        @input="testtest"
                        v-model="timeReport">
                    </Datepicker>
                </div>
                <h6>Select Category</h6>
                <div class="mt-2 mb-2">
                    <Multiselect
                        v-model="selectedCategories"
                        label="name"
                        name="name"
                        mode="multiple"
                        track-by="value"
                        :options="options">
                    </Multiselect>
                </div>
                <div class="flex items-center justify-end mt-4">
                    <button class="ml-4 btn btn-success" @click.prevent="submit">
                        Apply
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>