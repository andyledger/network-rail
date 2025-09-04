<template>
  <div class="tw-flex tw-flex-col tw-max-w-800 tw-group">
    <component
      :is="componentType"
      class="tw-block tw-cursor-pointer"
      :href="link"
    >
      <n-img
        :lazy-src="image"
        :aspect-ratio="aspectRatio"
        class="tw-mb-6"
        :alt="altImage"
      ></n-img>

      <h3
        class="tw-pb-4 group-hover:tw-text-hyperlinks group-hover:tw-underline"
        :class="[ fourColumns ? 'xl:tw-pb-3 h5' : 'h4']"
        v-html="title"
      ></h3>
    </component>

    <div
      v-if="date"
      class="tw-text-gray-dark tw-mb-4 tw-font-bold"
    >{{ date }}</div>

    <div
      v-if="description"
      class="tw-text-gray-dark tw-text-xl"
      :class="{'xl:tw-text-base' : fourColumns}"
      v-html="description"
    ></div>
  </div>
</template>

<script>
import NImg from './NImg.vue';

export default {
  name: "card",

  components: {
    NImg
  },

  props: {
    link: {
      type: String,
      default: ""
    },

    /**
     * Url of the image
     */
    image: {
      type: String,
      default: ""
    },

    /**
     * Alternative text for the image
     */
    altImage: {
      type: String,
      default: ""
    },

    title: {
      type: String,
      default: ""
    },

    date: {
      type: String,
      default: ""
    },

    description: {
      type: String,
      default: ""
    },

    aspectRatio: {
      type: String,
      default: "16/9"
    },

    /**
     * Smaller font-size on title and description
     */
    fourColumns: {
      type: Boolean,
      default: false
    }
  },

  computed: {
    componentType() {
      if (this.link) {
        return 'a';
      }

      return 'div';
    }
  }
}
</script>
