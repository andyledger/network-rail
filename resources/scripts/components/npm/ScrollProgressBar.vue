<template>
  <div class="tw-h-1 tw-absolute tw-bottom-0 tw-w-full">
    <div
      class="tw-h-1 tw-bg-secondary"
      :style="{ width: percentage + '%' }"
    ></div>
  </div>
</template>

<script>
  export default {
    name: 'scroll-progress-bar',

    props: {
      percentage: {
        type: Number,
        default: 0
      }
    }
  }
</script>
