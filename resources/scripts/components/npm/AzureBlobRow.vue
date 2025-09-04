<template>
  <button
    v-if="item.type == 'folder'"
    @click="openFolder(item.path)"
    class="tw-cursor-pointer tw-py-4 tw-border-t tw-font-bold tw-text-lg tw-border-gray-light tw-w-full tw-text-left tw-flex tw-items-center"
    tabindex="0"
  >
    <inline-svg name="ft_folder" class="tw-text-primary tw-text-3xl tw-pr-4"></inline-svg>

    <span class="hover:tw-text-hyperlinks hover:tw-underline">{{ item.name }}</span>
  </button>

  <a
    :href="item.path"
    class="tw-cursor-pointer tw-py-4 tw-border-t tw-font-bold tw-text-lg tw-border-gray-light tw-w-full tw-text-left tw-flex tw-items-center hover:tw-text-hyperlinks hover:tw-underline"
    target="_blank"
    rel="noopener noreferrer"
    v-else
  >
    <inline-svg :name="iconName(item.type)" class="tw-text-primary tw-text-3xl tw-mr-4"></inline-svg>

    <span class="tw-flex-grow">{{ item.name }}</span>

    <inline-svg name="ut_download" class="tw-text-primary tw-text-3xl tw-mr-4"></inline-svg>

    <span class="tw-font-normal tw-text-gray-dark" style="min-width: 60px">{{ item.size }}</span>
  </a>
</template>

<script>
import azureV2 from 'azure-storage';
import utils from '../../utils/blobs.js';
import InlineSvg from './InlineSvg.vue';

export default {
  name: 'azure-blob-row',

  components: {
    InlineSvg
  },

  props: {
    item: {
      type: Object,
      default: () => {
        return {
          fullName: '',
          name: '',
          path: '',
          type: ''
        }
      }
    },

    folderName: {
      type: String,
      default: '',
    },

    breadcrumbs: {
      type: Array,
      default: () => []
    }
  },

  data() {
    return {
      files: {
        folder: 'ft_folder',
        pdf: 'ft_pdf',
        txt: 'ft_text',
        xls: 'ft_excel',
        xlsx: 'ft_excel',
        ppt: 'ft_powerpoint',
        pptx: 'ft_powerpoint',
        zip: 'ft_zip',
        doc: 'ft_word',
        docx: 'ft_word',
        jpg: 'ft_image',
        jpeg: 'ft_image'
      },
    }
  },

  methods: {
    iconName(type) {
      let types = ['folder', 'pdf', 'txt', 'xls', 'xlsx', 'ppt', 'pptx', 'zip', 'doc', 'docx', 'jpg', 'jpeg']

      if (types.includes(type)) {
        return this.files[type]
      }

      return 'ft_file'
    },

    createBreadcrumb(prefix) {
      let breadcrumbs = this.breadcrumbs

      breadcrumbs.push({
        text: utils.getFolderName(prefix),
        path: prefix,
        endpoint: true,
      })

      // set previous element endpoint to false
      breadcrumbs[breadcrumbs.length - 2].endpoint = false
    },

    blobService() {
      return azureV2.createBlobServiceAnonymous(utils.storageAccount)
    },

    openFolder(prefix) {
      let promise = new Promise((resolve) => {
        this.blobService().listBlobsSegmentedWithPrefix(
          this.folderName, prefix, null, {delimiter: "/"},
          (err, results, response)=> {
            this.$emit('update-items', utils.getList(results, response, this.folderName))

            resolve()
          }
        )
      });

      promise.then(() => {
        this.createBreadcrumb(prefix)
      })
    },
  },
}
</script>

