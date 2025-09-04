<template>
  <div class="tw-relative">
    <button
      class="tw-flex tw-w-full tw-items-center tw-justify-between tw-border tw-border-gray-light tw-mb-2 tw-py-3 tw-px-4 tw-cursor-pointer tw-rounded-md"
      @click="extend = !extend"
    >
      <span class="tw-mr-2 tw-text-gray-dark">{{ label }}</span>

      <inline-svg
        name="ut_arrow_right2"
        class="tw-transition-transform tw-duration-200"
        :class="{'tw-transform tw-rotate-90': extend}"
      ></inline-svg>
    </button>

    <collapse-transition :duration="200">
      <ul
        class="tw-w-full tw-bg-white tw-border tw-border-gray-light tw-py-2 tw-rounded-md tw-absolute"
        v-show="extend"
      >
        <li
          v-for="(item, i) in items" :key="i"
        >
          <a
            class="hover:tw-bg-gray-lighter tw-block tw-py-3 tw-px-4 tw-underline hover:tw-text-hyperlinks"
            :href="item.url"
          >{{ item.title }}</a>
        </li>
      </ul>
    </collapse-transition>
  </div>
</template>

<script>
import InlineSvg from "./InlineSvg.vue";
import { CollapseTransition } from 'vue2-transitions';

export default {
  name: "n-dropdown-menu",

  components: {
    InlineSvg,
    CollapseTransition
  },

  props: {
    /*
     * Array of objects with url and title
     */
    items: {
      type: Array
    },

    label: String
  },

  data() {
    return {
      extend: false
    }
  }
}
</script>
