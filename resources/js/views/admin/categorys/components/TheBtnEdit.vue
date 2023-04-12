<template>
  <b3p-button @click="_redirectUrl" custom-color="primary" title="Chi tiết danh mục">
    <b3p-emoji emoji="edit"/>
  </b3p-button>
</template>

<script>
import { fn_redirect_url, } from '@app/api/utils/fn-helper'

export default {
  name: 'TheButtonEdit',
  props: {
    isRedirect: {
      type: Boolean,
      default: true,
    },
    categoryId: {
      type: Number,
      default: 0,
      validator: function(value) {
        return value && Number.isInteger(value)
      },
    },
  },
  methods: {
    _pushEditPage() {
      this.$router.push(
        `/${this.$cmsCfg.adminPrefix}/news-categories/edit/${this.categoryId}`
      )
    },
    _redirectUrl() {
      return fn_redirect_url(
        `${this.$cmsCfg.adminPrefix}/news-categories/edit/${this.categoryId}`
      )
    },
    _getHref() {
      return (
        `${this.$cmsCfg.baseUrl}/${this.$cmsCfg.adminPrefix}/news-categories/edit/${this.categoryId}`
      )
    },
  },
}
</script>
