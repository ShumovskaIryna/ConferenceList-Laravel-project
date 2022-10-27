<script>

export default {
  props: {
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
        countReport: this.countReport,
        dateConf: this.dateConf,
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
                <h6>Count of report in conference</h6>
                <div class="mt-5 mb-2">
                    <Slider
                        :min="0"
                        :max="40"
                        :step="1"
                        v-model="countReport">
                    </Slider>
                </div>
                <h6>Select date conference</h6>
                <div class="justify-center mt-2 mb-2">
                    <Datepicker 
                        :range="true"
                        @input="testtest"
                        v-model="dateConf">
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