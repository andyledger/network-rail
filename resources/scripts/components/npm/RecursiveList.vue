<template>
  <li
    :class="liClasses"
  >
    <div class="tw-flex" v-if="depth !== 0">
      <div
        class="tw-cursor-pointer tw-pl-0 tw-p-3 tw-mt-1"
        :class="{ 'tw-invisible': !child_items }"
        @click="expand(title)"
        v-show="depth === 2"
      >
        <plus-minus
          :isExpanded="isExpandedComputed"
          :aria-expanded="[isExpandedComputed ? 'true' : 'false']"
        ></plus-minus>
      </div>

      <a
        :href="url"
        :class="aClasses"
        v-html="title"
      />

      <div
        class="tw-cursor-pointer tw-mt-1.5"
        :class="{ 'tw-invisible': !child_items }"
        @click="expand(title)"
        v-show="depth === 1"
      >
        <plus-minus
          :isExpanded="isExpandedComputed"
          :aria-expanded="[isExpandedComputed ? 'true' : 'false']"
          class="tw-w-44 tw-h-44 tw-flex tw-justify-center tw-items-center"
        ></plus-minus>
      </div>
    </div>

    <collapse-transition :duration="500">
      <ul
        :class="ulClasses"
        v-show="isExpandedComputed"
      >
        <recursive-list
          v-for="(liElement, index) in child_items"
          :key="index"
          :child_items="liElement.child_items"
          :title="liElement.title"
          :url="liElement.url"
          :depth="depth + 1"
        ></recursive-list>
      </ul>
    </collapse-transition>
  </li>
</template>

<script>
import PlusMinus from './PlusMinus.vue';
import {CollapseTransition} from 'vue2-transitions';

export default {
  name: "recursive-list",

  components: {
    PlusMinus,
    CollapseTransition
  },

  props: {
    title: String,
    url: String,
    child_items: Array,
    depth: Number
  },

  data() {
    return {
      isExpanded: false
    }
  },

  computed: {
    isExpandedComputed: {
      get() {
        if (this.depth === 0) {
          return true
        }

        return this.isExpanded
      },

      set(newValue) {
        this.isExpanded = newValue
      }
    },

    liClasses() {
      if (this.depth === 1) {
        return 'tw-pl-6 tw-pr-2 tw-border-b-2 tw-border-gray-light'
      }

      return ''
    },

    ulClasses() {
      if (this.depth === 0) {
        return 'tw-relative'
      }

      if (this.depth === 2) {
        return 'tw-pl-12 tw-list-disc'
      }

      return 'tw-mb-4'
    },

    aClasses() {
      if (this.depth === 1) {
        return 'tw-text-lg tw-py-4 tw-font-bold tw-flex-grow'
      }

      if (this.depth === 2) {
        return 'tw-text-lg tw-py-3 tw-font-bold tw-flex-grow'
      }

      if (this.depth === 3) {
        return 'tw-py-2 tw-pl-2 tw-block tw-text-lg'
      }

      return ''
    }
  },

  methods: {
    expand(title) {
      this.isExpandedComputed = !this.isExpandedComputed;

      this.$parent.$children.forEach((item) => {
        if (item.title !== title) {
          item.isExpandedComputed = false
        }
      })
    }
  }
}
</script>
