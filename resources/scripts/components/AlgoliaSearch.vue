<template>
  <ais-instant-search
    :search-client="searchClient"
    :index-name="indexName"
  >
    <ais-search-box
      autofocus
      submit-title="Submit the query"
      :class-names="{
        'ais-SearchBox-form': 'tw-relative tw-flex tw-items-center',
        'ais-SearchBox-reset': 'tw-hidden'
      }"
    >
      <template slot-scope="{ currentRefinement, refine }">
        <form
          action="/"
          role="search"
          novalidate="novalidate"
          class="ais-SearchBox-form tw-relative tw-flex tw-items-center"
        >
          <input
            class="tw-pr-8 tw-w-full tw-border-gray-medium tw-rounded"
            :value="currentRefinement"
            type="search"
            @input="refine($event.currentTarget.value)"
            placeholder="Search"
            name="s"
          />

          <inline-svg
            slot="submit-icon"
            name="nr_magnifying_glass"
            type="button"
            aria-label="Search"
            class="tw-text-2xl tw-right-0 tw-absolute tw-p-1.5"
          ></inline-svg>
        </form>
      </template>
    </ais-search-box>

    <ais-configure :hits-per-page.camel="10" />

    <ais-state-results
      :class-names="{
        'ais-StateResults': classStateResults
      }"
    >
      <template slot-scope="{ query, hits }">
        <ais-hits
          :escape-HTML="true"
          v-if="queryAndResults(query, hits)"
          :class-names="{
            'ais-Hits': 'tw-bg-white tw-border tw-rounded tw-border-gray-light tw-py-4 tw-shadow',
            'ais-Hits-list': '',
            'ais-Hits-item': 'tw-text-gray-medium tw-px-8 tw-py-2 hover:tw-bg-gray-lighter hover:tw-text-hyperlinks hover:tw-underline'
          }"
        >
          <template slot="item" slot-scope="{ item }">
            <a :href="item.url">
              <ais-highlight
                attribute="title"
                :hit="item"
                :class-names="{
                  'ais-Highlight-highlighted': 'tw-font-bold tw-bg-transparent tw-text-hyperlinks',
                }"
              />
            </a>
          </template>
        </ais-hits>

        <div v-if="!hits.length" class="tw-bg-white tw-border tw-rounded tw-border-gray-light tw-py-4 tw-shadow tw-text-xl tw-px-4">
          No results, press enter.
        </div>
      </template>
    </ais-state-results>
  </ais-instant-search>
</template>

<script>
import axios from 'axios';
import AlgoliaMixin from './AlgoliaMixin.js';
import InlineSvg from './npm/InlineSvg';
import Vue from 'vue';
import InstantSearch from 'vue-instantsearch'; // This is massive - todo find a way to reduce size
Vue.use(InstantSearch);

export default {
  name: 'algolia-search',

  props: {
    classStateResults: {
      type: String
    }
  },

  components: {
    InlineSvg
  },

  mixins: [ AlgoliaMixin ],

  methods: {
    queryAndResults(query, hits) {
      return (query.length > 0 && hits.length > 0)
    },
  }
};
</script>



