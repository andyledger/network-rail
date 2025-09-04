<template>
  <address>
    {{ name }},<br>
    {{ address.line1 }}<span v-if="address.line2"> {{ address.line2 }}</span>, {{ address.city }}<br>
    {{ address.region}} {{ address.postalCode }}
  </address>
</template>

<script>
export default {
  name: "n-yext-address",

  props: {
    address: Object,
    name: String
  }
}
</script>
