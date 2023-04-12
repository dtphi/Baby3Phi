<template>
  <b3p-button @click="_refreshList" custom-color="info" original-title="Tải lại danh sách">
    <b3p-emoji emoji="refresh"/>
  </b3p-button>
</template>

<script>
import { mapState, mapActions, } from 'vuex'
import { MODULE_INFO, } from 'store@admin/types/module-types'
import { ACTION_GET_INFO_LIST, } from 'store@admin/types/action-types'

export default {
  name: "TheButtonRefresh",
  computed: {
    ...mapState({
      perPage: state => state.cfApp.perPage,
    }),
  },
  methods: {
    ...mapActions(MODULE_INFO, [ACTION_GET_INFO_LIST]),
    _refreshList() {
      const params = {
        perPage: this.perPage,
      }
      this[ACTION_GET_INFO_LIST](params)
    },
  },
}
</script>
