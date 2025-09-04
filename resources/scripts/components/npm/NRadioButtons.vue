<template>
  <div class="tw-mt-4">
    <div class="tw-text-gray-dark">
      <slot></slot>
    </div>

    <div class="tw-mt-2 tw-flex-col">
      <label
        v-for="(option, i) in options"
        :key="i"
        class="tw-flex tw-mb-2"
      >
        <input type="radio" class="tw-form-radio tw-text-primary tw-mt-1" :name="name" :value="option.value" checked />

        <span class="tw-ml-2">{{ option.label }}</span>
      </label>
    </div>
  </div>
</template>

<script>
export default {
  name: "n-radio-buttons",

  props: {
    options:  {
      type: Array,
      default: () => []
    },

    name: {
      required: true,
      type: String
    }
  }
}
</script>
