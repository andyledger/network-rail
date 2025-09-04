<div class="tw-h-72 md:tw-h-96 lg:tw-h-128 2xl:tw-h-152 3xl:tw-h-176 tw-relative">
  <flickity
    ref="flickityComponent"
    :options="{initialIndex: 0,prevNextButtons: false,pageDots: false,wrapAround: true,setGallerySize: false,draggable: false,autoPlay: false,fade: true}"
    class="tw-h-full"
  >
    <div
      v-for="(item, i) in <?php echo e(json_encode($main_slider)); ?>"
      :key="i"
      class="tw-w-full tw-h-full tw-flex tw-items-center tw-justify-center"
    >
      <img
        class="tw-absolute tw-object-cover tw-w-full tw-h-full"
        :alt="item.altImage"
        :src="item.imgUrl"
        :srcset="item.imgUrlSrcSet"
      />

      <div class="tw-absolute tw-inset-0 tw-bg-black tw-bg-opacity-50 tw-z-10"></div>

      <div
        class="tw-container tw-flex tw-flex-col tw-justify-center tw-items-start tw-text-white tw-relative tw-z-20"
      >
        <div class="tw-bg-black tw-rounded-lg tw-py-6 tw-px-8 md:tw-py-8">
          <h2 class="tw-text-2xl md:tw-text-3xl lg:tw-text-5xl tw-font-bold tw-mb-4 md:tw-mb-8">
            {{ item.title }}
          </h2>

          <div class="tw-hidden lg:tw-block tw-mb-8 tw-text-xl">
            {{ item.description }}
          </div>

          <a
            class="tw-inline-block tw-text-white tw-underline md:tw-no-underline md:tw-px-4 md:tw-py-3 md:tw-rounded-lg md:tw-bg-gray-dark md:tw-font-bold"
            :href="item.link"
            :tabindex="[selectedIndex !== i ? '-1' : '']"
          >
            More information

            <inline-svg
              name="ut_arrow_right2"
              class="tw-hidden md:tw-inline tw-ml-4 tw-relative"
              svg-classes="tw-inline"
            ></inline-svg>
          </a>
        </div>
      </div>
    </div>
  </flickity>

  <div
    class="tw-flex tw-justify-center lg:tw-h-24 tw-absolute lg:tw-border-t lg:tw-border-white lg:tw-border-opacity-25 tw-inset-x-0 tw-bottom-0 tw-z-20 lg:tw-bg-black"
  >
    <div class="tw-container tw-flex">
      <button
        v-for="(item, i) in <?php echo e(json_encode($main_slider)); ?>"
        :key="i"
        class="tw-mb-4 sm:tw-mb-6 tw-mr-4 md:tw-mr-8 lg:tw-mr-0 lg:tw-mb-0 lg:tw-pl-5 tw-flex tw-items-center lg:tw-w-1/3 tw-text-white tw--mt-px tw-relative"
        :class="{ 'lg:tw-border-t-2 lg:tw-border-white': selectedIndex === i }"
        v-on:click="selectItem(i, false)"
      >
        <div
          class="tw-py-1 tw-px-3 lg:tw-py-2 lg:tw-px-4 tw-rounded-lg tw-mr-4"
          :class="[
            selectedIndex === i ? 'tw-bg-primary' : 'tw-bg-gray-dark'
          ]"
        >
          {{ i + 1 }}
        </div>

        <div class="tw-hidden lg:tw-block tw-font-bold tw-text-lg" v-html="item.title"></div>
      </button>
    </div>
  </div>
</div><?php /**PATH /nas/content/live/newnetworkrail/wp-content/themes/network-rail/resources/views/partials/main-slider.blade.php ENDPATH**/ ?>