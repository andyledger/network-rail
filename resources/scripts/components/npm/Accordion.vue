<template>
  <div>
    <slot
      name="accordion"
      :activeItem="activeItem"
      :handleExpand="handleExpand"
    />
  </div>
</template>

<script>
export default {
  name: 'accordion',

  data() {
    return {
      activeItem: -1
    }
  },

  props: {
    multiple: Boolean
  },

  methods: {
    /**
     * Gets called when the user clicks on the button
     */
    handleExpand(e) {
      if (this.activeItem === e) {
        this.activeItem = -1;

        return;
      }

      this.activeItem = e
    }
  }
}
</script>
