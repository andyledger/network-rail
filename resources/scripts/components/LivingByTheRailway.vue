<template>
	<div class="tw-relative tw-overflow-hidden">
		<slot></slot>

		<a 
			class="tw-absolute tw-z-10 tw-cursor-pointer" 
			:style="{top: 0 + (i * 10) + '%', right: 0 + (i * 13) + '%'}" 
			:href="anim.link.url"
			:target="anim.link.target" 
			v-for="(anim, i) in animations"
		>
			<n-lottie 
				:options="{
					animationData: JSON.parse(anim.json), 
					autoplay: false, 
					loop: false
				}"
				:height="60"
				:width="140"
				:playOnHover="true"
			/>
		</a>
	</div>
</template>

<script>
import NLottie from './npm/NLottie';

export default {
	name: "living-by-the-railway",

	data() {
		return {
			anim: null
		}
	},

	components: { NLottie },

	props: {
		animations: Array
	}
}
</script>
l
<style type="text/css">
@keyframes train-animation {
  0%,
  20% {
    top: -250px;
    right: -595px;
  }

  100% {
    top: 330px;
    right: 790px;
  }
}

.train-animation {
  animation-duration: 10s;
  animation-delay: 2s;
  animation-name: train-animation;
  animation-iteration-count: infinite;
  animation-direction: normal;
  animation-timing-function: linear;
}
</style>