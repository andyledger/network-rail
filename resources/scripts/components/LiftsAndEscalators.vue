<template>
  <div class="tw-mb-8">
    <div class="sm:tw-grid sm:tw-grid-cols-2 sm:tw-gap-8 tw-mb-12">
      <div class="tw-mb-10 sm:tw-mb-0">
        <label class="tw-block tw-mb-2 tw-font-bold">Search for a station</label>

        <autocomplete
          :items="stationNames"
          placeholder="Enter station name..."
          @input="startOfJourneyStation = $event"
          :height="200"
          error-message="We are adding new lifts and escalators to our database frequently..."
          class="autocomplete"
        />
      </div>
    </div>

    <cta-button
      filled
      color="primary"
      size="md"
      icon-name="ut_arrow_right2"
      @click="isMapView = !isMapView"
    >
      <span v-show="isMapView">Go to list view</span>

      <span v-show="!isMapView">Go to map view</span>
    </cta-button>

    <div
      class="tw-bg-gray-light tw-h-176 tw-relative tw-mb-1"
      v-show="isMapView"
    >
      <div
        class="tw-absolute tw-top-0 tw-right-0 tw-z-10 tw-bg-white tw-mt-2 tw-mr-2 tw-p-2 tw-rounded-sm tw-shadow-md"
      >
        <div
          v-for="(status, name) in stationStatusAttributes"
          class="tw-flex tw-items-center"
        >
          <inline-svg
            :name="'availability-' + name"
            class="tw-text-md md:tw-text-md tw-mr-2"
            :style="'color: ' + status.color + ';'"
          ></inline-svg>

          <span class="tw-text-md md:tw-text-md">{{ status.label }}</span>
        </div>
      </div>

      <gmap-map v-bind="map" class="tw-w-full tw-h-full">
        <gmap-marker
          v-for="(station, i) in filterResults(stations)"
          :key="i"
          :icon="iconMarker(station)"
          :position="getLatLng(station)"
          :clickable="true"
          :draggable="false"
          @click="toogleInfoWindow(station)"
        />
      </gmap-map>

      <n-info-window
        :is-open="infoWindowOpen"
        @is-open="infoWindowOpen = !infoWindowOpen"
        v-if="infoWindowOpen"
      >
        <div class="tw-relative tw-z-20 tw-p-4">
          <div class="tw-mb-4">
            <h3 class="tw-text-lg tw-font-black" style="margin-bottom: 0;">
              {{ infoWindowContent.name }}
            </h3>

            <div class="tw-mb-4 tw-block tw-font-normal">
              <span v-show="infoWindowContent.name"
                >{{ infoWindowContent.name }} -</span
              >

              <span>{{ infoWindowContent.postcode }}</span>
            </div>

            <div class="tw-mb-4">
              <a
                class="tw-block tw-text-hyperlinks tw-underline visited:tw-text-hyperlinks-visited"
                :href="
                  'https://www.nationalrail.co.uk/stations/' +
                    infoWindowContent.crs +
                    '/details.html'
                "
                target="_blank"
                rel="noopener noreferrer"
              >
                National Rail station information
              </a>
            </div>
          </div>

          <div
            v-for="(asset, index) in infoWindowContent.assets"
            :key="index"
            class="tw-flex tw-items-center tw-mb-2"
          >
            <span
              class="tw-h-4 tw-w-4 tw-mr-2 tw-rounded-full"
              :style="{background: asset.statusObject.color}"
            ></span>

            <span class="tw-sr-only">
              {{ asset.statusObject.label }}
            </span>

            <span class="tw-pr-2">
              {{ asset.displayName }}
            </span>

            <span v-show="getAssetStatusDetails(asset)"> ({{ getAssetStatusDetails(asset) }})</span>
          </div>
        </div>
      </n-info-window>
    </div>

    <div class="tw-mb-20" v-show="!isMapView">
      <h3 class="tw-text-2xl">Stations list</h3>

      <p class="tw-text-md tw-mb-4">
        Click the station name to find lift and escalator availability
      </p>

      <lifts-and-escalators-station-row
        v-for="(station, i) in filterResults(stations)"
        :key="i"
        :station="station"
      />
    </div>
  </div>
</template>

