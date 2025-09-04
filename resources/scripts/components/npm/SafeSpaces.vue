<template>
  <div
    ref="safe-spaces"
  >
    <button
      type="button"
      class="tw-container tw-flex tw-justify-between tw-items-center tw-py-12 tw-cursor-pointer"
      @click="isSafeSpaceAvailable()"
    >
      <inline-svg name="lg_safe_spaces" type="div" class="tw-mr-8 tw-text-12xl md:tw-text-24xl" :ratio="0.5"></inline-svg>

      <div class="tw-text-lg md:tw-text-xl tw-text-white">
        <slot></slot>
      </div>
    </button>
  </div>
</template>

<script>
import axios from "axios";
import InlineSvg from "./InlineSvg.vue";

export default {
  name: "safe-spaces",

  props: ["text"],

  components: {InlineSvg},

  methods: {
    isSafeSpaceAvailable() {
      axios
        .get("https://safespaces.azurewebsites.net/Home/IsAlive")
        .then(() => {
          this.launchSafeSpace();
        })
    },

    launchSafeSpace() {
      let targetEl = this.$refs["safe-spaces"];
      axios
        .get("https://safespaces.azurewebsites.net/")
        .then(result => {
          this.hostWidgetInIframe(result.data, targetEl);
        })
    },

    hostWidgetInIframe(result, targetEl) {
      var iframe = document.createElement('iframe');
      iframe.setAttribute('id', 'safe-space-iframe');
      targetEl.appendChild(iframe);
      targetEl.style.overflow = "hidden";
      iframe.setAttribute(
        "style",
        "height:100%;width:100%;position:fixed;z-index:2000;top:0;bottom:0;background-color: rgba(0, 0,0, 0.26);")
      ;
      iframe.contentWindow.document.open();
      iframe.contentWindow.document.write(result);
      iframe.contentWindow.document.close();
      iframe.focus();
    }
  }
}
</script>
