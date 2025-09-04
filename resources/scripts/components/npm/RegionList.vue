<template>
  <li class="tw-text-sm">
    <div
      class="tw-flex tw-mb-2"
      @mouseover="$emit('select-region', region.name)"
      @mouseleave="$emit('deselect-region')"
    >
      <div
        class="tw-w-6 tw-h-6 tw-rounded-full tw-border-2 tw-mr-2"
        :style="{ backgroundColor: region.colorHover, borderColor: region.colorHover }"
      />

      <div class="tw-font-bold" :style="{ color: region.colorHover }">
        <a
          :href="[region.link.url ? region.link.url : '#']"
          :target="[region.link.target ? region.link.target : '']"
        >{{ region.title }}</a>
      </div>
    </div>

    <ul>
      <li
        v-for="(route, key, i) in region.routes"
        :key="i"
        class="tw-flex tw-items-center tw-mb-1"
        @mouseover="$emit('select-route', route.name)"
        @mouseleave="$emit('deselect-route')"
      >
        <div
          class="tw-border-2 tw-w-6 tw-h-6 tw-rounded-full tw-mr-2 tw-flex tw-justify-center tw-items-center"
          :style="{ borderColor: region.colorHover }"
        >
          <div class="text-sm" :style="{ color: region.colorHover }">
            {{ countStart[index] + i }}
          </div>
        </div>

        <div
          class="tw-text-gray-500"
          :class="[
            route.name == selectedRoute ? 'tw-font-bold' : 'tw-font-thin'
          ]"
        >
          <a
            :href="[route.link.url ? route.link.url : '#']"
            :target="[route.link.target ? route.link.target : '']"
          >{{ route.title }}</a>
        </div>
      </li>
    </ul>
  </li>
</template>

<script>
export default {
  name: 'region-list',

  props: {
    "region": Object,
    "index": Number,
    "countStart": Array,
    "selectedRegion": String,
    "selectedRoute": String
  }
};
</script>
