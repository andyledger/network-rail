<template>
  <label
    class="tw-block"
  >
    <span
      class="tw-font-bold tw-mb-2 tw-block tw-text-lg"
    ><slot></slot></span>

    <autocomplete
      :items="postcodes"
      :height="height"
      :placeholder="placeholder"
      v-model="postcode"
      ref="postcode"
      isAsync
      :errorMessage="errorMessage"
      @input="autocompletePostcode(postcode)"
    ></autocomplete>
  </label>
</template>

<script>
import Autocomplete from "./Autocomplete.vue";
import axios from "axios";

export default {
  name: "n-postcode",

  components: {
    Autocomplete
  },

  model: {
    event: 'postcode'
  },

  props: {
    height: Number,

    placeholder: {
      type: String,
      default: "search postcode..."
    },

    /**
     * limit of postcodes
     */
    limit: {
      type: Number,
      default: 10
    },

    errorMessage: {
      type: String,
      default: 'Wrong postcode'
    }
  },

  data() {
    return {
      postcode: "",
      postcodes: null,
      isValidPostcode: false,
      latitude: null,
      longitude: null,
      formatedPostcode: null
    }
  },

  methods: {
    autocompletePostcode(postcode) {
      axios
        .get(`https://api.postcodes.io/postcodes/${postcode}/autocomplete?limit=${this.limit}`)
        .then(response => {
          this.postcodes = response.data.result;

          this.validatePostcode(postcode);
        })
        .catch(() => {
          this.validatePostcode(postcode);
        });
    },

    validatePostcode(postcode) {
      axios
        .get(`https://api.postcodes.io/postcodes/${postcode}`)
        .then(response => {
          this.isValidPostcode = true;
          this.latitude = response.data.result.latitude;
          this.longitude = response.data.result.longitude;
          this.formatedPostcode = response.data.result.postcode;
          this.$emit('postcode', {
            isValidPostcode: this.isValidPostcode,
            latitude: this.latitude,
            longitude: this.longitude,
            formatedPostcode: this.formatedPostcode
          })
        })
        .catch(() => {
          /**
           * Fired when `validatePostcode` method run.
           *
           * @event postcode
           * @property {object}
           */
          this.$emit('postcode', {
            isValidPostcode: false,
            latitude: null,
            longitude: null,
            formatedPostcode: null
          })
        });
    },
  }
}
</script>
