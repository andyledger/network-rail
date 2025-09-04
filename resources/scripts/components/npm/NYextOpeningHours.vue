<template>
  <div>
    <div>Monday - Friday: {{ hours.monday.openIntervals[0].start }} - {{ hours.monday.openIntervals[0].end }}</div>
    <div>Saturday: {{ hours.saturday.openIntervals[0].start }} - {{ hours.saturday.openIntervals[0].end }}</div>
    <div>Sunday: {{ hours.sunday.openIntervals[0].start }} - {{ hours.sunday.openIntervals[0].end }}</div>
  </div>
</template>

<script>
export default {
  name: "n-yext-opening-hours",

  props: {
    hours: Object,
    default: {}
  }
}
</script>
