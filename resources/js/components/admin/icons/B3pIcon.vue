<template>
  <transition>
    <i class="fa" :class="_class"></i>
  </transition>
</template>

<script>
export default {
  props: {
    icon: {
      type: String,
      default: '',
    },
  },
  computed: {
    _class() {
      return (this.icon) ? ' fa-' + this.icon : ''
    }
  },
}
</script>
