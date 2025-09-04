<template>
  <div
    class="tw-relative tw-overflow-hidden tw-w-full"
    :style="style"
  >
    <img
      :alt="alt"
      ref="imageElement"
      :data-src="lazySrc"
      :data-srcset="lazySrcset"
      class="tw-absolute tw-object-cover tw-w-full tw-h-full"
    >
  </div>
</template>

<script>
import lozad from 'lozad';

export default {
  name: "n-img",

  props: {
    alt: String,
    aspectRatio: {
      type: String,
      default: '16/9'
    },
    lazySrc: String,
    lazySrcset: String
  },

  computed: {
    computedAspectRatio() {
      let arr = this.aspectRatio.split('/')
      let height = arr[1]
      let width = arr[0]

      return (height / width).toFixed(2);
    },

    style() {
      let style = { backgroundColor: "#efefef" }

      style.paddingBottom = `${this.computedAspectRatio * 100}%`;

      return style;
    }
  },

  mounted() {
    const el = this.$refs.imageElement;
    const observer = lozad(el);
    observer.observe();
  }
}
</script>
