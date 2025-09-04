<template>
  <div class="tw-my-10 md:tw-pr-28px" ref="dropdownContainer" @focusout="handleFocusOut">
    <nav class="tw-w-full md:tw-w-1/2 tw-relative tw-z-10">
      <button @click="toggleDropdown"  aria-label="Select a category" class="story-categories-button tw-w-full tw-bg-white tw-px-4 tw-border tw-border-cccccc tw-rounded-4px tw-h-48px tw-text-left" :class="{'active' : showNav }" :aria-expanded="showNav ? 'true' : 'false'">

        <span v-if="!selectedCategory">Select a category</span>
        <span v-if="selectedCategory">{{ categories.filter(x => x.slug === selectedCategory)[0].name }}</span>
      </button>
      <ul
        ref="dropdownMenu"
        v-if="showNav"
        class="tw-absolute tw-w-full tw-max-h-52 tw-overflow-y-auto tw-bg-white tw-border tw-border-t-0 tw-border tw-border-cccccc tw-px-4 tw-py-2 tw-rounded-b-4px tw-z-10"
      >
        <li class="tw-border-b tw-border-gray-light hover:tw-border-hyperlinks hover:tw-text-hyperlinks">
          <a :href="siteUrl + '/stories/'" class="tw-py-4 tw-py-4 tw-block">All stories</a>
        </li>
        <li v-for="(category, index) in categories" class="tw-border-gray-light hover:tw-border-hyperlinks hover:tw-text-hyperlinks" :class="{'tw-border-b' : index !== Object.keys(categories).length - 1}">
          <a :href="siteUrl + '/stories/?cat=' + category.slug" v-html="category.name" class="tw-py-4 tw-py-4 tw-block"></a>
        </li>
      </ul>
    </nav>
  </div>
</template>
<script>
export default {
  props: {
    categories: {
      type: Array
    },
    storyCategory: {
      type: String
    },
    siteUrl: {
      type: String
    }
  },

  data() {
    return {
      selectedCategory: this.storyCategory,
      showNav: false
    }
  },

  mounted() {
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        this.showNav = false
      }
    })

    document.addEventListener('click', this.handleClickOutside);
  },

  methods: {
    toggleDropdown() {
      this.showNav = !this.showNav;
      if (this.showNav) {
        this.$nextTick(() => {
          this.$refs.dropdownMenu?.focus();
        });
      }
    },

    handleFocusOut(e) {
      setTimeout(() => {
        if (!this.$refs.dropdownContainer.contains(document.activeElement)) {
          this.showNav = false;
        }
      }, 50);
    },

    handleClickOutside(e) {
      if (this.$refs.dropdownContainer && !this.$refs.dropdownContainer.contains(e.target)) {
        this.showNav = false;
      }
    },

  },
}
</script>
