<template>
  <component
    :is="componentType"
    :href="link"
    :target="external ? 'blank' : null"
    class="tw-font-bold tw-mb-4 tw-mr-4 tw-text-center tw-inline-block tw-min-w-200 tw-border-2 tw-transition-colors tw-duration-200"
    :class="classes"
    :style="styles"
    @click="$emit('click')"
  >
    <!-- @slot Default {string} -->
    <slot>Click</slot>

    <inline-svg v-if="iconName" :name="iconName" class="tw-text-sm"></inline-svg>
  </component>
</template>

<script>
import InlineSvg from './InlineSvg.vue';

export default {
  name: 'cta-button',

  components: {
    InlineSvg
  },

  props: {
    /**
     * An empty link will create a button element instead of an 'a' element
     */
    link: {
      type: String,
      default: null
    },

    /**
     * Only valid for 'a' elements
     */
    external: {
      type: Boolean,
      default: false
    },

    filled: {
      type: Boolean,
      default: true
    },

    color: {
      type: String,
      default: 'primary',
      validator: value => ['black', 'secondary', 'primary'].indexOf(value) !== -1
    },

    /**
     * @values sm, md, lg
     */
    size: {
      type: String,
      default: 'sm',
      validator: value => value.match(/(sm|md|lg)/)
    },

    /**
     * Only for button
     */
    disabled: {
      type: Boolean,
      default: false
    },

    rounded: {
      type: Boolean,
      default: false
    },

    iconName: {
      type: String,
      default: ''
    }
  },

  computed: {
    classes() {
      let classes = '';

      if (this.color === 'primary' && !this.filled) classes += 'tw-border-primary tw-text-primary hover:tw-bg-brand-blue hover:tw-text-white';

      if (this.color === 'secondary' && !this.filled) classes += 'tw-border-secondary tw-text-secondary hover:tw-bg-secondary hover:tw-text-white';

      if (this.color === 'black' && !this.filled) classes += 'tw-border-black tw-text-black hover:tw-bg-black hover:tw-text-white';

      if (this.color === 'primary' && this.filled) classes += 'tw-border-secondary tw-bg-brand-blue tw-text-white hover:tw-bg-brand-blue-darker hover:tw-border-brand-blue-darker';

      if (this.color === 'secondary' && this.filled) classes += 'tw-border-secondary tw-bg-secondary tw-text-white hover:tw-bg-white hover:tw-text-secondary';

      if (this.color === 'black' && this.filled) classes += 'tw-border-black tw-bg-black tw-text-white hover:tw-bg-white hover:tw-text-black';

      if (this.size === 'sm') classes += ' tw-py-2 tw-px-4 tw-text-base';

      if (this.size === 'md') classes += ' tw-py-3 tw-px-6 tw-text-lg';

      if (this.size === 'lg') classes += ' tw-py-4 tw-px-8 tw-text-xl';

      if (this.disabled) classes += ' tw-opacity-50 tw-cursor-not-allowed';

      if (this.rounded) classes += ' tw-rounded-full';

      if (!this.rounded) classes += ' tw-rounded-md';

      if (this.iconName) classes += ' tw-flex tw-items-center tw-justify-between';

      return classes;
    },

    styles() {
      let styles = '';

      if (this.link != null) styles += 'text-decoration: none !important;';      

      if (this.filled) styles += ' color: white !important';

      return styles;
    },

    componentType() {
      if (this.link) {
        return 'a';
      }

      return 'button';
    }
  }
}
</script>