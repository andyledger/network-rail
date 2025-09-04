<template>
  <a
    class="tw-py-4 tw-border-b tw-border-gray-light tw-block tw-flex tw-justify-between tw-items-center tw-cursor-pointer tw-group card-link"
    :class="{ 'tw-border-t' : isFirstElement}"
    :href="link"
    :aria-label="'Find out more about ' + title"
  >
    <inline-svg v-if="icon" :name="icon" :ratio="getRatio()" class="tw-text-primary tw-text-6xl tw-mr-4"></inline-svg>

    <div
      class="tw-pr-4 tw-flex-grow"
    >
      <component
        :is="description ? 'h3' : 'span'"
        class="tw-font-bold tw-text-2xl group-hover:tw-text-hyperlinks group-hover:tw-underline"
        :class="{ 'md:tw-mb-1' : description}"
      >
        {{ title }}
      </component>

      <p v-if="description" class="tw-text-md tw-text-gray-dark tw-block">
        {{ description }}
      </p>
    </div>

    <inline-svg name="ut_arrow_right" class="tw-text-primary tw-text-5xl group-hover:tw-text-hyperlinks"></inline-svg>
  </a>
</template>

<script>
import InlineSvg from "./InlineSvg.vue";

export default {
  name: 'card-link',

  components: {
    InlineSvg
  },

  props: {
    isFirstElement: {
      type: Boolean,
      default: false
    },

    link: {
      type: String,
      default: "#"
    },

    title: {
      type: String,
      default: ""
    },

    description: {
      type: String,
      default: ""
    },

    icon: {
      type: String,
      default: ""
    }
  },

  methods: {
    getRatio() {
      if (this.icon === 'nr_twitter') {
        return 0.75
      }

      return 1
    }
  }
}
</script>
