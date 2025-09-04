<template>
  <ais-instant-search
    :search-client="searchClient"
    :index-name="indexName"
    :class-names="{'ais-InstantSearch': 'ais-InstantSearch-Page'}"
  >
    <div class="md:tw-flex">
      <aside class="tw-block md:tw-w-1/3 lg:tw-w-1/4 tw-pr-8">
        <ais-search-box
          v-model="query"
          :class-names="{
            'ais-SearchBox-form': 'tw-relative',
            'ais-SearchBox-input': 'tw-pr-8 tw-w-full tw-border-gray-medium tw-rounded',
            'ais-SearchBox-reset': 'tw-hidden',
            'ais-SearchBox-submit': 'tw-text-2xl tw-right-0 tw-absolute tw-top-px tw-p-2'
          }"
        >
          <inline-svg
            slot="submit-icon"
            name="nr_magnifying_glass"
          ></inline-svg>
        </ais-search-box>

        <p class="tw-my-8">You can use the filters to show only results that match your interests.</p>

        <fieldset>
          <legend class="tw-text-2xl tw-font-bold tw-mb-6 h2-search-page">Type:</legend>
          <ais-refinement-list
            attribute="post_type"
            :transform-items="transformPostTypes"
            class="tw-mb-8"
            :class-names="{
              'ais-RefinementList-checkbox' : 'tw-h-5 tw-w-5 tw-text-hyperlinks tw-relative tw-bottom-0.5 tw-rounded-sm tw-mr-1',
              'ais-RefinementList-item' : 'tw-mb-2 tw-ml-1',
              'ais-RefinementList-count' : 'tw-bg-gray-light tw-px-2 tw-rounded-2xl',
              'ais-RefinementList-list' : 'tw-list-none tw-pl-0'
            }"
          ></ais-refinement-list>
        </fieldset>

        <fieldset>
          <legend
            class="tw-text-2xl tw-font-bold tw-mb-6 h2-search-page"
            id="categories-title"
          >Categories:</legend>

          <ais-refinement-list
            attribute="categories"
            :transform-items="transformStoryCategories"
            class="tw-mb-8"
            :class="{'tw-hidden' : postType.includes('post')}"
            :class-names="{
              'ais-RefinementList-checkbox' : 'tw-h-5 tw-w-5 tw-text-hyperlinks tw-relative tw-bottom-0.5 tw-rounded-sm tw-mr-1',
              'ais-RefinementList-item' : 'tw-mb-2 tw-ml-1',
              'ais-RefinementList-count' : 'tw-bg-gray-light tw-px-2 tw-rounded-2xl',
              'ais-RefinementList-list' : 'tw-list-none tw-pl-0 tw-text-lg'
            }"
            :limit="50"
            :sort-by="['name:asc']"
        ></ais-refinement-list>
        </fieldset>

        <ais-clear-refinements
          class="tw-hidden md:tw-block"
          @click="clearFilters"
        >
          <button
            slot="resetLabel"
            class="tw-cursor-pointer tw-border tw-border-gray-light tw-p-3 tw-text-sm tw-text-gray-dark tw-rounded tw-inline-flex tw-items-center tw-justify-between"
          >Clear filters</button>
        </ais-clear-refinements>
      </aside>

      <div class="md:tw-w-2/3 lg:tw-w-3/4">

        <ais-state-results>
          <template slot-scope="{ query, hits }">

            <div class="tw-sr-only" role="status">Page {{ pageNumber }}</div>

            <ais-stats>
              <template v-slot="{ hitsPerPage, nbPages, nbHits, page, processingTimeMS, query }">
                <div class="tw-sr-only" role="status">{{ nbHits }} results found</div>
              </template>
            </ais-stats>

            <ais-hits
              :escape-HTML="false"
              :class-names="{
                'ais-Hits-item': 'tw-mb-4',
                'ais-Highlight': 'tw-block tw-text-xl',
                'ais-Hits-list': 'tw-list-none'
              }"
            >
              <template slot="item" slot-scope="{ item }">
                <h2 class="tw-text-2xl tw-mb-2 h2-search-page">
                  <a :href="item.url">
                    <ais-highlight
                      attribute="title"
                      :hit="item"
                      class="tw-underline hover:tw-text-hyperlinks visited:tw-text-hyperlinks-visited"
                      :class-names="{
                        'ais-Highlight-highlighted': 'tw-font-bold tw-bg-white tw-text-hyperlinks',
                      }"
                    />
                  </a>

                  <small class="tw-italic tw-text-lg">({{postTypeNiceNameSingular(item.post_type)}})</small>
                </h2>

                <div
                  v-if="isPost(item)"
                  class="tw-mb-2 tw-font-bold tw-text-base"
                >{{ date(item.post_date) }}</div>

                <ais-highlight
                  attribute="excerpt"
                  :hit="item"
                  :class-names="{
                    'ais-Highlight-highlighted': 'tw-font-bold tw-bg-white',
                  }"
                ></ais-highlight>

                <div class="tw-my-4 tw-border-t tw-border-gray-light"></div>
              </template>
            </ais-hits>

            <div v-if="!hits.length" class="tw--mt-8">
              <p class="tw-text-2xl" role="status">We're sorry but there are no results for your search <q>{{ query }}</q></p>

              <div v-html="pageContent"></div>
            </div>
          </template>
        </ais-state-results>

        <nav>
          <pagination
            :padding="2"
            :class-names="{
              'ais-Pagination-list': 'tw-flex tw-justify-center sm:tw-justify-end tw-list-none',
              'ais-Pagination-item': 'tw-px-3 tw-py-1 sm:tw-mx-1 first:tw-hidden last:tw-hidden sm:first:tw-inline sm:last:tw-inline',
              'ais-Pagination-item--selected': 'tw-rounded tw-bg-gray-pagination',
            }"
            @page-change="pageChange"
          ></pagination>
        </nav>
      </div>
    </div>
  </ais-instant-search>
