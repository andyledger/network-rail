<template>
  <div>
    <slot
      name="yext"
      :response="response"
      :isLoaded="isLoaded"
    />
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "n-yext-schema",

  props: {
    locationId: String,
    apiKey: String,
    date: String
  },

  data() {
    return {
      response: {},
      isLoaded: false
    }
  },

  created() {
    axios
      .get(`https://liveapi.yext.com/v2/accounts/me/entities/${this.locationId}?api_key=${this.apiKey}&v=${this.date}`)
      .then((response) => {
        this.response = response.data.response;
        this.isLoaded = true;
      });
  },
}
</script>
