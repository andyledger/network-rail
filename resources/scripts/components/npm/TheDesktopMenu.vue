<template>
  <nav class="tw-hidden xl:tw-block">
    <ul class="tw-justify-center tw-flex tw-flex-grow tw-gap-x-8 2xl:tw-gap-x-10">
      <li
        v-for="(item, key) in items"
        :key="key"
        class="tw-relative tw-py-5 tw-cursor-pointer"
        @mouseover="updateActiveItem(key)"
        @mouseleave="onMouseLeave(key)"
      >
        <a
          @focus="updateActiveItem(key)"
          :href="item.url"
          class="tw-font-bold tw-text-md tw-flex-grow"
          v-html="item.title"
        />

        <div
          class="tw-absolute tw-left-1/2 tw-z-10 tw-transition-fade tw-duration-200 tw-top-full"
          :class="[key === activeItem ? 'tw-visible tw-opacity-100' : 'tw-invisible tw-opacity-0']"
        >
          <div class="tw--left-1/2 tw-relative tw-shadow-brand tw-min-w-300">
            <div
              v-if="item.child_items"
              class="tw-bg-white"
            >
              <div class="tw-arrow-up" />

              <ul class="tw-px-8 tw-py-3">
                <li
                  v-for="(item, key) in item.child_items"
                  :key="key"
                  class="tw-py-2 tw-py-2 tw-border-b tw-border-gray-light hover:tw-border-hyperlinks hover:tw-text-hyperlinks"
                >
                  <a
                    :href="item.url"
                    v-html="item.title"
                    class="tw-text-lg tw-block"
                  />
                </li>
              </ul>
            </div>
          </div>
        </div>
      </li>
    </ul>
  </nav>
</template>

<script>
import axios from "axios";

export default {
  name: "the-desktop-menu",

  data() {
    return {
      items: null,
      activeItem: null,
    }
  },
  methods: {
    updateActiveItem(key) {
      this.activeItem = key;
    },
    onMouseLeave() {
      this.activeItem = null;
    }
  },
  mounted() {

      axios.get('/wp-json/menu/items')
        .then((response) => {
          this.items = response.data
        })

      // Close dropdowns with 'esc' key
      document.addEventListener("keydown", (e) => {
          if (e.key == 'Escape') {
              this.updateActiveItem(null);
          }
      });
  },
};
</script>
