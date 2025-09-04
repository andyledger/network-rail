<div class="tw-relative tw-border tw-pt-58px md:tw-pt-63px lg:tw-pt-73px xl:tw-pt-24">
  <header
    class="tw-z-50 tw-bg-white tw-inset-x-0 tw-top-0 tw-fixed"
    :style="{marginTop: elementHeight('wpadminbar') + 'px'}"
  >
    <div class="tw-container tw-flex tw-justify-center tw-items-center xl:tw-justify-between tw-py-4 tw-relative tw-h-20 xl:tw-h-24">
      <a
        href="/"
        class="tw-block"
        aria-label="home"
      >
        <inline-svg
          name="<?php echo e($logo_type); ?>"
          :ratio="0.4"
          class="tw-text-12xl tw-text-primary"
        ></inline-svg>
      </a>

      <the-desktop-menu
        :items="<?php echo e(json_encode($menu)); ?>"
      ></the-desktop-menu>

      <div class="tw-absolute xl:tw-static tw-right-0 tw-top-5 xl:tw-block tw-text-gray-dark tw-ml-4 tw-w-64 tw-hidden md:tw-block">
        <algolia-search
          class-state-results="tw-w-96 tw-mt-4 xl:tw-mt-0 tw-relative tw-right-32 | xl:tw-absolute xl:tw-right-16 xl:tw-mt-4"
        ></algolia-search>
      </div>

      <div
        class="md:tw-hidden tw-cursor-pointer tw-absolute tw-z-10 tw-right-4"
        v-on:click="displaySearchPhone()"
      >
        <inline-svg
          v-show="!isSearchPhone"
          type="button"
          name="nr_magnifying_glass" class="tw-text-4xl"
          aria-label="Open Search"
        ></inline-svg>

        <inline-svg
          v-show="isSearchPhone"
          type="button"
          name="ut_close"
          class="tw-text-4xl"
          aria-label="Search"
        ></inline-svg>
      </div>

      <div
        v-show="isSearchPhone"
        class="tw-absolute tw-left-0 tw-w-full tw-container md:tw-hidden tw-mt-4"
        style="top: 60px;"
      >
        <algolia-search
          class-state-results="tw-w-full tw-mt-4 inset-x-0"
        ></algolia-search>
      </div>
    </div>
  </header>

  <n-menu-button
    :open="!isMenuOpen"
    v-on:click="openMenu()"
    class="xl:tw-hidden"
    :aria-expanded="[isMenuOpen ? 'true' : 'false']"
    aria-controls="the-phone-menu"
  ></n-menu-button>

  <the-phone-menu
    id="the-phone-menu"
    :open="!isMenuOpen"
    :items="<?php echo e(json_encode($menu)); ?>"
    :style="menuTranslate"
  ></the-phone-menu>

  <div
    class="tw-fixed tw-inset-0 tw-z-40 tw-bg-black tw-transition-opacity tw-duration-500"
    :class="[isMenuOpen ? 'tw-opacity-50' : 'tw-opacity-0 tw-pointer-events-none']"
  ></div>
</div>
<?php /**PATH /Users/jerometoole/code/wholegrain-projects/network-rail/wp-content/themes/network-rail/resources/views/partials/header.blade.php ENDPATH**/ ?>