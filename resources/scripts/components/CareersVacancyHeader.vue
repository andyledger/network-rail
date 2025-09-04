<template>
  <thead class="tw-text-lg md:tw-text-xl tw-border-b-2">
    <tr>
      <th
        class="tw-py-5 tw-text-left"
        :class="classes(item)"
        v-for="(item, i) in [
          'Position',
          'Location',
          'Salary',
          'Business Function',
          'Closing',
        ]"
        :key="i"
      >
        <button
          type="button"
          class="tw-flex tw-justify-start tw-items-center"
          @click="$emit('sort-vacancies', item)"
        >
          <span class="tw-font-bold tw-mr-2">
            {{ item }}
          </span>

          <inline-svg
            :name="sortIcon(item)"
            class="tw-inline-block tw-cursor-pointer tw-pl-1 tw-pr-3 tw-text-lg"
            :class="[
              item === sortColumn
                ? 'tw-text-brand-orange'
                : 'tw-text-gray-dark',
            ]"
          ></inline-svg>
        </button>
      </th>
    </tr>
  </thead>
</template>

<script>
import InlineSvg from './npm/InlineSvg.vue';

export default {
  name: 'careers-vacancy-header',

  components: {
    InlineSvg,
  },

  props: {
    reverseSortColumn: Boolean,
    sortColumn: String,
  },

  methods: {
    sortIcon(item) {
      if (!this.reverseSortColumn && item === this.sortColumn) {
        return 'ut_sort_amount_up_bold';
      }

      if (this.reverseSortColumn && item === this.sortColumn) {
        return 'ut_sort_amount_down_bold';
      }

      return 'ut_sort_bold';
    },

    classes(item) {
      let classes = '';

      if (item === 'Business Function') {
        classes += 'tw-hidden md:tw-table-cell';
      }

      if (item === 'Closing') {
        classes += 'tw-hidden lg:tw-table-cell';
      }

      if (item === 'Salary') {
        classes += 'tw-hidden xl:tw-table-cell';
      }

      return classes;
    },
  },
};
</script>
