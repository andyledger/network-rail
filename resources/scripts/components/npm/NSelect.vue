<template>
  <label class="tw-block">
    <span class="tw-font-bold tw-mb-2 tw-block tw-text-lg"><slot /></span>

    <select
      class="tw-form-select tw-rounded-md tw-block tw-w-full tw-mt-1 tw-py-3 tw-pl-4 tw-pr-10 tw-text-xl tw-text-gray-medium tw-border tw-border-gray-light"
      ref="select"
      v-model="value"
      @input="$emit('input', value)"
    >
      <option
        v-for="(option, i) in options"
        :key="i"
        :value="option"
      >{{ option }}</option>
    </select>
  </label>
</template>

<script>
/**
 * TO DO
 * Detele or rebuild this component, it's not working properly 
 */
export default {
  name: "n-select",

  props: {
    value: String,
    options: Array
  },

  data() {
    return {
      default: this.value
    }
  },

  methods: {
    updateSelect() {
      this.$emit('input', this.$refs.select.value);
    }
  }
}
</script>
