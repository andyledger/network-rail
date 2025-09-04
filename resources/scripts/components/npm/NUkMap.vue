<template>
  <div class="md:tw-flex">
    <svg viewBox="0 0 600 800" xmlns="http://www.w3.org/2000/svg" class="tw-mb-12 md:tw-mb-0 tw-w-full" aria-hidden="true">
      <n-path
        v-for="(region, i) in areas"
        :key="i"
        :class="[ selectedRegion.includes(region.count) ? region.color : region.color + ' tw-opacity-75']"
        :regionName="region.svg"
        @mouseover.native="selectedRegion.push(region.count)"
        @mouseout.native="selectedRegion = [] "
        :x="region.x"
        :y="region.y"
        :count="region.count"
        :link="region.link"
      ></n-path>
    </svg>

    <div class="md:tw-w-1/2 lg:tw-w-1/3 tw-flex tw-items-center">
      <div>
        <h4
          class="tw-inline-block tw-pb-2 tw-text-secondary tw-text-2xl tw-font-bold tw-border-b-4 tw-border-gray-medium tw-mb-6"
        >Network Rail Regions and Routes</h4>

        <ul>
          <li
            v-for="(route, j) in [
              {name: 'Eastern', slice: [0, 13, 1, 2,], regions:['1', '2', '3', '14'], color: 'brand-orange', link: regions.eastern},
              {name: 'North West and Central', slice: [3, 4, 5], regions:['4', '5', '6'], color: 'brand-green', link: regions.northwestandcentral},
              {name: 'Scotland\'s Railway', slice: [6], regions:['8'], color: 'brand-blue-dark', link: regions.scotlandsrailway},
              {name: 'Southern', slice: [7, 8, 9, 10], regions:['9', '10', '11', '12'], color: 'brand-turquesa', link: regions.southern},
              {name: 'Wales & Western', slice: [11, 12], regions:['13', '14'], color: 'brand-red', link: regions.walesandwestern},
            ]"
            class="tw-mb-8"
          >
            <h5
              @mouseover="selectedRegion = route.regions"
              @mouseout="selectedRegion = []"
              class="tw-mb-0 tw-font-bold"
              :class="'tw-text-' + route.color"
            >
              <component :is="route.link ? 'a' : 'span'" :href="route.link" class="tw-flex tw-items-center" :class="route.link && 'hover:tw-text-hyperlinks hover:tw-underline'">
                <span
                  class="tw-text-base tw-p-3 tw-mr-2 tw-border-2 tw-rounded-full tw-w-6 tw-h-6 tw-inline-block"
                  :class="'tw-bg-' + route.color"
                ></span>

                <span class="tw-text-black">{{ route.name }}</span>
              </component>
            </h5>

            <ul>
              <li
                v-for="(region, i) in route.slice.map(index => areas[index])"
                :key="i"
                class="tw-mb-1 tw-flex tw-items-center tw-cursor-pointer tw-text-gray-dark"
                @mouseover="selectedRegion.push(region.count)"
                @mouseout="selectedRegion = [] "
              >
                <span
                  class="tw-text-sm tw-p-3 tw-mr-2 tw-flex tw-justify-center tw-items-center tw-border-2 tw-rounded-full tw-w-6 tw-h-6 tw-inline-block"
                  :class="'tw-border-' + route.color"
                >{{ region.count }}</span>

                <a :href="region.link" class="hover:tw-text-hyperlinks hover:tw-underline">{{ region.name }}</a>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
import NPath from './NPath.vue';

export default {
  name: "n-uk-map",

  components: {
    NPath
  },

  props: {
    areas: {
      type: Array,
      default: () => [],
      required: true
    },
    regions: {
      type: Object,
      default: () => [],
      required: true
    }
  },

  data() {
    return {
      selectedRegion: []
    }
  }
}
</script>
