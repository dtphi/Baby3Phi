<template>
  <div>
    <b3p-select :items="$options.setting.perPageList" :value="perPage" @change="_changePerPage"></b3p-select>
  </div>
</template>

<script>
import { mapState, mapGetters, } from 'vuex'
import AppConfig from '@app/api/admin/constants/app-config'

export default {
  name: 'TheSelectPerpage',
  computed: {
    ...mapState({
      perPage: (state) => state.cfApp.perPage,
    }),
    ...mapGetters(['moduleNameActive', 'moduleActionListActive']),
  },
  methods: {
    _changePerPage(perPage) {
      const actionName = this.moduleNameActive + '/' + this.moduleActionListActive
      this.$store.dispatch(actionName, {
        perPage: parseInt(perPage),
      })
    },
  },
  setting: {
    perPageList: AppConfig.perPageValues,
  },
}
</script>
