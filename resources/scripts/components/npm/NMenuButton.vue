<template>
	<button
		class="tw-w-12 tw-h-12 | tw-relative tw-z-50 tw-mr-auto | tw-bg-white tw-rounded tw-border tw-border-gray-light"
		aria-label="Navigation Menu"
		@click="openMenu()"
	>
		<div
			class="tw-w-5 tw-absolute tw-top-1/2 tw-transform tw-translate-x-1/2 tw--translate-y-1/2"
		>
			<div
				class="tw-absolute tw-h-0.5 tw-text-white tw-bg-black tw-transform tw-transition tw-duration-500"
				:class="[open ? 'tw--translate-y-2 tw-w-7' : 'tw--translate-x-0.5 tw-rotate-45 tw-w-8']"
			></div>

			<div
				class="tw-absolute tw-h-0.5 tw-w-7 tw-text-white tw-bg-black tw-transform tw-transition tw-duration-500"
				:class="{'tw-opacity-0': !open } "
			></div>

			<div
				class="tw-absolute tw-h-0.5 tw-text-white tw-bg-black tw-transform tw-transition tw-duration-500"
				:class="[open ? 'tw-translate-y-2 tw-w-7' : 'tw--translate-x-0.5 tw--rotate-45 tw-w-8']"
			></div>
		</div>
	</button>
</template>

<script>
export default {
	name: "n-menu-button",

	props: {
    /**
     * State of the icon
     */
		open: {
			type: Boolean,
			default: false
		}
	},

  methods: {
    openMenu() {
      /**
       * Fired on click
       *
       * @event click
       */
      this.$emit('click');
    }
  }
}
</script>
