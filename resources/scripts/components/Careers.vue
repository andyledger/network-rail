<template>
  <div>
    <careers-filters-section
      @search-positions="setSearchFilters"
    />

    <div
      v-if="filteredVacancies.length === 0 && isSearch"
      class="tw-mb-8"
    >
      <h2 class="tw-text-3xl tw-mb-6" role="status">
        No matching results
      </h2>

      <p class="tw-text-lg">
        We haven't found any jobs that match you search criteria, please amend
        and click the search button
      </p>
    </div>

    <p
      v-if="filteredVacancies.length > 0"
      class="tw-text-3xl tw-mb-8"
      role="status"
    >
      Your job search returned {{ filteredVacancies.length }} results.
    </p>

    <cta-button
      filled
      color="primary"
      size="md"
      iconName="ut_arrow_right2"
      v-if="filteredVacancies.length > 0"
      @click="isMapView = !isMapView"
    >
      <span v-show="isMapView">Go to list view</span>

      <span v-show="!isMapView">Go to map view</span>
    </cta-button>

    <div class="tw-overflow-hidden tw-mb-8" v-if="isMapView">
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
            v-for="(vacancy, i) in filteredVacancies"
            :key="i"
            :position="positionMarker(vacancy.LATITUDE, vacancy.LONGITUDE)"
            :icon="iconMarker()"
            :clickable="true"
            :draggable="false"
            @click="toogleInfoWindow(vacancy, i)"
          />
        </gmap-map>

        <n-info-window
          :is-open="infoWindowOpen"
          @is-open="infoWindowOpen = !infoWindowOpen"
          class="tw-shadow"
        >
          <div class="tw-p-4 tw-text-white tw-bg-brand-blue">
            <div class="tw-text-base">{{ infoWindowContent.location }}</div>
            <div class="tw-text-xl tw-font-bold">{{ infoWindowContent.name }}</div>
          </div>

          <div class="tw-p-4 tw-text-lg">
            <div class="tw-mb-4">
              <div class="tw-font-bold">Function</div>
              <div>{{ infoWindowContent['function'] }}</div>
            </div>

            <div class="tw-mb-4" v-if="infoWindowContent.salary">
              <div class="tw-font-bold">Salary</div>
              <div>{{ pounds(infoWindowContent.salary.min) }} - {{ pounds(infoWindowContent.salary.min) }}</div>
            </div>

            <div class="tw-mb-4">
              <div class="tw-font-bold">Closing date</div>
              <div>{{ infoWindowContent.closingDate }}</div>
            </div>

            <div>
              <cta-button
                :link="applyNow(infoWindowContent)"
                external
                filled
                color="primary"
                size="sm"
              >Apply now</cta-button>
            </div>
          </div>
        </n-info-window>
      </div>
    </div>

    <div v-if="!isMapView">
      <div
        class="tw-overflow-x-auto tw-mb-12"
        v-if="filteredVacancies.length > 0"
      >
        <table class="tw-table-auto tw-w-full vacancies-list">
          <careers-vacancy-header
            :reverseSortColumn="reverseSortColumn"
            :sortColumn="sortColumn"
            @sort-vacancies="sortBy($event)"
          ></careers-vacancy-header>

          <careers-vacancy-row
            v-for="(vacancy, i) in paginateVacancies"
            :key="i"
            :vacancy="vacancy"
          />
        </table>
      </div>

      <div
        class="tw-flex tw-flex-col lg:tw-flex-row lg:tw-justify-between lg:tw-items-center tw-text-xl tw-mb-8"
        v-if="filteredVacancies.length > pageSize"
      >
        <div
          class="tw-mb-4 md:tw-mb-0"
        >Results 1 - {{ pageSize }} out of {{ filteredVacancies.length }}</div>

        <div class="tw-sr-only" role="status">Page {{ pageNumber }}</div>

        <nav role="navigation" aria-label="Pagination">
        <v-pagination
          class="tw-flex v-pagination"
          v-model="pageNumber"
          :classes="paginationConfig.paginationClasses"
          :page-count="pageCount"
          :labels="paginationConfig.paginationAnchorTexts"
          @change="currentPage()"
          @hook:mounted="currentPage()"
        ></v-pagination>
        </nav>
      </div>
    </div>
  </div>
</template>

