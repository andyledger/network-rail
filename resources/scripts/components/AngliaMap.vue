<template>
  <div>
    <div class="md:tw-flex tw-justify-between tw-mb-8">
      <label class="tw-block tw-min-w-200 tw-mb-4 md:tw-mb-0">
        <span class="tw-font-bold tw-mb-2 tw-block tw-text-lg">Select line</span>

        <select
          class="tw-form-select tw-rounded-md tw-block tw-w-full tw-mt-1 tw-py-3 tw-pl-4 tw-pr-10 tw-text-xl tw-text-gray-medium tw-border tw-border-gray-light"
          v-model="line"
        >
          <option
            v-for="(option, i) in ['All', 'Regional Lines', 'Great Eastern', 'North London Line / Gospel Oak to Barking', 'Essex Thameside', 'West Anglia']"
            :key="i"
            :value="option"
          >{{ option }}</option>
        </select>
      </label>

      <label class="tw-block tw-min-w-200 tw-mb-4 md:tw-mb-0">
        <span class="tw-font-bold tw-mb-2 tw-block tw-text-lg">Select Year</span>

        <select
          class="tw-form-select tw-rounded-md tw-block tw-w-full tw-mt-1 tw-py-3 tw-pl-4 tw-pr-10 tw-text-xl tw-text-gray-medium tw-border tw-border-gray-light"
          v-model="year"
        >
          <option
            v-for="(option, i) in ['All', '2020/21', '2021/22', '2022/23', '2023/24']"
            :key="i"
            :value="option"
          >{{ option }}</option>
        </select>
      </label>
    </div>

    <div class="tw-flex tw-mb-4 tw-text-xl">
      <div
        class="tw-flex tw-ml-4"
        v-for="item in [
          {title: 'Renewals', class: 'tw-text-brand-blue'},
          {title: 'Enhancement', class: 'tw-text-brand-orange'}
      ]">
        <span>{{ item.title }}:</span>

        <inline-svg
          name="ut_marker"
          class="tw-text-4xl"
          :class="item.class"
        ></inline-svg>
      </div>
    </div>

    <div class="tw-overflow-hiddenx tw-mb-8">
      <div class="tw-bg-gray-light tw-h-128 tw-relative tw-mb-1">
        <gmap-map
          v-bind="map"
          map-type-id="roadmap"
          :options="{
            streetViewControl: false,
            mapTypeControl: false
          }"
          class="tw-w-full tw-h-128 tw-mb-12"
        >
          <gmap-marker
            v-for="(station, i) in filterStations(stations, line, year)"
            :key="i"
            :icon="iconMarker(station.type)"
            :position="station.position"
            :clickable="true"
            :draggable="false"
            @click="toogleInfoWindow(station, i)"
          />
        </gmap-map>

        <n-info-window
          :is-open="infoWindowOpen"
          @is-open="infoWindowOpen = !infoWindowOpen"
          class="tw-shadow"
        >
          <div class="tw-h-36 tw-flex tw-justify-center tw-items-center tw-transform tw-overflow-hidden">
            <inline-svg
              v-if="infoWindowContent.icon"
              :name="mapIcons(infoWindowContent.icon)"
              class="tw-text-8xl"
            ></inline-svg>

            <n-img
              v-else
              :lazy-src="infoWindowContent.imageUrl"
              :alt="infoWindowContent.work"
            ></n-img>
          </div>

          <div class="tw-p-2 tw-text-white" :class="mapColors(infoWindowContent.type)">
            <div class="tw-text-sm">Location</div>
            <div class="tw-text-xl tw-font-bold tw-truncate">{{ infoWindowContent.location }}</div>
          </div>

          <div class="tw-p-2">
            <div class="tw-mb-2">
              <div class="tw-font-bold tw-text-base">What works are we carrying out</div>
              <div class="tw-text-sm">{{ infoWindowContent.work }}</div>
            </div>

            <div class="tw-mb-2">
              <div class="tw-font-bold tw-text-base">Line and year</div>
              <div class="tw-text-sm">{{ infoWindowContent.line }} - {{ infoWindowContent.year }}</div>
            </div>

            <div class="tw-mb-2">
              <div class="tw-font-bold tw-text-base">Passenger or freight user benefit</div>
              <div class="tw-text-sm">{{ infoWindowContent.benefit }}</div>
            </div>

            <template v-if="infoWindowContent.info != ''">
              <div class="tw-font-bold tw-text-base">More information</div>

              <a
                :href="infoWindowContent.info"
                target="_blank"
                rel="noopener noreferrer"
                class="tw-block tw-underline tw-truncate tw-text-sm"
              >{{ info(infoWindowContent.info) }}</a>
            </template>
          </div>
        </n-info-window>
      </div>
    </div>
  </div>
