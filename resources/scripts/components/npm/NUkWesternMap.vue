<template>
  <div class="md:tw-flex">
    <svg viewBox="0 0 2000 2000" xmlns="http://www.w3.org/2000/svg">
      <n-path
        v-for="(region, i) in areas"
        :key="i"
        :class="[ selectedRegion === i ? 'tw-text-primary' : 'tw-text-secondary']"
        :regionName="region.slug"
        @mouseover.native="selectedRegion = i"
        @mouseout.native="selectedRegion = null"
      ></n-path>
    </svg>

    <div class="tw-flex tw-items-center md:tw-pl-8 md:max-w-400">
      <div>
        <h4 class="tw-inline-block tw-pb-2 tw-text-secondary tw-text-2xl tw-font-bold tw-border-b-4 tw-border-gray-medium tw-mb-6">{{ mapTitle }}</h4>

        <ul>
          <li
            class="tw-mb-2 tw-flex tw-items-center tw-cursor-pointer hover:tw-font-bold tw-text-gray-dark sm:tw-text-lg"
            :class="{'tw-font-bold' : selectedRegion === i}"
            @mouseover="selectedRegion = i"
            @mouseout="selectedRegion = null "
            :key="i"
            v-for="(region, i) in areas
          ">
            <span
              class="tw-text-base tw-p-3 tw-mr-2 tw-flex tw-justify-center tw-items-center tw-text-black tw-border-2 tw-border-secondary tw-rounded-full tw-w-6 tw-h-6 tw-inline-block"
            >{{ i + 1 }}</span>

            <a v-if="region.link.url" :href="region.link.url" :target="region.link.target">{{ region.title }}</a>

            <span v-else>{{ region.title }}</span>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
import NPath from './NPath.vue';

export default {
  name: "n-uk-western-map",

  props: {
    areas: {
      type: Array,
      default: () => [],
      required: true
    },
    mapTitle: {
      type: String,
      default: 'Map'
    }
  },

  data() {
    return {
      selectedRegion: null
    }
  },

  components: {
    NPath
  }
}
</script>