<script>
import { paginationConfig } from '../utils/paginationConfig.js';
import { filterCareers, paginateArray, mapColumns, positionFormat } from "../utils/careers.js";
import GmapCluster from 'gmap-vue/dist/components/cluster';
import axios from 'axios';
import CtaButton from './npm/CtaButton.vue';
import CareersFiltersSection from './CareersFiltersSection.vue';
import CareersVacancyHeader from './CareersVacancyHeader.vue';
import CareersVacancyRow from './CareersVacancyRow.vue';
import VPagination from 'vue-plain-pagination';
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
  name: "careers",

  components: {
    GmapCluster,
    CtaButton,
    CareersFiltersSection,
    CareersVacancyHeader,
    CareersVacancyRow,
    VPagination,
    NInfoWindow
  },

  data() {
    return {
      careers: [],
      pageNumber: 1,
      pageSize: 10,
      paginationConfig: paginationConfig,
      filterCareers: filterCareers,
      mapColumns: mapColumns,
      paginateArray: paginateArray,
      employment: null,
      jobType: null,
      keywords: null,
      isSalaryActive: false,
      salary: null,
      isValidPostcode: false,
      latitude: 53,
      longitude: -1,
      radius: null,
      sortColumn: null,
      reverseSortColumn: true,
      isSearch: false,
      isMapView: false,
      map: {
        center: positionFormat(52, -1),
        zoom: 7,
      },
      infoWindowContent: {},
      infoWindowOpen: false
    }
  },

  computed: {
    filteredVacancies() {
      return this.filterCareers(
        this.careers,
        this.employment,
        this.jobType,
        this.keywords,
        this.isSalaryActive,
        this.salary,
        this.isValidPostcode,
        this.latitude,
        this.longitude,
        this.radius
      );
    },

    sortVacancies() {
      let field = this.mapColumns(this.sortColumn);

      this.filteredVacancies.sort((a, b) => {
        if (a[field] < b[field]) {
          return -1;
        }

        if (a[field] > b[field]) {
          return 1;
        }

        return 0;
      });

      if( this.reverseSortColumn ) {
        return this.filteredVacancies;
      }

      if( !this.reverseSortColumn ) {
        return this.filteredVacancies.reverse();
      }
    },

    paginateVacancies() {
      return this.paginateArray(this.pageNumber, this.sortVacancies, this.pageSize);
    },

    pageCount() {
      return Math.ceil(this.filteredVacancies.length / this.pageSize);
    }
  },

  methods: {
    positionMarker(lat, lng) {
      return positionFormat(lat, lng);
    },

    iconMarker() {
      return {
        path: "M16,3.5c-4.142,0-7.5,3.358-7.5,7.5c0,4.143,7.5,18.121,7.5,18.121S23.5,15.143,23.5,11C23.5,6.858,20.143,3.5,16,3.5z M16,14.584c-1.979,0-3.584-1.604-3.584-3.584S14.021,7.416,16,7.416S19.584,9.021,19.584,11S17.979,14.584,16,14.584z",
        fillColor: '#005272',
        fillOpacity: 1,
        strokeWeight: 1,
        strokeColor: "white",
        scale: 1.2,
        anchor: {x: 15, y: 30}
      }
    },

    sortBy(column) {
      if ( this.sortColumn === column ) {
        this.reverseSortColumn = !this.reverseSortColumn;
      }

      this.sortColumn = column;
    },

    setSearchFilters(data) {
      this.isSearch = true;
      this.employment = data.employment;
      this.jobType = data.jobType;
      this.keywords = data.keywords;
      this.isSalaryActive = data.isSalaryActive,
      this.salary = data.salary,
      this.isValidPostcode = data.isValidPostcode,
      this.latitude = data.latitude,
      this.longitude = data.longitude,
      this.radius = data.radius,
      this.pageNumber = 1
    },

    pounds(number) {
      const formatter = new Intl.NumberFormat('en-GB', {
        style: 'currency',
        currency: 'GBP'
      });

      return formatter.format(number);
    },

    applyNow(infoContent) {
      return `https://iebsprodnwrl.opc.oracleoutsourcing.com/OA_HTML/OA.jsp?OAFunc=IRC_VIS_VAC_DISPLAY&p_svid=${infoContent.vacancyId}&p_spid=${infoContent.postingContentId}&refsh=0`;
    },

    toogleInfoWindow(job, index) {
      this.infoWindowContent = {
        name: job.DISPLAYED_JOB_TITLE,
        location: job.TOWN_OR_CITY,
        function: job.FUNCTION,
        closingDate: job.VAC_ADVERTISE_END_DATE,
        vacancyId: job.VACANCY_ID,
        postingContentId: job.POSTING_CONTENT_ID,
      };

      if (job.MIN_SALARY != "") {
        this.infoWindowContent.salary = {
          min: job.MIN_SALARY,
          max: job.MAX_SALARY,
        }
      } else {
        this.infoWindowContent.salary = false;
      }

      // check if it's the same marker that was selected
      if (this.currentMidx == index) {
        this.infoWindowOpen = !this.infoWindowOpen;
      } else {
        // if different marker set infowindow to open and reset current marker index
        this.infoWindowOpen = true;
        this.currentMidx = index;
      }
    },

    currentPage() {
      this.$nextTick(() => {
        if (document.querySelector('.v-pagination [aria-current="page"]')) {
          document.querySelector('.v-pagination [aria-current]').removeAttribute('aria-current')
        }
        if (document.querySelector('.pagination-link--active')) {
          document.querySelector('.pagination-link--active').setAttribute('aria-current', 'page')
        }

        setTimeout(() => {
          document.querySelector('.vacancies-list tr:first-of-type button').focus({
            focusVisible: true
          })
        }, 300)
      })
    }
  },

  mounted() {
    axios.get('/wp-content/themes/network-rail/resources/careers.json')
    .then((response) => {
      this.careers = response.data.career;
    })
  }
}
</script>
