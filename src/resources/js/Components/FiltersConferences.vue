<script>

export default {
  props: {
    defaultFilterValues: {
      type: Object,
      default: {}
    },
    countReport: {
        type: Array,
        default: [0, 40],
    },
    dateConf: {
        type: Array,
        default: [],
    },
    selectedCategories: {
        type: Array,
        default: [],
    },
    categories:{
        type: Array,
        default: [],
    },
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
        countReport: this.defaultFilterValues.countReport,
        dateConf: this.defaultFilterValues.dateConf,
        selectedCategories: this.defaultFilterValues.selectedCategories,
      });
    },
    reset() {
      this.$emit('submit', {
        countReport: [0, 40],
        dateConf: '',
        selectedCategories: '',
      })
    }
  }
}
</script> 
<template>
    <div class="relative inline-block top-0 left-0">
        <div class="single-sidebar-box">
            <form>
                <h6>Count of report in conference</h6>
                <div class="mt-5 mb-2">
                    <Slider
                        :min="0"
                        :max="40"
                        :step="1"
                        v-model="defaultFilterValues.countReport">
                    </Slider>
                </div>
                <h6>Select date conference</h6>
                <div class="justify-center mt-2 mb-2">
                    <Datepicker 
                        :range="true"
                        @input="testtest"
                        v-model="defaultFilterValues.dateConf">
                    </Datepicker>
                </div>
                <h6>Select Category</h6>
                <div class="mt-2 mb-2">
                    <Multiselect
                        label="name"
                        name="name"
                        mode="multiple"
                        track-by="value"
                        :options="options"
                        v-model="defaultFilterValues.selectedCategories">
                    </Multiselect>
                </div>
                <div class="flex items-center justify-end mt-4">
                  <button class="ml-4 btn" @click.prevent="reset">
                        Reset
                    </button>
                    <button class="ml-4 btn btn-success" @click.prevent="submit">
                        Apply
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>