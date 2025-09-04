<template>
  <div
    class="tw-relative tw-bg-primary tw-flex tw-items-center"
    :class="[isLandingPage ? 'tw-h-72 xl:tw-h-96 2xl:tw-h-128 tw-bg-cover tw-bg-center' : 'tw-h-40 md:tw-h-48 lg:tw-h-56 xl:tw-h-64 2xl:tw-h-72']"
    :style="[hasBgImage ? { backgroundImage: `url('${computedImage}')` } : '']"
  >
    <div v-if="hasGradient" class="tw-absolute tw-bg-gradient-to-r tw-from-black tw-via-transparent tw-to-black tw-inset-0 tw-opacity-75"></div>
    
    <div class="tw-container tw-relative">
      <h1
        class="tw-mb-4 tw-text-4xl lg:tw-text-5xl xl:tw-text-6xl tw-font-bold tw-text-white"
      >{{ title }}</h1>
      <!-- @slot Can be used to add a breadcrumb or date -->
      <slot></slot>
    </div>
  </div>
</template>

<script>
export default {
  name: 'n-landing-page-header',

  props: {
    /**
     * The H1 title of the page
     */
    title: {
      type: String,
      required: true,
      default: ''
    },

    /**
     * This will be the default image URL
     */
    imageSm: {
      type: String,
      required: false,
      default: ''
    },

    imageMd: {
      type: String,
      required: false,
      default: ''
    },

    imageLg: {
      type: String,
      required: false,
      default: ''
    },

    imageXl: {
      type: String,
      required: false,
      default: ''
    },

    /**
     * If has a background image
     */
    hasBgImage: {
      type: Boolean,
      required: false,
      default: false
    },

    /**
     * If has a black to transparet gradient
     */
    hasGradient: {
      type: Boolean,
      required: false,
      default: false
    },

    /**
     * If is a landing page or normal page header
     */
    isLandingPage: {
      type: Boolean,
      required: false,
      default: false
    }
  },

  computed: {
    computedImage() {
      if (window.innerWidth > 1440 && this.imageXl ) {
        return this.imageXl
      }

      if (window.innerWidth > 1024 && this.imageLg) {
        return this.imageLg
      }

      if (window.innerWidth > 768 && this.imageMd) {
        return this.imageMd
      }

      return this.imageSm
    }
  }
}
</script>
