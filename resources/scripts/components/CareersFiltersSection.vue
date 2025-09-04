<template>
  <div class="tw-bg-gray-lighter tw-p-4 sm:tw-p-8 tw-mb-12">
    <div class="tw-grid tw-grid-cols-1 lg:tw-grid-cols-2 tw-gap-8 tw-mb-12">
      <div class="tw-grid tw-grid-cols-1 lg:tw-grid-cols-2 tw-gap-4">
        <label class="tw-block">
          <span class="tw-font-bold tw-mb-2 tw-block tw-text-lg">Employment</span>

          <select
            class="tw-form-select tw-rounded-md tw-block tw-w-full tw-mt-1 tw-py-3 tw-pl-4 tw-pr-10 tw-text-xl tw-text-gray-dark tw-border tw-border-gray-dark"
            v-model="employment"
          >
            <option
              v-for="(option, i) in employmentOptions"
              :key="i"
              :value="option"
            >{{ option }}</option>
          </select>
        </label>

        <label class="tw-block">
          <span class="tw-font-bold tw-mb-2 tw-block tw-text-lg">Job type</span>

          <select
            class="tw-form-select tw-rounded-md tw-block tw-w-full tw-mt-1 tw-py-3 tw-pl-4 tw-pr-10 tw-text-xl tw-text-gray-dark tw-border tw-border-gray-dark"
            v-model="jobType"
          >
            <option
              v-for="(option, i) in jobTypeOptions"
              :key="i"
              :value="option"
            >{{ option }}</option>
          </select>
        </label>

        <n-text
          placeholder="keyword"
          v-model="keywords"
        >Keyword</n-text>

        <n-postcode
          :height="300"
          :limit="30"
          v-model="postcodeObject"
          class="n-postcode"
        >Postcode</n-postcode>
      </div>

      <div class="tw-grid tw-grid-cols-1 tw-gap-4">

        <div class="tw-mb-8 lg:tw-mb-0">
          <div class="tw-flex tw-justify-between tw-items-center tw-mb-2">
            <label class="tw-font-bold tw-block tw-text-lg">Salary <span class="tw-font-normal">(£k per annum)</span></label>

            <n-switch
              v-model="isSalaryActive"
              :label="isSalaryActive ? 'Deactivate salary filter' : 'Activate salary filter'"
            >
              <div class="tw-text-gray-darker tw-hidden sm:tw-block tw-text-sm">Activate salary filter</div>
            </n-switch>
          </div>

          <div class="tw-mt-2 tw-grid tw-grid-cols-1 sm:tw-grid-cols-2 tw-gap-4">

            <div
              class="tw-flex tw-flex-col sm:tw-flex-row tw-gap-2 tw-items-start sm:tw-items-center"
              :class="[!isSalaryActive ? 'tw-opacity-50' : '']"
            >
              <label class="tw-font-bold tw-w-max">Minimum</label>
              <select
                class="tw-form-select tw-rounded-md tw-block tw-w-full tw-py-3 tw-pl-4 tw-pr-10 tw-text-xl tw-text-gray-dark tw-border tw-border-gray-dark"
                v-model="salary[0]"
                :disabled="!isSalaryActive"
              >
                <option
                  v-for="value in salaryOptions"
                  :key="value"
                  :value="value"
                  :disabled="value > salary[1]"
                >£{{ value }}k pa</option>
              </select>
            </div>

            <div
              class="tw-flex tw-flex-col sm:tw-flex-row tw-gap-2 tw-items-start sm:tw-items-center"
              :class="[!isSalaryActive ? 'tw-opacity-50' : '']"
            >
              <label class="tw-font-bold tw-w-max">Maximum</label>
              <select
                class="tw-form-select tw-rounded-md tw-block tw-w-full tw-py-3 tw-pl-4 tw-pr-10 tw-text-xl tw-text-gray-dark tw-border tw-border-gray-dark"
                v-model="salary[1]"
                :disabled="!isSalaryActive"
              >
                <option
                  v-for="value in salaryOptions"
                  :key="value"
                  :value="value"
                  :disabled="value < salary[0]"
                >£{{ value }}k pa</option>
              </select>
            </div>
          </div>
        </div>

        <div
          :class="[!postcodeObject.isValidPostcode ? 'tw-opacity-50' : '']"
        >
          <label class="tw-font-bold tw-mb-2 tw-block tw-text-lg">Radius <span class="tw-font-normal">(miles)</span></label>
          <select
            class="tw-form-select tw-rounded-md tw-block tw-w-full tw-py-3 tw-pl-4 tw-pr-10 tw-text-xl tw-text-gray-dark tw-border tw-border-gray-dark"
            :disabled="!postcodeObject.isValidPostcode"
            v-model="radius"
          >
            <option
              v-for="value in radiusOptions"
              :key="value"
              :value="value"
            >{{ value }} miles</option>
          </select>
        </div>

      </div>
    </div>
    <div>
      <cta-button
        filled
        color="primary"
        size="md"
        iconName="ut_arrow_right2"
        @click="searchPositions"
      >Search positions</cta-button>

      <p class="tw-text-xl">Need to check an existing application? <a class="tw-underline" href="https://iebsprodnwrl.opc.oracleoutsourcing.com/OA_HTML/IrcVisitor.jsp" target="_blank" rel="noopener noreferrer">Login to our job site</a></p>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import CtaButton from '../components/npm/CtaButton.vue';
