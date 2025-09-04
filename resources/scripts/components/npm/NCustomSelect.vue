<template>
  <div class="custom-select" :tabindex="tabindex" @blur="open = false">
    <div class="tw-font-bold tw-mb-2 tw-block tw-text-lg"><slot /></div>

    <div class="selected" :class="{ open: open }" @click="open = !open">
      {{ selected }}
    </div>
    /
    <div class="items" :class="{ selectHide: !open }">
      <div
        v-for="(option, i) of options"
        :key="i"
        @click="
          selected = option;
          open = false;
          $emit('input', option);
        "
      >
        {{ option }}
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "n-custom-select",

  props: {
    options: {
      type: Array,
      required: true,
    },
    default: {
      type: String,
      required: false,
      default: null,
    },
    tabindex: {
      type: Number,
      required: false,
      default: 0,
    },
  },

  data() {
    return {
      selected: this.default
        ? this.default
        : this.options.length > 0
        ? this.options[0]
        : null,
      open: false,
    };
  },

  mounted() {
    this.$emit("input", this.selected);
  },
};
</script>