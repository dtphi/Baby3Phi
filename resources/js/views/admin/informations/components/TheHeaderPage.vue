<template>
  <b3p-page-header>
    <template #pull_right>
      <btn-add></btn-add>
      <the-btn-refresh></the-btn-refresh>
      <the-btn-select-delete></the-btn-select-delete>
    </template>
    <h1>{{ $options.setting.title }}</h1>
    <b3p-breadcrumb />
    <ul class="cms-breadcrumb">
      <li>
        <b3p-select-perpage />
      </li>
      <li>
        <b3p-global-search />
      </li>
    </ul>
  </b3p-page-header>
</template>

<script>
import { mapState, mapActions, } from 'vuex'
import BtnAdd from './TheBtnAdd'
import TheBtnRefresh from './TheBtnRefresh'
import TheBtnSelectDelete from './TheBtnSelectDelete'
import { MODULE_INFO, } from 'store@admin/types/module-types'
import { ACTION_GET_INFO_LIST, } from 'store@admin/types/action-types'

export default {
  name: 'InformationHeaderPage',
  components: {
    BtnAdd,
    TheBtnRefresh,
    TheBtnSelectDelete,
  },
  methods: {
    ...mapState({
      perPage: (state) => state.cfApp.perPage,
    }),
    ...mapActions(MODULE_INFO, {
      getInfoList: ACTION_GET_INFO_LIST,
    }),
    _pushAddPage() {
      this.$router.push(`/${this.$cmsCfg.adminPrefix}/informations/add`)
    },
    _refreshList() {
      const params = {
        perPage: this.perPage,
      }
      this.getInfoList(params)
    },
  },
  setting: {
    title: 'Tin Tức',
    refresh_txt: 'Tải lại danh sách',
  },
}
</script>
