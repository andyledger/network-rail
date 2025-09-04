<template>
  <div>
    <div
      v-for="(item, i) in items" :key="i"
      class="tw-border-b tw-border-gray-light"
      :class="{ 'tw-border-t': i === 0 }"
      data-allow-toggle
    >
      <button
        :id="'heading-' + i"
        class="tw-flex tw-items-center tw-justify-between tw-cursor-pointer tw-w-full" style="height: 60px"
        :aria-expanded="item.isExpanded"
        :aria-controls="'collapse-' + i"
        aria-pressed="false"
        role="button"
        tabindex="0"
        @click="expand(item)"
      >
        <inline-svg
          v-if="item.is_icon"
          :name="`nr_${item.icon}`"
          class="tw-text-6xl tw-mr-5 tw--mt-2"
        />

        <div
          class="tw-text-xl tw-font-black tw-flex-grow tw-truncate tw-mr-2 tw-block tw-text-left"
        >{{ item.title }}</div>

        <PlusMinus :isExpanded="item.isExpanded" class="tw-mr-1"/>
      </button>

      <collapse-transition>
        <div
          :id="'collapse-' + i"
          :aria-labelledby="'heading-' + i"
          v-show="item.isExpanded"
        >
          <div
            class="tw-py-4"
            v-html="item.description"
          ></div>
        </div>
      </collapse-transition>
    </div>
  </div>
</template>

<script>
import InlineSvg from './InlineSvg.vue';
import PlusMinus from './PlusMinus.vue';
import {CollapseTransition} from 'vue2-transitions';

export default {
  name: 'accordion',

  components: {
    InlineSvg,
    PlusMinus,
    CollapseTransition
  },

  props: {
    items: {
      type: Array,
      default: () => []
    }
  },

  methods: {
    expand(currentItem) {
      this.items.forEach( item => {
        if (currentItem !== item) {
          item.isExpanded = false
        }

        if (currentItem === item) {
          currentItem.isExpanded = !currentItem.isExpanded
        }
      })
    }
  }
}
</script>
