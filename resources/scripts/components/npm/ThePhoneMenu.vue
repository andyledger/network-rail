<template>
  <nav class="the-phone-menu tw-fixed tw-left-0 tw-overflow-y-auto tw-w-full sm:tw-max-w-400 tw-z-50 tw-bg-white tw-duration-500 xl:tw-hidden tw-border-t-2 tw-border-gray-light tw-transform"
    :class="[open ? 'tw-invisible tw--translate-x-full' : 'tw-visible']"
    >
    <ul v-if="!open">
      <recursive-list
        ref="recursiveListRoot"
        title="phone menu"
        :child_items="items"
        :depth="0"
      ></recursive-list>
    </ul>
  </nav>
</template>

<script>
import InlineSvg from './InlineSvg.vue';
import RecursiveList from './RecursiveList.vue';
import axios from "axios";

export default {
  name: "the-phone-menu",

  components: {
    InlineSvg,
    RecursiveList
  },

  props: {
    open: {
			type: Boolean,
			default: false
		},
    items: {
      type: Array,
      default: () => []
    }
  }
}
</script>
