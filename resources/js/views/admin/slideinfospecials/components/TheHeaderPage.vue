<template>
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <btn-add></btn-add>
        <button
          @click="_refreshList()"
          data-toggle="tooltip"
          :title="$options.setting.refresh_txt"
          class="btn btn-default"
          :data-original-title="$options.setting.refresh_txt"
        >
        <b3p-emoji emoji="refresh" />
        </button>
        <button
          type="button"
          data-toggle="tooltip"
          title=""
          class="btn btn-danger"
          onclick="confirm('Are you sure?') ? $('#form-category').submit() : false;"
          data-original-title="Delete"
        >
        <b3p-emoji emoji="remove" />
        </button>
      </div>
      <h1>{{ $options.setting.title }}</h1>
      <b3p-breadcrumb />
      <ul class="cms-breadcrumb">
        <li>
          <b3p-select-perpage />
        </li>
        <li>
          <list-search></list-search>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import { mapActions, } from 'vuex'
import BtnAdd from './TheBtnAdd'
import ListSearch from 'com@admin/Search'
import { MODULE_INFO, } from 'store@admin/types/module-types'
import { ACTION_GET_INFO_LIST, } from 'store@admin/types/action-types'

export default {
  name: 'InformationHeaderPage',
  components: {
    BtnAdd,
    ListSearch,
  },
  methods: {
    ...mapActions(MODULE_INFO, {
      getInfoList: ACTION_GET_INFO_LIST,
    }),
    _pushAddPage() {
      this.$router.push(`/${this.$cmsCfg.adminPrefix}/informations/add`)
    },
    _refreshList() {
      this.getInfoList()
    },
  },
  setting: {
    title: 'Tin Tức',
    refresh_txt: 'Tải lại danh sách',
  },
}
</script>
