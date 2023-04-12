<template lang="pug">
.layout-default
  B3pHeader
  B3pNav
  .container
    Nuxt
</template>

<script>
import B3pHeader from '~/components/layouts/B3pHeader.vue'
import B3pNav from '~/components/layouts/B3pNav.vue'
export default {
  components: { B3pHeader, B3pNav },
  data() {
    return {
      clipped: false,
      drawer: false,
      fixed: false,
      items: [
        {
          icon: 'mdi-apps',
          title: 'Welcome',
          to: '/linhmucadmin',
        },
      ],
      miniVariant: false,
      right: true,
      rightDrawer: false,
      title: 'Vuetify.js',
    }
  },
}
</script>

<style lang="stylus">
.layout-default
  display flex
  justify-content space-between
  padding-top 50px
  min-height calc(100vh - 50px)
  position relative
  .container
    width calc(100vw - 58px)
    transition width .2s
    padding 20px
    box-sizing border-box
    display flex
    flex-direction column
    justify-content space-between
    background var(--color-bgMain, color-bg-main)
    +bp(sm)
      width 100vw
    &.open
      width calc(100vw - 230px)
      +bp(sm)
        width 100vw
      &.detail
        width calc(100vw - 462px)
        +bp(sm)
          width 100vw
    &.detail
      width calc(100vw - 292px)
      +bp(sm)
        width 100vw
  a.link
    font-size rem(12px)
    color var(--color-link1)
    &.right
      display flex
      justify-content flex-end
</style>
