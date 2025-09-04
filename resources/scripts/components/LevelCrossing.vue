<template>
  <div>
    <div class="tw-bg-gray-lighter tw-p-4 sm:tw-p-8 tw-mb-12">
      <div class="md:tw-flex md:tw-mb-12">
        <div class="md:tw-w-1/3 md:tw-mr-8 tw-mb-8 md:tw-mb-0">
          <n-postcode
            class="n-postcode"
            v-model="postcodeObject"
            :key="postcodeKey"
          >Postcode</n-postcode>
        </div>

        <div class="md:tw-w-2/3 tw-mb-16 md:tw-mb-0">
          <label class="tw-font-bold tw-mb-4 tw-block tw-text-lg">Radius <span class="tw-font-normal tw-text-base">(miles)</span></label>

          <vue-slider
            v-model="radius"
            v-bind="radiusSliderConfig"
            :disabled="!postcodeObject.isValidPostcode"
            :class="[!postcodeObject.isValidPostcode ? 'tw-opacity-75': 'vue-slider-active']"
            :dotAttrs="{ tabindex: postcodeObject.isValidPostcode ? 0 : -1 }"
          />
        </div>
      </div>

      <div class="tw-mb-16">
        <div class="tw-flex tw-justify-between tw-items-center tw-mb-4">
          <label class="tw-font-bold tw-block tw-text-lg">Line speed <span class="tw-font-normal tw-text-base">(mph)</span></label>

          <n-switch
            v-model="isLineSpeedActive"
            :key="isLineSpeedActiveKey"
            :label="isLineSpeedActive ? 'Deactivate line speed filter' : 'Activate line speed filter'"
          >
            <div class="tw-text-gray-dark tw-hidden sm:tw-block tw-text-sm">Activate line speed filter</div>
          </n-switch>
        </div>

        <vue-slider
          v-model="lineSpeed"
          v-bind="defaultSliderConfig"
          :min="0"
          :max="120"
          :interval="30"
          :marks="val => val % 30 === 0 ? { label: `${val}` } : { label: '' }"
          :disabled="!isLineSpeedActive"
          :class="[!isLineSpeedActive ? 'tw-opacity-75': 'vue-slider-active']"
          :dotAttrs="{ tabindex: isLineSpeedActive ? 0 : -1 }"
        />
      </div>

      <div class="tw-mb-16">
        <div class="tw-flex tw-justify-between tw-items-center tw-mb-4">
          <label class="tw-font-bold tw-block tw-text-lg">Number of trains per day <span class="tw-font-normal tw-text-base">(approximately)</span></label>

          <n-switch
            v-model="isNumberTrainsPerDayActive"
            :key="isNumberTrainsPerDayActiveKey"
            :label="isNumberTrainsPerDayActive ? 'Deactivate nº of trains per day filter' : 'Activate nº of trains per day filter'"
          >
            <div class="tw-text-gray-dark tw-hidden sm:tw-block tw-text-sm">Activate nº of trains per day filter</div>
          </n-switch>
        </div>

        <vue-slider
          v-model="numberTrainsPerDay"
          v-bind="defaultSliderConfig"
          :min="0"
          :max="600"
          :interval="50"
          :marks="val => val % 100 === 0 ? { label: `${val}` } : { label: '' }"
          :disabled="!isNumberTrainsPerDayActive"
          :class="[!isNumberTrainsPerDayActive ? 'tw-opacity-75': 'vue-slider-active']"
          :dotAttrs="{ tabindex: isNumberTrainsPerDayActive ? 0 : -1 }"
        />
      </div>

      <div>
        <cta-button
          @click="resetFilters()"
          size="md"
        >Reset filters - show all crossing</cta-button>

        <div class="tw-text-xl" role="status">You have found {{ filteredLevelsNumber }} level crossing</div>
      </div>
    </div>

    <div class="tw-overflow-hidden tw-mb-8">
      <div class="tw-bg-gray-light tw-h-176 tw-relative tw-mb-1">
        <gmap-map
          v-bind="map"
          map-type-id="roadmap"
          :options="{
            streetViewControl: false,
            mapTypeControl: false
          }"
          class="tw-w-full tw-h-full tw-mb-12"
        >
          <gmap-marker
            v-for="(level, i) in filteredLevels(levels, lineSpeed, isLineSpeedActive, numberTrainsPerDay, isNumberTrainsPerDayActive, postcodeObject.isValidPostcode, postcodeObject.latitude, postcodeObject.longitude, radius)"
            :key="i"
            :icon="marker"
            :position="level.position"
            :clickable="true"
            :draggable="false"
            @click="toogleInfoWindow(level)"
          />
        </gmap-map>

        <n-info-window
          :is-open="infoWindowOpen"
          @is-open="infoWindowOpen = !infoWindowOpen"
          class="tw-shadow tw-min-w-300 tw-text-lg"
        >
          <div class="tw-p-4 tw-text-white tw-bg-brand-blue">
            <div class="tw-font-bold">Location</div>
            <div class="tw-mb-2 tw-text-base">{{ infoWindowContent.location }}</div>

            <div class="tw-font-bold">Name</div>
            <div class="tw-mb-2 tw-text-base">{{ infoWindowContent.crossingName }}</div>
          </div>

          <div class="tw-p-4">
            <div class="tw-font-bold">Latitude, longitude</div>
            <div
              class="tw-mb-4"
            >{{ positionString(infoWindowContent.position) }}</div>

            <div class="tw-font-bold">Type</div>
            <div class="tw-mb-4">{{ infoWindowContent.crossingType }}</div>

            <div class="tw-font-bold">Risk Score</div>
            <div class="tw-mb-4">{{ infoWindowContent.riskScore }}</div>

            <div class="tw-font-bold">Trains per day</div>
            <div class="tw-mb-4">{{ infoWindowContent.numberTrainsPerDay }}</div>

            <div class="tw-font-bold">Line Speed</div>
            <div>{{ infoWindowContent.lineSpeed }} mph</div>
          </div>
        </n-info-window>
      </div>
    </div>
  </div>
