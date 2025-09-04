<template>
  <div class="tw-relative">
    <input
      type="text"
      @input="onChange"
      v-model="search"
      :placeholder="placeholder"
      @keydown.down="onArrowDown"
      @keydown.up="onArrowUp"
      @keydown.enter="onEnter"
      class="tw-text-xl tw-w-full tw-border tw-border-gray-dark tw-rounded-md tw-py-3 tw-px-4 tw-placeholder-gray-medium"
      :disabled="disabled == true"
      role="combobox"
      :aria-expanded="isOpen.toString()"
      aria-autocomplete="list"
      aria-controls="postcode-list"
      :aria-activedescendant="activeDescendant"
    />

    <button
      @click="setResult('')"
      v-if="search !== ''"
      class="hover:tw-text-gray-dark tw-z-20 tw-cursor-pointer tw-text-xl tw-text-gray-medium tw-absolute tw-right-0 tw-p-4"
      aria-label="Clear postcode input"
    >
      <inline-svg
        name="ut_close"
      ></inline-svg>
    </button>

    <p
      v-show="results.length === 0 && search !== ''"
      class="tw-absolute tw-text-xs tw-mt-2 tw-text-brand-red"
      style="top: 50px"
    >
      {{ errorMessage }}
    </p>

    <div class="tw-sr-only" aria-live="polite">{{ announcement }}</div>

    <ul
      v-show="isOpen"
      class="tw-absolute tw-rounded-md tw-mt-2 tw-z-20 tw-bg-white tw-border tw-border-gray-light tw-w-full tw-overflow-hidden tw-list-none"
      :style="style"
      role="listbox"
      id="postcode-list"
    >
      <li
        v-if="isLoading"
      >
        Loading results...
      </li>

      <li
        v-else
        v-for="(result, i) in results"
        :key="i"
        @click="setResult(result)"
        class="tw-px-2 tw-py-1 tw-cursor-pointer hover:tw-text-hyperlinks"
        :class="{ 'tw-text-secondary': i === arrowCounter }"
      >
        {{ result }}
      </li>
    </ul>
  </div>
</template>

<script>
import InlineSvg from './InlineSvg.vue';

export default {
  name: 'autocomplete',

  components: {
    InlineSvg
  },

  props: {
    items: {
      type: Array,
      required: false,
      default: () => [],
    },
    isAsync: {
      type: Boolean,
      required: false,
      default: false,
    },
    placeholder: {
      type: String,
      required: false,
      default: "..."
    },

    /**
     * Height of the dropdown container
     * the container is set at position absolute
     */
    height: {
      type: Number,
      required: false,
      default: 100
    },
    errorMessage: {
      type: String,
      required: false,
      default: "error",
    },
    disabled: {
      type: Boolean,
      required: false,
      default: false
    },
  },

  data() {
    return {
      isOpen: false,
      results: [],
      search: '',
      isLoading: false,
      arrowCounter: 0,
      announcement: "",
    };
  },

  computed: {
    style() {
      return {
        height: `${this.height}px`
      }
    },
    activeDescendant() {
      return this.arrowCounter >= 0 ? `result-${this.arrowCounter}` : "";
    },
  },

  methods: {
    onChange() {
      // Let's warn the parent that a change was made
      this.$emit('input', this.search);

      // Is the data given by an outside ajax request?
      if (this.isAsync) {
        this.isLoading = true;
        this.isOpen = true;

        if (this.results.length !== 0) {
          this.isLoading = false
          this.announcement = `${this.results.length} results found.`;
        }
      } else {
        // Let's our flat array
        this.filterResults();
      }
    },

    filterResults() {
      // first uncapitalize all the things
      this.results = this.items.filter((item) => {
        return item.toLowerCase().indexOf(this.search.toLowerCase()) > -1;
      });

      this.isOpen = (this.results.length !== 0) ? true : false;
      this.announcement = `${this.results.length} results found.`;
    },

    setResult(result) {
      this.search = result;
      this.$emit('input', this.search);
      this.isOpen = false;
    },

    onArrowDown() {
      if (this.arrowCounter < this.results.length) {
        this.arrowCounter = this.arrowCounter + 1;
        this.announcement = `Selected ${this.results[this.arrowCounter]}`;
      }
    },

    onArrowUp() {
      if (this.arrowCounter > 0) {
        this.arrowCounter = this.arrowCounter - 1;
        this.announcement = `Selected ${this.results[this.arrowCounter]}`;
      }
    },

    onEnter() {
      this.setResult(this.results[this.arrowCounter]);
      this.isOpen = false;
      this.arrowCounter = -1;
    },

    handleClickOutside(e) {
      if (!this.$el.contains(e.target)) {
        this.isOpen = false;
        this.arrowCounter = - 1;
      }
    }
  },

  watch: {
    items: function (value, prevValue) {
      if (this.isAsync) {
        if (value !== null && value.length === 0) {
          this.isOpen = false;
        }

        // actually compare them
        if (value !== null && value !== prevValue) {
          this.results = value;
          this.isLoading = false;
        }
      }
    }
  },

  mounted() {
    document.addEventListener('click', this.handleClickOutside)
  },

  destroyed() {
    document.removeEventListener('click', this.handleClickOutside)
  }
};
</script>
