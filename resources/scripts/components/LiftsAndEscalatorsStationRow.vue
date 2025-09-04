<template>
  <div>
    <div class="tw-flex tw-flex-wrap tw-items-center tw-cursor-pointer">
      <plus-minus
        :is-expanded="expand" class="tw-mr-4"
        @click.native="expand = !expand"
      />

      <span
        class="tw-h-4 tw-w-4 tw-mr-2 tw-rounded-full"
        :style="{background: station.statusObject.color}"
      ></span>

      <span>
        <span
          class="tw-font-bold tw-text-xl tw-mr-2"
        >{{ station.name }}</span>

        <span class="tw-text-sm">{{ station.postcode }}</span>
      </span>

    </div>

    <div class="tw-overflow-x-auto">
      <table
        class="tw-ml-4 tw-mb-4"
        v-show="expand"
      >
        <thead>
          <tr>
            <th class="tw-px-2 tw-py-1 tw-text-left">Location</th>
            <th class="tw-px-2 tw-py-1 tw-text-left">Status</th>
            <th class="tw-px-2 tw-py-1 tw-text-left">Type</th>
            <th class="tw-px-2 tw-py-1 tw-text-left"></th>
          </tr>
        </thead>

        <tbody>
          <tr v-for="(asset, j) in station.assets" :key="j">
            <td class="tw-px-2 tw-py-1 tw-min-w-200">{{ asset.displayName }}</td>

            <td v-if="asset.statusObject"
              class="tw-px-2 tw-py-1 tw-font-bold"
              :style="{color: asset.statusObject.color}"
            >{{ asset.statusObject.label }}</td>

            <td class="tw-px-2 tw-py-1">{{ asset.type }}</td>

            <td class="tw-px-2 tw-py-1">
              <span v-show="(asset.status && asset.status.engineerOnSite)">(Engineer on site)</span>
            </td>
          </tr>
        </tbody>

        <tfoot>
          <tr>
            <th class="tw-px-2 tw-py-1 tw-text-left">
              <a
                class="tw-block tw-text-hyperlinks tw-underline visited:tw-text-hyperlinks-visited"
                :href="'https://www.nationalrail.co.uk/stations/' + station.crs + '/details.html'"
                target="_blank"
                rel="noopener noreferrer"
              >
                National Rail station information
              </a>
            </th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</template>

<script>
import PlusMinus from "./npm/PlusMinus.vue";

export default {
  name: "lifts-and-escalators-station-row",

  components: {
    PlusMinus
  },

  data() {
    return {
      expand: false
    }
  },

  props: {
    station: {
      type: Object
    }
  }
}
</script>