<script>
import { positionFormat } from '../utils/careers.js';
import gql from 'graphql-tag';
import apolloProvider from '../vue-apollo.js';
import 'regenerator-runtime/runtime.js';
import LiftsAndEscalatorsStationRow from './LiftsAndEscalatorsStationRow.vue';
import InlineSvg from './npm/InlineSvg.vue';
import CtaButton from './npm/CtaButton.vue';
import Autocomplete from './npm/Autocomplete.vue';
import NInfoWindow from './npm/NInfoWindow.vue';
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
  name: 'lifts-and-escalators',

  components: {
    LiftsAndEscalatorsStationRow,
    Autocomplete,
    CtaButton,
    InlineSvg,
    NInfoWindow,
  },

  data() {
    return {
      startOfJourneyStation: '',
      map: {
        center: positionFormat(54.0226,-4.2731),
        zoom: 6,
        currentMidx: null,
        mapTypeId: 'roadmap',
        options: {
          streetViewControl: false,
          mapTypeControl: false,
        },
      },
      infoWindowContent: {},
      infoWindowOpen: false,
      isMapView: true,
      stationData: [],
      stations: [],
      stationStatusAttributes: {
        all: {
          label: 'Available',
          color: 'green',
          path:
            'M0 256a256 256 0 1 1 512 0 256 256 0 0 1-512 0zm164 70a16 16 0 1 0-24 21 152 152 0 0 0 232 0 16 16 0 1 0-24-21 121 121 0 0 1-184 0zm12-150a32 32 0 1 0 0 64 32 32 0 0 0 0-64zm160 64a32 32 0 1 0 0-64 32 32 0 0 0 0 64z',
        },
        partial: {
          label: 'Partially available',
          color: '#ffb200',
          path:
            'M0 256a256 256 0 1 1 512 0 256 256 0 0 1-512 0zm160 80c-9 0-16 7-16 16s7 16 16 16h192c9 0 16-7 16-16s-7-16-16-16H160zm-16-112h64c9 0 16-7 16-16s-7-16-16-16h-64c-9 0-16 7-16 16s7 16 16 16zm160-32c-9 0-16 7-16 16s7 16 16 16h64c9 0 16-7 16-16s-7-16-16-16h-64z',
        },
        none: {
          label: 'Sorry, unavailable',
          color: 'red',
          path:
            'M0 256a256 256 0 1 1 512 0 256 256 0 0 1-512 0zm159 133a100 100 0 0 1 97-69c46 0 85 29 97 69a16 16 0 1 0 30-10 133 133 0 0 0-127-92c-60 0-111 39-127 92a16 16 0 1 0 30 10zm17-213a32 32 0 1 0 0 64 32 32 0 0 0 0-64zm160 64a32 32 0 1 0 0-64 32 32 0 0 0 0 64z',
        },
      },
      assetStatusAttributes: {
        Available: {
          label: 'Available',
          color: 'green',
        },
        Unknown: {
          label: 'Unknown',
          color: '#ffb200',
        },
        'Not Available': {
          label: 'Not Available',
          color: 'red',
        },
      },
    };
  },

  apolloProvider: apolloProvider,

  apollo: {
    stationData: {
      query: gql`
        query {
          stationData: stations(
            order_by: [{ name: asc }, {crs: asc}],
            distinct_on: [name, crs],
            where: {
              lat: { _is_null: false },
              long: { _is_null: false }
            }
          ) {
            crs
            name
            address
            lat
            long
            postcode
            assets(
                where: {
                    publicFacing: { _eq: true },
                }
            ) {
              blockId
              crs
              description
              displayName
              location
              publicFacing
              sensorId
              status {
                engineerOnSite
                independent
                isolated
                sensorId
                status
              }
              type
            }
          }
        }
      `,
      result({ data: { stationData } }) {
        this.stations = this.normaliseStationData(stationData);
      }
    },
  },

  computed: {
    stationNames() {
      let names = [];

      this.stations.forEach(station => {
        names.push(station.name);
      });

      names = names.filter(this.onlyUnique);

      return names;
    },
  },

  methods: {
    normaliseStationData(stationData) {
      const stations = stationData.map(station => {
        station.statusObject = this.getAvailability(station.assets);

        station.assets = station.assets.map(asset => {
          asset.statusObject = this.getAssetAvailabilityObject(asset);

          return asset;
        })

        return station;
      })
      .filter(station => {
        return station.assets.length > 0;
      });

      return stations;
    },

    toogleInfoWindow(station) {
      this.infoWindowContent = station;

      this.infoWindowOpen = true;
    },

    onlyUnique(value, index, self) {
      return self.indexOf(value) === index;
    },

    filterResults(stations) {
      let station = [];

      if (this.startOfJourneyStation === '') {
        return stations;
      }

      stations = stations.filter(station => {
        return station.name === this.startOfJourneyStation;
      });

      return stations;
    },

    getLatLng(station) {
      return positionFormat(station.lat, station.long);
    },

    iconMarker(station) {
      let marker = {
        fillOpacity: 1,
        strokeWeight: 1,
        strokeColor: 'white',
        scale: 0.04,
        anchor: { x: 0, y: 0 },
      };

      marker.path = station.statusObject.path;
      marker.fillColor = station.statusObject.color;

      return marker;
    },

    getAssetAvailability(asset) {
      let status = 'Unknown';

      if (asset?.status?.status) {
        status = asset.status.status;
      }

      return status;
    },

    getAssetAvailabilityObject(asset) {
      return  this.assetStatusAttributes[this.getAssetAvailability(asset)]
    },

    getAvailability(stationAssets) {
      // Get all availability statuses from the station assets
      const assetAvailabilities = stationAssets.map((asset) => this.getAssetAvailability(asset));

      if (!assetAvailabilities.length) {
        return this.stationStatusAttributes['all'];
      }

      if (assetAvailabilities.every((i) => i === 'Not Available')) {
        return this.stationStatusAttributes['none'];
      }

      if (assetAvailabilities.every((i) => i === 'Available')) {
        return this.stationStatusAttributes['all'];
      }

      return this.stationStatusAttributes['partial'];
    },

    getAssetStatusDetails(asset) {
      let str = '';

      if (asset.status) {
        let statuses = [];
        if (asset.status.engineerOnSite) {
          statuses.push('Engineer on site');
        }

        if (asset.status.independent) {
          statuses.push('Independent');
        }

        if (asset.status.isolated) {
          statuses.push('Isolated');
        }

        str = statuses.join(', ');
      }

      return str;
    },
  },
};
</script>
