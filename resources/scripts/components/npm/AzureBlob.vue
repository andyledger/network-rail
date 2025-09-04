<template>
  <div>
    <h3 v-if="title" class="tw-text-3xl tw-mb-4">{{ title }}</h3>

    <label for="search-files-folders-input">Search files and folders</label>

    <input
      id="search-files-folders-input"
      type="text"
      class="tw-w-full tw-py-3 tw-px-2 tw-mb-4 tw-rounded tw-border tw-border-gray-light"
      placeholder="Search files and folders"
      v-model="search"
      @keyup="searchFiles()"
      @focus="clearSearch()"
    >

    <azure-blob-breadcrumb
      @update-items="updateItems"
      :folderName="container"
      :breadcrumbs="breadcrumbs"
    />

    <div class="tw-flex tw-flex-col">
      <azure-blob-row
        @update-items="updateItems"
        v-for="(item, key) in items"
        :key="key"
        :item="item"
        :folderName="container"
        :breadcrumbs="breadcrumbs"
      />
    </div>
  </div>
</template>

<script>
import azureV2 from 'azure-storage';
import utils from '../../utils/blobs.js';
import AzureBlobBreadcrumb from './AzureBlobBreadcrumb.vue';
import AzureBlobRow from './AzureBlobRow.vue';

export default {
  name: 'azure-blob',

  components: {
    AzureBlobRow,
    AzureBlobBreadcrumb
  },

  props: {
    folder: {
      type: String,
      default: '',
      required: true
    },
    title: {
      type: String,
      default: ''
    }
  },

  data() {
    return {
      search: '',
      items: [],
      itemsCache: [],
      itemsAll: [],
      breadcrumbs: []
    }
  },

  computed: {
    container() {
      if (this.folder.includes('/')) {
        let prefix = this.folder.split('/')

        return prefix[0].trim()
      }

      return this.folder.trim()
    },

    prefix() {
      if (this.folder.includes('/')) {
        let prefix = this.folder.split('/').slice(1).join('/') + '/'

        return prefix.trim()
      }

      return null
    },

    breadcrumbStartingPoint() {
      if (this.prefix != null) {
        let str = this.prefix.split('/')

        return str[str.length - 2]
      }

      return this.container
    }
  },

  methods: {
    blobService() {
      return azureV2.createBlobServiceAnonymous(utils.storageAccount)
    },

    updateItems(event) {
      this.items = event
    },

    clearSearch() {
      this.search = ''

      this.items = this.itemsCache

      this.breadcrumbs = []

      this.breadcrumbs.push({
        text: this.breadcrumbStartingPoint,
        endpoint: true,
      })
    },

    searchFiles() {
      // https://levelup.gitconnected.com/use-regex-and-javascript-to-improve-search-results-870932050d08

      // searching only the name of the file, not including folders name.
      // aparently is limited to 5000 files.
      if (this.search.length > 2) {
        let itemsAll = this.itemsAll

        let str = this.search.toLowerCase().replace(/\s/g, '').substring(0, 8)

        this.items = itemsAll.filter(item => {
          return item.name.toLowerCase().replace(/\s/g, '').includes(str)
        })

        this.breadcrumbs = []

        this.breadcrumbs.push({
          text: this.breadcrumbStartingPoint,
          endpoint: false,
        })

        this.breadcrumbs.push({
          text: 'Search Results',
          endpoint: true,
        })
      }
    },
  },

  mounted() {
    this.breadcrumbs.push({
      text: this.breadcrumbStartingPoint,
      path: this.prefix,
      endpoint: true,
    })

    this.blobService().listBlobsSegmentedWithPrefix(
      this.container, this.prefix, null, { delimiter: "/" },
      (err, results, response) => {
        this.items = utils.getList(results, response, this.container)

        this.itemsCache = this.items;
      }
    )

    // this is for searching purpose
    this.blobService().listBlobsSegmented(
      this.container, null, {},
      (err, results, response) => {
        this.itemsAll = utils.getList(results, response, this.container)
      }
    )
  },
}
</script>
