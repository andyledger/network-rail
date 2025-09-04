<template>
  <label
    class="tw-block"
  >
    <span
      class="tw-font-bold tw-mb-2 tw-block tw-text-lg"
    >
      <!--
        @slot Use this slot to enter a label
      -->
      <div :class="{ 'tw-sr-only' : hideLabel }">
        <slot>Label</slot>
      </div>
    </span>

    <div class="tw-relative">
      <input
        class="tw-py-3 tw-px-4 tw-text-xl tw-form-input tw-block tw-w-full tw-rounded-md tw-border-gray-dark tw-placeholder-gray-dark"
        type="text"
        ref="input"
        :placeholder="placeholder"
        @input="updateText"
        :value="value"
      />

      <button
        class="hover:tw-text-gray-dark tw-z-20 tw-cursor-pointer tw-text-xl tw-text-gray-medium tw-absolute tw-inset-y-0 tw-right-0 tw-p-4"
        @click="deleteInput"
        :class="{'tw-hidden' : value == ''}"
      >
        <inline-svg
          name="ut_close"
        ></inline-svg>
      </button>

      <inline-svg
        name="nr_magnifying_glass"
        class="tw-text-4xl tw-absolute tw-inset-y-0 tw-right-0 tw-p-2"
        :class="{'tw-hidden' : value != ''}"
        v-if="isSearch"
      ></inline-svg>
    </div>
  </label>
</template>

<script>
import InlineSvg from './InlineSvg.vue';

export default {
  name: "n-text",

  components: {
    InlineSvg
  },

  props: {
    placeholder: String,
    value: String,
    /**
     * Apply a sr-only class to the label
     * @type {Boolean}
     */
    hideLabel: Boolean,
    /**
     * Display a magnifying glass icon
     * @type {Boolean}
     */
    isSearch: Boolean
  },

  methods: {
    updateText() {
      /**
       * Fired on `input`.
       *
       * @event input
       * @property {string} input value
       */
      this.$emit('input', this.$refs.input.value);
    },

    deleteInput() {
      this.$emit('input', '');
    }
  }
}
</script>
