<template>
  <div id="content">
    <div class="container-fluid">
      <keep-alive>
        <component v-bind:is="currentModule"></component>
      </keep-alive>
    </div>
  </div>
</template>

<script>
import category_icon_side_bars from './category_icon_side_bars'
import category_left_side_bars from './category_left_side_bars'
import home_banners from './home_banners'
import noi_bats from './noi_bats'

export default {
  name: 'ExtensionModuler',
  components: {
    'module-category-icon-side-bars': category_icon_side_bars,
    'module-category-left-side-bars': category_left_side_bars,
    'module-home-banners': home_banners,
    'module-noi-bats': noi_bats,
  },
  computed: {
    currentModule: app => {
      let moduleName = app.$route.params.pathMatch

      return 'module-' + moduleName.toLowerCase()
    },
  },
}
</script>
