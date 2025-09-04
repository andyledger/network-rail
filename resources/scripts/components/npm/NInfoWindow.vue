<template>
  <div
    class="tw-max-w-300 tw-min-h-full tw-bg-white tw-absolute tw-z-10 tw-top-0 tw-left-0 tw-transition tw-duration-300"
    :style="[isOpen ? {transform: 'translate(0px)'} : {transform: 'translate(-300px)'}]"
  >
    <div class="tw-bg-gray-darker tw-flex tw-justify-end">
      <button
        @click="$emit('is-open')" class="tw-text-white tw-text-3xl tw-p-1"
        aria-label="close"
      >
        <inline-svg
          name="ut_close"
        ></inline-svg>
      </button>
    </div>

    <slot></slot>
  </div>
</template>

<script>
import InlineSvg from './InlineSvg.vue';

export default {
  name: "n-info-window",

  components: {
    InlineSvg
  },

  props: {
    isOpen: {
      type: Boolean,
      default: false
    }
  }
}
</script>
