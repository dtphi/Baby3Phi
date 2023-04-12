<template>
  <b3p-button @click="_redirectUrl" custom-color="primary" original-title="Thêm danh mục">
    <b3p-emoji emoji="plus" />
  </b3p-button>
</template>

<script>
import { fn_redirect_url, } from '@app/api/utils/fn-helper'

export default {
  name: "TheButtonAdd",
  methods: {
    _redirectUrl() {
      return fn_redirect_url(`${this.$cmsCfg.adminPrefix}/news-categories/add`)
    },
  },
}
</script>
