<template>
  <div class="tw-flex tw-items-en">
    <button class="tw-flex tw-cursor-pointer tw-items-center" @click="switchComponent" :aria-label="label ? label : 'Toggle switch'">
      <div
        class="tw-border-4 tw-w-10 tw-h-6 tw-rounded-full tw-flex tw-mr-2 tw-transition tw-duration-200"
        :class="[
          switchValue
            ? 'tw-justify-end tw-border-primary tw-bg-primary'
            : 'tw-justfy-start tw-border-gray-dark tw-bg-gray-dark'
        ]"
      >
        <div
          class="tw-h-4 tw-w-4 tw-bg-gray-lighter tw-rounded-full tw-relative"
          :class="[switchValue ? '-tw-right-px' : '-tw-left-px']"
        />
      </div>
    </button>

    <slot />
  </div>
</template>

<script>
export default {
  name: "n-switch",

  data() {
    return {
      switchValue: this.value
    }
  },

  props: {
    value: Boolean,
    label: String
  },

  // default prop is value, in this case we don't need to add it.
  // https://www.digitalocean.com/community/tutorials/how-to-add-v-model-support-to-custom-vue-js-components
  model: {
    event: 'click'
  },

  methods: {
    switchComponent() {
      this.switchValue = !this.switchValue;

      /**
       * Fired on click
       *
       * @event click
       * @property {boolean}
       */
      this.$emit('click', this.switchValue);
    }
  }
};
</script>
