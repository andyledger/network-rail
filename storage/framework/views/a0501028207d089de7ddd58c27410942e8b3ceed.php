<div class="tw-relative tw-border tw-pt-58px md:tw-pt-63px lg:tw-pt-73px xl:tw-pt-24">
  <header
    class="tw-z-50 tw-bg-white tw-inset-x-0 tw-top-0 tw-fixed"
    :style="{marginTop: elementHeight('wpadminbar') + 'px'}"
  >
    <div class="tw-container tw-flex tw-justify-between tw-items-center tw-py-4 tw-relative tw-h-20 xl:tw-h-24">
      <n-menu-button
        :open="!isMenuOpen"
        v-on:click="openMenu()"
        class="xl:tw-hidden"
      ></n-menu-button>

      <a
        href="/"
        class="tw-absolute tw-left-1/2 lg:tw-static tw-block"
        aria-label="Network Rail logo linking home page"
      >
        <inline-svg
          name="<?php echo e($logo_type); ?>"
          :ratio="0.4"
          class="tw-text-12xl tw-text-primary tw-relative tw--left-1/2 lg:tw-left-0"
        ></inline-svg>
      </a>

      <the-desktop-menu
        :items="<?php echo e(json_encode($menu)); ?>"
      ></the-desktop-menu>

      <div class="tw-relative tw-text-gray-dark tw-ml-8 tw-hidden md:tw-block">
        <algolia-search class-state-results="tw-absolute tw-w-96 tw-mt-4 tw-right-0 tw-z-20"></algolia-search>
      </div>

      <div
        class="md:tw-hidden tw-cursor-pointer tw-relative tw-z-10"
        v-on:click="displaySearchPhone()"
      >
        <inline-svg v-show="!isSearchPhone" type="button" name="nr_magnifying_glass" class="tw-text-4xl"></inline-svg>

        <inline-svg v-show="isSearchPhone" type="button" name="ut_close" class="tw-text-4xl"></inline-svg>
      </div>

      <div
        v-show="isSearchPhone"
        class="tw-absolute tw-left-0 tw-w-full tw-container md:tw-hidden tw-mt-4"
        style="top: 60px;"
      >
        <algolia-search class-state-results="tw-w-full tw-mt-4 inset-x-0"></algolia-search>
      </div>
    </div>
  </header>

  <the-phone-menu
    id="the-phone-menu"
    :items="<?php echo e(json_encode($menu)); ?>"
    :style="menuTranslate"
  ></the-phone-menu>

  <div
    class="tw-fixed tw-inset-0 tw-z-40 tw-bg-black tw-transition-opacity tw-duration-500"
    :class="[isMenuOpen ? 'tw-opacity-50' : 'tw-opacity-0 tw-pointer-events-none']"
  ></div>
</div>
<?php /**PATH /nas/content/live/newnetworkrail/wp-content/themes/network-rail/resources/views/partials/header.blade.php ENDPATH**/ ?>