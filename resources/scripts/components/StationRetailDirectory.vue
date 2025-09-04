<template>
	<div class="station-retail-directory">
	  <div class="sm:tw-flex tw-mb-4">
		  <label class="tw-block tw-mb-4 sm:tw-mb-0 sm:tw-mr-4 tw-w-72">
		    <span class="tw-font-bold tw-mb-2 tw-block tw-text-lg">Select station:</span>

		    <select
		      class="tw-form-select tw-rounded-md tw-block tw-w-full tw-mt-1 tw-py-3 tw-pl-4 tw-pr-10 tw-text-xl tw-border tw-border-gray-light"
		      v-model="station"
		    >
		    	<option value="" disabled>Please select station</option>

		      <option
		        v-for="(option, i) in stations"
		        :key="i"
		        :value="option"
		      >{{ option }}</option>
		    </select>
		  </label>

		  <label class="tw-block tw-mb-4 sm:tw-mb-0 sm:tw-mr-4 tw-w-72">
		    <span class="tw-font-bold tw-mb-2 tw-block tw-text-lg">Select shop type:</span>

		    <select
		      class="tw-form-select tw-rounded-md tw-block tw-w-full tw-mt-1 tw-py-3 tw-pl-4 tw-pr-10 tw-text-xl tw-border tw-border-gray-light"
		      v-model="storeType"
		    >
		      <option
		        v-for="retailType in retailTypes"
		        :key="retailType.key"
		        :value="retailType.key"
		      >{{ retailType.label }}</option>
		    </select>
		  </label>
	  </div>

		<div class="tw-text-xl tw-mb-8" role="status">{{ numberOfRetailers }} results found</div>

	  <ul class="station-retail-directory__list tw-grid sm:tw-grid-cols-2 tw-gap-4 md:tw-grid-cols-3 tw-list-none">
		<li v-for="retailer in retailers" :key="retailer.name" class="station-retailer">
			<div
				class="tw-w-full tw-relative tw-block"
				@click="modal = retailer.name"
				:aria-label="'View ' + retailer.title + ' details'"
			>
				<n-img
					:lazy-src="retailer.attachment_src"
					alt=""
					aspect-ratio="2/1"
				></n-img>

				<button class="tw-flex tw-justify-center tw-items-center tw-absolute tw-inset-0 tw-bg-primary tw-text-white tw-text-3xl tw-font-bold tw-underline tw-flex tw-justify-center tw-items-center tw-w-full tw-h-full tw-inset-0 tw-absolute tw-opacity-0 hover:tw-opacity-100 focus:tw-opacity-100 tw-transition-opacity tw-duration-500 tw-p-2">
					<span class="tw-mr-4">{{ retailer.title }}</span>
					<inline-svg name="ut_arrow_right2"></inline-svg>
				</button>
			</div>

			<n-modal
			:show-modal="modal == retailer.name"
			@close-modal="modal = ''"
			>
			<div class="md:tw-flex tw-justify-between tw-items-center tw-mb-4">
				<div class="tw-mb-4 md:tw-mb-0 md:tw-w-1/3 md:tw-mr-4">
				<n-img
					:lazy-src="retailer.attachment_src"
					:alt="retailer.title + 'brand logo'"
					aspect-ratio="2/1"
				></n-img>
				</div>

				<div class="md:tw-w-2/3">
				<h3 class="retailer-title tw-font-bold tw-mb-4">
					{{ retailer.title }} at
					<a :href="retailer.link_to_station" class="tw-underline">{{ station }}</a>
				</h3>

				<p class="tw-text-xl" v-html="retailer.description"></p>
				</div>
			</div>
			<div class="tw-border-b tw-border-gray-light"></div>

			<div class="tw-overflow-x-auto">
				<table class="tw-table tw-table-fixed tw-w-full">
				<thead class="tw-text-2xl tw-font-bold">
					<tr>
					<th scope="col" class="tw-p-2 md:tw-p-4 tw-w-8"><span class="tw-sr-only">Result</span></th>
					<th scope="col" class="tw-p-2 md:tw-p-4 tw-w-56">Where is it?</th>
					<th scope="col" class="tw-p-2 md:tw-p-4 tw-w-56">Opening Times</th>
					<th scope="col" class="tw-p-2 md:tw-p-4 tw-w-48">Contact</th>
					</tr>
				</thead>

				<tbody>
					<tr class="odd:tw-bg-gray-lighter tw-mb-0-p tw-text-lg" v-for="(store, i) in retailer.stores">
					<td class="tw-p-2 md:tw-p-4 tw-align-top tw-text-lg md:tw-text-2xl tw-font-bold">
						{{ i + 1 }}
					</td>

					<td class="tw-p-2 md:tw-p-4 tw-align-top" v-html="store.where_is_it"></td>

					<td class="tw-p-2 md:tw-p-4 tw-align-top" v-html="store.opening_times"></td>

					<td class="tw-p-2 md:tw-p-4 tw-align-top" v-html="store.contact"></td>
					</tr>
				</tbody>
				</table>
			</div>
			</n-modal>
		</li>
	  </ul>
	</div>
</template>

<script>
import axios from 'axios';
import NCardTransition from './npm/NCardTransition';
import NModal from './npm/NModal';
import InlineSvg from './npm/InlineSvg';
import NImg from './npm/NImg';

export default {
	name: "station-retail-directory",

	components: {
		NModal,
		InlineSvg,
		NImg
	},

	data() {
		return {
			data: null,
			stations: [],
			station: '',
			storeType: 'all',
			modal: '',
			numberOfRetailers: 0,
      retailTypes: [
        {
          'key': 'all',
          'label': 'All'
        },
        {
          'key': 'food-drink',
          'label': 'Food & Drink'
        },
        {
          'key': 'retail',
          'label': 'Retail',
        },
        {
          'key': 'services',
          'label': 'Services',
        },
        {
          'key': 'supermarket',
          'label': 'Supermarket'
        }
      ]
		}
	},

	computed: {
		retailers() {
			if (this.data) {
				return this.filterByStoreType(this.data, this.station, this.storeType);
			}

			return [];
		}
	},

	methods: {
		filterByStoreType(data, station, type) {
			data = data[station];

			if (data == null) {
				return '';
			}

			data = data.retailers.filter(retailer => {
				if (type === 'all') {
					return true;
				}

				return retailer.types.includes(type);
			})

			this.numberOfRetailers = data.length;

			return data;
		},

		getStationNameFromId(stationId, data) {
			/**
			 * convert Object in array to be filtered
			 */
			const asArray = Object.entries(data);

			let result = asArray.filter(station => {
				return (station[1].id === parseInt(stationId))
			})

			if (result.length > 0) {
				return result[0][0];
			}

			return '';
		}
	},

  mounted() {
		const queryString = window.location.search;
		const urlParams = new URLSearchParams(queryString);
		const stationId = urlParams.get('station_id');

    axios.get('/wp-content/themes/network-rail/resources/retailers.json')
    .then((response) => {
    	let data = response.data;

    	this.stations = Object.keys(data);
    	this.data = data;

			if (stationId !== null) {
				this.station = this.getStationNameFromId(stationId, data);
			}
    })
  }
}
</script>