import NSwitch from '../components/npm/NSwitch.vue';
import NPostcode from '../components/npm/NPostcode.vue';
import NText from '../components/npm/NText.vue';
import VueSlider from "vue-slider-component";
import {
  salarySliderConfig,
  radiusSliderConfig,
  reduceElements
} from "../utils/careers.js";
import Vue from "vue";

export default {
  name: "carrers-filter-section",

  components: {
    CtaButton,
    NSwitch,
    NPostcode,
    NText,
    VueSlider
  },

  data() {
    return {
      employment: 'All',
      jobType: 'All',
      isSalaryActive: false,
      salarySliderConfig: salarySliderConfig,
      radiusSliderConfig: radiusSliderConfig,
      salary: [20, 40],
      radius: 50,
      postcodeObject: {
        isValidPostcode: false
      },
      keywords: "",
      reduceElements: reduceElements,
      careers: [],
    }
  },

  computed: {
    jobTypeOptions() {
      let elements = [];

      elements = this.reduceElements(this.careers, 'FUNCTION');

      return elements.sort();
    },

    employmentOptions() {
      let elements = [];

      elements = this.reduceElements(this.careers, 'EMPLOYEEMENT_STATUS');

      return elements.sort();
    },

    salaryOptions() {
      const min = this.salarySliderConfig?.min ?? 0;
      const max = this.salarySliderConfig?.max ?? 150;
      const step = this.salarySliderConfig?.step ?? 10;
      const options = [];
      for (let i = min; i <= max; i += step) {
        options.push(i);
      }
      return options;
    },

    radiusOptions() {
      const min = this.radiusSliderConfig?.min ?? 5;
      const max = this.radiusSliderConfig?.max ?? 100;
      const step = this.radiusSliderConfig?.step ?? 5;
      const options = [];
      for (let i = min; i <= max; i += step) {
        options.push(i);
      }
      return options;
    }
  },

  watch: {
    'salary.0'(newMin) {
      if (newMin > this.salary[1]) {
        this.salary.splice(1, 1, newMin);
      }
    },
    'salary.1'(newMax) {
      if (newMax < this.salary[0]) {
        this.salary.splice(0, 1, newMax);
      }
    }
  },

  methods: {
    /**
     * Array sort comparation function
     * Use in case you need to sort an array of objects based on one of its properties.
     * Ex: Array.sort(this.compare);
     * https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/sort
     **/
    compare(a, b) {
      if (a.property < b.property) {
        return -1;
      }

      if (a.property > b.property) {
        return 1;
      }

      return 0;
    },

    searchPositions(e) {
      this.$emit('search-positions', {
        employment: this.employment,
        isSalaryActive: this.isSalaryActive,
        salary: this.salary,
        jobType: this.jobType,
        isValidPostcode: this.postcodeObject.isValidPostcode,
        latitude: this.postcodeObject.latitude,
        longitude: this.postcodeObject.longitude,
        radius: this.radius,
        keywords: this.keywords
      });
    },

    handleChange(key, val) {

      if (val > 90) {
        val = 90;
      }

      if (key === 0 && val >= 90) {
        val = 89;
      }

      if (key === 0 && val >= this.salary[1]) {

        let maxVal = Number(val) + 10;

        if (maxVal >= 90) {
          maxVal = 90
        }

        Vue.set(this.salary, 1, maxVal);
      }

      if (key === 1 && val <= this.salary[1]) {

        let minVal = Number(val) - 10;

        if (minVal <= 0) {
          minVal = 0
        }

        Vue.set(this.salary, 0, minVal);
      }

      Vue.set(this.salary, key, Number(val));
    }
  },

  mounted() {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const employment = urlParams.get('employment');
    const jobType = urlParams.get('job-type');

    // See: /resources/scripts/components/ApprenticeshipSchemeLocationMap.vue
    axios.get('/wp-content/themes/network-rail/resources/careers.json')
      .then((response) => {
        this.careers = Object.values(response.data.career)
      });

    if (employment != null && this.employmentOptions.includes(employment)) {
      this.employment = employment;
    }

    if (jobType != null && this.jobTypeOptions.includes(jobType)) {
      this.jobType = jobType;
    }
  }
}
</script>
