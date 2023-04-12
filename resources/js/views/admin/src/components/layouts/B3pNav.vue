<template lang="pug">
.b3p-nav(:class="{ open: isOpen, detail: isShowDetail }")
  .fixed
    .login
      B3pLoginDetail
    .nav
      .hambmenu
        B3pHamburger(:color="colorschemeMain" @click="clickHamburger")
</template>

<script>
import B3pLoginDetail from '../auths/B3pLoginDetail.vue'
import B3pHamburger from '../buttons/B3pHamburger.vue'
import B3pMenu from './B3pMenu.vue'
export default {
  components: { B3pLoginDetail, B3pHamburger, B3pMenu },
  props: {
    isOpen: {
      type: Boolean,
      default: false,
    },
    isShowDetail: {
      type: Boolean,
      default: true,
    },
    colorschemeMain: {
      type: String,
      default: '#dddddd',
    },
  },
  methods: {
    clickHamburger(bool) {
      this.$store.dispatch('base/changeNavOpen', bool)
    },
  },
}
</script>

<style lang="stylus">
.b3p-nav
  background var(--color-bgSub, color-bg-sub)
  width 58px
  transition .2s
  +bp(sm)
    width 100vw
    min-height calc(100vh - 50px)
    transform translateX(-100vw)
    position fixed
    left 0
    z-index 9999
  &.open
    width 230px
    .fixed
      width 230px
      +bp(sm)
        width 100vw
    +bp(sm)
      width 100vw
      transform translateX(0)
    &.detail
      width 462px
      .fixed
        width 462px
  &.detail
    width 292px
    .fixed
      width 292px
  .fixed
    position fixed
    z-index 2
    width 58px
    height calc(100vh - 51px)
    transition .2s
  .login
    display none
    +bp(sm)
      display block
  .nav
    height calc(100vh - 51px)
    box-shadow 0 0 20px color-shadow
    position relative
    border-right 1px solid var(--color-border, color-border)
    +bp(sm)
      height calc(100vh - 113px)
      padding 20px 2%
      box-sizing border-box
      box-shadow none
    .hambmenu
      position absolute
      z-index 3
      padding 15px 0 15px 16px
      +bp(sm)
        display none
</style>
