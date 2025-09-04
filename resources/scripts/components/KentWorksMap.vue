<template>
  <div>
    <div class="md:tw-flex tw-justify-between tw-items-end tw-mb-8">
      <label class="tw-block tw-min-w-200 tw-mb-8 md:tw-mb-0">
        <span class="tw-font-bold tw-mb-2 tw-block tw-text-lg">Status</span>

        <select
          class="tw-form-select tw-rounded-md tw-block tw-w-full tw-mt-1 tw-py-3 tw-pl-4 tw-pr-10 tw-text-xl tw-text-gray-medium tw-border tw-border-gray-light"
          v-model="workStatus"
        >
          <option
            v-for="(option, i) in ['All', 'Complete', 'Proposed', 'Ongoing']"
            :key="i"
            :value="option"
          >{{ option }}</option>
        </select>
      </label>

      <div class="tw-flex tw-mb-4 tw-text-xl">
        <div
          class="tw-flex tw-ml-4"
          v-for="item in [
            {title: 'Proposed', class: 'tw-text-brand-blue'},
            {title: 'Ongoing', class: 'tw-text-brand-orange'},
            {title: 'Complete', class: 'tw-text-brand-green'}
        ]">
          <span>{{ item.title }}:</span>

          <inline-svg
            name="ut_marker"
            class="tw-text-4xl"
            :class="item.class"
          ></inline-svg>
        </div>
      </div>
    </div>

    <div class="tw-overflow-hidden tw-mb-8">
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
            v-for="(station, i) in filterWorks(stations, workStatus)"
            :key="i"
            :icon="iconMarker(station.status)"
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
          <div class="tw-p-2 tw-text-white" :class="mapColors(infoWindowContent.status)">
            <div class="tw-text-sm">Status</div>
            <div class="tw-text-xl tw-font-bold tw-truncate">{{ infoWindowContent.status }}</div>
          </div>

          <div class="tw-p-2">
            <div class="tw-mb-2">
              <div class="tw-font-bold tw-text-base">Project</div>
              <div class="tw-text-sm">{{ infoWindowContent.project }}</div>
            </div>

            <div class="tw-mb-2">
              <div class="tw-font-bold tw-text-base">Passenger benefit</div>
              <div class="tw-text-sm">{{ infoWindowContent.passengerBenefit }}</div>
            </div>

            <template v-if="infoWindowContent.moreInfo != ''">
              <h5 class="tw-font-bold tw-text-base">More information</h5>

              <a
                :href="infoWindowContent.moreInfo"
                target="_blank"
                rel="noopener noreferrer"
                class="tw-block tw-underline tw-truncate tw-text-sm"
              >{{ infoWindowContent.moreInfo }}</a>
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
  name: "kent-works-map",

  components: {
    InlineSvg,
    NInfoWindow
  },

  data() {
    return {
      map: {
        center: positionFormat(51.3, 0.6),
        zoom: 9,
        currentMidx: null
      },
      infoWindowContent: {},
      infoWindowOpen: false,
      stations: [],
      workStatus: 'All'
    }
  },

  methods: {
    iconMarker(status) {
      return {
        path: "M16,3.5c-4.142,0-7.5,3.358-7.5,7.5c0,4.143,7.5,18.121,7.5,18.121S23.5,15.143,23.5,11C23.5,6.858,20.143,3.5,16,3.5z M16,14.584c-1.979,0-3.584-1.604-3.584-3.584S14.021,7.416,16,7.416S19.584,9.021,19.584,11S17.979,14.584,16,14.584z",
        fillColor: this.styleColor(status),
        fillOpacity: 1,
        strokeWeight: 1,
        strokeColor: "white",
        scale: 1.2,
        anchor: {x: 15, y: 30}
      }
    },

    styleColor(status) {
      if (status == 'Ongoing') {
        return '#005172';
      }

      if (status == 'Proposed') {
        return '#E56430';
      }

      if (status == 'Complete') {
        return '#8DC055 ';
      }

      return 'black';
    },

    toogleInfoWindow(station) {
      this.infoWindowContent = station
      this.infoWindowOpen = true;
    },

    mapColors(status) {
      if (status == 'Ongoing') {
        return 'tw-bg-brand-blue';
      }

      if (status == 'Proposed') {
        return 'tw-bg-brand-orange';
      }

      if (status == 'Complete') {
        return 'tw-bg-brand-green';
      }

      return 'tw-bg-black';
    },

    filterWorks(works, status) {
      let filterWorks = []

      // by status
      filterWorks = works.filter( item => {
        if (status == 'All') {
          return true;
        }

        return item.status == status;
      });

      return filterWorks;
    }
  },

  mounted() {
    axios.get('/wp-content/themes/network-rail/resources/kent-works-map.json')

    .then((response) => {
      this.stations = Object.values(response.data)
    })
  }
}
</script>

