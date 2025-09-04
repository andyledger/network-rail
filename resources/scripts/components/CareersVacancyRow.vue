<template>
  <tbody class="tw-border-b-2 tw-border-gray-light tw-text-md md:tw-text-lg tw-text-gray-dark">
    <tr>
      <td class="tw-py-2 md:tw-py-3 lg:tw-py-5 tw-pr-2" @click="expand">
          <plus-minus
            :is-expanded="isExpanded"
            class="tw-cursor-pointer tw-mr-3"
            :label="'View job description for ' + vacancy.DISPLAYED_JOB_TITLE"
          />

          <a
          :href="vacancyLink"
          target="_blank"
          rel="noopener noreferrer"
          class="hover:tw-text-hyperlinks tw-underline tw-cursor-pointer"
        >{{ vacancy.DISPLAYED_JOB_TITLE }} - {{ vacancy.VACANCY_ID }}</a>
      </td>

      <td class="tw-py-2 md:tw-py-3 lg:tw-py-5 tw-pr-2 tw-truncate">
        {{ vacancy.TOWN_OR_CITY }}
      </td>

      <td class="tw-py-2 md:tw-py-3 lg:tw-py-5 tw-pr-2 tw-hidden xl:tw-table-cell">
        <span v-if="vacancy.MIN_SALARY != ''">
          {{ minSalary }} to {{ maxSalary }}
        </span>
      </td>

      <td class="tw-py-2 md:tw-py-3 lg:tw-py-5 tw-pr-2 tw-hidden md:tw-table-cell">
        {{ vacancy.FUNCTION }}
      </td>

      <td class="tw-py-2 md:tw-py-3 lg:tw-py-5 tw-pr-2 tw-hidden lg:tw-table-cell">
        <span v-if="vacancy.VAC_ADVERTISE_END_DATE"></span>

        {{ closingDate }}
      </td>
    </tr>

    <tr>
      <td colspan="6">
        <collapse-transition :duration="500">
          <div
            v-show="isExpanded"
            class="tw-py-2 md:tw-py-3 lg:tw-py-5"
            v-html="vacancy.DEPARTMENT_AND_HOW_IT_RELATES_TO_THE_ROLE"
          ></div>
        </collapse-transition>
      </td>
    </tr>
  </tbody>
</template>

<script>
import { CollapseTransition } from 'vue2-transitions';
import PlusMinus from './npm/PlusMinus.vue';

export default {
  name: "careers-vacancy-row",

  components: {
    CollapseTransition,
    PlusMinus
  },

  props: ["vacancy"],

  data() {
    return {
      isExpanded: false
    }
  },

  computed: {
    minSalary() {
      return this.formatCurrency(this.vacancy.MIN_SALARY);
    },

    maxSalary() {
      return this.formatCurrency(this.vacancy.MAX_SALARY);
    },

    closingDate() {
      let date = this.vacancy.VAC_ADVERTISE_END_DATE;

      if (!date) return "";

      date = date.split('-');

      return `${date[2]}/${date[1]}/${date[0]}`;
    },

    vacancyLink() {
      return `https://iebsprodnwrl.opc.oracleoutsourcing.com/OA_HTML/OA.jsp?OAFunc=IRC_VIS_VAC_DISPLAY&p_svid=${this.vacancy.VACANCY_ID}&p_spid=${this.vacancy.POSTING_CONTENT_ID}&refsh=0`;
    }
  },

  methods: {
    expand() {
      this.isExpanded = !this.isExpanded;
    },

    formatCurrency(value) {
      const formatter = new Intl.NumberFormat("en-UK", {
        style: "currency",
        currency: "GBP",
        minimumFractionDigits: 0
      });

      return formatter.format(value);
    },

    formatDate(value) {
      let date = new Date(value);

      let mounth = date.getMonth() + 1;

      return date.getDate() + "/" + mounth + "/" + date.getFullYear();
    }
  }
}
</script>
