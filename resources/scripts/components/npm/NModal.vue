<template>
	<fade-transition :duration="500">
		<div class="tw-fixed tw-top-0 tw-left-0 tw-w-full tw-h-full tw-overflow-x-hidden tw-overflow-y-auto tw-bg-black tw-bg-opacity-50 tw-z-40" v-if="showModal" id="modal">
			<div role="dialog" aria-labelledby="modal" class="tw-relative tw-mx-4 tw-mb-4 tw-mt-16 md:tw-my-32 md:tw-mx-auto md:tw-max-w-screen-md tw-bg-white">
				<div class="tw-p-4 sm:tw-p-8 tw-flex tw-flex-col">
					<button
						class="tw-absolute tw-top-0 tw-right-0 tw-z-50 tw-bg-white"
						aria-label="close modal"
						@click="closeModal()"
					>
						<inline-svg name="ut_close" class="tw-text-4xl tw-text-gray-dark hover:tw-text-gray-darker"></inline-svg>
					</button>

					<div class="tw-mb-4">
						<slot></slot>
					</div>

					<div class="tw-flex tw-justify-end">
						<button
							class="tw-px-4 tw-py-1 tw-border tw-rounded tw-text-lg"
							aria-label="close modal"
							@click="closeModal()"
              ref="closeButton"
						><slot name="close">Close</slot></button>
					</div>
				</div>
			</div>
		</div>
	</fade-transition>
</template>

<script>
import InlineSvg from './InlineSvg.vue';
import { FadeTransition } from 'vue2-transitions';

export default {
	name: 'n-modal',

	components: {
		InlineSvg, FadeTransition
	},

	props: {
		showModal: {
			type: Boolean,
			default: false
		}
	},

  watch: {
    showModal(newValue, oldValue) {
      if (newValue) {
        this.trapFocus()
      }
    }
  },

	methods: {
		closeModal() {
			this.$emit('close-modal');
		},

    trapFocus() {

      this.$nextTick(() => {

        this.$refs.closeButton.focus()

        const element = document.getElementById('modal')
        const focusableElements = element.querySelectorAll('a[href]:not([disabled]), button:not([disabled]), textarea:not([disabled]), input[type="text"]:not([disabled]), input[type="radio"]:not([disabled]), input[type="checkbox"]:not([disabled]), select:not([disabled])')

        const firstFocusableElement = focusableElements[0];
        const lastFocusableElement = focusableElements[focusableElements.length - 1];

        element.addEventListener('keydown', (e) => {

          if(e.key === 'Escape') {
            this.closeModal()
          }

          if (e.key === 'Tab') {
            if ( e.shiftKey ) /* shift + tab */ {
              if (document.activeElement === firstFocusableElement) {
                lastFocusableElement.focus();
                e.preventDefault();
              }
            } else /* tab */ {
              if (document.activeElement === lastFocusableElement) {
                firstFocusableElement.focus();
                e.preventDefault();
              }
            }
          }
        })

      })
    }
	}
}
</script>
