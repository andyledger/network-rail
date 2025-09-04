<template>
  <div ref="cookieDeclaration" class="tw-mb-8"></div>
</template>

<script>
export default {
	name: "cookie-declaration",

  mounted() {
    let cookiebot = document.createElement('script');

    cookiebot.setAttribute('src', 'https://consent.cookiebot.com/96365530-2409-485b-bcc8-81ac3cb7e12e/cd.js');

    let el = this.$refs.cookieDeclaration;

    el.appendChild(cookiebot);
  }
}
</script>