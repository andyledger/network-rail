<template>
  <div
    class="tw-border-b tw-border-gray-light"
    :class="{'tw-border-t': i === 0}"
    data-allow-toggle
  >
    <button
      class="tw-flex tw-items-center tw-justify-between tw-cursor-pointer tw-w-full tw-py-4"
      :aria-expanded="[isExpanded ? 'true' : 'false']"
      :aria-controls="id"
      role="button"
      tabindex="0"
      @click="handleExpand(i)"
    >
      <inline-svg
        v-if="iconName"
        :name="`nr_${iconName}`"
        aria-hidden="true"
        class="tw-text-6xl tw-mr-5 tw--mt-2 tw-text-primary"
      />

      <h3
        class="accordion-title tw-font-black tw-flex-grow tw-mr-2 tw-block tw-text-left h5"
      >{{ title }}</h3>

      <plus-minus type="span" :isExpanded="isExpanded" class="tw-mr-1"/>
    </button>

    <collapse-transition>
      <div
        v-show="isExpanded"
        class="tw-py-4"
        :id="id"
        v-html="description"
      ></div>
    </collapse-transition>
  </div>
</template>

<script>
import InlineSvg from './InlineSvg.vue';
import PlusMinus from './PlusMinus.vue';
import {CollapseTransition} from 'vue2-transitions';
import uniqueId from 'lodash/uniqueId';

export default {
  name: 'accordion-item',

  components: {
    InlineSvg,
    PlusMinus,
    CollapseTransition
  },

  props: {
    isExpanded: {
      type: Boolean,
      default: false
    },

    i: {
      type: Number,
      default: 0
    },

    /**
     * Only accept values from nr icons font, so only icons
     * with the "nr_" prefix but without the prefix.
     * The reason is becasuse ACF field is done this way.
     */
    iconName: {
      type: String,
      default: ""
    },

    title: {
      type: String,
      default: ""
    },

    description: {
      type: String,
      default: ""
    }
  },

  data () {
    return {
      id: ''
    }
  },

  mounted () {
    this.id = `accordion-item-${uniqueId()}`
  },

  methods: {
    handleExpand(i) {
      /**
       * Send a number to the accordion wrapper component
       *
       * @event expand
       */
      this.$emit('expand', i);
    }
  }
}
</script>
