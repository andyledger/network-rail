<template>
	<div>
		<button 
			class="tw-bg-brand-yellow tw-py-4 tw-block tw-w-full" 
			@click="isOpen = !isOpen"
			:aria-expanded="[isOpen ? 'true' : 'false']"
			aria-controls="emergency-banner"
		>
			<h2 class="tw-mb-0 tw-font-bold tw-container | tw-flex tw-items-center tw-justify-center">
				<inline-svg
					name="ut_exclamation_triangle" 
					class="tw-inline-block tw-text-4xl tw-relative tw-bottom-1"
				></inline-svg>

				<span class="tw-pr-1 tw-pl-2 tw-text-xl">{{ title }}</span>

				<inline-svg 
					name="ut_arrow_up" 
					class="tw-inline-block tw-text-2xl tw-transition tw-transform tw-relative tw-top-0.5"
					:class="[isOpen ? 'tw-rotate-0' : 'tw-rotate-180']"
				></inline-svg>
			</h2>
		</button>

		<div 
			class="tw-container tw-max-w-6xl"
			id="emergency-banner"
		>
	    <collapse-transition :duration="500">
	      <div v-show="isOpen">
	      	<div class="tw-py-8 tw-text-xl prose" v-html="description"></div>
	      </div>
	    </collapse-transition>
		</div>
	</div>
</template>

<script>
import InlineSvg from "./InlineSvg.vue";
import {CollapseTransition} from 'vue2-transitions';

export default {
	name: "emergency-banner",

	components: {
		InlineSvg, CollapseTransition
	},

	props: {
		title: String,
		description: String
	},

	data() {
		return {
			isOpen: false
		}
	}
}
</script>