</template>

<script>
import { positionFormat, defaultSliderConfig, radiusSliderConfig, getDistanceFromLatLonInMiles } from "../utils/careers.js";
import axios from 'axios';
import VueSlider from "vue-slider-component";
import NPostcode from './npm/NPostcode.vue';
import NSwitch from "./npm/NSwitch";
import CtaButton from "./npm/CtaButton";
import NInfoWindow from "./npm/NInfoWindow";
import * as GmapVue from 'gmap-vue';
import Vue from 'vue'

Vue.use(GmapVue, {
  load: {
    key: 'AIzaSyB2A0Rc9Mssp2Cj9EyzjfpCcN3yLO3iL1c',
    libraries: 'geometry,places', // necessary for places input
  },
  installComponents: true,
});

export default {
  name: "level-crossing",

  components: {
    VueSlider,
    NPostcode,
    NInfoWindow,
    CtaButton,
    NSwitch
  },

  data() {
    return {
      map: {
        center: positionFormat(54.5, -1),
        zoom: 6,
        currentMidx: null
      },
      infoWindowContent: {},
      infoWindowOpen: false,
      levels: [],
      filteredLevelsNumber: 0,
      defaultSliderConfig: defaultSliderConfig,
      radiusSliderConfig: radiusSliderConfig,
      postcodeObject: {
        isValidPostcode: false,
        latitude: null,
        longitude: null
      },
      radius: 50,
      lineSpeed: [30, 70],
      isLineSpeedActive: false,
      isLineSpeedActiveKey: 0,
      numberTrainsPerDay: [50, 100],
      isNumberTrainsPerDayActive: false,
      isNumberTrainsPerDayActiveKey: 1,
      postcodeKey: 2
    }
  },

  computed: {
    marker() {
      return {
        url: '/wp-content/themes/network-rail/resources/images/marker-blue-small.png'
      };
    }
  },

  methods: {
    toogleInfoWindow(level) {
      this.infoWindowContent = level;
      this.infoWindowOpen = true;
    },

    positionString(position) {
      if (position !== undefined) {
        return position.lat + ', ' + position.lng;
      }

      return 'lat, lng';
    },

    resetFilters() {
      this.postcodeObject = {
        isValidPostcode: false,
        latitude: null,
        longitude: null
      };
      this.radius = 50;
      this.lineSpeed = [30, 70];
      this.isLineSpeedActive = false;
      this.isLineSpeedActiveKey++;
      this.numberTrainsPerDay = [50, 100];
      this.isNumberTrainsPerDayActive = false;
      this.isNumberTrainsPerDayActiveKey++;
      this.postcodeKey++;
    },

    filteredLevels(levels, lineSpeed, isLineSpeedActive, numberTrainsPerDay, isNumberTrainsPerDayActive, isValidPostcode, latitude, longitude, radius) {
      // filter by postcode
      levels = levels.filter(level => {
        if (!isValidPostcode) {
          return true;
        }

        return (
          getDistanceFromLatLonInMiles(
            level.position.lat,
            level.position.lng,
            latitude,
            longitude
          ) <= radius
        );
      });

      // filter by line speed
      levels = levels.filter(level => {
        if (!isLineSpeedActive) {
          return true;
        }

        return (
           this.lineSpeed[0] <= level.lineSpeed &&
           level.lineSpeed <= this.lineSpeed[1]
        );
      });

      // filter by number of trains
      levels = levels.filter(level => {
        if (!isNumberTrainsPerDayActive) {
          return true;
        }

        return (
           this.numberTrainsPerDay[0] <= level.numberTrainsPerDay &&
           level.numberTrainsPerDay <= this.numberTrainsPerDay[1]
        );
      });

      this.filteredLevelsNumber = levels.length;

      return levels;
    }
  },

  mounted() {
    axios.get('/wp-content/themes/network-rail/resources/level-crossing-map.json')

    .then((response) => {
      this.levels = Object.values(response.data)
    })
  }
}
</script>
