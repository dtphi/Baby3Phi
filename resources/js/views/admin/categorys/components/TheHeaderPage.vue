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
import TheBtnAdd from './TheBtnAdd'
import TheBtnRefresh from './TheBtnRefresh'
import TheBtnSelectDelete from './TheBtnSelectDelete'

export default {
  name: 'CategoryHeaderPage',
  components: {
    TheBtnAdd,
    TheBtnRefresh,
    TheBtnSelectDelete,
  },
  methods: {
    _pushAddPage() {
      this.$router.push(`/${this.$cmsCfg.adminPrefix}/news-categories/add`)
    },
  },
  setting: {
    title: 'Danh Mục',
    refresh_txt: 'Tải lại danh sách',
  },
}
</script>
