<template>
	<div class="tw-h-72 md:tw-h-96 lg:tw-h-128 2xl:tw-h-152 3xl:tw-h-176 tw-relative slider">
		<div class="tw-absolute tw--bottom-9 tw-w-full tw-text-center">
			<button
				class="tw-inline-block tw-mx-3 tw-rounded-full tw-border"
				style="width: 24px; height: 24px;"
				:class="{'tw-bg-black' : selectedIndex === i}"
				:aria-label="slideDotTitle(i)"
				:aria-current="selectedIndex === i ? 'step' : false"
				v-for="(item, i) in slides"
				@click="selectIndex(i)"
				tabindex="0"
			></button>
		</div>

		<button
			class="tw-w-8 tw-h-8 tw-rounded-full tw--translate-y-1/2 tw-top-1/2 tw-absolute tw-left-4 tw-bg-gray-light tw-bg-opacity-75 tw-hidden sm:tw-inline-block tw-z-10"
			type="button"
			:aria-label="prevSlideTitle()"
			@click="previousSlide"
		>
			<svg class="tw-absolute tw-left-1/5 tw-top-1/5 tw-w-3/5 tw-h-3/5" viewBox="0 0 100 100">
				<path d="M 10,50 L 60,100 L 70,90 L 30,50  L 70,10 L 60,0 Z" class="arrow"></path>
			</svg>
		</button>

		<button
			class="tw-w-8 tw-h-8 tw-rounded-full tw--translate-y-1/2 tw-top-1/2 tw-absolute tw-right-4 tw-bg-gray-light tw-bg-opacity-75 tw-hidden sm:tw-inline-block tw-z-10"
			type="button"
			:aria-label="nextSlideTitle()"
			@click="nextSlide"
		>
			<svg class="tw-absolute tw-left-1/5 tw-top-1/5 tw-w-3/5 tw-h-3/5" viewBox="0 0 100 100">
				<path d="M 10,50 L 60,100 L 70,90 L 30,50  L 70,10 L 60,0 Z" class="arrow" transform="translate(100, 100) rotate(180) "></path>
			</svg>
		</button>

		<flickity
			ref="flickityComponent"
			:options="{
				initialIndex: 0,
				prevNextButtons: false,
				pageDots: false,
				wrapAround: true,
				setGallerySize: false,
				draggable: true,
				autoPlay: false,
				fade: true,
				accessibility: false, // disable tabindex on root div and arrow navigation..
			}"
			class="tw-h-full"
			@update-index="updateIndex"
		>
			<div
				v-for="(item, i) in slides"
				:key="i"
				class="tw-w-full tw-h-full tw-flex tw-items-center tw-justify-center"
				@touchend="change()"
			>
				<img
					class="tw-absolute tw-object-cover tw-w-full tw-h-full"
					:alt="item.altImage"
					:src="item.imgUrl"
					:srcset="item.imgUrlSrcSet"
				/>

				<div class="tw-mx-auto tw-px-16 tw-max-w-2xl tw-w-full md:tw-container tw-flex tw-flex-col tw-justify-center tw-items-start tw-text-white tw-relative tw-z-20">
					<div class="tw-bg-black tw-rounded-lg tw-py-6 tw-px-8 md:tw-py-8 tw-max-w-2xl">
						<h2 class="tw-mb-4 md:tw-mb-8">
							{{ item.title }}
						</h2>

						<div class="tw-hidden lg:tw-block tw-mb-8 tw-text-xl">
							{{ item.description }}
						</div>

						<a
							class="tw-inline-block tw-text-white tw-underline md:tw-no-underline md:tw-px-4 md:tw-py-3 md:tw-rounded-lg md:tw-bg-gray-dark md:tw-font-bold md:hover:tw-bg-secondary tw-transition-colors"
							:href="item.link"
							:tabindex="[selectedIndex !== i ? '-1' : '']"
						>
							{{ item.link_title }}

							<inline-svg
								name="ut_arrow_right2"
								class="tw-hidden md:tw-inline tw-ml-4 tw-relative"
								svg-classes="tw-inline"
							></inline-svg>
						</a>
					</div>
				</div>
			</div>
		</flickity>
	</div>
</template>

<script>
import Flickity from './npm/Flickity.vue';
import InlineSvg from './npm/InlineSvg.vue';

export default {
	name: "main-slider",

	components: {
		Flickity,
		InlineSvg
	},

	props: {
		slides: {
			type: Array,
			default: () => []
		}
	},

	data() {
		return {
			selectedIndex: 0,
		}
	},

	methods: {
		change() {
			this.selectedIndex = this.$refs.flickityComponent.selectedIndex();
		},

		nextSlide(isWrapped = true, isInstant = false) {
			this.$refs.flickityComponent.next(isWrapped, isInstant);
		},

		previousSlide(isWrapped = true, isInstant = false) {
			this.$refs.flickityComponent.previous(isWrapped, isInstant);
		},

		selectIndex(index, isWrapped = true, isInstant = false) {
			this.selectedIndex = index;
			this.$refs.flickityComponent.select(index, isWrapped, isInstant);

		},

		updateIndex(e) {
			this.selectedIndex = e;
		},

		nextSlideTitle() {
			let next = this.selectedIndex + 1

			if (this.slides[next] === undefined) {
				next = 0
			}

			return 'View "' + this.slides[next].title + '" slide'
		},

		prevSlideTitle() {
			let prev = this.selectedIndex - 1

			if (this.slides[prev] === undefined) {
				prev = this.slides.length - 1
			}

			return 'View "' + this.slides[prev].title + '" slide'
		},

		slideDotTitle(index) {
			return 'View "' + this.slides[index].title + '" slide'
		}

	}
}
</script>
