<template>
  <a :href="'tel:'+phone">{{ formatedPhone }}</a>
</template>

<script>
export default {
  name: "n-phone",

  props: {
    phone: String
  },

  computed: {
    formatedPhone() {
      let phone = this.phone.toString();

      phone = phone.substring(0, 3) + "(GB) 0" + phone.substring(3, 6) + " " + phone.substring(6, 9) + " " + phone.substring(9, phone.length);

      return phone;
    }
  }
}
</script>
