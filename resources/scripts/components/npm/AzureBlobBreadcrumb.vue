<template>
  <div>
    <h3>Search Results</h3>
    <nav aria-label="breadcrumb" class="tw-mb-4">
      <ul class="tw-flex tw-flex-wrap">
        <li
          v-for="(breadcrumb, key) in breadcrumbs"
          :key="key"
          class="tw-pl-0"
        >
          <button
            @click="breadcrumbBack(breadcrumb.path)"
            v-if="!breadcrumb.endpoint"
            class="tw-flex tw-cursor-pointer tw-items-center tw-underline hover:tw-text-hyperlinks"
          >
            {{ breadcrumb.text }}

            <inline-svg name="ut_arrow_right2" aria-hidden="true" class="tw-px-4"></inline-svg>
          </button>

          <span v-else class="tw-text-gray-dark">
            {{ breadcrumb.text }}
          </span>
        </li>
      </ul>
    </nav>
  </div>
</template>

<script>
import azureV2 from 'azure-storage';
import utils from '../../utils/blobs.js';
import InlineSvg from './InlineSvg.vue';

export default {
  name: 'azure-blob-breadcrumb',

  components: {
    InlineSvg
  },

  props: ['folderName', 'breadcrumbs'],

  methods: {
    deleteBreadcrumb(prefix) {
      let breadcrumbs = this.breadcrumbs

      let index = breadcrumbs.map(e => {
        return e.path;
      }).indexOf(prefix);

      let length = breadcrumbs.length - index

      if (index > -1) {
        breadcrumbs.splice(index + 1, length)
        breadcrumbs[index].endpoint = true
      }
    },

    blobService() {
      return azureV2.createBlobServiceAnonymous(utils.storageAccount)
    },

    breadcrumbBack(prefix) {
      this.deleteBreadcrumb(prefix)

      this.blobService().listBlobsSegmentedWithPrefix(
        this.folderName,
        prefix,
        null,
        { delimiter: "/" },
        (err, results, response) => {
          this.$emit('update-items', utils.getList(results, response))
        }
      )
    },
  },
}
</script>
