<template>
    <div class="tw-mx-auto">
      <div class="tw-relative tw-pb-2/3 tw-bg-gray-light">
        <div class="tw-absolute tw-w-full tw-h-full">
          <flickity
            ref="flickityNSlider"
            :options="flickityOptions"
            class="tw-w-full tw-h-full"
            v-on:update-index="updateIndex"
          >
            <figure
              class="tw-w-full tw-h-full"
              v-for="(item, i) in items"
              :key="i"
            >
              <n-img
                :lazy-src="item.lazySrc"
                aspect-ratio="3/2"
                class="tw-w-full tw-h-full tw-object-cover"
                :alt="item.altImage"
              ></n-img>
            </figure>
          </flickity>
        </div>
      </div>

      <div class="tw-flex tw-items-center tw-justify-between tw-mt-4">
        <button
          class="tw-p-6 tw-bg-primary tw-text-white tw-text-4xl tw-rounded-md"
          @click="previous()"
          aria-label="Previous slide"
        >
          <inline-svg name="ut_arrow_left2" class="tw-text-xl" />
        </button>

        <div class="tw-flex tw-flex-col tw-items-center tw-w-full tw-mt-0.5">

          <figcaption
            class="tw-text-center tw-bg-white tw-italic tw-px-2 tw-py-1 tw-rounded-md tw-text-base tw-truncate"
            v-if="hasDescription"
          >
            {{ items[index].description }}
          </figcaption>

          <div class="tw-w-full tw-text-center tw-mt-0.5">
            <button
              class="tw-inline-block tw-mx-2 tw-rounded-full tw-border"
              style="width: 20px; height: 20px;"
              :class="{ 'tw-bg-black': index === i }"
              :aria-label="'Slide ' + (i + 1) + ' - ' + item.altImage"
              :aria-current="index === i ? 'step' : false"
              v-for="(item, i) in items"
              :key="i"
              @click="selectIndex(i)"
            ></button>
          </div>
        </div>

        <button
          class="tw-p-6 tw-bg-primary tw-text-white tw-text-4xl tw-rounded-md"
          @click="next()"
          aria-label="Next slide"
        >
          <inline-svg name="ut_arrow_right2" class="tw-text-xl" />
        </button>
      </div>
    </div>
  </template>

  <script>
  import Flickity from './Flickity.vue';
  import InlineSvg from './InlineSvg.vue';
  import NImg from './NImg.vue';

  export default {
    name: 'n-slider',

    components: {
      Flickity,
      InlineSvg,
      NImg,
    },

    props: {
      items: {
        type: Array,
        required: true,
      },
    },

    data() {
      return {
        flickityOptions: {
          prevNextButtons: false,
          pageDots: false,
          setGallerySize: true,
          draggable: false,
          fade: false,
          lazyLoad: true,
          resize: true,
          wrapAround: true,
        },
        index: 0,
      };
    },

    computed: {
      hasDescription() {
        return !!this.items[this.index]?.description;
      },
    },

    methods: {
      selectIndex(index, isWrapped = true, isInstant = false) {
        this.index = index;
        this.$refs.flickityNSlider.select(index, isWrapped, isInstant);
      },

      next() {
        this.$refs.flickityNSlider.next();
      },

      previous() {
        this.$refs.flickityNSlider.previous();
      },

      resize() {
        this.$refs.flickityNSlider.rerender();
      },

      updateIndex(e) {
        this.index = e;
      },
    },

    created() {
      window.addEventListener('resize', this.resize);
    },

    destroyed() {
      window.removeEventListener('resize', this.resize);
    },
  };
</script>
