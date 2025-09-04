<template>
  <div class="tw-fixed tw-right-6 tw-bottom-6 tw-z-60">
    <button
      type="button"
      ref="bttBtn"
      :class="{'btn-visible' : isVisible, 'btn-hidden' : wasVisible && !isVisible, 'btn-initial': !wasVisible}"
      class="btn-back-to-top"
      @click.prevent="scrollUp"
    >
      Back to top
      <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M6.66665 6.66655C6.28887 6.66655 5.97199 6.53855 5.71598 6.28255C5.45998 6.02655 5.33243 5.7101 5.33332 5.33322C5.33332 4.95544 5.46132 4.63855 5.71732 4.38255C5.97332 4.12655 6.28976 3.99899 6.66665 3.99988H25.3333C25.7111 3.99988 26.028 4.12788 26.284 4.38388C26.54 4.63988 26.6676 4.95633 26.6667 5.33322C26.6667 5.71099 26.5387 6.02788 26.2827 6.28388C26.0267 6.53988 25.7102 6.66744 25.3333 6.66655H6.66665ZM16 27.9999C15.6222 27.9999 15.3053 27.8719 15.0493 27.6159C14.7933 27.3599 14.6658 27.0434 14.6667 26.6665V14.3999L12.1 16.9665C11.8555 17.211 11.5555 17.3332 11.2 17.3332C10.8444 17.3332 10.5333 17.1999 10.2667 16.9332C10.0222 16.6888 9.89999 16.3777 9.89999 15.9999C9.89999 15.6221 10.0222 15.311 10.2667 15.0665L15.0667 10.2665C15.2 10.1332 15.3444 10.039 15.5 9.98388C15.6555 9.92877 15.8222 9.90077 16 9.89988C16.1778 9.89988 16.3444 9.92788 16.5 9.98388C16.6556 10.0399 16.8 10.1341 16.9333 10.2665L21.7667 15.0999C22.0111 15.3443 22.1333 15.6443 22.1333 15.9999C22.1333 16.3554 22 16.6665 21.7333 16.9332C21.4889 17.1777 21.1778 17.2999 20.8 17.2999C20.4222 17.2999 20.1111 17.1777 19.8667 16.9332L17.3333 14.3999V26.6665C17.3333 27.0443 17.2053 27.3612 16.9493 27.6172C16.6933 27.8732 16.3769 28.0008 16 27.9999Z" fill="white"/>
      </svg>
    </button>
  </div>
</template>
<script>
import Focusable from '../utils/Focusable.js';

export default {
  mounted() {
    this.downThreshold = (document.body.scrollHeight - document.body.clientHeight) * 0.75;

    window.addEventListener('load', () => {
      window.addEventListener('scroll', this.handleScroll);
    }, { once: true });
  },

  beforeUnmounted() {
    window.removeEventListener('scroll', this.handleScroll);
  },

  data() {
    return {
      isVisible: false,
      wasVisible: false,
    }
  },

  methods: {
    scrollUp() {
      window.scrollTo(
        {
          top: 0,
          behavior: 'smooth'
        }
      );

      const focusable = new Focusable();

      focusable.firstFocusable.focus();
      document.activeElement.blur();
    },

    handleScroll() {
      let currentScroll = window.scrollY || document.scrollTop

      if (currentScroll < this.downThreshold || currentScroll === undefined) {
        this.isVisible = false
      } else if (currentScroll >= this.downThreshold) {
        this.isVisible = true
        this.wasVisible = true
      }
    }
  }
}
</script>
