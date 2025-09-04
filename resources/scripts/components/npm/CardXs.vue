<template>
  <a
    class="tw-py-4 lg:tw-py-0 tw-block tw-border-b tw-group lg:tw-border tw-border-gray-light lg:tw-relative lg:tw-max-w-400 lg:hover:tw-border-hyperlinks"
    :class="{'tw-border-t' : firstElement}"
    :href="link"
  >
    <div class="tw-items-center lg:tw-items-start tw-w-full tw-flex tw-justify-between lg:tw-justify-start lg:tw-flex-col lg:tw-p-8">
      <inline-svg
        :name="iconName"
        class="tw-hidden sm:tw-pr-4 lg:tw-pr-0 sm:tw-block tw-text-6xl lg:tw-text-8xl tw-text-primary"
      ></inline-svg>

      <div class="lg:tw-flex lg:tw-flex-col sm:tw-flex-grow lg:tw-flex-grow-0 tw-min-w-0 lg:min-w-full">
        <h3
          class="lg:tw-pt-6 group-hover:tw-text-hyperlinks group-hover:tw-underline h4"
        >{{ title }}</h3>

        <div
          class="tw-hidden sm:tw-block tw-text-md tw-text-gray-dark 2xl:tw-text-xl"
        >{{ cutWords }}</div>
      </div>

      <inline-svg
        name="ut_arrow_right"
        class="tw-block lg:tw-hidden tw-text-primary tw-text-4xl group-hover:tw-text-hyperlinks"
      ></inline-svg>
    </div>
  </a>
</template>

<script>
import InlineSvg from "./InlineSvg.vue";

export default {
  name: "card-xs",

  components: {
    InlineSvg
  },

  props: {
    /*
     * Render border top on first element
     */
    firstElement: {
      type: Boolean,
      default: false
    },

    iconName: {
      type: String,
      default: ""
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
    }
  },

  computed: {
    cutWords() {
      let viewportWidth = window.innerWidth || document.documentElement.clientWidth;
      let description = this.description;

      if (viewportWidth > 1024 && viewportWidth < 1366) {
        return description.split(" ").slice(0, 20).join(" ");
      }

      return description;
    }
  }
}
</script>
