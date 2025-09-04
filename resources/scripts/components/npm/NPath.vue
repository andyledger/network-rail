<template>
  <a
    :href="link"
    :target="target"
    tabindex="-1"
    class="tw-transition-all tw-duration-500 tw-cursor-pointer"
    :aria-label="'View the ' + regionName + ' route'"
  >
    <g
      class="tw-fill-current"
    >
      <g v-html="svg"></g>

      <g v-if="count">
        <circle
          :cx="x"
          :cy="y"
          r="8"
          stroke="white"
          stroke-width="1"
          fill="white"
        />

        <text
          :x="x"
          :y="y"
          text-anchor="middle"
          alignment-baseline="middle"
          stroke-width="1px"
          class="tw-text-2xs tw-text-black"
          >{{ count }}</text
        >
      </g>
    </g>
  </a>
</template>

<script>
const req = require.context("../../../regions/", true, /^\.\/.*\.svg$/)

export default {
  name: "n-path",

  props: {
    /**
     * path to the file with the path svg.
     */
    regionName: String,

    link: {
      type: String,
      default: '#'
    },

    target: String,

    x: String,

    y: String,

    count: String
  },

  computed: {
    svg() {
      return req("./" + this.regionName + ".svg")
    }
  },
}
</script>
