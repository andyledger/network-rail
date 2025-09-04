<template>
  <div v-if="socialMedia.length !== 0">
    <div class="tw-font-bold tw-text-xl tw-text-black tw-mb-4">
      Follow us on:
    </div>

    <ul class="tw-flex">
      <li
        v-for="(item, i) in socialMedia"
        :key="i"
        class="tw-text-3xl tw-mr-4 tw-w-10 tw-h-10 tw-bg-primary tw-text-white tw-rounded-full tw-flex tw-justify-center tw-items-center hover:tw-bg-gray-medium tw-transition tw-duration-200"
      >
        <a :href="item.link">
          <inline-svg :name="item.svg_name" class="tw-relative tw-bottom-px tw-left-px"></inline-svg>
        </a>
      </li>
    </ul>
  </div>
</template>

<script>
import InlineSvg from './InlineSvg.vue';

export default {
  name: "follow-us",

  components: {
    InlineSvg
  },

  props: {
    socialMedia: {
      type: Array,
      default: () => []
    }
  }
}
</script>
