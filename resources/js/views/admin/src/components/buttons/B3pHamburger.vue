<template lang="pug">
.b3p-hamburger(:class="{ open: isOpen }" @click="click")
  .inner(:style="{ background: color }")
    .before(:style="{ background: color }")
    .after(:style="{ background: color }")
</template>

<script>
export default {
  props: {
    color: {
      type: String,
      default: '',
    },
  },
  data() {
    return {
      isOpen: false,
    }
  },
  methods: {
    click() {
      this.isOpen = !this.isOpen
      this.$emit('click', this.isOpen)
    },
  },
}
</script>

<style lang="stylus">
@keyframes menu-open-bar-top-anm-normal
  0%
    transform rotate( -45deg )
    top calc( 50% - 1.5px )
  10%
    top calc( 50% - 1.5px )
  50%
    top calc( 50% - 1.5px )
  100%
    top -7px

@keyframes menu-open-bar-bottom-anm-normal
  0%
    transform rotate( 45deg )
    bottom calc( 50% - 1.5px )
  10%
    bottom calc( 50% - 1.5px )
  50%
    bottom calc( 50% - 1.5px )
  100%
    bottom -7px

@keyframes menu-open-bar-top-anm
  0%
    top -7px
  50%
    top calc( 50% - 1.5px )
  90%
    top calc( 50% - 1.5px )
  100%
    transform rotate( -45deg )
    top calc( 50% - 1.5px )

@keyframes menu-open-bar-bottom-anm
  0%
    bottom -7px
  50%
    bottom calc( 50% - 1.5px )
  90%
    bottom calc( 50% - 1.5px )
  100%
    transform rotate( 45deg )
    bottom calc( 50% - 1.5px )
</style>

<style lang="stylus">
.b3p-hamburger
  width 25px
  height 17px
  cursor s-resize
  transition .4s
  &:hover
    transform scale(.8)
    transition .4s
  > .inner
    position relative
    top 7px
    left 0
    width 25px
    height 3px
    border-radius 10px
    background var(--color-icon, color-icon)
    display block
    transition .4s
    > .before, .after
      position absolute
      left 0
      background var(--color-icon, color-icon)
      border-radius 10px
      width 25px
      height 3px
      transition .4s
    > .before
      top -7px
      animation 'menu-open-bar-top-anm-normal' .4s ease-out both
    > .after
      bottom -7px
      animation 'menu-open-bar-bottom-anm-normal' .4s ease-out both
  &.open
    .inner
      background transparent!important
      transition .64s
      .before
        animation 'menu-open-bar-top-anm' .4s ease-out both
      .after
        animation 'menu-open-bar-bottom-anm' .4s ease-out both
</style>
