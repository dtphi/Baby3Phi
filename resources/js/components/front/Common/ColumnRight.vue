<template>
  <b-col :cols="_getColumnNumber()" class="col-mobile">
    <slot></slot>

    <keep-alive v-for="(item, idx) in _moduleList" :key="idx">
      <component v-bind:is="item"></component>
    </keep-alive>
  </b-col>
</template>

<script>
import { mapState, } from 'vuex'
import category_icon_side_bars from 'v@front/modules/category_icon_side_bars'
import info_fanpages from 'v@front/modules/info_fanpages'
import { fnCheckProp, } from '@app/common/util'

export default {
  name: 'ContentColumnRight',
  props: {
    contentType: {
      default: 'top',
    },
  },
  components: {
    'module-category-icon-side-bar': category_icon_side_bars,
    'module-info-fanpage': info_fanpages,
  },
  data() {
    return {}
  },
  computed: {
    ...mapState({
      setting: (state) => state.cfApp.setting,
    }),
    _moduleList() {
      let list = []

      if (Object.keys(this.setting) && fnCheckProp(this.setting, 'modules')) {
        let contentType = 'content_' + this.contentType + '_column'
        let modules = this.$route.meta.layout_content[contentType].right_modules
        if (modules && modules.length) {
          _.forEach(modules, function(item) {
            list.push('module-' + item.moduleName.toLowerCase())
          })
        }
      }

      return list
    },
  },
  methods: {
    _getColumnNumber() {
      let contentType = 'content_' + this.contentType + '_column'

      return this.$route.meta.layout_content[contentType].right_column
    },
  },
}
</script>
