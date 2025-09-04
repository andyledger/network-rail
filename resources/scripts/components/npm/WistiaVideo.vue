<template>
  <div class="embed-responsive tw-relative">
    <div
      v-if="!playVideo"
      class="tw-relative"
    >
      <button
        class="tw-absolute tw-z-10 tw-top-1/2 tw-left-1/2 tw-transform tw--translate-x-1/2 tw--translate-y-1/2 tw-inline-flex tw-bg-brand-orange tw-border-4 tw-border-transparent tw-text-white tw-p-2 xl:tw-p-5 tw-rounded-md hover:tw-shadow hover:tw-border-brand-orange-light tw-transition-colors"
        @click="playVideo = true"
        :aria-label="'Play video - ' + (buttonAriaLabel || 'we run, look after and improve Britain\'s railway')"
      >
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="tw-w-16 tw-h-16 xl:tw-w-24 xl:tw-h-24" viewBox="0 0 16 16">
          <path d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393z"/>
        </svg>
      </button>

      <slot v-if="hasImage"></slot>

      <img v-if="!hasImage" :src="thumbnailUrl" alt="" class="tw-w-full tw-object-cover" width="556" height="313">
    </div>
    <div
      v-if="playVideo"
      :style="{'padding-top': aspectRatio}"
      v-html="html"
    ></div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'wistia-video',

  props: {
    url: {
      type: String,
      required: true
    },
    hasImage: {
      type: Boolean,
      required: false
    },
  },

  data() {
    return {
      html: '',
      height: '',
      width: '',
      playVideo: false,
      thumbnailUrl: null,
      buttonAriaLabel: '',
    }
  },

  computed: {
    aspectRatio() {
      return (this.height / this.width) * 100 + '%'
    },
  },

  mounted() {
    axios
      .get('https://fast.wistia.net/oembed/', {
        params: {
          url: this.url,
          embedType: 'iframe',
          autoplay: true
        }
      })
      .then(response => {
        this.html = response.data.html;
        this.height = response.data.height;
        this.width = response.data.width;
        this.thumbnailUrl = response.data.thumbnail_url;
        this.buttonAriaLabel = response.data.title;
        this.$emit('video-loaded');
      });
  }
}
</script>
