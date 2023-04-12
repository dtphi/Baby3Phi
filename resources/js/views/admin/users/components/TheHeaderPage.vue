<template>
  <b3p-page-header>
    <template #pull_right>
      <the-btn-add></the-btn-add>
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
import { mapActions, } from 'vuex'
import TheBtnAdd from './TheBtnAdd'
import TheBtnRefresh from './TheBtnRefresh'
import TheBtnSelectDelete from './TheBtnSelectDelete'
import { MODULE_USER, } from 'store@admin/types/module-types'
import { ACTION_GET_USER_LIST, } from 'store@admin/types/action-types'

export default {
  name: 'TheUserHeaderPage',
  components: {
    TheBtnAdd,
    TheBtnRefresh,
    TheBtnSelectDelete,
  },
  methods: {
    ...mapActions(MODULE_USER, {
      getUserList: ACTION_GET_USER_LIST,
    }),
    _refreshList() {
      this.getUserList()
    },
    _deleteMultiple() {
      confirm(this.$options.setting.delete_warning_txt)
        ? $('#form-category').submit()
        : false
    },
  },
  setting: {
    title: 'Người Dùng',
    refresh_txt: 'Tải lại danh sách',
    delete_warning_txt: 'Bạn muốn xóa tất cả các mục đã chọn ?',
  },
}
</script>