</template>

<script>
import { positionFormat } from "../utils/careers.js";
import axios from 'axios';
import InlineSvg from "./npm/InlineSvg.vue";
import NInfoWindow from "./npm/NInfoWindow.vue";
import NImg from "./npm/NImg.vue";
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
  name: "anglia-map",

  components: {
    InlineSvg,
    NInfoWindow,
    NImg
  },

  data() {
    return {
      map: {
        center: positionFormat(52.2, 1),
        zoom: 8,
        currentMidx: null
      },
      infoWindowContent: {},
      infoWindowOpen: false,
      stations: [],
      line: 'All',
      year: 'All'
    }
  },

  methods: {
    info(str) {
      if (str) {
        let info = str.split("/");

        info = info[info.length - 2];

        info = info.split("-");

        for (let i = 0; i < info.length; i++) {
          info[i] = info[i].charAt(0).toUpperCase() + info[i].substring(1);
        }

        return info.join(" ");
      }

      return '';
    },

    iconMarker(type) {
      return {
        path: "M16,3.5c-4.142,0-7.5,3.358-7.5,7.5c0,4.143,7.5,18.121,7.5,18.121S23.5,15.143,23.5,11C23.5,6.858,20.143,3.5,16,3.5z M16,14.584c-1.979,0-3.584-1.604-3.584-3.584S14.021,7.416,16,7.416S19.584,9.021,19.584,11S17.979,14.584,16,14.584z",
        fillColor: this.styleColor(type),
        fillOpacity: 1,
        strokeWeight: 1,
        strokeColor: "white",
        scale: 1.2,
        anchor: {x: 15, y: 30}
      }
    },

    styleColor(type) {
      if (type == 'Renewals') {
        return '#005172';
      }

      if (type == 'Enhancement') {
        return '#E56430';
      }

      if (type == 'New Trains') {
        return '#F9A825';
      }

      return 'black';
    },

    toogleInfoWindow(station) {
      this.infoWindowContent = station
      this.infoWindowOpen = true;
    },

    mapColors(type) {
      if (type == 'Renewals') {
        return 'tw-bg-brand-blue';
      }

      if (type == 'Enhancement') {
        return 'tw-bg-brand-orange';
      }

      if (type == 'New Trains') {
        return 'tw-bg-brand-yellow';
      }

      return 'tw-bg-black';
    },

    mapIcons(icon) {
      if (icon === 'Track') {
        return 'bh_track';
      }

      if (icon === 'Structures') {
        return 'bh_structures';
      }

      if (icon === 'OLE') {
        return 'bh_ole';
      }

      if (icon === 'Signalling') {
        return 'bh_signals';
      }

      if (icon === 'Level crossing') {
        return 'bh_level_crossing';
      }

      if (icon === 'Station') {
        return 'bh_new_platform_extension';
      }

      return false;
    },

    filterStations(stations, line, year) {
      let filterStations = []

      // by line
      filterStations = stations.filter( item => {
        if (line == 'All') {
          return true;
        }

        return item.line == line;
      });

      // by year
      filterStations = filterStations.filter( item => {
        if (year == 'All') {
          return true;
        }

        return item.year == year;
      });

      return filterStations
    }
  },

  mounted() {
    axios.get('/wp-content/themes/network-rail/resources/anglia-map.json')

    .then((response) => {
      this.stations = Object.values(response.data)
    })
  }
}
</script>
