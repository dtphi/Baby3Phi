<template>
  <div id="container">
    <notifications group="common-update"></notifications>
    <main-header></main-header>
    <left-side-bar></left-side-bar>
    <slot></slot>
    <main-footer></main-footer>
    <v-dialog />
    <modals-container />
  </div>
</template>

<script>
import MainHeader from 'com@admin/Header'
import MainFooter from 'com@admin/Footer'
import LeftSideBar from 'com@admin/Sidebar/LeftSideBar'

export default {
  name: 'DefaultLayout',
  components: {
    MainHeader,
    LeftSideBar,
    MainFooter,
  },
  mounted() {
    require('../assets/javascript/cms.common')
  },
}
</script>

<!--<style src="../../../tools/mm/src/assets/css/style.scss" lang="scss">
</style>-->
