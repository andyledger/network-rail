<template>
  <div 
    :style="style"
    ref="lavContainer"
    @mouseenter="manageMouseenter()"
    @mouseleave="manageMouseleave()"
    @click="manageClick()"
  ></div>
</template>

<script>
import lottie from 'lottie-web';

export default {
  name: "n-lottie",
  
  props: {
    options: {
      type: Object,
      required: true
    },
    height: Number,
    width: Number,
    playOnHover: {
      type: Boolean,
      default: false
    },
    playOnClick: {
      type: Boolean,
      default: false
    }
  },

  data () {
    return {
      style: {
        width: this.width ? `${this.width}px` : 'auto',
        height: this.height ? `${this.height}px` : 'auto',
        overflow: 'hidden',
        margin: '0 auto'
      },
      anim: null
    }
  },

  methods: {
    manageMouseenter() {
      if (this.playOnHover) {
        this.anim.setDirection(1);
        this.anim.setSpeed(0.7);
        this.anim.play();
      }
    },

    manageMouseleave() {
      this.anim.setDirection(-1);
      this.anim.setSpeed(0.7);
      this.anim.play();
    },

    manageClick() {
      if (this.playOnClick) {
        this.anim.setDirection(1);
        this.anim.setSpeed(0.7);
        this.anim.play();
      }
    }
  },

  mounted() {
    this.anim = lottie.loadAnimation({
      container: this.$refs.lavContainer,
      renderer: 'svg',
      loop: this.options.loop,
      autoplay: this.options.autoplay,
      animationData: this.options.animationData,
      rendererSettings: this.options.rendererSettings
    });
  }
}
</script>