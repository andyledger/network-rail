<template>
	<div>
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

	  <div class="tw-overflow-hidden tw-mb-8" v-if="isMapView">
	    <div class="tw-bg-gray-light tw-h-128 tw-relative tw-mb-1">
	      <gmap-map
	        v-bind="map"
	        class="tw-w-full tw-h-128 tw-mb-12"
	      >
	        <gmap-marker
	          v-for="(location, i) in locations"
	          :key="i"
	          :icon="marker"
	          :position="position(location.position)"
	          :clickable="true"
	          :draggable="false"
	          @click="toogleInfoWindow(location)"
	        />
	      </gmap-map>

	      <n-info-window
	        :is-open="infoWindowOpen"
	        @is-open="infoWindowOpen = !infoWindowOpen"
	        class="tw-shadow"
	      >
	        <div class="tw-p-2 tw-text-white tw-bg-secondary tw-min-w-200">
	          <div class="tw-text-sm">Location</div>
	          <div class="tw-text-xl tw-font-bold tw-truncate">{{ infoWindowContent.location }}</div>
	        </div>

	        <div class="tw-p-2">
	          <div class="tw-font-bold tw-text-base">Postcode</div>
	          <div class="tw-text-sm">{{ infoWindowContent.postCode }}</div>
	        </div>

	        <div class="tw-p-2">
				    <cta-button
				      filled
				      color="primary"
				      external
				      icon-name="ut_arrow_right2"
				      :link="infoWindowContent.link"
				    >Apply for the scheme</cta-button>
	        </div>
	      </n-info-window>
	    </div>
	  </div>

	  <div class="tw-overflow-x-auto tw-mb-12" v-if="!isMapView">
	  	<table class="tw-table-auto tw-w-full">
			  <thead class="tw-text-lg md:tw-text-xl tw-border-b-2">
			    <tr>
			      <th
			        class="tw-py-5 tw-text-left"
			        v-for="(item, i) in ['Location', 'Postcode', 'Link']"
			        :key="i"
			      >
			        {{ item }}
			      </th>
			    </tr>
			  </thead>

		  	<tbody>
		  		<tr
		  			class="tw-border-b-2 tw-border-gray-light tw-text-md md:tw-text-lg tw-text-gray-dark"
		  			v-for="(location, i) in locations"
		  		>
		  			<td class="tw-py-2 md:tw-py-3 lg:tw-py-5 tw-pr-2">
		  				{{ location.location }}
		  			</td>

		  			<td class="tw-py-2 md:tw-py-3 lg:tw-py-5 tw-pr-2">
		  				{{ location.postCode }}
		  			</td>

		  			<td class="tw-py-2 md:tw-py-3 lg:tw-py-5 tw-pr-2">
		  				<a :href="location.link" target="_blank" rel="noopener noreferrer">Apply for the scheme</a>
		  			</td>
		  		</tr>
		  	</tbody>
	  	</table>
	  </div>
	</div>

</template>

<script>
import axios from 'axios';
import { positionFormat } from "../utils/careers.js";
import CtaButton from "./npm/CtaButton.vue";
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
	name: "apprenticeship-scheme-location-map",

	components: {
		CtaButton,
		NInfoWindow
	},

	data() {
		return {
			locations: [],
      map: {
        center: positionFormat(54, -2),
        zoom: 5.3,
        currentMidx: null,
        mapTypeId: "roadmap",
        options: {
          streetViewControl: false,
          mapTypeControl: false
        }
      },
      infoWindowContent: {},
      infoWindowOpen: false,
      marker: {
        path: "M16,3.5c-4.142,0-7.5,3.358-7.5,7.5c0,4.143,7.5,18.121,7.5,18.121S23.5,15.143,23.5,11C23.5,6.858,20.143,3.5,16,3.5z M16,14.584c-1.979,0-3.584-1.604-3.584-3.584S14.021,7.416,16,7.416S19.584,9.021,19.584,11S17.979,14.584,16,14.584z",
        fillColor: '#005172',
        fillOpacity: 1,
        strokeWeight: 1,
        strokeColor: "white",
        scale: 1.2,
        anchor: {x: 15, y: 30}
      },
      isMapView: true
		}
	},

	methods: {
		toogleInfoWindow(location) {
      this.infoWindowContent = location
      this.infoWindowOpen = true;
    },

    position(position) {
    	return positionFormat(position.lat, position.lng)
    }
	},

	mounted() {
    axios.get('/wp-content/themes/network-rail/resources/apprenticeship-scheme-location-map.json')

    .then((response) => {
      this.locations = Object.values(response.data)
    })
	}
}
</script>
