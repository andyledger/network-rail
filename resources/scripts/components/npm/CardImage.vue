<template>
  <a
    class="tw-block tw-cursor-pointer md:tw-border-0 tw-border-b tw-border-gray-light tw-group"
    :href="link"
  >
    <n-img
      :lazy-src="image"
      :alt="altImage"
      aspect-ratio="16/9"
      class="tw-hidden md:tw-block"
    ></n-img>

    <h3
      class="tw-font-bold tw-py-6 tw-text-xl group-hover:tw-text-hyperlinks group-hover:tw-underline tw-text-lg"
    >{{ title }}</h3>
  </a>
</template>

<script>
import NImg from "./NImg";

export default {
  name: 'card-image',

  components: {
    NImg
  },

  props: {
    link: {
      type: String,
      default: "#"
    },

    title: {
      type: String,
      default: ""
    },

    image: {
      type: String,
      default: ""
    },

    altImage: {
      type: String,
      default: ""
    }
  }
}
</script>
