<template>
  <component
    :is="type"
    :aria-label="ariaLabel"
    v-html="svg"
    />
</template>

<script>
const req = require.context("../../../svgs/", true, /^\.\/.*\.svg$/)

/**
 * Use tw-text-{size} and tw-text-{color} to set a size and color.
 */
export default {
  name: "inline-svg",

  computed: {
    svg() {
      return req("./" + this.name + ".svg").replace(
        /^<svg /,
        `<svg style="fill: currentColor" width="1em" height="${this.ratio}em"
          class="${this.svgClasses}" alt=""`
      )
    }
  },

  props: {
    /**
     * The name of the icon to display. Use the name of the .svg file.
     */
    name: {
      type: String,
      required: true,
      default: null,
    },

    ariaLabel: {
      type: String,
    },

    /**
     * The html element name used for the icon.
     * `span, div, button`
     */
    type: {
      type: String,
      default: "span",
      validator: value => {
        return value.match(/(span|div|button)/)
      },
    },

    /**
     * The aspect ratio, default 1 = square.
     */
    ratio: {
      type: Number,
      default: 1
    },

    /**
     * Add specific tailwind classes to the svg
     */
    svgClasses: {
      type: String,
      default: ''
    }
  },
}
</script>