</template>

<script>
import AlgoliaMixin from './AlgoliaMixin.js';
import axios from 'axios';
import InlineSvg from './npm/InlineSvg';
import Pagination from './Pagination';
import Vue from 'vue';
import InstantSearch from 'vue-instantsearch'; // This is massive - todo find a way to reduce size
Vue.use(InstantSearch);

export default {
  name: "algolia-search-page",

  data() {
    return {
      query: '',
      postType: [],
      pageContent: '',
      pageNumber: 1
    };
  },

  components: {
    InlineSvg,
    Pagination
  },

  mixins: [AlgoliaMixin],

  methods: {
    clearFilters() {
      this.postType = []
    },

    isPost(item) {
      return (item.post_type == 'post')
    },

    date(item) {
      const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

      let date = new Date(item.replace(/-/g, "/"));

      return months[date.getMonth()] + ' ' + date.getDate() + ', ' + date.getFullYear();
    },

    transformPostTypes(items) {
      return items.map(item => ({
        ...item,
        label: this.postTypeNiceName(item.label),
        count: item.count,
      }));
    },

    transformStoryCategories(items) {
      let cat = [
        'Environment',
        'Industry-leading',
        'Infrastructure insights',
        'Life at Network Rail',
        'Living by the railway',
        'Our stories',
        'Planned engineering works',
        'Project updates',
        'Putting passengers first',
        'Railway heritage',
        'Railway safety',
        'Week on the Network',
        'Working with Network Rail'
      ];

      let filteredCat = [];

      items.forEach((item) => {
        if (cat.includes(item.label)) {
          filteredCat.push(item);
        }
      })

      return filteredCat;
    },

    postTypeNiceName(item) {
      if (item == 'post') {
        return 'Stories';
      }

      if (item == 'page') {
        return 'Pages';
      }

      return item;
    },

    postTypeNiceNameSingular(item) {
      if (item == 'post') {
        return 'Story';
      }

      if (item == 'page') {
        return 'Page';
      }

      return item;
    },

    pageChange(page) {
      this.pageNumber = page + 1

      setTimeout(() => {
        document.querySelector('.ais-Hits li:first-of-type a').focus({
          focusVisible: true
        })
      }, 300)
    }
  },

  mounted() {
    let query = window.location.search;
    query = query.split('=');
    this.query = query[1];

    /**
     *
     * Create a search-page-no-results on root pages
     */
    axios.get('/wp-json/options/v1/search-page-no-results-id')
      .then((response) => {
        axios.get('/wp-json/wp/v2/pages/' + response.data)
          .then((response) => {
            this.pageContent = response.data.content.rendered
          })
      })

  },
}
</script>

