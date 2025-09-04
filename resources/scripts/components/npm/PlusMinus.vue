<template>
  <component :is="type" :aria-label="label">
    <div class="tw-h-4 tw-w-4 tw-relative">
      <div
        class="tw-absolute tw-bg-gray-medium tw-h-4 tw-w-0.5 tw-left-1/2 tw-origin-center tw-transition-transform tw-transform tw-rotate-90 tw-duration-500"
        :class="{ 'tw-rotate-180': !isExpanded }"
      />

      <div
        class="tw-absolute tw-bg-gray-medium tw-h-4 tw-w-0.5 tw-left-1/2 tw-origin-center tw-transition-transform tw-transform tw-rotate-90"
      />
    </div>
  </component>
</template>

<script>
export default {
  name: 'plus-minus',

  props: {

    label: String,

    isExpanded: {
      type: Boolean,
      default: false
    },

    /**
     * The html element name used for the icon.
     * `span, div, button`
     */
    type: {
      type: String,
      default: "button",
      validator: value => {
        return value.match(/(span|div|button)/)
      },
    },
  }
};
</script>
