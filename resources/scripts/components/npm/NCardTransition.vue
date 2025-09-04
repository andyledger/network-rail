<template>
  <div class="tw-relative" @mouseover="show = true" @mouseleave="show = false">
    <n-img
      :lazy-src="imgSrc"
      :alt="altImg"
      :aspect-ratio="aspectRatio"
    ></n-img>

    <fade-transition :duration="500">
    	<div v-show="show" class="tw-flex tw-justify-center tw-items-center tw-absolute tw-inset-0 tw-bg-primary tw-text-white tw-text-xl">
				<slot></slot> 		
    	</div>
    </fade-transition>
  </div>
</template>

<script>
import { FadeTransition } from 'vue2-transitions';
import NImg from './NImg.vue';
import InlineSvg from './InlineSvg.vue';

export default {
	name: "n-card-transition",

	components: {
		NImg, InlineSvg, FadeTransition
	},

	props: {
		imgSrc: String,

		altImg: String,

		link: String,

		/**
		 * "w/h" format
		 */
		aspectRatio: {
			type: String,
			default: "16/9"
		}
	},

	data() {
		return {
			show: false
		}
	}
}
</script>