<template lang="pug">
.b3p-header(
  :style="{ background: bgSubHeader }"
)
  .hambmenu
    B3pHamburger(:color="colorHambmenu" @click="clickHamburger")
  .logo
    nuxt-link(to="/")
      img.pc-logo(src="/images/sample/b3p-logo.svg")
      img.sp-logo(src="/images/common/logo.png")
  B3pLoginDetail
</template>

<script>
import B3pHamburger from '../buttons/B3pHamburger.vue'
import B3pLoginDetail from '../auths/B3pLoginDetail.vue'
export default {
  components: { B3pHamburger, B3pLoginDetail },
  props: {
    bgSubHeader: {
      type: String,
      default: '',
    },
    colorHambmenu: {
      type: String,
      default: '',
    },
  },
  computed: {
    base() {
      return this.$store.state.base
    },
  },
  methods: {
    clickHamburger(bool) {
      // this.$store.dispatch('base/changeNavOpen', bool)
    },
  },
}
</script>

<style lang="stylus">
.b3p-header
  width 100%
  height 50px
  box-sizing border-box
  padding 0 2%
  background var(--color-bgSub, color-bg-sub)
  border-bottom 1px solid var(--color-border, color-border)
  position fixed
  top 0
  z-index 1000
  display flex
  align-items center
  justify-content space-between
  .hambmenu
    display none
    +bp(sm)
      display block
      position relative
  .logo
    +bp(sm)
      display flex
      align-items center
      justify-content center
      margin 0 auto
    a
      .pc-logo
        +bp(sm)
          display none
      .sp-logo
        display none
        width 30px
        margin 0 auto
        +bp(sm)
          display block
  .b3p-login-detail
    +bp(sm)
      display none
</style>
